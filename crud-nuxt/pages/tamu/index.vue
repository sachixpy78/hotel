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
    <main>
      <!-- Hero Section -->
      <section class="relative bg-gradient-to-r from-red-600 to-red-800 text-white py-20">
        <div class="container mx-auto px-4">
          <div class="max-w-3xl">
            <h1 class="text-5xl font-bold mb-6">Selamat Datang di Flojachi Hotel</h1>
            <p class="text-xl mb-8 text-red-100">
              Pengalaman menginap yang tak terlupakan dengan kenyamanan, kemewahan, dan pelayanan terbaik di jantung kota
            </p>
            <div class="flex gap-4">
              <NuxtLink to="/tamu/kamar" class="bg-white text-red-600 px-8 py-3 rounded-lg font-semibold hover:bg-red-50 transition">
                Pesan Kamar Sekarang
              </NuxtLink>
              <a href="#tentang" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-red-600 transition">
                Pelajari Lebih
              </a>
            </div>
          </div>
        </div>
        <div class="absolute bottom-0 left-0 right-0 h-20 bg-gradient-to-t from-gray-50 to-transparent"></div>
      </section>

      <!-- Tentang Hotel -->
<section id="tentang" class="py-16">
  <div class="container mx-auto px-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
      <!-- Text Content - Left Side -->
      <div>
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Tentang Flojachi Hotel</h2>
        <p class="text-gray-600 mb-4 leading-relaxed">
          Flojachi Hotel adalah hotel berbintang yang menawarkan pengalaman menginap istimewa dengan kombinasi sempurna antara kenyamanan modern dan keramahan tradisional Indonesia.
        </p>
        <p class="text-gray-600 mb-6 leading-relaxed">
          Terletak di lokasi strategis, hotel kami dilengkapi dengan fasilitas lengkap dan pelayanan profesional untuk memastikan setiap momen menginap Anda menjadi pengalaman yang berkesan.
        </p>
        <div class="grid grid-cols-3 gap-6">
          <div class="text-center">
            <div class="text-3xl font-bold text-red-600 mb-2">50+</div>
            <div class="text-sm text-gray-600">Kamar Mewah</div>
          </div>
          <div class="text-center">
            <div class="text-3xl font-bold text-red-600 mb-2">15+</div>
            <div class="text-sm text-gray-600">Tahun Pengalaman</div>
          </div>
          <div class="text-center">
            <div class="text-3xl font-bold text-red-600 mb-2">10k+</div>
            <div class="text-sm text-gray-600">Tamu Puas</div>
          </div>
        </div>
      </div>
      
      <!-- Images - Right Side -->
      <div class="grid grid-cols-2 gap-4">
        <div class="space-y-4">
          <img src="/hotel.jpg" alt="Hotel Interior" class="rounded-2xl h-38 w-full object-cover shadow-lg" />
          <img src="/hotel2.jpg" alt="Hotel Room" class="rounded-2xl h-54 w-full object-cover shadow-lg" />
        </div>
        <div class="space-y-4 pt-8">
          <img src="/hotel3.jpg" alt="Hotel Facility" class="rounded-2xl h-44 w-full object-cover shadow-lg" />
          <img src="/hotel4.jpg" alt="Hotel Lobby" class="rounded-2xl h-50 w-full object-cover shadow-lg" />
        </div>
      </div>
    </div>
  </div>
</section>

      <!-- Fasilitas -->
<section class="py-16 bg-white">
  <div class="container mx-auto px-4">
    <div class="text-center mb-12">
      <h2 class="text-3xl font-bold text-gray-800 mb-4">Fasilitas Kami</h2>
      <p class="text-gray-600 max-w-2xl mx-auto">
        Nikmati berbagai fasilitas premium untuk kenyamanan dan kepuasan Anda selama menginap
      </p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div v-for="facility in facilities" :key="facility.name" class="bg-gray-50 rounded-xl p-6 text-center hover:shadow-lg transition">
        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
          <svg class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path :d="facility.icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
          </svg>
        </div>
        <h3 class="font-semibold text-gray-800 mb-2">{{ facility.name }}</h3>
        <p class="text-sm text-gray-600">{{ facility.description }}</p>
      </div>
    </div>
  </div>
</section>

      <!-- Tipe Kamar -->
<section class="py-16 bg-gray-50">
  <div class="container mx-auto px-4">
    <div class="text-center mb-12">
      <h2 class="text-3xl font-bold text-gray-800 mb-4">Kamar Terpopuler</h2>
      <p class="text-gray-600 max-w-2xl mx-auto">
        Kamar favorit yang paling sering dipesan
      </p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <div v-for="room in roomTypes" :key="room.name" class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition">
        
        <!-- BAGIAN INI YANG DIGANTI MENJADI GAMBAR -->
        <div class="h-48 overflow-hidden">
           <img :src="room.image" :alt="room.name" class="h-48 w-full object-cover hover:scale-110 transition duration-500" />
        </div>
        <!-- SELESAI GANTI GAMBAR -->

        <div class="p-6">
          <h3 class="text-xl font-bold text-gray-800 mb-2">{{ room.name }}</h3>
          <p class="text-gray-600 text-sm mb-4">{{ room.description }}</p>
          <div class="flex items-center gap-4 mb-4 text-sm text-gray-500">
            <div class="flex items-center gap-1">
              <!-- Icon Orang -->
              <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
              </svg>
              <span>{{ room.capacity }} Orang</span>
            </div>
            <div class="flex items-center gap-1">
              <!-- Icon Luas -->
              <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 4l-5-5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
              </svg>
              <span>{{ room.size }} m²</span>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="text-center mt-8">
      <NuxtLink to="/tamu/kamar" class="inline-flex items-center gap-2 text-red-600 font-semibold hover:text-red-700">
        Lihat Semua Kamar
        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
      </NuxtLink>
    </div>
  </div>
</section>

      <!-- Kenapa Memilih Kami -->
      <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
          <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Mengapa Memilih Kami?</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
              Alasan mengapa Flojachi Hotel menjadi pilihan utama para tamu
            </p>
          </div>
          
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div v-for="reason in reasons" :key="reason.title" class="text-center">
              <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path :d="reason.icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                </svg>
              </div>
              <h3 class="font-bold text-gray-800 mb-2">{{ reason.title }}</h3>
              <p class="text-sm text-gray-600">{{ reason.description }}</p>
            </div>
          </div>
        </div>
      </section>
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
const showDropdown = ref(false)

// Inisialisasi dengan nilai default
const user = ref({
  name: 'Tamu',
  foto_profil: '/default-avatar.png'
})

// Akses localStorage hanya di client side
onMounted(() => {
  if (process.client) {
    user.value.name = sessionStorage.getItem('user_name') || 'Tamu'
    user.value.foto_profil = sessionStorage.getItem('user_foto') || '/default-avatar.png'
  }
})

// Data Fasilitas
const facilities = ref([
  {
    name: 'WiFi Gratis',
    description: 'Akses internet cepat di seluruh area hotel',
    icon: 'M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0'
  },
  {
    name: 'Kolam Renang',
    description: 'Kolam renang outdoor dengan pemandangan indah',
    icon: 'M13 10V3L4 14h7v7l9-11h-7z'
  },
  {
    name: 'Restoran',
    description: 'Menu lokal dan internasional tersedia',
    icon: 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'
  },
  {
    name: 'Fitness Center',
    description: 'Peralatan olahraga modern dan lengkap',
    icon: 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z'
  },
  {
    name: 'Parkir Gratis',
    description: 'Area parkir luas dan aman',
    icon: 'M5 10a2 2 0 012-2h10a2 2 0 012 2v7a2 2 0 01-2 2H7a2 2 0 01-2-2v-7zm4-6a2 2 0 114 0'
  },
  {
    name: 'Room Service',
    description: 'Layanan kamar 24 jam',
    icon: 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'
  }
])

// Data Tipe Kamar
const roomTypes = ref([
  {
    id: 1,
    name: 'Standard Room',
    description: 'Kamar nyaman dengan fasilitas lengkap untuk perjalanan bisnis atau liburan',
    capacity: 2,
    size: 25,
    image: '/standard.jpg'
  },
  {
    id: 2,
    name: 'Deluxe Room',
    description: 'Kamar lebih luas dengan pemandangan kota dan fasilitas premium',
    capacity: 2,
    size: 35,
    image: '/deluxe.jpg'
  },
  {
    id: 3,
    name: 'Suite Room',
    description: 'Kamar suite mewah dengan ruang terpisah dan fasilitas eksklusif',
    capacity: 4,
    size: 50,
    image: '/suite.jpg'
  }
])

// Alasan Memilih
const reasons = ref([
  {
    title: 'Lokasi Strategis',
    description: 'Berada di pusat kota dengan akses mudah ke berbagai destinasi',
    icon: 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z'
  },
  {
    title: 'Harga Terbaik',
    description: 'Harga kompetitif dengan kualitas pelayanan terbaik',
    icon: 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
  },
  {
    title: 'Pelayanan 24/7',
    description: 'Staf kami siap melayani Anda kapan saja',
    icon: 'M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z'
  },
  {
    title: 'Fasilitas Lengkap',
    description: 'Nikmati berbagai fasilitas premium untuk kenyamanan Anda',
    icon: 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z'
  }
])

const formatRupiah = (amount) => {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0
  }).format(amount || 0)
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