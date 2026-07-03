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
      <h1 class="text-2xl font-bold mb-6">Cari Kamar Tersedia</h1>
      
      <!-- Form Pencarian -->
      <div class="bg-white rounded-xl shadow-sm border p-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Check-in</label>
            <input type="date" v-model="searchForm.check_in" :min="minDate" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-red-500">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Check-out</label>
            <input type="date" v-model="searchForm.check_out" :min="searchForm.check_in || minDate" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-red-500">
          </div>
          <div class="flex items-end">
            <button @click="cariKamar" :disabled="loading" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition disabled:opacity-50">
              {{ loading ? 'Mencari...' : '🔍 Cari Kamar' }}
            </button>
          </div>
        </div>
      </div>
      
      <!-- Loading -->
      <div v-if="loading" class="text-center py-10">
        <div class="animate-spin rounded-full h-12 w-12 border-4 border-red-500 border-t-transparent mx-auto"></div>
      </div>
      
      <!-- Hasil Pencarian -->
      <div v-else-if="kamarList.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div v-for="kamar in kamarList" :key="kamar.id" class="bg-white rounded-xl shadow-sm border overflow-hidden hover:shadow-lg transition">
          <img :src="getFotoUrl(kamar.foto)" :alt="kamar.nama" class="w-full h-48 object-cover">
          <div class="p-4">
            <h3 class="text-lg font-bold">{{ kamar.nama }}</h3>
            <div class="text-sm text-gray-500 mt-1">
              <span v-for="(f, i) in parseFasilitas(kamar.fasilitas)" :key="i" class="inline-block mr-2">• {{ f }}</span>
            </div>
            <div class="mt-3 flex justify-between items-center">
              <div>
                <span class="text-2xl font-bold text-red-600">{{ formatRupiah(kamar.harga_per_malam) }}</span>
                <span class="text-gray-500">/malam</span>
              </div>
              <span class="text-sm" :class="getStokClass(kamar.stok_tersedia || kamar.stok)">
                Tersedia {{ kamar.stok_tersedia || kamar.stok }} kamar
              </span>
            </div>
            <button 
              @click="pesanSekarang(kamar)" 
              class="block mt-4 w-full bg-red-600 hover:bg-red-700 text-white text-center py-2 rounded-lg transition"
            >
              Pesan Sekarang →
            </button>
          </div>
        </div>
      </div>
      
      <!-- Empty State - Belum Cari -->
      <div v-else-if="!searched" class="text-center py-20">
        <svg class="h-24 w-24 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        <p class="text-gray-500 text-lg mb-2">Silakan masukkan tanggal check-in dan check-out</p>
        <p class="text-gray-400 text-sm">Kemudian klik tombol "Cari Kamar" untuk melihat ketersediaan</p>
      </div>
      
      <!-- Empty State - Hasil Kosong -->
      <div v-else-if="searched && kamarList.length === 0" class="text-center py-10">
        <svg class="h-16 w-16 text-gray-400 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <p class="text-gray-500">Tidak ada kamar yang tersedia untuk tanggal tersebut</p>
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
const loading = ref(false)
const searched = ref(false)
const kamarList = ref([])

const user = ref({
  name: '',
  foto_profil: '/default-avatar.png'
})

const today = new Date()
const minDate = today.toISOString().split('T')[0]

const searchForm = ref({
  check_in: '',
  check_out: ''
})

const formatRupiah = (amount) => {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0
  }).format(amount)
}

const getFotoUrl = (foto) => {
  if (!foto) return '/default-room.jpg'
  if (foto.startsWith('http')) return foto
  return `http://localhost:8000/storage/${foto}`
}

const parseFasilitas = (fasilitas) => {
  if (!fasilitas) return []
  return fasilitas.split(/[\n,]+/).map(f => f.trim()).filter(f => f)
}

const getStokClass = (stok) => {
  if (stok === 0) return 'text-red-600 font-semibold'
  if (stok <= 3) return 'text-orange-600 font-semibold'
  return 'text-green-600'
}

const logout = () => {
  if (confirm('Apakah Anda yakin ingin logout?')) {
    sessionStorage.clear()
    router.push('/')
  }
}

const cariKamar = async () => {
  if (!searchForm.value.check_in || !searchForm.value.check_out) {
    alert('Pilih tanggal check-in dan check-out terlebih dahulu')
    return
  }
  
  if (searchForm.value.check_out <= searchForm.value.check_in) {
    alert('Tanggal check-out harus setelah check-in')
    return
  }
  
  loading.value = true
  searched.value = true
  
  try {
    const response = await $fetch('http://localhost:8000/api/cari-kamar', {
      method: 'POST',
      body: {
        check_in: searchForm.value.check_in,
        check_out: searchForm.value.check_out
      }
    })
    if (response.success) {
      kamarList.value = response.data
      if (kamarList.value.length === 0) {
        alert('Maaf, tidak ada kamar tersedia untuk tanggal yang dipilih')
      }
    }
  } catch (error) {
    console.error('Error:', error)
    alert('Gagal mencari kamar')
  } finally {
    loading.value = false
  }
}

const pesanSekarang = (kamar) => {
  // Validasi login
  const token = sessionStorage.getItem('auth_token')
  if (!token) {
    if (confirm('Anda harus login untuk memesan. Login sekarang?')) {
      router.push(`/login?redirect=/tamu/${kamar.id}?check_in=${searchForm.value.check_in}&check_out=${searchForm.value.check_out}`)
    }
    return
  }
  
  // Redirect ke halaman detail dengan query params
  router.push({
    path: `/tamu/${kamar.id}`,
    query: {
      check_in: searchForm.value.check_in,
      check_out: searchForm.value.check_out
    }
  })
}

onMounted(() => {
  user.value.name = sessionStorage.getItem('user_name') || 'Tamu'
  user.value.foto_profil = sessionStorage.getItem('user_foto') || '/default-avatar.png'
  
  // ✅ DIHAPUS: Tidak load kamar saat halaman dibuka
  // loadAllKamar()
})
</script>