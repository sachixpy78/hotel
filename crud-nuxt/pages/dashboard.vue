<template>
  <div class="min-h-screen bg-gray-50">
    <!-- HEADER -->
    <header class="bg-white shadow-sm border-b">
      <div class="container mx-auto px-6 py-3 flex items-center justify-between">
        <!-- Logo (TETAP) -->
        <div class="flex items-center space-x-3">
          <img src="/71.jpg" alt="Logo" class="h-10 w-10 rounded-full bg-blue-100 p-1" />
          <span class="font-bold text-red-800">SMKN 71</span>
        </div>

        <!-- Menu Navbar -->
     <nav class="hidden md:flex space-x-1">
          <NuxtLink 
            to="/admin" 
            class="px-6 py-2.5 bg-red-700 text-white font-medium rounded-lg hover:bg-maroon-dark transition-colors"
          >
            Admin
          </NuxtLink>
          <NuxtLink 
            to="/laporan" 
            class="px-6 py-2.5 text-gray-700 font-medium rounded-lg hover:bg-gray-100 transition-colors"
          >
            Laporan
          </NuxtLink>
        </nav>

        <!-- Profil Dropdown -->
        <div class="relative">
          <button @click="showDropdown = !showDropdown" class="flex items-center space-x-2 bg-gray-100 px-3 py-2 rounded-md">
            <span class="text-sm font-medium">{{ user.name }}</span>
            <img :src="user.foto_profil" alt="Profile" class="h-8 w-8 rounded-full" />
          </button>
          <div v-if="showDropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10">
            <NuxtLink to="/profil" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil</NuxtLink>
            <button @click="logout" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Log Out</button>
          </div>
        </div>
      </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="container mx-auto px-6 py-6">
      <h1 class="text-xl font-bold text-center text-gray-800 mb-8">Pameran SMKN 71</h1>

      <!-- Loading -->
      <div v-if="loading" class="text-center py-10">
        <p class="text-gray-500">Memuat data dashboard...</p>
      </div>

      <!-- Statistik Cards -->
      <div v-else class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">
        <!-- Card 1: Total Pendapatan -->
        <div class="bg-white rounded-xl shadow-md p-5 border-l-4 border-blue-500">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-xs text-gray-500">Total Pendapatan</p>
              <p class="text-2xl font-bold mt-1">{{ formatRupiah(stats.total_pendapatan) }}</p>
              <p class="text-xs text-gray-500">Hari ini</p>
            </div>
            <div class="text-blue-500">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08-.402 2.598-1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.598-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
          </div>
        </div>

        <!-- Card 2: Rata-rata Transaksi -->
        <div class="bg-white rounded-xl shadow-md p-5 border-l-4 border-purple-500">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-xs text-gray-500">Rata-rata Transaksi</p>
              <p class="text-2xl font-bold mt-1">{{ formatRupiah(stats.rata_rata_transaksi) }}</p>
              <p class="text-xs text-gray-500">Per transaksi</p>
            </div>
            <div class="text-purple-500">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
              </svg>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import { useRouter } from 'vue-router'
import { useStorage } from '@vueuse/core'

const router = useRouter()
const showDropdown = ref(false)
const loading = ref(true)
const stats = ref({
  total_pendapatan: 0,
  rata_rata_transaksi: 0
})

// Ambil data dari localStorage
const user_name = useStorage('user_name', 'Admin')
const user_foto = useStorage('user_foto', '/logo.jpg')

const user = ref({
  name: user_name.value,
  foto_profil: user_foto.value
})

// ✅ WATCH UNTUK AUTO-UPDATE JIKA LOCALSTORAGE BERUBAH
watch(user_name, (newVal) => {
  user.value.name = newVal
})
watch(user_foto, (newVal) => {
  user.value.foto_profil = newVal
})

onMounted(() => {
  const auth_token = useStorage('auth_token').value
  if (!auth_token) {
    router.push('/')
  } else {
    // ✅ REFRESH DATA USER SAAT MASUK DASHBOARD
    const updatedName = localStorage.getItem('user_name') || 'Admin'
    const updatedFoto = localStorage.getItem('user_foto') || ''
    
    user.value.name = updatedName
    user.value.foto_profil = updatedFoto

    fetchDashboardStats()
  }
})

const fetchDashboardStats = async () => {
  try {
    const data = await $fetch('http://localhost:8000/api/dashboard')
    stats.value = data
  } catch (err) {
    console.error('Error:', err)
    alert('Gagal memuat data dashboard.')
  } finally {
    loading.value = false
  }
}

const logout = () => {
  if (confirm('Yakin mau logout?')) {
    if (typeof window !== 'undefined') {
      localStorage.clear()
    }
    router.push('/')
  }
}

const formatRupiah = (angka) => {
  if (angka == null) return 'Rp 0'
  return 'Rp ' + parseInt(angka).toLocaleString('id-ID')
}
</script>