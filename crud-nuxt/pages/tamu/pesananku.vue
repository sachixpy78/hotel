<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-md sticky top-0 z-50">
      <div class="container mx-auto px-4 py-4">
        <div class="flex justify-between items-center">
          <NuxtLink to="/tamu" class="flex items-center gap-2">
            <div class="w-10 h-10 bg-red-600 rounded-lg flex items-center justify-center">
              <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
              </svg>
            </div>
            <span class="text-xl font-bold text-gray-800">Flojachi Hotel</span>
          </NuxtLink>
          
          <nav class="hidden md:flex space-x-6">
            <NuxtLink to="/tamu" class="text-gray-600 hover:text-red-600 transition">Beranda</NuxtLink>
            <NuxtLink to="/tamu/kamar" class="text-gray-600 hover:text-red-600 transition">Kamar</NuxtLink>
            <NuxtLink to="/tamu/pesananku" class="text-gray-600 hover:text-red-600 transition">Pesananku</NuxtLink>
            <NuxtLink to="/tamu/cek-pesanan" class="text-gray-600 hover:text-red-600 transition">Cek Pesanan</NuxtLink>
          </nav>
          
          <div class="relative">
            <button @click="showDropdown = !showDropdown" class="flex items-center gap-2 bg-gray-100 px-3 py-2 rounded-lg">
              <img :src="user.foto_profil || '/default-avatar.png'" class="h-8 w-8 rounded-full object-cover" />
              <span class="text-sm font-medium">{{ user.name }}</span>
              <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            
            <div v-if="showDropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border z-50">
              <NuxtLink to="/tamu/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" @click="showDropdown = false">
                Profil Saya
              </NuxtLink>
              <button @click="logout" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                Logout
              </button>
            </div>
          </div>
        </div>
      </div>
    </header>
    
    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
      <h1 class="text-2xl font-bold mb-6">Pesananku</h1>
      
      <div v-if="loading" class="text-center py-10">
        <div class="animate-spin rounded-full h-12 w-12 border-4 border-red-500 border-t-transparent mx-auto"></div>
      </div>
      
      <div v-else class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <div class="overflow-x-auto">
          <table class="w-full">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">No. Pemesanan</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Tipe Kamar</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Check-in</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Check-out</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Total</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Status</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              <tr v-for="booking in pemesananList" :key="booking.id">
                <td class="px-4 py-3 text-sm font-mono">{{ booking.nomor_pemesanan }}</td>
                <td class="px-4 py-3 text-sm">{{ booking.tipe_kamar?.nama }}</td>
                <td class="px-4 py-3 text-sm">{{ formatDate(booking.check_in) }}</td>
                <td class="px-4 py-3 text-sm">{{ formatDate(booking.check_out) }}</td>
                <td class="px-4 py-3 text-sm font-medium text-green-600">{{ formatRupiah(booking.total_harga) }}</td>
                <td class="px-4 py-3">
                  <span :class="getStatusClass(booking.status)" class="px-2 py-1 rounded-full text-xs">
                    {{ getStatusLabel(booking.status) }}
                  </span>
                </td>
                <td class="px-4 py-3">
                  <NuxtLink :to="`/tamu/booking?id=${booking.id}`" class="text-red-600 hover:text-red-800 text-sm">
                    Detail →
                  </NuxtLink>
                </td>
              </tr>
              <tr v-if="pemesananList.length === 0">
                <td colspan="7" class="px-4 py-8 text-center text-gray-500">Belum ada pemesanan</td>
              </tr>
            </tbody>
          </table>
        </div>
        
        <!-- Pagination -->
        <div v-if="pagination.last_page > 1" class="px-6 py-4 border-t flex justify-between items-center">
          <button @click="fetchPemesanan(pagination.current_page - 1)" :disabled="pagination.current_page <= 1" class="px-3 py-1 border rounded-lg disabled:opacity-50">Previous</button>
          <span class="text-sm">Halaman {{ pagination.current_page }} dari {{ pagination.last_page }}</span>
          <button @click="fetchPemesanan(pagination.current_page + 1)" :disabled="pagination.current_page >= pagination.last_page" class="px-3 py-1 border rounded-lg disabled:opacity-50">Next</button>
        </div>
      </div>
    </main>
    
    <!-- Footer - UPDATED ✅ -->
    <footer class="bg-gray-800 text-white py-12">
      <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
          <div>
            <div class="flex items-center gap-2 mb-4">
              <div class="w-10 h-10 bg-red-600 rounded-lg flex items-center justify-center">
                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
              </div>
              <span class="text-xl font-bold">Flojachi Hotel</span>
            </div>
            <p class="text-gray-400 text-sm">
              Hotel berbintang dengan pelayanan terbaik untuk pengalaman menginap yang tak terlupakan.
            </p>
          </div>
          
          <div>
            <h3 class="font-bold mb-4">Kontak Kami</h3>
            <ul class="space-y-2 text-gray-400 text-sm">
              <li class="flex items-center gap-2">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Jl. kedung Sumur No. 123, Kota
              </li>
              <li class="flex items-center gap-2">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                info@flojachihotel.com
              </li>
              <li class="flex items-center gap-2">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
                (+62) 821-0668-551
              </li>
            </ul>
          </div>
          
          <div>
            <h3 class="font-bold mb-4">Jam Operasional</h3>
            <ul class="space-y-2 text-gray-400 text-sm">
              <li>Resepsionis: 24 Jam</li>
              <li>Check-in: 14:00 WIB</li>
              <li>Check-out: 12:00 WIB</li>
              <li>Restoran: 06:00 - 22:00 WIB</li>
            </ul>
          </div>
        </div>
        
        <div class="border-t border-gray-700 pt-8 text-center text-gray-400 text-sm">
          <p>&copy; 2025 Flojachi Hotel. All rights reserved.</p>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const showDropdown = ref(false)
const loading = ref(true)
const pemesananList = ref([])
const pagination = ref({ current_page: 1, last_page: 1 })

const user = ref({
  name: '',
  foto_profil: '/default-avatar.png'
})

const formatRupiah = (amount) => {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0
  }).format(amount)
}

const formatDate = (date) => {
  if (!date) return '-'
  return new Date(date).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' })
}

// ✅ UPDATED: Hapus 'baru', ganti 'terkonfirmasi' jadi 'dibayar'
const getStatusClass = (status) => {
  const classes = {
    'menunggu_pembayaran': 'bg-yellow-100 text-yellow-800',
    'menunggu_verifikasi': 'bg-orange-100 text-orange-800',
    'dibayar': 'bg-green-100 text-green-800',
    'check_in': 'bg-purple-100 text-purple-800',
    'check_out': 'bg-gray-100 text-gray-800',
    'batal': 'bg-red-100 text-red-800'
  }
  return classes[status] || 'bg-gray-100 text-gray-800'
}

const getStatusLabel = (status) => {
  const labels = {
    'menunggu_pembayaran': 'Menunggu Pembayaran',
    'menunggu_verifikasi': 'Menunggu Verifikasi',
    'dibayar': 'Dibayar',
    'check_in': 'Check-in',
    'check_out': 'Check-out',
    'batal': 'Batal'
  }
  return labels[status] || status
}

const logout = () => {
  if (confirm('Apakah Anda yakin ingin logout?')) {
    sessionStorage.clear()
    router.push('/')
  }
}

const fetchPemesanan = async (page = 1) => {
  loading.value = true
  try {
    const token = sessionStorage.getItem('auth_token')
    const response = await $fetch(`http://localhost:8000/api/tamu/pemesanan?page=${page}`, {
      headers: { 'Authorization': `Bearer ${token}` }
    })
    if (response.success) {
      pemesananList.value = response.data.data
      pagination.value = {
        current_page: response.data.current_page,
        last_page: response.data.last_page
      }
    }
  } catch (error) {
    console.error('Error:', error)
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  user.value.name = sessionStorage.getItem('user_name') || 'Tamu'
  user.value.foto_profil = sessionStorage.getItem('user_foto') || '/default-avatar.png'
  fetchPemesanan()
})
</script>