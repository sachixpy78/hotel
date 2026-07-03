<template>
  <div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50/30 flex">
    <!-- Sidebar - SESUAIKAN DENGAN INDEX.VUE -->
    <aside class="w-72 bg-gradient-to-b from-slate-900 via-red-900 to-slate-900 min-h-screen text-white fixed left-0 top-0 z-30 shadow-2xl">
      <!-- Profile Section -->
      <div class="p-8 text-center border-b border-blue-800/50 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-blue-600/20 to-transparent pointer-events-none"></div>
        <div class="relative">
          <div class="mb-4 inline-block p-1 rounded-full bg-gradient-to-r from-blue-400 to-blue-600">
            <img 
              :key="imageKey"
              :src="getUserFotoUrl(user.foto_profil)"
              @error="handleImageError"
              alt="Resepsionis" 
              class="h-24 w-24 rounded-full border-4 border-slate-900 object-cover shadow-xl"
            />
          </div>
          <div class="absolute bottom-4 right-1/4 w-4 h-4 bg-green-500 border-4 border-slate-900 rounded-full"></div>
        </div>
        <h3 class="font-bold text-xl mt-3 bg-gradient-to-r from-white to-blue-200 bg-clip-text text-transparent">{{ user.nama }}</h3>
        <p class="text-xs text-blue-300 mt-1 font-medium tracking-wide uppercase">Resepsionis</p>
      </div>

      <!-- Menu Navigation -->
      <nav class="mt-6 px-3">
        <NuxtLink 
          to="/resepsionis" 
          class="group flex items-center px-4 py-3.5 mb-1 rounded-xl transition-all duration-300 hover:shadow-lg hover:shadow-blue-900/50"
          :class="{ 'bg-gradient-to-r from-blue-600 to-blue-700 shadow-lg shadow-blue-900/50': $route.path === '/resepsionis' }"
        >
          <div class="p-2 rounded-lg mr-3 transition-all duration-300 group-hover:scale-110" :class="$route.path === '/resepsionis' ? 'bg-white/20' : 'bg-blue-800/50 group-hover:bg-blue-700'">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
          </div>
          <span class="font-medium text-sm">Dashboard</span>
          <svg v-if="$route.path === '/resepsionis'" class="h-4 w-4 ml-auto opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </NuxtLink>
        
        <NuxtLink 
          to="/resepsionis/data-pemesanan" 
          class="group flex items-center px-4 py-3.5 mb-1 rounded-xl transition-all duration-300 hover:shadow-lg hover:shadow-blue-900/50"
          :class="{ 'bg-gradient-to-r from-blue-600 to-blue-700 shadow-lg shadow-blue-900/50': $route.path.includes('data-pemesanan') }"
        >
          <div class="p-2 rounded-lg mr-3 transition-all duration-300 group-hover:scale-110" :class="$route.path.includes('data-pemesanan') ? 'bg-white/20' : 'bg-blue-800/50 group-hover:bg-blue-700'">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
          </div>
          <span class="font-medium text-sm">Data Pemesanan</span>
          <svg v-if="$route.path.includes('data-pemesanan')" class="h-4 w-4 ml-auto opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </NuxtLink>
        
        <NuxtLink 
          to="/resepsionis/laporan" 
          class="group flex items-center px-4 py-3.5 mb-1 rounded-xl transition-all duration-300 hover:shadow-lg hover:shadow-blue-900/50"
          :class="{ 'bg-gradient-to-r from-blue-600 to-blue-700 shadow-lg shadow-blue-900/50': $route.path.includes('laporan') }"
        >
          <div class="p-2 rounded-lg mr-3 transition-all duration-300 group-hover:scale-110" :class="$route.path.includes('laporan') ? 'bg-white/20' : 'bg-blue-800/50 group-hover:bg-blue-700'">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
          </div>
          <span class="font-medium text-sm">Laporan</span>
          <svg v-if="$route.path.includes('laporan')" class="h-4 w-4 ml-auto opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </NuxtLink>
      </nav>
      
      <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-blue-800/50">
        <button @click="handleLogout" class="flex items-center gap-3 px-4 py-3 text-red-400 hover:bg-red-900/20 rounded-xl transition w-full group">
          <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
          </svg>
          <span class="font-medium">Logout</span>
        </button>
      </div>

      <!-- Bottom decoration -->
      <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-500 via-purple-500 to-blue-500"></div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 ml-72">
      <!-- Header -->
      <header class="bg-white/80 backdrop-blur-xl border-b border-gray-200/60 px-8 py-5 flex items-center justify-between sticky top-0 z-40 shadow-sm">
        <div>
          <h1 class="text-2xl font-bold bg-gradient-to-r from-slate-800 to-slate-600 bg-clip-text text-transparent">Data Pemesanan</h1>
          <p class="text-sm text-gray-500 mt-1">Kelola check-in, check-out, dan verifikasi tamu</p>
        </div>
        
        <!-- Profile Dropdown -->
        <div class="relative" ref="profileRef">
          <button @click="toggleProfileDropdown" class="flex items-center gap-3 px-4 py-2.5 bg-white border border-gray-200 hover:border-blue-300 hover:shadow-md rounded-xl transition-all duration-300 group">
  <div class="relative">
    <img 
      :key="imageKey + 'header'"
      :src="getUserFotoUrl(user.foto_profil)"
      @error="handleProfileImageError"
      alt="Profile"
      class="w-9 h-9 rounded-xl border-2 border-gray-200 object-cover shadow-sm group-hover:border-blue-300 transition-colors"
    />
    <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></div>
  </div>
  <span class="text-sm font-semibold text-gray-700 hidden md:block">{{ userName }}</span>
  <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
  </svg>
</button>
          
         <!-- Dropdown Menu -->
            <div v-if="showProfileDropdown" class="absolute right-0 mt-2 w-48 bg-gray-800 border border-gray-700 rounded-lg shadow-xl py-1 z-50">
              <NuxtLink to="/resepsionis/prof" class="flex items-center gap-3 px-4 py-3 text-gray-300 hover:bg-gray-700 transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Profil Saya
              </NuxtLink>
              <button @click="logout" class="flex items-center gap-3 px-4 py-3 text-red-400 hover:bg-gray-700 transition w-full text-left">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Logout
              </button>
            </div>
        </div>
      </header>

      <!-- Content -->
      <div class="p-8">
        <!-- 🔍 QR Scan Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
          <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
            <div class="p-2 bg-blue-100 rounded-lg">
              <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
              </svg>
            </div>
            Scan QR Code / Cari Pemesanan
          </h3>
          
          <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
              <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Pemesanan / QR Code</label>
              <div class="flex gap-2">
                <input 
                  v-model="scanInput" 
                  type="text" 
                  placeholder="Masukkan nomor pemesanan atau scan QR"
                  class="flex-1 px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition hover:border-gray-400"
                  @keyup.enter="handleScan"
                />
                <button 
                  @click="handleScan" 
                  :disabled="isScanning"
                  class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 disabled:from-blue-400 disabled:to-blue-500 rounded-xl text-white font-semibold transition-all flex items-center gap-2 shadow-lg shadow-blue-600/30 hover:shadow-xl hover:shadow-blue-600/40 hover:scale-105"
                >
                  <span v-if="isScanning">Memindai...</span>
                  <span v-else>🔍 Scan</span>
                </button>
              </div>
              <p class="text-xs text-gray-500 mt-2">💡 Tips: Masukkan nomor pemesanan manual atau scan QR code tamu</p>
            </div>
          </div>
        </div>

        <!-- 📋 Modal: Detail Pemesanan -->
        <div v-if="showBookingModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
          <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full p-6 max-h-[90vh] overflow-y-auto">
            <div class="flex items-start justify-between mb-6">
              <div>
                <h3 class="text-2xl font-bold text-gray-800">Detail Pemesanan</h3>
                <p class="text-sm text-gray-500 mt-1">Informasi lengkap pemesanan tamu</p>
              </div>
              <button @click="closeBookingModal" class="text-gray-400 hover:text-gray-600 p-2 hover:bg-gray-100 rounded-xl transition">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>
            
            <div v-if="scannedBooking" class="space-y-6">
              <!-- Header dengan Status -->
              <div class="bg-gradient-to-br from-slate-50 to-blue-50/50 rounded-xl p-5 border border-gray-200">
                <div class="flex justify-between items-center mb-3">
                  <span class="text-gray-600 font-medium">Nomor Pemesanan</span>
                  <span class="font-mono text-lg font-bold text-blue-600">{{ scannedBooking.nomor_pemesanan }}</span>
                </div>
                <div class="flex justify-between items-center">
                  <span class="text-gray-600 font-medium">Status</span>
                  <span :class="getStatusBadge(scannedBooking.status)" class="px-4 py-1.5 rounded-full text-sm font-semibold shadow-sm">
                    {{ getStatusLabel(scannedBooking.status) }}
                  </span>
                </div>
              </div>
              
              <!-- Data Pemesan -->
              <div>
                <h4 class="text-lg font-bold text-gray-800 mb-3 flex items-center gap-2">
                  <div class="p-1.5 bg-blue-100 rounded-lg">
                    <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                  </div>
                  Data Pemesan
                </h4>
                <div class="grid grid-cols-2 gap-4 bg-gray-50 rounded-xl p-5 border border-gray-200">
                  <div>
                    <p class="text-gray-500 text-sm font-medium">Nama Lengkap</p>
                    <p class="font-semibold text-gray-800 mt-1">{{ scannedBooking.nama_pemesan }}</p>
                  </div>
                  <div>
                    <p class="text-gray-500 text-sm font-medium">Email</p>
                    <p class="font-semibold text-gray-800 mt-1">{{ scannedBooking.email }}</p>
                  </div>
                  <div>
                    <p class="text-gray-500 text-sm font-medium">No. Telepon</p>
                    <p class="font-semibold text-gray-800 mt-1">{{ scannedBooking.no_telp || '-' }}</p>
                  </div>
                  <div>
                    <p class="text-gray-500 text-sm font-medium">Metode Pembayaran</p>
                    <p class="font-semibold text-gray-800 mt-1 capitalize">{{ scannedBooking.metode_pembayaran || 'tunai' }}</p>
                  </div>
                </div>
              </div>
              
              <!-- Detail Kamar -->
              <div>
                <h4 class="text-lg font-bold text-gray-800 mb-3 flex items-center gap-2">
                  <div class="p-1.5 bg-blue-100 rounded-lg">
                    <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                  </div>
                  Detail Kamar
                </h4>
                <div class="grid grid-cols-2 gap-4 bg-gray-50 rounded-xl p-5 border border-gray-200">
                  <div>
                    <p class="text-gray-500 text-sm font-medium">Tipe Kamar</p>
                    <p class="font-semibold text-gray-800 mt-1">{{ scannedBooking.tipe_kamar }}</p>
                  </div>
                  <div>
                    <p class="text-gray-500 text-sm font-medium">Jumlah Kamar</p>
                    <p class="font-semibold text-gray-800 mt-1">{{ scannedBooking.jumlah_kamar || 1 }} kamar</p>
                  </div>
                  <div>
                    <p class="text-gray-500 text-sm font-medium">Check-in</p>
                    <p class="font-semibold text-gray-800 mt-1">{{ formatDate(scannedBooking.check_in) }}</p>
                  </div>
                  <div>
                    <p class="text-gray-500 text-sm font-medium">Check-out</p>
                    <p class="font-semibold text-gray-800 mt-1">{{ formatDate(scannedBooking.check_out) }}</p>
                  </div>
                  <div>
                    <p class="text-gray-500 text-sm font-medium">Jumlah Malam</p>
                    <p class="font-semibold text-gray-800 mt-1">{{ scannedBooking.jumlah_malam }} malam</p>
                  </div>
                  <div>
                    <p class="text-gray-500 text-sm font-medium">Total Harga</p>
                    <p class="font-bold text-green-600 text-lg mt-1">{{ formatRupiah(scannedBooking.total_harga) }}</p>
                  </div>
                </div>
              </div>

              <!-- BUKTI TRANSFER -->
              <div v-if="scannedBooking.metode_pembayaran === 'transfer' && scannedBooking.bukti_transfer" class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                <h4 class="text-lg font-bold text-gray-800 mb-3 flex items-center gap-2">
                  <div class="p-1.5 bg-blue-100 rounded-lg">
                    <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                  </div>
                  Bukti Transfer
                </h4>
                <div class="bg-white rounded-xl p-4 text-center border-2 border-dashed border-gray-300 hover:border-blue-400 transition">
                  <img 
                    :src="getBuktiTransferUrl(scannedBooking.bukti_transfer)" 
                    alt="Bukti Transfer"
                    class="max-h-64 mx-auto rounded-lg shadow-md cursor-pointer hover:opacity-90 transition"
                    @click="openImageModal(scannedBooking.bukti_transfer)"
                    @error="handleImageError"
                  />
                  <p class="text-sm text-gray-500 mt-3">📎 Klik gambar untuk memperbesar</p>
                </div>
              </div>
              
              <!-- Action Buttons -->
              <div class="flex gap-3 pt-6 border-t border-gray-200">
                <button 
                  v-if="scannedBooking.status === 'menunggu_verifikasi'"
                  @click="openVerifyModalFromModal"
                  class="flex-1 px-4 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 rounded-xl text-white font-semibold transition-all flex items-center justify-center gap-2 shadow-lg shadow-blue-600/30 hover:shadow-xl"
                >
                  <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  Verifikasi Pembayaran
                </button>
                
                <button 
                  v-if="scannedBooking.status === 'dibayar'"
                  @click="openCheckInModalFromModal"
                  class="flex-1 px-4 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 rounded-xl text-white font-semibold transition-all flex items-center justify-center gap-2 shadow-lg shadow-green-600/30 hover:shadow-xl"
                >
                  <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                  </svg>
                  Check-in Tamu
                </button>
                
                <button 
                  v-if="scannedBooking.status === 'check_in'"
                  @click="openCheckoutModalFromModal"
                  class="flex-1 px-4 py-3 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 rounded-xl text-white font-semibold transition-all flex items-center justify-center gap-2 shadow-lg shadow-orange-600/30 hover:shadow-xl"
                >
                  <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                  </svg>
                  Check-out Tamu
                </button>

                <button 
                  v-if="['menunggu_pembayaran', 'menunggu_verifikasi', 'dibayar'].includes(scannedBooking.status)"
                  @click="openCancelModalFromModal"
                  class="flex-1 px-4 py-3 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 rounded-xl text-white font-semibold transition-all flex items-center justify-center gap-2 shadow-lg shadow-red-600/30 hover:shadow-xl"
                >
                  <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                  </svg>
                  Batalkan Pesanan
                </button>
                
                <button 
                  @click="closeBookingModal"
                  class="px-6 py-3 bg-gray-100 hover:bg-gray-200 rounded-xl text-gray-700 font-semibold transition"
                >
                  Tutup
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- 📊 Table: Daftar Pemesanan -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
          <div class="px-6 py-5 border-b border-gray-200 flex items-center justify-between bg-gradient-to-r from-slate-50 to-white">
            <h3 class="text-lg font-bold text-gray-800">Daftar Pemesanan</h3>
            
            <!-- Filters -->
            <div class="flex gap-3">
              <select 
                v-model="filterStatus" 
                @change="fetchBookings"
                class="px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white hover:border-gray-400 transition font-medium"
              >
                <option value="check_in">Check-in</option>
                <option value="">Semua Status</option>
                <option value="menunggu_verifikasi">Menunggu Verifikasi</option>
                <option value="dibayar">Dibayar</option>
                <option value="check_out">Check-out</option>
                <option value="batal">Batal</option>
              </select>
              
              <input 
                v-model="searchQuery"
                @keyup.enter="fetchBookings"
                type="text" 
                placeholder="Cari nama/nomor..."
                class="px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none hover:border-gray-400 transition"
              />
            </div>
          </div>
          
          <div class="overflow-x-auto">
            <table class="w-full">
              <thead class="bg-gradient-to-r from-slate-50 to-gray-50 border-b border-gray-200">
                <tr>
                  <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No. Pemesanan</th>
                  <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Tamu</th>
                  <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kamar</th>
                  <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Check-in</th>
                  <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Check-out</th>
                  <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                  <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-100">
                <tr v-for="booking in bookings" :key="booking.id" 
                    :class="{'bg-red-50 border-l-4 border-red-500': isLateCheckout(booking)}"
                    class="hover:bg-gradient-to-r hover:from-blue-50/30 hover:to-transparent transition-all duration-300"
                >
                  <td class="px-6 py-4 text-sm font-mono font-semibold text-gray-800">{{ booking.nomor_pemesanan }}</td>
                  <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ booking.nama_pemesan }}</td>
                  <td class="px-6 py-4 text-sm text-gray-600">{{ booking.tipe_kamar }} <span class="text-gray-400">({{ booking.jumlah_kamar || 1 }})</span></td>
                  <td class="px-6 py-4 text-sm text-gray-600">{{ booking.check_in }}</td>
                  <td class="px-6 py-4 text-sm">
                    <span :class="{'text-red-600 font-semibold': isLateCheckout(booking)}">
                      {{ booking.check_out }}
                    </span>
                    <span v-if="isLateCheckout(booking)" class="ml-2 text-xs text-red-600 font-bold bg-red-100 px-2 py-1 rounded-full">⚠️ Terlambat</span>
                  </td>
                  <td class="px-6 py-4">
                    <span :class="getStatusBadge(booking.status)" class="px-3 py-1.5 rounded-full text-xs font-semibold shadow-sm">
                      {{ getStatusLabel(booking.status) }}
                    </span>
                  </td>
                  <td class="px-6 py-4">
                    <div class="flex gap-2">
                      <button 
                        v-if="booking.status === 'menunggu_verifikasi'"
                        @click="openVerifyModal(booking)"
                        class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 rounded-lg text-xs text-white font-medium transition shadow-md hover:shadow-lg"
                      >
                        Verifikasi
                      </button>
                      <button 
                        v-if="booking.status === 'dibayar'"
                        @click="openCheckInModal(booking)"
                        class="px-3 py-1.5 bg-green-600 hover:bg-green-700 rounded-lg text-xs text-white font-medium transition shadow-md hover:shadow-lg"
                      >
                        Check-in
                      </button>
                      <button 
                        v-if="booking.status === 'check_in'"
                        @click="openCheckoutModal(booking)"
                        class="px-3 py-1.5 bg-orange-500 hover:bg-orange-600 rounded-lg text-xs text-white font-medium transition shadow-md hover:shadow-lg"
                      >
                        Check-out
                      </button>
                      <button 
                        v-if="['menunggu_pembayaran', 'menunggu_verifikasi', 'dibayar'].includes(booking.status)"
                        @click="openCancelModal(booking)"
                        class="px-3 py-1.5 bg-red-500 hover:bg-red-600 rounded-lg text-xs text-white font-medium transition shadow-md hover:shadow-lg"
                      >
                        Batalkan
                      </button>
                    </div>
                  </td>
                </tr>
                <tr v-if="bookings.length === 0">
                  <td colspan="7" class="px-6 py-16 text-center text-gray-500">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                      <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                      </svg>
                    </div>
                    <p class="font-medium text-gray-700">Belum ada data pemesanan</p>
                    <p class="text-sm mt-1">Pemesanan dengan status check-in akan muncul di sini</p>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          
          <!-- Pagination -->
          <div v-if="pagination.total > 0" class="px-6 py-4 border-t border-gray-200 flex items-center justify-between bg-gradient-to-r from-slate-50 to-white">
            <span class="text-sm text-gray-600 font-medium">
              Menampilkan {{ pagination.from }} - {{ pagination.to }} dari {{ pagination.total }} data
            </span>
            <div class="flex gap-2">
              <button 
                @click="changePage(pagination.current_page - 1)"
                :disabled="pagination.current_page === 1"
                class="px-4 py-2 border border-gray-300 rounded-xl text-sm disabled:opacity-50 hover:bg-gray-50 transition font-medium"
              >
                ← Prev
              </button>
              <button 
                @click="changePage(pagination.current_page + 1)"
                :disabled="pagination.current_page === pagination.last_page"
                class="px-4 py-2 border border-gray-300 rounded-xl text-sm disabled:opacity-50 hover:bg-gray-50 transition font-medium"
              >
                Next →
              </button>
            </div>
          </div>
        </div>
      </div>
    </main>

    <!-- Modal Modal lainnya dengan tema yang sama -->
    <!-- 🔐 Modal: Verifikasi Pembayaran -->
    <div v-if="showVerifyModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6">
        <div class="flex items-center gap-3 mb-4">
          <div class="p-3 bg-blue-100 rounded-xl">
            <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <h3 class="text-xl font-bold text-gray-800">Verifikasi Pembayaran</h3>
        </div>
        <p class="text-gray-600 mb-6">Konfirmasi pembayaran untuk pemesanan <span class="font-mono font-bold text-blue-600">{{ verifyBooking?.nomor_pemesanan }}</span>?</p>
        
        <div class="flex gap-3">
          <button 
            @click="confirmVerification('terima')"
            class="flex-1 px-4 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 rounded-xl text-white font-semibold transition shadow-lg shadow-green-600/30"
          >
            ✅ Terima
          </button>
          <button 
            @click="confirmVerification('tolak')"
            class="flex-1 px-4 py-3 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 rounded-xl text-white font-semibold transition shadow-lg shadow-red-600/30"
          >
            ❌ Tolak
          </button>
          <button 
            @click="showVerifyModal = false"
            class="px-6 py-3 bg-gray-100 hover:bg-gray-200 rounded-xl text-gray-700 font-semibold transition"
          >
            Batal
          </button>
        </div>
      </div>
    </div>

    <!-- 🏨 Modal: Check-in -->
    <div v-if="showCheckInModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full p-6">
        <div class="flex items-center gap-3 mb-6">
          <div class="p-3 bg-green-100 rounded-xl">
            <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
            </svg>
          </div>
          <div>
            <h3 class="text-xl font-bold text-gray-800">Check-in Tamu</h3>
            <p class="text-sm text-gray-500">Pilih nomor kamar untuk tamu</p>
          </div>
        </div>
        
        <div class="space-y-4 mb-6">
          <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
            <p class="text-gray-600 mb-1">Tamu: <span class="font-bold text-gray-800">{{ checkInBooking?.nama_pemesan }}</span></p>
            <p class="text-sm text-gray-500">Tipe Kamar: <span class="font-semibold text-gray-700">{{ checkInBooking?.tipe_kamar }}</span></p>
            <p class="text-sm text-gray-500">Jumlah: <span class="font-bold text-blue-600">{{ checkInBooking?.jumlah_kamar || 1 }} kamar</span></p>
          </div>
          
          <div v-for="index in (checkInBooking?.jumlah_kamar || 1)" :key="index" class="space-y-2">
            <label class="block text-sm font-semibold text-gray-700">
              Kamar #{{ index }}
            </label>
            <select 
              v-model="selectedRoomNumbers[index - 1]"
              class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none bg-white hover:border-gray-400 transition"
              :disabled="availableRoomsLoading || availableRooms.length === 0"
            >
              <option value="" disabled>
                {{ availableRoomsLoading ? 'Memuat kamar...' : (availableRooms.length === 0 ? 'Tidak ada kamar tersedia' : `Pilih nomor kamar ${index}...`) }}
              </option>
              <option v-for="room in getAvailableRoomsForIndex(index - 1)" :key="room" :value="room">
                Kamar {{ room }}
              </option>
            </select>
          </div>
          
          <p class="text-xs text-gray-500 bg-blue-50 p-3 rounded-lg border border-blue-200">* Hanya menampilkan kamar dengan status "tersedia". Pilih kamar yang berbeda untuk setiap pemesanan.</p>
          
          <div v-if="availableRoomsLoading" class="flex items-center gap-2 text-sm text-gray-600">
            <div class="animate-spin rounded-full h-4 w-4 border-2 border-blue-600 border-t-transparent"></div>
            Memuat daftar kamar tersedia...
          </div>
        </div>
        
        <div class="flex gap-3">
          <button 
            @click="confirmCheckIn"
            :disabled="!areAllRoomsSelected() || availableRoomsLoading"
            class="flex-1 px-4 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 disabled:from-green-400 disabled:to-green-500 rounded-xl text-white font-semibold transition shadow-lg shadow-green-600/30"
          >
            ✅ Konfirmasi Check-in
          </button>
          <button 
            @click="showCheckInModal = false"
            class="px-6 py-3 bg-gray-100 hover:bg-gray-200 rounded-xl text-gray-700 font-semibold transition"
          >
            Batal
          </button>
        </div>
      </div>
    </div>

    <!-- 🚪 Modal: Check-out - PERBAIKAN DI SINI -->
<div v-if="showCheckoutModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
  <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6">
    <div class="flex items-center gap-3 mb-4">
      <div class="p-3 bg-orange-100 rounded-xl">
        <svg class="w-6 h-6 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
        </svg>
      </div>
      <h3 class="text-xl font-bold text-gray-800">Konfirmasi Check-out</h3>
    </div>
    
    <div class="space-y-4 mb-6">
      <p class="text-gray-600">Apakah tamu <span class="font-bold text-gray-800">{{ checkoutBooking?.nama_pemesan }}</span> sudah check-out?</p>
      
      <!-- ✅ PERBAIKAN: TAMPILKAN JAM TERLAMBAT & DENDA YANG BENAR -->
      <div v-if="checkoutBooking?.is_late_checkout" class="p-4 bg-red-50 border border-red-200 rounded-xl">
        <p class="text-red-700 text-sm font-bold mb-2">⚠️ Tamu check-out terlambat</p>
        <div class="space-y-1 text-sm">
          <p class="text-gray-700">Waktu checkout: <span class="font-semibold">12:00</span></p>
          <p class="text-gray-700">Terlambat: <span class="font-bold text-red-600">{{ checkoutBooking.jam_terlambat || 1 }} jam</span></p>
          <p class="text-gray-700">Denda: <span class="font-bold text-red-600">{{ formatRupiah(checkoutBooking.denda || 50000) }}</span></p>
          <p class="text-xs text-gray-500 mt-1">(Rp 50.000 x {{ checkoutBooking.jam_terlambat || 1 }} jam)</p>
        </div>
      </div>
    </div>
        
            <div class="flex gap-3">
      <button @click="confirmCheckout" class="flex-1 px-4 py-3 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 rounded-xl text-white font-semibold transition shadow-lg shadow-orange-600/30">
        ✅ Ya, Check-out
      </button>
      <button @click="showCheckoutModal = false" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 rounded-xl text-gray-700 font-semibold transition">
        Batal
      </button>
    </div>
  </div>
</div>

    <!-- ❌ Modal: Batalkan -->
    <div v-if="showCancelModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6">
        <div class="flex items-center gap-3 mb-4">
          <div class="p-3 bg-red-100 rounded-xl">
            <svg class="w-6 h-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
          </div>
          <h3 class="text-xl font-bold text-gray-800 text-red-600">Batalkan Pesanan</h3>
        </div>
        
        <div class="space-y-4 mb-6">
          <p class="text-gray-600">Apakah Anda yakin ingin membatalkan pemesanan <span class="font-mono font-bold text-red-600">{{ cancelBooking?.nomor_pemesanan }}</span>?</p>
          
          <div class="p-4 bg-red-50 border border-red-200 rounded-xl">
            <p class="text-red-700 text-sm font-bold mb-1">⚠️ Peringatan</p>
            <p class="text-gray-700 text-sm">Pesanan yang dibatalkan tidak dapat dikembalikan. Tamu akan mendapat notifikasi pembatalan.</p>
          </div>
        </div>
        
        <div class="flex gap-3">
          <button 
            @click="confirmCancel"
            class="flex-1 px-4 py-3 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 rounded-xl text-white font-semibold transition shadow-lg shadow-red-600/30"
          >
            ✅ Ya, Batalkan
          </button>
          <button 
            @click="showCancelModal = false"
            class="px-6 py-3 bg-gray-100 hover:bg-gray-200 rounded-xl text-gray-700 font-semibold transition"
          >
            Tidak
          </button>
        </div>
      </div>
    </div>

    <!-- 🖼️ Modal: Gambar Besar -->
    <div v-if="showImageModal" class="fixed inset-0 bg-black/95 flex items-center justify-center z-50 p-4" @click="showImageModal = false">
      <div class="relative max-w-4xl w-full">
        <button @click="showImageModal = false" class="absolute -top-12 right-0 text-white hover:text-gray-300 transition">
          <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
        <div class="bg-white rounded-2xl p-4 shadow-2xl">
          <img 
            :src="getBuktiTransferUrl(imageModalSrc)" 
            alt="Bukti Transfer"
            class="w-full h-auto rounded-xl"
          />
        </div>
        <p class="text-center text-gray-400 mt-3 text-sm">Klik di mana saja untuk menutup</p>
      </div>
    </div>

    <!-- ✅ Success Toast -->
    <div v-if="showToast" class="fixed bottom-6 right-6 bg-gradient-to-r from-green-600 to-green-700 text-white px-6 py-3 rounded-xl shadow-2xl z-50 animate-pulse font-semibold">
      {{ toastMessage }}
    </div>

    <!-- ✅ Click Outside Handler -->
    <div v-if="showProfileDropdown" class="fixed inset-0 z-40" @click="closeProfileDropdown"></div>
  </div>
</template>

<script setup>
// Script tetap sama seperti sebelumnya (tidak ada perubahan logic)
import { ref, onMounted, onUnmounted, computed } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

// State
const isLoading = ref(false)
const isScanning = ref(false)
const scanInput = ref('')
const scannedBooking = ref(null)
const showBookingModal = ref(false)
const bookings = ref([])
const filterStatus = ref('check_in')
const searchQuery = ref('')
const pagination = ref({ current_page: 1, last_page: 1, total: 0, from: 0, to: 0 })

// Profile Dropdown
const showProfileDropdown = ref(false)
const profileRef = ref(null)
const userName = ref('Resepsionis')

// ✅ User data dan image key (DITAMBAHKAN)
const imageKey = ref(0)
const user = ref({
  nama: '',
  foto_profil: ''
})

const userInitials = computed(() => {
  if (!userName.value) return 'R'
  const names = userName.value.split(' ')
  return names.map(n => n[0]).join('').substring(0, 2).toUpperCase()
})

const toggleProfileDropdown = (e) => {
  e.stopPropagation()
  showProfileDropdown.value = !showProfileDropdown.value
}

const closeProfileDropdown = () => {
  showProfileDropdown.value = false
}

// Modals
const showVerifyModal = ref(false)
const showCheckInModal = ref(false)
const showCheckoutModal = ref(false)
const showCancelModal = ref(false)
const showImageModal = ref(false)
const imageModalSrc = ref('')
const verifyBooking = ref(null)
const checkInBooking = ref(null)
const checkoutBooking = ref(null)
const cancelBooking = ref(null)

// Check-in
const selectedRoomNumbers = ref([])
const availableRooms = ref([])
const availableRoomsLoading = ref(false)

// Toast
const showToast = ref(false)
const toastMessage = ref('')

// ✅ Helper URL foto dengan cache-buster (DITAMBAHKAN dari index.vue)
const getUserFotoUrl = (foto) => {
  if (!foto || foto === '' || foto === 'logo.jpg' || foto === null) {
    const name = sessionStorage.getItem('user_name') || 'Resepsionis'
    return `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=1e40af&color=fff&size=128&_r=${Date.now()}`
  }
  
  if (foto.startsWith('http://') || foto.startsWith('https://') || foto.startsWith('data:')) {
    const separator = foto.includes('?') ? '&' : '?'
    return `${foto}${separator}_r=${Date.now()}`
  }
  
  return `http://localhost:8000/storage/${foto}?_r=${Date.now()}`
}

// ✅ Handle image error untuk PROFIL (DITAMBAHKAN dari index.vue)
const handleProfileImageError = (e) => {
  const name = user.value.nama || 'Resepsionis'
  e.target.src = `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=1e40af&color=fff&size=128&_r=${Date.now()}`
}

// ✅ Load user data (DITAMBAHKAN dari index.vue)
const loadUserData = () => {
  const nama = sessionStorage.getItem('user_name') || 'Resepsionis'
  const foto = sessionStorage.getItem('user_foto') || ''
  
  user.value = {
    nama: nama,
    foto_profil: foto
  }
  
  imageKey.value = Date.now()
}

// Helpers
const formatRupiah = (amount) => {
  if (!amount) return 'Rp 0'
  return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(amount)
}

const formatDate = (dateString) => {
  if (!dateString) return '-'
  const date = new Date(dateString)
  return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })
}

const getStatusBadge = (status) => {
  const map = {
    'menunggu_pembayaran': 'bg-orange-100 text-orange-700 border border-orange-300',
    'menunggu_verifikasi': 'bg-blue-100 text-blue-700 border border-blue-300',
    'dibayar': 'bg-green-100 text-green-700 border border-green-300',
    'check_in': 'bg-purple-100 text-purple-700 border border-purple-300',
    'check_out': 'bg-gray-100 text-gray-700 border border-gray-300',
    'batal': 'bg-red-100 text-red-700 border border-red-300'
  }
  return map[status] || 'bg-gray-100 text-gray-700 border border-gray-300'
}

const getStatusLabel = (status) => {
  const map = {
    'menunggu_pembayaran': 'Menunggu Pembayaran',
    'menunggu_verifikasi': 'Menunggu Verifikasi',
    'dibayar': 'Dibayar',
    'check_in': 'Check-in',
    'check_out': 'Check-out',
    'batal': 'Batal'
  }
  return map[status] || status
}

const getBuktiTransferUrl = (buktiPath) => {
  if (!buktiPath) return ''
  if (buktiPath.startsWith('http')) return buktiPath
  return `http://localhost:8000/storage/${buktiPath}?t=${Date.now()}`
}

// ✅ Handle image error untuk BUKTI TRANSFER (yang asli)
const handleImageError = (e) => {
  console.error('Failed to load image:', e.target.src)
  alert('Gambar bukti transfer tidak dapat dimuat')
}

const isLateCheckout = (booking) => {
  if (booking.status !== 'check_in') return false
  const now = new Date()
  const checkoutTime = new Date(booking.check_out)
  checkoutTime.setHours(12, 0, 0, 0)
  return now > checkoutTime
}

const showToastMsg = (message) => {
  toastMessage.value = message
  showToast.value = true
  setTimeout(() => showToast.value = false, 3000)
}

const closeBookingModal = () => {
  showBookingModal.value = false
  scannedBooking.value = null
  scanInput.value = ''
}

const openImageModal = (buktiPath) => {
  imageModalSrc.value = buktiPath
  showImageModal.value = true
}

const getAvailableRoomsForIndex = (index) => {
  const selected = selectedRoomNumbers.value.filter((_, i) => i !== index && _.value)
  const selectedValues = selected.map(s => s.value || s)
  return availableRooms.value.filter(room => !selectedValues.includes(room))
}

const areAllRoomsSelected = () => {
  const jumlahKamar = checkInBooking.value?.jumlah_kamar || 1
  if (selectedRoomNumbers.value.length !== jumlahKamar) return false
  return selectedRoomNumbers.value.every(room => room && room.trim() !== '')
}

// API Calls
const fetchBookings = async () => {
  try {
    isLoading.value = true
    const token = sessionStorage.getItem('auth_token')
    const params = new URLSearchParams()
    if (filterStatus.value) params.append('status', filterStatus.value)
    if (searchQuery.value) params.append('search', searchQuery.value)
    params.append('page', pagination.value.current_page)
    params.append('per_page', '15')
    
    const response = await $fetch(`http://localhost:8000/api/resepsionis/pemesanan?${params}`, {
      headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
    })
    
    if (response.success) {
      bookings.value = response.data || []
      pagination.value = response.pagination || {}
    }
  } catch (error) {
    console.error('Gagal fetch bookings:', error)
    if (error.statusCode === 401) {
      alert('Session habis. Silakan login ulang.')
      router.push('/')
    }
  } finally {
    isLoading.value = false
  }
}

const fetchAvailableRoomsByTypeName = async (tipeKamarName) => {
  try {
    const typesResponse = await $fetch('http://localhost:8000/api/room-types', {
      headers: { 'Accept': 'application/json' }
    })
    
    if (!typesResponse.data || !Array.isArray(typesResponse.data)) {
      return []
    }
    
    const tipeKamar = typesResponse.data.find(t => 
      t.nama && t.nama.toLowerCase() === tipeKamarName.toLowerCase()
    )
    
    if (!tipeKamar) {
      return []
    }
    
    const roomsResponse = await $fetch(`http://localhost:8000/api/kamar/available/${tipeKamar.id}`, {
      headers: { 'Accept': 'application/json' }
    })
    
    if (roomsResponse.success && roomsResponse.data) {
      return roomsResponse.data.map(room => room.nomor_kamar)
    }
    
    return []
  } catch (error) {
    console.error('Error fetching available rooms:', error)
    return []
  }
}

const handleScan = async () => {
  if (!scanInput.value.trim()) {
    alert('Masukkan nomor pemesanan terlebih dahulu')
    return
  }
  
  isScanning.value = true
  try {
    const token = sessionStorage.getItem('auth_token')
    const response = await $fetch('http://localhost:8000/api/resepsionis/scan-qr', {
      method: 'POST',
      headers: { 
        'Authorization': `Bearer ${token}`,
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: { nomor_pemesanan: scanInput.value.trim() }
    })
    
    if (response.success) {
      scannedBooking.value = response.data
      showBookingModal.value = true
      showToastMsg('Data pemesanan ditemukan!')
      
      if (response.data.tipe_kamar) {
        availableRoomsLoading.value = true
        availableRooms.value = await fetchAvailableRoomsByTypeName(response.data.tipe_kamar)
        availableRoomsLoading.value = false
      }
      
      if (response.data.id && response.data.metode_pembayaran === 'transfer') {
        try {
          const pembayaranResponse = await $fetch(`http://localhost:8000/api/resepsionis/pembayaran/${response.data.id}`, {
            headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
          })
          
          if (pembayaranResponse.success && pembayaranResponse.data) {
            scannedBooking.value.bukti_transfer = pembayaranResponse.data.bukti_transfer || null
            scannedBooking.value.status_pembayaran = pembayaranResponse.data.status || null
          }
        } catch (error) {
          console.error('Failed to fetch pembayaran:', error)
        }
      }
    }
  } catch (error) {
    console.error('Scan error:', error)
    alert(error.data?.message || 'Pemesanan tidak ditemukan')
  } finally {
    isScanning.value = false
  }
}

const openVerifyModal = (booking) => {
  verifyBooking.value = booking
  showVerifyModal.value = true
}

const openVerifyModalFromModal = () => {
  if (scannedBooking.value) {
    verifyBooking.value = scannedBooking.value
    showVerifyModal.value = true
  }
}

const confirmVerification = async (action) => {
  try {
    const token = sessionStorage.getItem('auth_token')
    await $fetch(`http://localhost:8000/api/resepsionis/pemesanan/${verifyBooking.value.id}/verifikasi`, {
      method: 'POST',
      headers: { 
        'Authorization': `Bearer ${token}`,
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: { action, catatan: `Diverifikasi oleh resepsionis` }
    })
    
    showToastMsg(`Pembayaran ${action === 'terima' ? 'diterima' : 'ditolak'}!`)
    showVerifyModal.value = false
    closeBookingModal()
    fetchBookings()
  } catch (error) {
    alert(error.data?.message || 'Gagal memverifikasi')
  }
}

const openCheckInModal = async (booking) => {
  checkInBooking.value = booking
  selectedRoomNumbers.value = []
  availableRoomsLoading.value = true
  
  const jumlahKamar = booking.jumlah_kamar || 1
  selectedRoomNumbers.value = Array(jumlahKamar).fill('')
  
  if (booking.available_rooms && Array.isArray(booking.available_rooms)) {
    availableRooms.value = booking.available_rooms
    availableRoomsLoading.value = false
  } else {
    if (booking.tipe_kamar) {
      availableRooms.value = await fetchAvailableRoomsByTypeName(booking.tipe_kamar)
    } else {
      availableRooms.value = []
    }
    availableRoomsLoading.value = false
  }
  
  showCheckInModal.value = true
}

const openCheckInModalFromModal = async () => {
  if (scannedBooking.value) {
    await openCheckInModal(scannedBooking.value)
  }
}

const confirmCheckIn = async () => {
  const jumlahKamar = checkInBooking.value?.jumlah_kamar || 1
  
  if (selectedRoomNumbers.value.length !== jumlahKamar) {
    alert(`Silakan pilih ${jumlahKamar} nomor kamar`)
    return
  }
  
  if (!selectedRoomNumbers.value.every(room => room && room.trim() !== '')) {
    alert('Semua nomor kamar harus dipilih')
    return
  }
  
  const uniqueRooms = new Set(selectedRoomNumbers.value)
  if (uniqueRooms.size !== selectedRoomNumbers.value.length) {
    alert('Nomor kamar tidak boleh sama. Silakan pilih kamar yang berbeda.')
    return
  }
  
  try {
    const token = sessionStorage.getItem('auth_token')
    await $fetch(`http://localhost:8000/api/resepsionis/pemesanan/${checkInBooking.value.id}/check-in`, {
      method: 'POST',
      headers: { 
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json',
        'Content-Type': 'application/json'
      },
      body: { 
        room_numbers: selectedRoomNumbers.value
      }
    })
    
    showToastMsg('Check-in berhasil!')
    showCheckInModal.value = false
    closeBookingModal()
    fetchBookings()
  } catch (error) {
    alert(error.data?.message || 'Gagal check-in')
  }
}

const openCheckoutModal = (booking) => {
  checkoutBooking.value = booking
  showCheckoutModal.value = true
}

const openCheckoutModalFromModal = () => {
  if (scannedBooking.value) {
    checkoutBooking.value = scannedBooking.value
    showCheckoutModal.value = true
  }
}

 const confirmCheckout = async () => {
  try {
    const token = sessionStorage.getItem('auth_token')
    const userId = sessionStorage.getItem('user_id')
    const userName = sessionStorage.getItem('user_name')
    
    console.log('=== CHECKOUT DEBUG ===')
    console.log('user_id:', userId)
    console.log('user_name:', userName)
    console.log('booking id:', checkoutBooking.value?.id)
    
    if (!userId) {
      alert('Error: Data user tidak ditemukan. Silakan login ulang.')
      router.push('/')
      return
    }
    
    // Hitung ulang jam terlambat dan denda
    const now = new Date()
    const checkoutDate = new Date(checkoutBooking.value.check_out)
    checkoutDate.setHours(12, 0, 0, 0)
    
    let jamTerlambat = 0
    let denda = 0
    
    if (now > checkoutDate) {
      const diffMs = now - checkoutDate
      jamTerlambat = Math.floor(diffMs / (1000 * 60 * 60))
      jamTerlambat = Math.min(jamTerlambat, 23)
      denda = jamTerlambat * 50000
    }
    
    console.log('jam_terlambat:', jamTerlambat)
    console.log('denda:', denda)
    
    const response = await fetch(`http://localhost:8000/api/resepsionis/pemesanan/${checkoutBooking.value.id}/check-out`, {
      method: 'POST',
      headers: { 
        'Authorization': `Bearer ${token}`, 
        'Accept': 'application/json',
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        verified_by: parseInt(userId),
        jam_terlambat: jamTerlambat,
        denda: denda
      })
    })
    
    const data = await response.json()
    console.log('Response:', data)
    
    if (data.success) {
      const message = data.data?.popup_message || `Check-out berhasil!\nResepsionis: ${data.data?.resepsionis_nama || userName || 'Resepsionis'}`
      alert(message)
      
      showCheckoutModal.value = false
      closeBookingModal()
      
      // Refresh data
      await fetchBookings()
      
      // Reload halaman setelah 2 detik
      setTimeout(() => {
        window.location.reload()
      }, 2000)
    } else {
      alert(data.message || 'Gagal check-out')
    }
  } catch (error) {
    console.error('Checkout error:', error)
    alert('Terjadi kesalahan: ' + (error.message || 'Gagal check-out'))
  }
}

const openCancelModal = (booking) => {
  cancelBooking.value = booking
  showCancelModal.value = true
}

const openCancelModalFromModal = () => {
  if (scannedBooking.value) {
    cancelBooking.value = scannedBooking.value
    showCancelModal.value = true
  }
}

const confirmCancel = async () => {
  try {
    const token = sessionStorage.getItem('auth_token')
    await $fetch(`http://localhost:8000/api/resepsionis/pemesanan/${cancelBooking.value.id}/batal`, {
      method: 'POST',
      headers: { 
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json'
      }
    })
    
    showToastMsg('Pesanan berhasil dibatalkan!')
    showCancelModal.value = false
    closeBookingModal()
    fetchBookings()
  } catch (error) {
    alert(error.data?.message || 'Gagal membatalkan pesanan')
  }
}

const changePage = (page) => {
  if (page < 1 || page > pagination.value.last_page) return
  pagination.value.current_page = page
  fetchBookings()
}

const handleLogout = () => {
  if (confirm('Apakah Anda yakin ingin logout?')) {
    sessionStorage.clear()
    router.push('/')
  }
}

const handleClickOutside = (event) => {
  if (profileRef.value && !profileRef.value.contains(event.target)) {
    showProfileDropdown.value = false
  }
}

onMounted(() => {
  const token = sessionStorage.getItem('auth_token')
  if (!token) {
    router.push('/')
    return
  }
  
  // ✅ Load user data untuk foto profil
  loadUserData()
  
  const storedUser = sessionStorage.getItem('user_name')
  if (storedUser) {
    userName.value = storedUser
  }
  
  fetchBookings()
  document.addEventListener('click', handleClickOutside)
})

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside)
})
</script>

<style scoped>
* { transition: background-color 0.2s, transform 0.2s, box-shadow 0.2s; }

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

.overflow-x-auto::-webkit-scrollbar { height: 6px; }
.overflow-x-auto::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 3px; }
.overflow-x-auto::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
.overflow-x-auto::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
</style>