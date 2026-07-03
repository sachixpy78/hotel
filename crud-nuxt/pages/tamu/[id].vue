<template>
  <div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50/30">
    <!-- Header -->
    <header class="bg-white/80 backdrop-blur-xl shadow-lg sticky top-0 z-50 transition-all duration-300">
      <div class="container mx-auto px-4 py-4">
        <div class="flex justify-between items-center">
          <NuxtLink to="/tamu" class="flex items-center gap-3 group">
            <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-blue-500/50 transition-all duration-300 group-hover:scale-105">
              <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
              </svg>
            </div>
            <span class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">Flojachi Hotel</span>
          </NuxtLink>
          
          <nav class="hidden md:flex space-x-8">
            <NuxtLink to="/tamu" class="text-gray-700 hover:text-blue-600 font-medium transition-all duration-300 relative group">
              Beranda
              <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
            </NuxtLink>
            <NuxtLink to="/tamu/kamar" class="text-gray-700 hover:text-blue-600 font-medium transition-all duration-300 relative group">
              Kamar
              <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
            </NuxtLink>
            <NuxtLink to="/tamu/pesananku" class="text-blue-600 font-medium transition-all duration-300 relative group">
              Pesananku
              <span class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-600"></span>
            </NuxtLink>
            <NuxtLink to="/tamu/cek-pesanan" class="text-gray-700 hover:text-blue-600 font-medium transition-all duration-300 relative group">
              Cek Pesanan
              <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
            </NuxtLink>
          </nav>
          
          <div class="relative">
            <button @click="showDropdown = !showDropdown" class="flex items-center gap-3 bg-gradient-to-r from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 px-4 py-2.5 rounded-xl transition-all duration-300 shadow-sm hover:shadow-md border border-blue-200">
              <img :src="user.foto_profil || '/default-avatar.png'" class="h-9 w-9 rounded-full object-cover border-2 border-white shadow-sm" />
              <span class="text-sm font-semibold text-gray-800">{{ user.name }}</span>
              <svg class="h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            
            <div v-if="showDropdown" class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-2xl border border-gray-100 z-50 overflow-hidden animate-fade-in">
              <NuxtLink to="/tamu/profile" class="block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all duration-200" @click="showDropdown = false">
                <div class="flex items-center gap-2">
                  <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                  </svg>
                  Profil Saya
                </div>
              </NuxtLink>
              <button @click="logout" class="block w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-all duration-200">
                <div class="flex items-center gap-2">
                  <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                  </svg>
                  Logout
                </div>
              </button>
            </div>
          </div>
        </div>
      </div>
    </header>
    
    <!-- Main Content -->
    <main class="container mx-auto px-4 py-12">
      <!-- BACK BUTTON -->
      <NuxtLink to="/tamu/kamar" class="text-blue-600 hover:text-blue-800 mb-8 inline-flex items-center gap-2 font-medium group">
        <svg class="h-5 w-5 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali ke Daftar Kamar
      </NuxtLink>
      
      <!-- LOADING -->
      <div v-if="loading" class="text-center py-20">
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-blue-50 mb-4">
          <div class="animate-spin rounded-full h-12 w-12 border-4 border-blue-600 border-t-transparent"></div>
        </div>
        <p class="text-gray-600 font-medium">Memuat detail kamar...</p>
      </div>
      
      <!-- ERROR -->
      <div v-else-if="error" class="text-center py-20 bg-white rounded-2xl shadow-sm border border-gray-100">
        <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
          <svg class="h-10 w-10 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
        <p class="text-gray-600 mb-4">{{ error }}</p>
        <NuxtLink to="/tamu/kamar" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 font-medium">
          <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
          </svg>
          Kembali ke Daftar Kamar
        </NuxtLink>
      </div>
      
      <!-- SUCCESS PAGE -->
      <div v-else-if="showSuccess && pemesananBaru" class="max-w-3xl mx-auto">
        <!-- Success Header -->
        <div class="bg-gradient-to-r from-green-600 to-green-700 rounded-2xl p-8 text-white text-center mb-8 shadow-xl shadow-green-600/30">
          <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 backdrop-blur-sm">
            <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
            </svg>
          </div>
          <h1 class="text-3xl font-bold mb-2">🎉 Pemesanan Berhasil!</h1>
          <p class="text-green-100 mb-2">Nomor Pemesanan Anda:</p>
          <p class="font-mono font-bold text-xl bg-white/20 inline-block px-4 py-2 rounded-lg backdrop-blur-sm">{{ pemesananBaru.nomor_pemesanan }}</p>
        </div>
        
        <!-- Booking Details -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
          <div class="bg-gradient-to-r from-blue-50 to-blue-100 px-6 py-4 border-b border-blue-200">
            <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
              <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
              </svg>
              Detail Pemesanan
            </h2>
          </div>
          
          <div class="p-6 space-y-6">
            <div class="grid grid-cols-2 gap-4">
              <div class="bg-gray-50 p-3 rounded-lg">
                <p class="text-gray-500 text-sm mb-1">Nomor Pemesanan</p>
                <p class="font-semibold font-mono text-blue-600">{{ pemesananBaru.nomor_pemesanan }}</p>
              </div>
              <div class="bg-gray-50 p-3 rounded-lg">
                <p class="text-gray-500 text-sm mb-1">Nama Pemesan</p>
                <p class="font-semibold">{{ pemesananBaru.nama_pemesan || user.name }}</p>
              </div>
              <div class="bg-gray-50 p-3 rounded-lg">
                <p class="text-gray-500 text-sm mb-1">Email</p>
                <p class="font-semibold">{{ pemesananBaru.user?.email || user.email }}</p>
              </div>
              <div class="bg-gray-50 p-3 rounded-lg">
                <p class="text-gray-500 text-sm mb-1">Tipe Kamar</p>
                <p class="font-semibold">{{ pemesananBaru.tipe_kamar?.nama }}</p>
              </div>
              <div class="bg-gray-50 p-3 rounded-lg">
                <p class="text-gray-500 text-sm mb-1">Check-in</p>
                <p class="font-semibold">{{ formatDate(pemesananBaru.check_in) }}</p>
              </div>
              <div class="bg-gray-50 p-3 rounded-lg">
                <p class="text-gray-500 text-sm mb-1">Check-out</p>
                <p class="font-semibold">{{ formatDate(pemesananBaru.check_out) }}</p>
              </div>
              <div class="bg-gray-50 p-3 rounded-lg">
                <p class="text-gray-500 text-sm mb-1">Jumlah Kamar</p>
                <p class="font-semibold">{{ pemesananBaru.jumlah_kamar }} kamar</p>
              </div>
              <div class="bg-gray-50 p-3 rounded-lg">
                <p class="text-gray-500 text-sm mb-1">Jumlah Malam</p>
                <p class="font-semibold">{{ pemesananBaru.jumlah_malam }} malam</p>
              </div>
            </div>
            
            <div class="border-t border-gray-200 pt-6">
              <div class="flex justify-between items-center bg-gradient-to-r from-blue-50 to-blue-100 p-4 rounded-xl">
                <p class="text-gray-700 font-semibold">Total Harga</p>
                <p class="text-3xl font-bold text-blue-600">{{ formatRupiah(pemesananBaru.total_harga) }}</p>
              </div>
            </div>
            
            <div class="border-t border-gray-200 pt-4">
              <div class="flex justify-between items-center">
                <p class="text-gray-500 text-sm">Status</p>
                <span :class="getStatusClass(pemesananBaru.status)" class="px-4 py-2 rounded-full text-sm font-semibold">
                  {{ getStatusLabel(pemesananBaru.status) }}
                </span>
              </div>
            </div>

            <!-- Kebijakan Waktu di Struk -->
            <div class="border-t border-gray-200 pt-6">
              <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Ketentuan Waktu
              </h3>
              <div class="space-y-3 text-sm bg-gray-50 p-4 rounded-xl">
                <div class="flex justify-between items-center">
                  <span class="text-gray-600">Check-in</span>
                  <span class="font-semibold text-gray-800">≥ 13:00 (1 siang)</span>
                </div>
                <div class="flex justify-between items-center">
                  <span class="text-gray-600">Check-out</span>
                  <span class="font-semibold text-gray-800">≤ 12:00 (12 siang)</span>
                </div>
                <div class="flex justify-between items-center text-orange-600 font-semibold">
                  <span>Denda keterlambatan</span>
                  <span>Rp 50.000</span>
                </div>
              </div>
              <p class="text-xs text-gray-500 mt-3 italic">
                * Reservasi hangus jika check-in lewat dari jam 13:00
              </p>
            </div>
          </div>
          
          <!-- Action Buttons -->
          <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 flex flex-col sm:flex-row gap-3 print-hide">
            <button @click="cetakBukti" class="flex-1 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white py-3 rounded-xl font-semibold transition-all duration-300 shadow-lg shadow-green-600/30 hover:shadow-xl hover:shadow-green-600/40 hover:scale-105 flex items-center justify-center gap-2">
              <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
              </svg>
              Cetak Bukti Pemesanan
            </button>
            <NuxtLink to="/tamu/pesananku" class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white py-3 rounded-xl font-semibold text-center transition-all duration-300 shadow-lg shadow-blue-600/30 hover:shadow-xl hover:shadow-blue-600/40 hover:scale-105">
              Masuk ke Pesananku
            </NuxtLink>
          </div>
        </div>
      </div>
      
      <!-- BOOKING FORM -->
      <div v-else-if="kamar" class="max-w-5xl mx-auto">
        <div class="mb-8">
          <div class="inline-block mb-2 px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold">
            Form Pemesanan
          </div>
          <h1 class="text-4xl font-bold text-gray-800">Lengkapi Data Pemesanan</h1>
        </div>
        
        <div class="space-y-6">
          <!-- Room Details dengan Gambar Besar -->
          <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <!-- GAMBAR KAMAR BESAR -->
            <div class="h-72 md:h-96 overflow-hidden bg-gray-100 relative">
              <img 
                :src="getFotoUrl(kamar.foto)" 
                :alt="kamar.nama" 
                class="w-full h-full object-cover"
                @error="handleImageError"
              />
              <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-semibold text-blue-600 shadow-lg">
                Tersedia {{ stokTersedia }} kamar
              </div>
            </div>
            
            <div class="p-6">
              <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
                <div>
                  <h2 class="text-3xl font-bold text-gray-800">{{ kamar.nama }}</h2>
                  <p class="text-gray-600 mt-1 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    {{ kamar.tipe_tempat_tidur || 'Tempat tidur standar' }}
                  </p>
                </div>
                <div class="text-right">
                  <span class="text-3xl font-bold text-blue-600">{{ formatRupiah(kamar.harga_per_malam) }}</span>
                  <span class="text-gray-500">/malam</span>
                </div>
              </div>
              
              <!-- Fasilitas -->
              <div class="mt-6 pt-6 border-t border-gray-200">
                <h3 class="text-sm font-bold text-gray-700 mb-3 flex items-center gap-2">
                  <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                  </svg>
                  Fasilitas:
                </h3>
                <div class="flex flex-wrap gap-2">
                  <span v-for="(f, i) in parseFasilitas(kamar.fasilitas)" :key="i" class="px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg text-sm font-medium border border-blue-200">
                    {{ f }}
                  </span>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Booking Details -->
          <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
              <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
              Detail Pemesanan
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Check-in</label>
                <div class="relative">
                  <input type="date" v-model="form.check_in" class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-gray-50 focus:ring-2 focus:ring-blue-500 outline-none" readonly disabled>
                </div>
              </div>
              <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Check-out</label>
                <div class="relative">
                  <input type="date" v-model="form.check_out" class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-gray-50 focus:ring-2 focus:ring-blue-500 outline-none" readonly disabled>
                </div>
              </div>
              <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Kamar</label>
                <input type="number" v-model.number="form.jumlah_kamar" min="1" :max="stokTersedia" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none hover:border-gray-400 transition">
                <p class="text-xs text-gray-500 mt-2">Maksimal {{ stokTersedia }} kamar tersedia</p>
              </div>
              <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Malam</label>
                <div class="relative">
                  <input type="text" :value="jumlahMalam + ' malam'" class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-gray-50" readonly disabled>
                </div>
              </div>
            </div>
            
            <div class="mt-6 pt-6 border-t border-gray-200 flex justify-between items-center bg-gradient-to-r from-blue-50 to-blue-100 p-4 rounded-xl">
              <span class="font-bold text-gray-800 text-lg">Total Harga</span>
              <span class="text-3xl font-bold text-blue-600">{{ formatRupiah(totalHarga) }}</span>
            </div>
          </div>
          
          <!-- Guest Data -->
          <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
              <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
              </svg>
              Data Pemesan
            </h2>
            <div class="space-y-4">
              <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                <!-- ✅ UBAH: Input nama pemesan bisa diedit -->
                <input 
                  type="text" 
                  v-model="form.nama_pemesan" 
                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none hover:border-gray-400 transition"
                  placeholder="Masukkan nama pemesan"
                >
                <p class="text-xs text-gray-500 mt-1">* Bisa diisi nama tamu lain jika memesan untuk orang lain</p>
              </div>
              <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                <input type="email" :value="user.email" class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-gray-50" readonly>
              </div>
            </div>
          </div>
          
          <!-- Payment Method -->
          <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
              <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
              </svg>
              Metode Pembayaran
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
              <button 
                @click="form.metode_pembayaran = 'tunai'"
                :class="form.metode_pembayaran === 'tunai' ? 'bg-green-100 border-green-500 ring-2 ring-green-500 shadow-lg shadow-green-500/30' : 'bg-gray-50 border-gray-200 hover:border-gray-300'"
                class="p-5 border-2 rounded-xl transition-all duration-300 flex items-center justify-center gap-3"
                :disabled="totalHarga > 500000"
              >
                <span class="text-3xl">💵</span>
                <div class="text-left">
                  <span class="font-bold block">Bayar Tunai</span>
                  <span class="text-sm text-gray-600">(Cash)</span>
                </div>
              </button>
              <button 
                @click="form.metode_pembayaran = 'transfer'"
                :class="form.metode_pembayaran === 'transfer' ? 'bg-blue-100 border-blue-500 ring-2 ring-blue-500 shadow-lg shadow-blue-500/30' : 'bg-gray-50 border-gray-200 hover:border-gray-300'"
                class="p-5 border-2 rounded-xl transition-all duration-300 flex items-center justify-center gap-3"
              >
                <span class="text-3xl">🏦</span>
                <div class="text-left">
                  <span class="font-bold block">Transfer Bank</span>
                  <span class="text-sm text-gray-600">(Online)</span>
                </div>
              </button>
            </div>

            <!-- KEBIJAKAN WAKTU -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl border border-blue-200 p-6 mb-6">
              <h2 class="text-lg font-bold mb-4 flex items-center gap-2 text-blue-800">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Kebijakan Waktu
              </h2>
              
              <div class="space-y-4 text-sm">
                <!-- Check-in Policy -->
                <div class="flex gap-4 p-4 bg-orange-50 border border-orange-200 rounded-xl">
                  <span class="text-3xl">🕐</span>
                  <div>
                    <p class="font-bold text-orange-800">Check-in: Mulai jam 13:00 (1 siang)</p>
                    <p class="text-orange-700 mt-1">
                      ⚠️ Jika tamu datang <strong>melebihi jam 13:00</strong> pada tanggal check-in, 
                      reservasi dianggap <strong>hangus (no-show)</strong> dan tidak dapat refund.
                    </p>
                  </div>
                </div>
                
                <!-- Check-out Policy -->
                <div class="flex gap-4 p-4 bg-blue-50 border border-blue-200 rounded-xl">
                  <span class="text-3xl">🕛</span>
                  <div>
                    <p class="font-bold text-blue-800">Check-out: Maksimal jam 12:00 (12 siang)</p>
                    <p class="text-blue-700 mt-1">
                      ⚠️ Jika tamu check-out <strong>melebihi jam 12:00</strong>, 
                      akan dikenakan <strong>denda keterlambatan Rp 50.000</strong>.
                    </p>
                  </div>
                </div>
                
                <!-- Info Tambahan -->
                <p class="text-xs text-gray-600 italic bg-white/50 p-3 rounded-lg">
                  * Kebijakan ini berlaku untuk semua tipe kamar. Hubungi resepsionis untuk permintaan khusus.
                </p>
              </div>
            </div>
            
            <!-- Bank Info -->
            <div v-if="form.metode_pembayaran === 'transfer'" class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-xl p-5">
              <p class="font-bold text-blue-800 mb-3 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
                Transfer ke rekening berikut:
              </p>
              <div class="space-y-2 text-sm text-blue-900 bg-white/50 p-4 rounded-lg">
                <p class="flex items-center gap-2">🏦 Bank BCA - 1234567890 a.n Flojachi Hotel</p>
                <p class="flex items-center gap-2">🏦 Bank Mandiri - 0987654321 a.n Flojachi Hotel</p>
                <p class="flex items-center gap-2">🏦 Bank BRI - 5678901234 a.n Flojachi Hotel</p>
              </div>
              <p class="text-xs text-blue-600 mt-3 flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                Setelah transfer, pesanan akan kami proses
              </p>
            </div>
            
            <!-- Warning -->
            <p v-if="totalHarga > 500000 && form.metode_pembayaran === 'tunai'" class="text-red-600 text-sm mt-4 p-4 bg-red-50 border border-red-200 rounded-xl flex items-center gap-2">
              <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <span>⚠️ Total di atas Rp 500.000, wajib transfer bank!</span>
            </p>
          </div>
          
          <!-- Notes -->
          <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan (opsional)</label>
            <textarea v-model="form.catatan" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none resize-none hover:border-gray-400 transition" placeholder="Permintaan khusus..."></textarea>
          </div>
          
          <!-- Action Buttons -->
          <div class="flex gap-4 print-hide">
            <button 
              @click="buatPemesanan" 
              :disabled="submitting || !form.metode_pembayaran || (totalHarga > 500000 && form.metode_pembayaran === 'tunai')"
              class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 disabled:from-gray-400 disabled:to-gray-500 text-white py-4 rounded-xl font-bold transition-all duration-300 shadow-lg shadow-blue-600/30 hover:shadow-xl hover:shadow-blue-600/40 hover:scale-105 disabled:shadow-none disabled:cursor-not-allowed disabled:hover:scale-100"
            >
              {{ submitting ? 'Memproses...' : 'Pesan Sekarang' }}
            </button>
            <NuxtLink to="/tamu/kamar" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 py-4 rounded-xl font-bold text-center transition-all duration-300">
              Batal
            </NuxtLink>
          </div>
        </div>
      </div>
    </main>
    
    <!-- Footer -->
    <footer class="bg-gray-900 text-white mt-16 py-12 print-hide">
      <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
          <div>
            <div class="flex items-center gap-3 mb-4">
              <div class="w-12 h-12 bg-gradient-to-br from-red-600 to-red-700 rounded-xl flex items-center justify-center shadow-lg">
                <svg class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
              </div>
              <span class="text-2xl font-bold">Flojachi Hotel</span>
            </div>
            <p class="text-gray-400 leading-relaxed">
              Hotel berbintang dengan pelayanan terbaik untuk pengalaman menginap yang tak terlupakan.
            </p>
          </div>
          
          <div>
            <h3 class="font-bold mb-4 text-xl">Kontak Kami</h3>
            <ul class="space-y-3 text-gray-400">
              <li class="flex items-start gap-3">
                <svg class="h-5 w-5 mt-1 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>Jl. Kedung Sumur No. 123, Kota</span>
              </li>
              <li class="flex items-center gap-3">
                <svg class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                info@flojachihotel.com
              </li>
              <li class="flex items-center gap-3">
                <svg class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
                (+62) 821-0668-551
              </li>
            </ul>
          </div>
          
          <div>
            <h3 class="font-bold mb-4 text-xl">Jam Operasional</h3>
            <ul class="space-y-3 text-gray-400">
              <li class="flex items-center gap-2">
                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                Resepsionis: 24 Jam
              </li>
              <li>Check-in: 13:00 WIB</li>
              <li>Check-out: 12:00 WIB</li>
              <li>Restoran: 06:00 - 22:00 WIB</li>
            </ul>
          </div>
        </div>
        
        <div class="border-t border-gray-800 pt-8 text-center text-gray-400">
          <p>&copy; 2025 Flojachi Hotel. All rights reserved.</p>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'

const route = useRoute()
const router = useRouter()
const kamarId = route.params.id

// State
const showDropdown = ref(false)
const loading = ref(true)
const submitting = ref(false)
const error = ref(null)
const kamar = ref(null)
const pemesananBaru = ref(null)
const showSuccess = ref(false)

const user = ref({
  name: '',
  email: '',
  foto_profil: '/default-avatar.png'
})

const form = ref({
  check_in: route.query.check_in || '',
  check_out: route.query.check_out || '',
  jumlah_kamar: 1,
  catatan: '',
  metode_pembayaran: '',
  nama_pemesan: '' // ✅ TAMBAHKAN: Field nama pemesan yang bisa diedit
})

// Computed
const jumlahMalam = computed(() => {
  if (!form.value.check_in || !form.value.check_out) return 0
  const checkIn = new Date(form.value.check_in)
  const checkOut = new Date(form.value.check_out)
  const diffTime = Math.abs(checkOut - checkIn)
  return Math.ceil(diffTime / (1000 * 60 * 60 * 24))
})

const totalHarga = computed(() => {
  if (!kamar.value) return 0
  return kamar.value.harga_per_malam * jumlahMalam.value * form.value.jumlah_kamar
})

const stokTersedia = computed(() => {
  return kamar.value?.stok_tersedia ?? kamar.value?.stok ?? 0
})

// Methods
const formatRupiah = (amount) => {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0
  }).format(amount)
}

const formatDate = (date) => {
  if (!date) return '-'
  return new Date(date).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })
}

const getStatusClass = (status) => {
  const classes = {
    'baru': 'bg-blue-100 text-blue-800 border border-blue-200',
    'menunggu_pembayaran': 'bg-yellow-100 text-yellow-800 border border-yellow-200',
    'menunggu_verifikasi': 'bg-orange-100 text-orange-800 border border-orange-200',
    'terkonfirmasi': 'bg-green-100 text-green-800 border border-green-200',
    'check_in': 'bg-purple-100 text-purple-800 border border-purple-200',
    'check_out': 'bg-gray-100 text-gray-800 border border-gray-200',
    'batal': 'bg-red-100 text-red-800 border border-red-200'
  }
  return classes[status] || 'bg-gray-100 text-gray-800 border border-gray-200'
}

const getStatusLabel = (status) => {
  const labels = {
    'baru': 'Baru',
    'menunggu_pembayaran': 'Menunggu Konfirmasi',
    'menunggu_verifikasi': 'Menunggu Verifikasi',
    'terkonfirmasi': 'Terkonfirmasi',
    'check_in': 'Check-in',
    'check_out': 'Check-out',
    'batal': 'Batal'
  }
  return labels[status] || status
}

// ✅ FUNGSI GAMBAR YANG DIPERBAIKI
const getFotoUrl = (foto) => {
  if (!foto) return '/default-room.jpg'
  if (foto.startsWith('http')) return foto
  return `http://localhost:8000/storage/${foto}`
}

const handleImageError = (e) => {
  e.target.src = '/default-room.jpg'
}

const parseFasilitas = (fasilitas) => {
  if (!fasilitas) return []
  return fasilitas.split(/[\n,]+/).map(f => f.trim()).filter(f => f)
}

const logout = () => {
  if (confirm('Apakah Anda yakin ingin logout?')) {
    sessionStorage.clear()
    router.push('/')
  }
}

const cetakBukti = () => {
  window.print()
}

const fetchKamar = async () => {
  loading.value = true
  error.value = null
  
  try {
    const response = await $fetch(`http://localhost:8000/api/room-types/${kamarId}`, {
      headers: { 'Accept': 'application/json' }
    })
    
    if (response.success) {
      kamar.value = response.data
      if (form.value.check_in && form.value.check_out) {
        await cekStok()
      }
    } else {
      error.value = response.message || 'Kamar tidak ditemukan'
    }
  } catch (err) {
    console.error('Fetch error:', err)
    error.value = err.data?.message || 'Kamar tidak ditemukan'
  } finally {
    loading.value = false
  }
}

const cekStok = async () => {
  if (!form.value.check_in || !form.value.check_out || !kamar.value) return
  
  try {
    const response = await $fetch('http://localhost:8000/api/cari-kamar', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: {
        check_in: form.value.check_in,
        check_out: form.value.check_out
      }
    })
    if (response.success) {
      const found = response.data.find(k => k.id == kamarId)
      if (found) {
        kamar.value.stok_tersedia = found.stok_tersedia
      }
    }
  } catch (err) {
    console.error('Cek stok error:', err)
  }
}

const buatPemesanan = async () => {
  // Validasi frontend
  if (!form.value.check_in || !form.value.check_out) {
    alert('Tanggal check-in dan check-out harus diisi')
    return
  }
  
  if (form.value.jumlah_kamar < 1) {
    alert('Jumlah kamar minimal 1')
    return
  }
  
  if (form.value.jumlah_kamar > stokTersedia.value) {
    alert(`Stok tidak mencukupi. Tersedia ${stokTersedia.value} kamar`)
    return
  }
  
  if (!form.value.metode_pembayaran) {
    alert('Pilih metode pembayaran')
    return
  }
  
  // ✅ Validasi nama pemesan tidak boleh kosong
  if (!form.value.nama_pemesan?.trim()) {
    alert('Nama pemesan harus diisi')
    return
  }
  
  if (totalHarga.value > 500000 && form.value.metode_pembayaran === 'tunai') {
    alert('Total di atas Rp 500.000 wajib transfer bank')
    return
  }
  
  submitting.value = true
  
  try {
    const token = sessionStorage.getItem('auth_token')
    if (!token) {
      throw new Error('Silakan login terlebih dahulu')
    }
    
    // ✅ Payload dengan nama_pemesan dari form (bisa diedit)
    const response = await $fetch('http://localhost:8000/api/tamu/pesan', {
      method: 'POST',
      body: {
        tipe_kamar_id: kamarId,
        jumlah_kamar: form.value.jumlah_kamar,
        check_in: form.value.check_in,
        check_out: form.value.check_out,
        metode_pembayaran: form.value.metode_pembayaran,
        catatan: form.value.catatan,
        nama_pemesan: form.value.nama_pemesan?.trim() || user.value.name
      },
      headers: {
        'Authorization': `Bearer ${token}`,
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      }
    })
    
    if (response.success) {
      pemesananBaru.value = response.data
      showSuccess.value = true
      window.scrollTo({ top: 0, behavior: 'smooth' })
    }
  } catch (err) {
    console.error('Booking error:', err)
    if (err.data?.errors) {
      let errorMsg = '❌ Validasi gagal:\n'
      for (let field in err.data.errors) {
        errorMsg += `- ${field}: ${err.data.errors[field].join(', ')}\n`
      }
      alert(errorMsg)
    } else {
      alert('❌ ' + (err.data?.message || err.message || 'Gagal membuat pemesanan'))
    }
  } finally {
    submitting.value = false
  }
}

// Lifecycle
onMounted(async () => {
  const token = sessionStorage.getItem('auth_token')
  if (!token) {
    if (confirm('Anda harus login untuk memesan kamar. Login sekarang?')) {
      router.push(`/login?redirect=${route.fullPath}`)
    } else {
      router.push('/tamu/kamar')
    }
    return
  }
  
  // ✅ Load user data dan pre-fill nama pemesan
  user.value.name = sessionStorage.getItem('user_name') || 'Tamu'
  user.value.email = sessionStorage.getItem('user_email') || ''
  user.value.foto_profil = sessionStorage.getItem('user_foto') || '/default-avatar.png'
  
  // ✅ Pre-fill nama pemesan dari session (bisa diedit user)
  form.value.nama_pemesan = user.value.name
  
  if (!route.query.check_in || !route.query.check_out) {
    error.value = 'Tanggal check-in dan check-out harus dipilih'
    loading.value = false
    return
  }
  
  await fetchKamar()
})
</script>

<style scoped>
@keyframes fade-in {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-fade-in {
  animation: fade-in 0.2s ease-out;
}

@media print {
  header, footer, button, a, .print-hide {
    display: none !important;
  }
  main {
    padding: 0 !important;
  }
  .bg-white {
    box-shadow: none !important;
  }
}
</style>