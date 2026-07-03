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
              <NuxtLink to="/tamu/profit" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" @click="showDropdown = false">
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
      <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mb-2 text-gray-800">Cek Pesanan</h1>
        <p class="text-gray-600 mb-8">Masukkan nomor pemesanan dan email Anda untuk melihat detail pesanan</p>
        
        <div class="bg-white rounded-xl shadow-lg border p-8">
          <div class="space-y-6">
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">
                Nomor Pemesanan <span class="text-red-500">*</span>
              </label>
              <input 
                type="text" 
                v-model="form.nomor_pemesanan" 
                placeholder="Contoh: INV202604061234" 
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition"
              />
            </div>
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">
                Email Pemesan <span class="text-red-500">*</span>
              </label>
              <input 
                type="email" 
                v-model="form.email" 
                placeholder="email@example.com" 
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition"
              />
            </div>
            <button 
              @click="cekPesanan" 
              :disabled="loading" 
              class="w-full bg-red-600 hover:bg-red-700 text-white py-3 rounded-lg font-semibold transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
            >
              <svg v-if="!loading" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
              <div v-if="loading" class="animate-spin rounded-full h-5 w-5 border-2 border-white border-t-transparent"></div>
              {{ loading ? 'Memeriksa...' : '🔍 Cek Pesanan' }}
            </button>
          </div>
        </div>
        
        <!-- Hasil Pencarian -->
        <div v-if="hasil && !loading" class="mt-8 bg-white rounded-xl shadow-lg border overflow-hidden">
          <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
            <div class="flex items-center gap-3">
              <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <span class="text-white font-bold text-lg">Pemesanan Ditemukan!</span>
            </div>
          </div>
          
          <div class="p-6 space-y-6">
            <div class="flex justify-between items-center bg-gray-50 p-4 rounded-lg">
              <div>
                <p class="text-gray-500 text-sm font-medium">Nomor Pemesanan</p>
                <p class="font-bold text-xl font-mono text-gray-800">{{ hasil.nomor_pemesanan }}</p>
              </div>
              <span :class="getStatusClass(hasil.status)" class="px-4 py-2 rounded-full text-sm font-semibold">
                {{ getStatusLabel(hasil.status) }}
              </span>
            </div>
            
            <div class="border-t pt-6">
              <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Data Pemesan
              </h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50 p-4 rounded-lg">
                <div>
                  <p class="text-gray-500 text-sm">Nama Lengkap</p>
                  <p class="font-semibold text-gray-800">{{ hasil.nama_pemesan || hasil.user?.username }}</p>
                </div>
                <div>
                  <p class="text-gray-500 text-sm">Email</p>
                  <p class="font-semibold text-gray-800">{{ hasil.user?.email }}</p>
                </div>
              </div>
            </div>
            
            <div class="border-t pt-6">
              <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                Detail Kamar
              </h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50 p-4 rounded-lg">
                <div>
                  <p class="text-gray-500 text-sm">Tipe Kamar</p>
                  <p class="font-semibold text-gray-800">{{ hasil.tipe_kamar?.nama }}</p>
                </div>
                <div>
                  <p class="text-gray-500 text-sm">Jumlah Kamar</p>
                  <p class="font-semibold text-gray-800">{{ hasil.jumlah_kamar }} kamar</p>
                </div>
                <div>
                  <p class="text-gray-500 text-sm">Check-in</p>
                  <p class="font-semibold text-gray-800">{{ formatDate(hasil.check_in) }}</p>
                </div>
                <div>
                  <p class="text-gray-500 text-sm">Check-out</p>
                  <p class="font-semibold text-gray-800">{{ formatDate(hasil.check_out) }}</p>
                </div>
                <div>
                  <p class="text-gray-500 text-sm">Jumlah Malam</p>
                  <p class="font-semibold text-gray-800">{{ hasil.jumlah_malam }} malam</p>
                </div>
                <div>
                  <p class="text-gray-500 text-sm font-bold">Total Harga</p>
                  <p class="font-bold text-green-600 text-lg">{{ formatRupiah(hasil.total_harga) }}</p>
                </div>
              </div>
            </div>
            
            <!-- QR Code Section -->
            <div class="border-t pt-6">
              <h3 class="font-bold text-gray-800 mb-4 text-center">📱 QR Code Pemesanan</h3>
              <p class="text-sm text-gray-600 mb-6 text-center">Scan QR code ini untuk verifikasi oleh resepsionis</p>
              <div class="flex justify-center">
                <div class="inline-block bg-white p-6 rounded-xl shadow-lg border-2 border-gray-200">
                  <img 
                    v-if="qrCodeUrl" 
                    :src="qrCodeUrl" 
                    alt="QR Code Pemesanan" 
                    class="w-56 h-56"
                    @error="handleQrError"
                  />
                  <div v-else class="w-56 h-56 flex items-center justify-center">
                    <div class="animate-spin rounded-full h-16 w-16 border-4 border-red-500 border-t-transparent"></div>
                  </div>
                </div>
              </div>
              <p class="text-sm text-gray-500 text-center mt-4">
                Nomor: <span class="font-mono font-bold text-gray-800">{{ hasil.nomor_pemesanan }}</span>
              </p>
            </div>
            
            <button 
              @click="cetakBukti" 
              class="w-full bg-gray-700 hover:bg-gray-800 text-white py-3 rounded-lg font-semibold transition flex items-center justify-center gap-2"
            >
              <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
              </svg>
              🖨️ Cetak Bukti Pemesanan
            </button>
          </div>
        </div>
        
        <!-- Error -->
        <div v-if="error && !loading" class="mt-8 bg-red-50 border-l-4 border-red-500 rounded-lg p-6">
          <div class="flex items-center gap-3">
            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="text-red-700 font-medium">{{ error }}</p>
          </div>
        </div>
      </div>
    </main>
    
    <!-- Footer -->
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
const loading = ref(false)
const hasil = ref(null)
const error = ref(null)
const qrCodeUrl = ref('')
const showDropdown = ref(false)

const user = ref({
  name: 'Tamu',
  foto_profil: '/default-avatar.png'
})

const form = ref({ 
  nomor_pemesanan: '', 
  email: '' 
})

onMounted(() => {
  if (process.client) {
    user.value.name = sessionStorage.getItem('user_name') || 'Tamu'
    user.value.foto_profil = sessionStorage.getItem('user_foto') || '/default-avatar.png'
  }
})

const formatRupiah = (amount) => {
  return new Intl.NumberFormat('id-ID', { 
    style: 'currency', 
    currency: 'IDR', 
    minimumFractionDigits: 0 
  }).format(amount || 0)
}

const formatDate = (date) => {
  if (!date) return '-'
  return new Date(date).toLocaleDateString('id-ID', { 
    day: 'numeric', 
    month: 'long', 
    year: 'numeric' 
  })
}

const getStatusClass = (status) => {
  const classes = {
    'baru': 'bg-blue-100 text-blue-800', 
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
    'baru': 'Baru', 
    'menunggu_pembayaran': 'Menunggu Bayar', 
    'menunggu_verifikasi': 'Verifikasi',
    'dibayar': 'Dibayar', 
    'check_in': 'Check-in', 
    'check_out': 'Check-out', 
    'batal': 'Batal'
  }
  return labels[status] || status
}

const handleQrError = () => {
  console.error('QR Code gagal dimuat dari server')
  if (hasil.value?.nomor_pemesanan) {
    qrCodeUrl.value = `https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=${encodeURIComponent(hasil.value.nomor_pemesanan)}`
  }
}

const cekPesanan = async () => {
  if (!form.value.nomor_pemesanan || !form.value.email) {
    alert('Masukkan nomor pemesanan dan email')
    return
  }
  
  loading.value = true
  error.value = null
  hasil.value = null
  qrCodeUrl.value = ''
  
  try {
    const response = await $fetch('http://localhost:8000/api/cek-pesanan', {
      method: 'POST',
      body: { 
        nomor_pemesanan: form.value.nomor_pemesanan, 
        email: form.value.email 
      }
    })
    
    if (response.success) {
      hasil.value = response.data
      qrCodeUrl.value = `http://localhost:8000/api/generate-qr/${response.data.id}?t=${Date.now()}`
    }
  } catch (err) {
    error.value = err.data?.message || 'Pemesanan tidak ditemukan'
  } finally {
    loading.value = false
  }
}

const cetakBukti = () => { 
  window.print() 
}

const logout = () => {
  if (confirm('Apakah Anda yakin ingin logout?')) {
    if (process.client) {
      sessionStorage.clear()
    }
    router.push('/')
  }
}
</script>

<style scoped>
@media print { 
  header, footer, button, .print-hide { 
    display: none !important; 
  }
  main {
    padding: 20px !important;
  }
}
</style>