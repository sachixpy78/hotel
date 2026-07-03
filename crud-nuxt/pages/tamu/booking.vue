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
            <NuxtLink to="/tamu/pesananku" class="text-gray-700 hover:text-blue-600 font-medium transition-all duration-300 relative group">
              Pesananku
              <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
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
      <!-- Back Button -->
      <NuxtLink to="/tamu/pesananku" class="text-blue-600 hover:text-blue-800 mb-8 inline-flex items-center gap-2 font-medium group">
        <svg class="h-5 w-5 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali ke Pesananku
      </NuxtLink>
      
      <!-- Loading -->
      <div v-if="loading" class="text-center py-20">
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-blue-50 mb-4">
          <div class="animate-spin rounded-full h-12 w-12 border-4 border-blue-600 border-t-transparent"></div>
        </div>
        <p class="text-gray-600 font-medium">Memuat detail pemesanan...</p>
      </div>
      
      <!-- Error -->
      <div v-else-if="error" class="text-center py-20 bg-white rounded-2xl shadow-sm border border-gray-100">
        <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
          <svg class="h-10 w-10 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
        <p class="text-gray-600 mb-4">{{ error }}</p>
        <NuxtLink to="/tamu/pesananku" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 font-medium">
          <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
          </svg>
          Kembali
        </NuxtLink>
      </div>
      
      <!-- Detail Pemesanan -->
      <div v-else-if="pemesanan" class="max-w-4xl mx-auto space-y-6">
        <!-- Header Status -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
          <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
              <div class="inline-block mb-2 px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold">
                Detail Pemesanan
              </div>
              <h1 class="text-3xl font-bold text-gray-800">Informasi Pemesanan</h1>
            </div>
            <span :class="getStatusClass(pemesanan.status)" class="px-5 py-2.5 rounded-full text-sm font-bold flex items-center gap-2 border-2 shadow-lg">
              <!-- Icon berdasarkan status -->
              <svg v-if="pemesanan.status === 'dibayar'" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
              </svg>
              <svg v-else-if="pemesanan.status === 'menunggu_pembayaran'" class="h-5 w-5 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <svg v-else-if="pemesanan.status === 'menunggu_verifikasi'" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              {{ getStatusLabel(pemesanan.status) }}
            </span>
          </div>
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm bg-gradient-to-r from-blue-50 to-blue-100 p-5 rounded-xl border border-blue-200">
            <div>
              <p class="text-blue-600 font-semibold mb-1">Nomor Pemesanan</p>
              <p class="font-bold font-mono text-blue-900 text-lg">{{ pemesanan.nomor_pemesanan }}</p>
            </div>
            <div>
              <p class="text-blue-600 font-semibold mb-1">Tanggal Pemesanan</p>
              <p class="font-bold text-blue-900">{{ formatDate(pemesanan.created_at) }}</p>
            </div>
          </div>
        </div>
        
        <!-- Info Pemesanan -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
          <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
            <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            Informasi Pemesanan
          </h2>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-gray-50 p-5 rounded-xl border border-gray-200">
              <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Data Tamu
              </h3>
              <div class="space-y-3 text-sm">
                <div class="flex justify-between py-2 border-b border-gray-200">
                  <span class="text-gray-500">Nama</span>
                  <span class="font-bold text-gray-800">{{ pemesanan.user?.name || '-' }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-200">
                  <span class="text-gray-500">Email</span>
                  <span class="font-bold text-gray-800">{{ pemesanan.user?.email || '-' }}</span>
                </div>
                <div class="flex justify-between py-2">
                  <span class="text-gray-500">No. Telepon</span>
                  <span class="font-bold text-gray-800">{{ pemesanan.user?.no_telp || '-' }}</span>
                </div>
              </div>
            </div>
            
            <div class="bg-gray-50 p-5 rounded-xl border border-gray-200">
              <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                Detail Kamar
              </h3>
              <div class="space-y-3 text-sm">
                <div class="flex justify-between py-2 border-b border-gray-200">
                  <span class="text-gray-500">Tipe Kamar</span>
                  <span class="font-bold text-gray-800">{{ pemesanan.tipe_kamar?.nama || '-' }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-200">
                  <span class="text-gray-500">Jumlah Kamar</span>
                  <span class="font-bold text-gray-800">{{ pemesanan.jumlah_kamar }} kamar</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-200">
                  <span class="text-gray-500">Check-in</span>
                  <span class="font-bold text-gray-800">{{ formatDate(pemesanan.check_in, 'check_in') }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-200">
                  <span class="text-gray-500">Check-out</span>
                  <span class="font-bold text-gray-800">{{ formatDate(pemesanan.check_out, 'check_out') }}</span>
                </div>
                <div class="flex justify-between py-2">
                  <span class="text-gray-500">Jumlah Malam</span>
                  <span class="font-bold text-gray-800">{{ pemesanan.jumlah_malam }} malam</span>
                </div>
              </div>
            </div>
          </div>
          
          <div class="mt-8 pt-6 border-t-2 border-gray-200">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-gradient-to-r from-blue-50 to-blue-100 p-6 rounded-xl border-2 border-blue-200">
              <div>
                <span class="text-gray-600 font-semibold block mb-1">Total Pembayaran</span>
                <span class="text-sm text-gray-500">Metode Pembayaran: <span class="font-bold text-gray-800">{{ pemesanan.metode_pembayaran === 'transfer' ? 'Transfer Bank' : 'Tunai' }}</span></span>
              </div>
              <span class="text-4xl font-bold text-blue-600">{{ formatRupiah(pemesanan.total_harga) }}</span>
            </div>
          </div>
        </div>
        
        <!-- 🟡 PESAN UNTUK STATUS "menunggu_pembayaran" -->
        <div v-if="pemesanan.status === 'menunggu_pembayaran'" class="bg-gradient-to-br from-yellow-50 to-yellow-100 border-2 border-yellow-300 rounded-2xl p-6 shadow-lg">
          <div class="flex items-start gap-4">
            <!-- Icon berbeda berdasarkan metode pembayaran -->
            <svg v-if="pemesanan.metode_pembayaran === 'tunai'" class="h-8 w-8 text-yellow-600 mt-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <svg v-else class="h-8 w-8 text-yellow-600 mt-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
            </svg>
            <div class="flex-1">
              <!-- Pesan untuk Tunai -->
              <h3 v-if="pemesanan.metode_pembayaran === 'tunai'" class="font-bold text-yellow-800 mb-2 text-lg">
                📱 Silahkan Scan Barcode dan Bayar di Resepsionis
              </h3>
              <!-- Pesan untuk Transfer -->
              <h3 v-else class="font-bold text-yellow-800 mb-2 text-lg">
                📤 Silahkan Kirim Bukti Pembayaran
              </h3>
              
              <p v-if="pemesanan.metode_pembayaran === 'tunai'" class="text-yellow-700 text-sm leading-relaxed">
                Tunjukkan QR Code di bawah ini ke resepsionis dan lakukan pembayaran tunai. 
                Status akan berubah menjadi <strong>"Dibayar"</strong> setelah pembayaran dikonfirmasi.
              </p>
              <p v-else class="text-yellow-700 text-sm leading-relaxed">
                Transfer sesuai total pembayaran ke rekening hotel, lalu upload bukti transfer di bawah ini.
                Setelah itu, tunjukkan QR Code ke resepsionis untuk verifikasi.
              </p>
            </div>
          </div>
        </div>
        
        <!-- 🟠 PESAN UNTUK STATUS "menunggu_verifikasi" (Hanya Transfer) -->
        <div v-else-if="pemesanan.status === 'menunggu_verifikasi'" class="bg-gradient-to-br from-orange-50 to-orange-100 border-2 border-orange-300 rounded-2xl p-6 shadow-lg">
          <div class="flex items-start gap-4">
            <svg class="h-8 w-8 text-orange-600 mt-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
            <div class="flex-1">
              <h3 class="font-bold text-orange-800 mb-2 text-lg">
                ⏳ Silahkan Verifikasi di Resepsionis
              </h3>
              <p class="text-orange-700 text-sm leading-relaxed">
                Bukti transfer Anda telah diterima. Silahkan tunjukkan QR Code ini ke resepsionis untuk verifikasi akhir.
                Status akan berubah menjadi <strong>"Dibayar"</strong> setelah diverifikasi.
              </p>
            </div>
          </div>
        </div>
        
        <!-- 🟢 PESAN UNTUK STATUS "dibayar" -->
        <div v-else-if="pemesanan.status === 'dibayar'" class="bg-gradient-to-br from-green-50 to-green-100 border-2 border-green-300 rounded-2xl p-6 shadow-lg">
          <div class="flex items-center gap-4">
            <svg class="h-10 w-10 text-green-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>
              <h3 class="text-xl font-bold text-green-800">✅ Pembayaran Telah Dikonfirmasi</h3>
              <p class="text-green-700 text-sm mt-1">Terima kasih! Pembayaran Anda telah dikonfirmasi. Silakan tunjukkan QR code saat check-in.</p>
            </div>
          </div>
        </div>
        
        <!-- 📤 FORM UPLOAD BUKTI TRANSFER (Hanya untuk transfer + status menunggu_pembayaran) -->
        <div v-if="showUploadForm" class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
          <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl flex items-center justify-center shadow-lg">
              <svg class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
              </svg>
            </div>
            <div>
              <h2 class="text-2xl font-bold text-gray-800">Upload Bukti Transfer</h2>
              <p class="text-sm text-gray-500">Upload bukti pembayaran Anda</p>
            </div>
          </div>
          
          <div class="bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-300 rounded-xl p-5 mb-6">
            <p class="text-sm text-blue-800 font-bold mb-2">
              📋 Instruksi Upload:
            </p>
            <ol class="text-sm text-blue-700 space-y-2 list-decimal list-inside">
              <li>Transfer sesuai total pembayaran ke rekening hotel</li>
              <li>Upload bukti transfer (foto/screenshot) di bawah ini</li>
              <li>Status akan berubah menjadi "Menunggu Verifikasi" setelah upload</li>
              <li>QR Code akan muncul setelah upload berhasil</li>
            </ol>
          </div>
          
          <form @submit.prevent="uploadBukti" class="space-y-5">
            <div>
              <label class="block text-sm font-bold text-gray-700 mb-2">
                File Bukti Transfer <span class="text-red-500">*</span>
              </label>
              <div class="flex items-center gap-4">
                <input 
                  type="file" 
                  @change="handleFileChange" 
                  accept="image/*,.pdf"
                  class="flex-1 px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition hover:border-gray-400"
                  :disabled="uploading"
                />
              </div>
              <p class="text-xs text-gray-500 mt-2">Format: JPG, PNG, PDF (Max 2MB)</p>
              
              <!-- Preview File -->
              <div v-if="selectedFile" class="mt-4 p-4 bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl border-2 border-gray-200">
                <div class="flex items-center gap-4">
                  <svg class="h-10 w-10 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                  </svg>
                  <div class="flex-1">
                    <p class="text-sm font-bold text-gray-800">{{ selectedFile.name }}</p>
                    <p class="text-xs text-gray-500">{{ formatFileSize(selectedFile.size) }}</p>
                  </div>
                  <button 
                    type="button" 
                    @click="selectedFile = null"
                    class="text-red-500 hover:text-red-700 p-2 hover:bg-red-50 rounded-lg transition"
                  >
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                  </button>
                </div>
              </div>
            </div>
            
            <div v-if="buktiUrl" class="mt-5">
              <p class="text-sm font-bold text-gray-700 mb-3">Bukti Transfer yang Sudah Diupload:</p>
              <div class="p-4 bg-gray-50 rounded-xl border-2 border-gray-200">
                <img v-if="isImage(buktiUrl)" 
                     :src="buktiUrl" 
                     alt="Bukti Transfer" 
                     class="max-w-full h-auto rounded-lg shadow-md"
                />
                <div v-else class="flex items-center gap-4 p-5 bg-white rounded-lg">
                  <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                  </svg>
                  <span class="text-sm font-medium text-gray-600">File PDF</span>
                </div>
              </div>
            </div>
            
            <div class="flex gap-4 pt-4">
              <button 
                type="submit" 
                :disabled="uploading || !selectedFile"
                class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 disabled:from-gray-400 disabled:to-gray-500 text-white py-4 rounded-xl font-bold transition-all duration-300 shadow-lg shadow-blue-600/30 hover:shadow-xl hover:shadow-blue-600/40 hover:scale-105 disabled:shadow-none disabled:cursor-not-allowed disabled:hover:scale-100 flex items-center justify-center gap-3"
              >
                <svg v-if="uploading" class="animate-spin h-6 w-6" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <svg v-else class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                </svg>
                {{ uploading ? 'Mengupload...' : 'Upload Bukti Transfer' }}
              </button>
            </div>
          </form>
        </div>
        
        <!-- 🔲 QR Code Section - Hanya muncul jika:
             1. Metode pembayaran tunai (selalu muncul)
             2. Metode transfer DAN sudah upload bukti (status bukan menunggu_pembayaran)
        -->
        <div v-if="showQRCode" class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
          <h3 class="text-2xl font-bold text-gray-800 mb-2 text-center flex items-center justify-center gap-2">
            <svg class="w-7 h-7 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
            </svg>
            QR Code Verifikasi
          </h3>
          <p class="text-gray-500 text-sm text-center mb-6">Scan QR Code ini di resepsionis untuk {{ pemesanan.metode_pembayaran === 'tunai' ? 'pembayaran' : 'verifikasi' }}</p>
          
          <!-- Loading QR -->
          <div v-if="qrLoading" class="flex justify-center mb-4">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-50">
              <div class="animate-spin rounded-full h-10 w-10 border-4 border-blue-600 border-t-transparent"></div>
            </div>
          </div>
          
          <!-- QR Image -->
          <div v-else-if="qrCodeUrl" class="flex justify-center">
            <div class="inline-block bg-white p-6 rounded-2xl shadow-2xl hover:shadow-3xl transition border-4 border-blue-100">
              <img :src="qrCodeUrl" alt="QR Code Pemesanan" class="w-56 h-56 object-contain" />
            </div>
          </div>
          
          <!-- Fallback Text -->
          <p v-else class="text-sm text-gray-400 italic text-center">Memuat QR Code...</p>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex gap-4">
          <NuxtLink to="/tamu/pesananku" class="flex-1 bg-gradient-to-r from-gray-100 to-gray-200 hover:from-gray-200 hover:to-gray-300 text-gray-700 py-4 rounded-xl font-bold text-center transition-all duration-300 shadow-lg hover:shadow-xl">
            Kembali
          </NuxtLink>
        </div>
      </div>
    </main>
    
    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 mt-16">
      <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
          <div>
            <div class="flex items-center gap-3 mb-4">
              <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl flex items-center justify-center shadow-lg">
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
                <svg class="h-5 w-5 mt-1 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>Jl. Kedung Sumur No. 123, Kota</span>
              </li>
              <li class="flex items-center gap-3">
                <svg class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                info@flojachihotel.com
              </li>
              <li class="flex items-center gap-3">
                <svg class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
import { useRouter } from 'vue-router'

const router = useRouter()
const pemesananId = ref(null)

// State
const showDropdown = ref(false)
const loading = ref(true)
const uploading = ref(false)
const qrLoading = ref(false)
const error = ref(null)
const pemesanan = ref(null)
const selectedFile = ref(null)
const buktiUrl = ref('')
const qrCodeUrl = ref('')

const user = ref({
  name: '',
  foto_profil: '/default-avatar.png'
})

// Computed
const showUploadForm = computed(() => {
  return pemesanan.value?.status === 'menunggu_pembayaran' && 
         pemesanan.value?.metode_pembayaran === 'transfer'
})

// ✅ QR Code hanya muncul jika:
// 1. Metode tunai (selalu tampil)
// 2. Metode transfer DAN sudah upload bukti (status bukan 'menunggu_pembayaran')
const showQRCode = computed(() => {
  if (!pemesanan.value) return false
  
  // Untuk tunai, QR selalu tampil
  if (pemesanan.value.metode_pembayaran === 'tunai') {
    return true
  }
  
  // Untuk transfer, QR hanya tampil jika sudah upload bukti
  // (status bukan 'menunggu_pembayaran')
  return pemesanan.value.status !== 'menunggu_pembayaran'
})

// Methods
const formatRupiah = (amount) => {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0
  }).format(amount)
}

// ✅ FUNGSI FORMAT TANGGAL YANG DIPERBAIKI
// type: 'normal' (default), 'check_in', 'check_out'
const formatDate = (date, type = 'normal') => {
  if (!date) return '-'
  
  // Buat salinan objek tanggal agar tidak mengubah data asli
  const dateObj = new Date(date)
  
  // Terapkan jam standar hotel HANYA untuk check-in dan check-out
  if (type === 'check_in') {
    dateObj.setHours(13, 0, 0, 0) // Paksa jadi 13:00
  } else if (type === 'check_out') {
    dateObj.setHours(12, 0, 0, 0) // Paksa jadi 12:00
  }
  // Jika type 'normal' (untuk created_at), biarkan jam asli dari database

  return dateObj.toLocaleDateString('id-ID', { 
    day: 'numeric', 
    month: 'long', 
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

const formatFileSize = (bytes) => {
  if (bytes === 0) return '0 Bytes'
  const k = 1024
  const sizes = ['Bytes', 'KB', 'MB', 'GB']
  const i = Math.floor(Math.log(bytes) / Math.log(k))
  return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i]
}

const isImage = (url) => {
  return url?.endsWith('.jpg') || url?.endsWith('.jpeg') || url?.endsWith('.png')
}

// ✅ UPDATED: Status classes tanpa 'baru'
const getStatusClass = (status) => {
  const classes = {
    'menunggu_pembayaran': 'bg-yellow-100 text-yellow-800 border-yellow-300',
    'menunggu_verifikasi': 'bg-orange-100 text-orange-800 border-orange-300',
    'dibayar': 'bg-green-100 text-green-800 border-green-300',
    'check_in': 'bg-purple-100 text-purple-800 border-purple-300',
    'check_out': 'bg-gray-100 text-gray-800 border-gray-300',
    'batal': 'bg-red-100 text-red-800 border-red-300'
  }
  return classes[status] || 'bg-gray-100 text-gray-800 border-gray-300'
}

// ✅ UPDATED: Status labels tanpa 'baru'
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

const handleFileChange = (event) => {
  const file = event.target.files[0]
  if (file) {
    // Validasi ukuran file (max 2MB)
    if (file.size > 2 * 1024 * 1024) {
      alert('Ukuran file terlalu besar. Maksimal 2MB')
      event.target.value = ''
      selectedFile.value = null
      return
    }
    
    // Validasi tipe file
    const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf']
    if (!validTypes.includes(file.type)) {
      alert('Format file tidak didukung. Gunakan JPG, PNG, atau PDF')
      event.target.value = ''
      selectedFile.value = null
      return
    }
    
    selectedFile.value = file
  }
}

const uploadBukti = async () => {
  if (!selectedFile.value) {
    alert('Pilih file bukti transfer terlebih dahulu')
    return
  }
  
  uploading.value = true
  
  try {
    const token = sessionStorage.getItem('auth_token')
    const formData = new FormData()
    formData.append('bukti_transfer', selectedFile.value)
    
    const response = await $fetch(`http://localhost:8000/api/tamu/upload-bukti/${pemesananId.value}`, {
      method: 'POST',
      headers: {
        'Authorization': `Bearer ${token}`
      },
      body: formData
    })
    
    if (response.success) {
      alert('Bukti transfer berhasil diupload! QR Code telah muncul. Menunggu verifikasi di resepsionis.')
      // Refresh data
      await fetchDetail()
      selectedFile.value = null
    }
  } catch (err) {
    console.error('Upload error:', err)
    alert(err.data?.message || 'Gagal upload bukti transfer')
  } finally {
    uploading.value = false
  }
}

const downloadQR = async () => {
  if (!pemesanan.value?.id) return
  
  try {
    const token = sessionStorage.getItem('auth_token')
    const response = await $fetch(`http://localhost:8000/api/pemesanan/${pemesanan.value.id}/download-qr`, {
      headers: { 'Authorization': `Bearer ${token}` },
      responseType: 'blob'
    })
    
    const blob = new Blob([response], { type: 'image/png' })
    const url = window.URL.createObjectURL(blob)
    const a = document.createElement('a')
    a.href = url
    a.download = `QR_${pemesanan.value.nomor_pemesanan}.png`
    a.click()
    window.URL.revokeObjectURL(url)
  } catch (err) {
    console.error('Download QR error:', err)
    alert('Gagal download QR Code')
  }
}

const generateQRFromBackend = async (pemesananId) => {
  qrLoading.value = true
  try {
    const token = sessionStorage.getItem('auth_token')
    
    const response = await $fetch(`http://localhost:8000/api/pemesanan/${pemesananId}/generate-qr`, {
      method: 'POST',
      headers: {
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json'
      }
    })
    
    if (response.success && response.data?.qr_code_url) {
      qrCodeUrl.value = `http://localhost:8000/storage/${response.data.qr_code_url}`
    } else {
      qrCodeUrl.value = `https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=${pemesanan.value?.nomor_pemesanan}`
    }
  } catch (err) {
    console.error('Generate QR error:', err)
    qrCodeUrl.value = `https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=${pemesanan.value?.nomor_pemesanan}`
  } finally {
    qrLoading.value = false
  }
}

const fetchDetail = async () => {
  loading.value = true
  error.value = null
  
  try {
    const token = sessionStorage.getItem('auth_token')
    const response = await $fetch(`http://localhost:8000/api/tamu/pemesanan/${pemesananId.value}`, {
      headers: {
        'Authorization': `Bearer ${token}`
      }
    })
    
    if (response.success) {
      pemesanan.value = response.data
      
      // Set bukti URL jika sudah ada
      if (response.data.bukti_transfer) {
        buktiUrl.value = `http://localhost:8000/storage/${response.data.bukti_transfer}`
      }
      
      // Generate QR Code
      if (response.data.qr_code_url) {
        qrCodeUrl.value = `http://localhost:8000/storage/${response.data.qr_code_url}`
      } else if (response.data.id) {
        await generateQRFromBackend(response.data.id)
      }
    }
  } catch (err) {
    console.error('Fetch error:', err)
    error.value = err.data?.message || 'Gagal memuat detail pemesanan'
  } finally {
    loading.value = false
  }
}

const logout = () => {
  if (confirm('Apakah Anda yakin ingin logout?')) {
    sessionStorage.clear()
    router.push('/')
  }
}

onMounted(() => {
  const token = sessionStorage.getItem('auth_token')
  if (!token) {
    alert('Silakan login terlebih dahulu')
    router.push('/login')
    return
  }
  
  user.value.name = sessionStorage.getItem('user_name') || 'Tamu'
  user.value.foto_profil = sessionStorage.getItem('user_foto') || '/default-avatar.png'
  
  // Ambil ID dari query params: /tamu/booking?id=123
  pemesananId.value = router.currentRoute.value.query.id
  
  if (!pemesananId.value) {
    error.value = 'ID pemesanan tidak ditemukan'
    loading.value = false
    return
  }
  
  fetchDetail()
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
</style>