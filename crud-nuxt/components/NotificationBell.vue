<template>
  <div class="relative">
    <!-- Tombol Lonceng -->
    <button 
      @click="toggleDropdown"
      class="relative p-2 hover:bg-gray-100 rounded-full transition-colors duration-300"
    >
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
      </svg>
      <!-- Badge jumlah notifikasi -->
      <span v-if="unreadCount > 0" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
        {{ unreadCount }}
      </span>
    </button>

    <!-- Dropdown Notifikasi -->
    <div 
      v-if="showDropdown" 
      class="absolute right-0 mt-2 w-96 bg-white rounded-lg shadow-xl border border-gray-200 z-50 overflow-hidden"
    >
      <!-- Header -->
      <div class="p-4 border-b border-gray-200 bg-blue-50">
        <div class="flex justify-between items-center">
          <h3 class="font-semibold text-gray-800">
            🔔 Notifikasi Resepsionis
          </h3>
          <button 
            v-if="notifications.length > 0" 
            @click="clearAll" 
            class="text-xs text-red-500 hover:text-red-700"
          >
            Hapus semua
          </button>
        </div>
        <p class="text-xs text-gray-500 mt-1">Resepsionis yang menunggu aktivasi</p>
      </div>

      <!-- Loading -->
      <div v-if="loading" class="p-8 text-center">
        <div class="animate-spin rounded-full h-6 w-6 border-2 border-blue-500 border-t-transparent inline-block"></div>
      </div>

      <!-- Kosong -->
      <div v-else-if="notifications.length === 0" class="p-8 text-center">
        <svg class="h-12 w-12 text-gray-300 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <p class="text-gray-500 text-sm">Tidak ada notifikasi</p>
        <p class="text-gray-400 text-xs">Semua resepsionis sudah diaktivasi</p>
      </div>

      <!-- List Notifikasi -->
      <div v-else class="divide-y divide-gray-100 max-h-96 overflow-y-auto">
        <div 
          v-for="notif in notifications" 
          :key="notif.id" 
          class="p-4 hover:bg-gray-50 transition-colors group"
          :class="{ 'bg-blue-50/50': notif.status === 'unread' }"
        >
          <div class="flex items-start gap-3">
            <!-- Icon -->
            <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0">
              <svg class="h-5 w-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
              </svg>
            </div>
            
            <!-- Content -->
            <div class="flex-1">
              <div class="flex justify-between items-start">
                <h4 class="text-sm font-semibold text-gray-800">{{ notif.title }}</h4>
                <span class="text-xs text-gray-400">{{ formatTime(notif.created_at) }}</span>
              </div>
              <p class="text-xs text-gray-500 mt-0.5">{{ notif.user_email }}</p>
              <p class="text-sm text-gray-600 mt-1">{{ notif.message }}</p>
              
              <!-- Link ke User Management -->
              <NuxtLink 
                to="/admin/" 
                class="text-xs text-blue-600 hover:text-blue-800 inline-flex items-center gap-1 mt-2"
                @click="markAsRead(notif)"
              >
                ⚙️ Kelola di User Management →
              </NuxtLink>
            </div>
            
            <!-- Tombol Hapus -->
            <button 
              @click="deleteNotif(notif)"
              class="opacity-0 group-hover:opacity-100 transition-opacity p-1 hover:bg-gray-200 rounded-full flex-shrink-0"
              title="Hapus notifikasi"
            >
              <svg class="h-4 w-4 text-gray-400 hover:text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>
      </div>

      <!-- Footer -->
      <div v-if="notifications.length > 0" class="p-3 bg-gray-50 border-t border-gray-200 text-center">
        <p class="text-xs text-gray-500">
          💡 Aktivasi akun dilakukan di menu <span class="font-medium">User Management</span>
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'

// ✅ PAKAI HTTP, BUKAN HTTPS
const API_URL = 'http://localhost:8000/api'

const showDropdown = ref(false)
const loading = ref(false)
const notifications = ref([])

const unreadCount = computed(() => {
  return notifications.value.filter(n => n.status === 'unread').length
})

// Ambil notifikasi
const fetchNotifications = async () => {
  loading.value = true
  try {
    const token = sessionStorage.getItem('auth_token')
    console.log('Token:', token ? 'Ada' : 'Tidak ada')
    
    if (!token) {
      console.log('Token tidak ditemukan!')
      return
    }
    
    console.log('Memanggil API:', `${API_URL}/admin/notifications`)
    
    const response = await $fetch(`${API_URL}/admin/notifications`, {
      headers: { 
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json'
      }
    })
    
    console.log('Response:', response)
    
    if (response.success) {
      notifications.value = response.data
      console.log('Jumlah notifikasi:', notifications.value.length)
    }
  } catch (error) {
    console.error('Error:', error)
  } finally {
    loading.value = false
  }
}

// Tandai sudah dibaca
const markAsRead = async (notif) => {
  if (notif.status === 'unread') {
    try {
      const token = sessionStorage.getItem('auth_token')
      await $fetch(`${API_URL}/admin/notifications/${notif.id}/read`, {
        method: 'PUT',
        headers: { 'Authorization': `Bearer ${token}` }
      })
      notif.status = 'read'
    } catch (error) {
      console.error('Error:', error)
    }
  }
}

// Hapus notifikasi
const deleteNotif = async (notif) => {
  if (!confirm(`Hapus notifikasi untuk ${notif.user_name}?`)) return
  
  try {
    const token = sessionStorage.getItem('auth_token')
    await $fetch(`${API_URL}/admin/notifications/${notif.id}`, {
      method: 'DELETE',
      headers: { 'Authorization': `Bearer ${token}` }
    })
    notifications.value = notifications.value.filter(n => n.id !== notif.id)
  } catch (error) {
    console.error('Error:', error)
    alert('Gagal menghapus notifikasi')
  }
}

// Hapus semua
const clearAll = async () => {
  if (!confirm(`Hapus semua notifikasi (${notifications.value.length} item)?`)) return
  
  try {
    const token = sessionStorage.getItem('auth_token')
    await $fetch(`${API_URL}/admin/notifications/clear-all`, {
      method: 'DELETE',
      headers: { 'Authorization': `Bearer ${token}` }
    })
    notifications.value = []
  } catch (error) {
    console.error('Error:', error)
    alert('Gagal menghapus notifikasi')
  }
}

// Format waktu
const formatTime = (dateString) => {
  const date = new Date(dateString)
  const now = new Date()
  const diffMinutes = Math.floor((now - date) / 1000 / 60)
  
  if (diffMinutes < 1) return 'Baru saja'
  if (diffMinutes < 60) return `${diffMinutes} menit lalu`
  if (diffMinutes < 1440) return `${Math.floor(diffMinutes / 60)} jam lalu`
  return `${Math.floor(diffMinutes / 1440)} hari lalu`
}

const toggleDropdown = () => {
  showDropdown.value = !showDropdown.value
  if (showDropdown.value) {
    fetchNotifications()
  }
}

// Klik di luar
const handleClickOutside = (event) => {
  if (showDropdown.value && !event.target.closest('.relative')) {
    showDropdown.value = false
  }
}

// Polling setiap 30 detik
let pollingInterval = null

onMounted(() => {
  console.log('🔔 NotificationBell mounted')
  fetchNotifications()
  pollingInterval = setInterval(fetchNotifications, 30000)
  document.addEventListener('click', handleClickOutside)
})

onUnmounted(() => {
  if (pollingInterval) clearInterval(pollingInterval)
  document.removeEventListener('click', handleClickOutside)
})
</script>