<template>
  <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/20 to-indigo-50">
    <!-- Animated Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
      <div class="absolute -top-40 -right-40 w-96 h-96 bg-blue-400/20 rounded-full blur-3xl animate-pulse"></div>
      <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-purple-400/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
      <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-indigo-400/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 4s;"></div>
    </div>

    <!-- Sidebar -->
    <aside class="w-72 bg-gradient-to-b from-slate-900 via-blue-900 to-slate-900 h-screen text-white fixed left-0 top-0 z-30 shadow-2xl overflow-y-auto">
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
          <div class="absolute bottom-4 right-1/4 w-4 h-4 bg-green-500 border-4 border-slate-900 rounded-full animate-pulse"></div>
        </div>
        <h3 class="font-bold text-xl mt-3 bg-gradient-to-r from-white to-blue-200 bg-clip-text text-transparent">{{ user.nama }}</h3>
        <p class="text-xs text-blue-300 mt-1 font-medium tracking-widest uppercase">Resepsionis</p>
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
    <main class="flex-1 ml-72 relative z-10 flex flex-col h-screen">
      <!-- Fixed Header - Sticky dengan z-index tinggi -->
      <header class="bg-white border-b border-gray-200 px-8 py-5 flex items-center justify-between sticky top-0 z-20 shadow-md">
        <div class="flex items-center gap-4">
          <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/30">
            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
          </div>
          <div>
            <h1 class="text-2xl font-bold bg-gradient-to-r from-slate-800 to-slate-600 bg-clip-text text-transparent">Flojachi</h1>
            <p class="text-sm text-gray-500 mt-0.5">Sistem Manajemen Pemesanan</p>
          </div>
        </div>
        
        <div class="flex items-center gap-4">
          <button @click="fetchData" :disabled="loading" class="px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 disabled:from-gray-400 disabled:to-gray-500 rounded-xl text-white text-sm font-semibold transition-all flex items-center gap-2 shadow-lg shadow-blue-600/30 hover:shadow-xl hover:shadow-blue-600/40 hover:scale-105 disabled:scale-100">
            <svg class="w-4 h-4" :class="{ 'animate-spin': loading }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
            </svg>
            Refresh
          </button>
          
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
            
            <div v-if="showProfileDropdown" class="absolute right-0 mt-2 w-48 bg-gray-800 border border-gray-700 rounded-lg shadow-xl py-1 z-50 animate-fade-in">
              <NuxtLink to="/resepsionis/prof" class="flex items-center gap-3 px-4 py-3 text-gray-300 hover:bg-gray-700 transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Profil Saya
              </NuxtLink>
              <button @click="handleLogout" class="flex items-center gap-3 px-4 py-3 text-red-400 hover:bg-gray-700 transition w-full text-left">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Logout
              </button>
            </div>
          </div>
        </div>
      </header>

      <!-- Content - Scrollable Area dengan padding top yang cukup -->
      <div class="flex-1 overflow-y-auto p-8">
        <!-- Welcome Hero Section -->
        <div class="relative mb-8 overflow-hidden rounded-3xl">
          <div class="absolute inset-0 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600"></div>
          <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80')] bg-cover bg-center opacity-20 mix-blend-overlay"></div>
          <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
          
          <div class="relative p-8 md:p-12">
            <div class="flex items-center gap-6 mb-6">
              <div class="w-20 h-20 bg-white/20 backdrop-blur-lg rounded-2xl flex items-center justify-center shadow-2xl">
                <svg class="w-10 h-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
              </div>
              <div>
                <h2 class="text-4xl font-bold text-white mb-2">Selamat Datang, {{ user.nama }}! 👋</h2>
                <p class="text-blue-100 text-lg">Siap melayani tamu dengan sepenuh hati</p>
              </div>
            </div>
            
            <!-- Stats Cards Row - Hero Section -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-8">
              <div class="bg-white/10 backdrop-blur-md rounded-xl p-4 border border-white/20 hover:bg-white/20 transition-all duration-300 hover:scale-105 cursor-pointer group">
                <div class="flex items-center gap-3">
                  <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                  </div>
                  <div>
                    <p class="text-white/80 text-sm">Jam Operasional</p>
                    <p class="text-white font-semibold">24 Jam / 7 Hari</p>
                  </div>
                </div>
              </div>
              
              <div class="bg-white/10 backdrop-blur-md rounded-xl p-4 border border-white/20 hover:bg-white/20 transition-all duration-300 hover:scale-105 cursor-pointer group">
                <div class="flex items-center gap-3">
                  <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                  </div>
                  <div>
                    <p class="text-white/80 text-sm">Total Kamar</p>
                    <p class="text-white font-semibold">50 Kamar</p>
                  </div>
                </div>
              </div>
              
              <div class="bg-white/10 backdrop-blur-md rounded-xl p-4 border border-white/20 hover:bg-white/20 transition-all duration-300 hover:scale-105 cursor-pointer group">
                <div class="flex items-center gap-3">
                  <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                  </div>
                  <div>
                    <p class="text-white/80 text-sm">Lokasi</p>
                    <p class="text-white font-semibold">Jakarta, Indonesia</p>
                  </div>
                </div>
              </div>

              <div class="bg-white/10 backdrop-blur-md rounded-xl p-4 border border-white/20 hover:bg-white/20 transition-all duration-300 hover:scale-105 cursor-pointer group">
                <div class="flex items-center gap-3">
                  <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                  </div>
                  <div>
                    <p class="text-white/80 text-sm">Rating</p>
                    <p class="text-white font-semibold">⭐ 4.8 / 5.0</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Stats Cards - Database Connection -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
          <!-- Total Pemesanan -->
          <div class="group bg-white/90 backdrop-blur-xl rounded-2xl p-6 border border-gray-200 shadow-lg hover:shadow-2xl transition-all duration-300 hover:scale-105 hover:-translate-y-1 cursor-pointer">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-gray-600 text-sm font-semibold mb-1">Total Pemesanan</p>
                <p class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-blue-700 bg-clip-text text-transparent">{{ totalPemesanan }}</p>
                <p class="text-xs text-gray-400 mt-1">Semua waktu</p>
              </div>
              <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/30 group-hover:scale-110 transition-transform">
                <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
              </div>
            </div>
          </div>

          <!-- Menunggu Pembayaran -->
          <div class="group bg-white/90 backdrop-blur-xl rounded-2xl p-6 border border-gray-200 shadow-lg hover:shadow-2xl transition-all duration-300 hover:scale-105 hover:-translate-y-1 cursor-pointer">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-gray-600 text-sm font-semibold mb-1">Menunggu Pembayaran</p>
                <p class="text-4xl font-bold bg-gradient-to-r from-orange-500 to-orange-600 bg-clip-text text-transparent">{{ menungguPembayaran }}</p>
                <p class="text-xs text-gray-400 mt-1">Perlu tindakan</p>
              </div>
              <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center shadow-lg shadow-orange-500/30 group-hover:scale-110 transition-transform">
                <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
            </div>
          </div>

          <!-- Menunggu Verifikasi -->
          <div class="group bg-white/90 backdrop-blur-xl rounded-2xl p-6 border border-gray-200 shadow-lg hover:shadow-2xl transition-all duration-300 hover:scale-105 hover:-translate-y-1 cursor-pointer">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-gray-600 text-sm font-semibold mb-1">Menunggu Verifikasi</p>
                <p class="text-4xl font-bold bg-gradient-to-r from-yellow-500 to-yellow-600 bg-clip-text text-transparent">{{ menungguVerifikasi }}</p>
                <p class="text-xs text-gray-400 mt-1">Perlu dicek</p>
              </div>
              <div class="w-14 h-14 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl flex items-center justify-center shadow-lg shadow-yellow-500/30 group-hover:scale-110 transition-transform">
                <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
            </div>
          </div>

          <!-- Check-in Hari Ini -->
          <div class="group bg-white/90 backdrop-blur-xl rounded-2xl p-6 border border-gray-200 shadow-lg hover:shadow-2xl transition-all duration-300 hover:scale-105 hover:-translate-y-1 cursor-pointer">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-gray-600 text-sm font-semibold mb-1">Check-in Hari Ini</p>
                <p class="text-4xl font-bold bg-gradient-to-r from-green-500 to-green-600 bg-clip-text text-transparent">{{ checkInHariIni }}</p>
                <p class="text-xs text-gray-400 mt-1">Tamu datang</p>
              </div>
              <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg shadow-green-500/30 group-hover:scale-110 transition-transform">
                <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
              </div>
            </div>
          </div>
        </div>

        <!-- Hotel Info Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <!-- Informasi Hotel -->
          <div class="bg-white/90 backdrop-blur-xl rounded-2xl p-6 border border-gray-200 shadow-lg">
            <div class="flex items-center gap-3 mb-4">
              <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <h3 class="text-lg font-bold text-gray-800">Informasi Hotel</h3>
            </div>
            <div class="space-y-3">
              <div class="flex items-center gap-3 text-gray-600">
                <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                <span class="text-sm">Hotel Flojachi - Jakarta</span>
              </div>
              <div class="flex items-center gap-3 text-gray-600">
                <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
                <span class="text-sm">+62 21 1234 5678</span>
              </div>
              <div class="flex items-center gap-3 text-gray-600">
                <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <span class="text-sm">info@flojachihotel.com</span>
              </div>
            </div>
          </div>

          <!-- Cuaca Hari Ini -->
          <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl p-6 text-white shadow-lg shadow-indigo-500/30">
            <div class="flex items-center gap-3 mb-4">
              <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
              </div>
              <h3 class="text-lg font-bold">Cuaca Hari Ini</h3>
            </div>
            <div class="flex items-center justify-between">
              <div>
                <p class="text-3xl font-bold">28°C</p>
                <p class="text-indigo-200 text-sm">Cerah Berawan</p>
              </div>
              <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                <svg class="w-10 h-10 text-yellow-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
              </div>
            </div>
            <div class="mt-4 pt-4 border-t border-white/20">
              <p class="text-sm text-indigo-200">Kelembapan: 65% | Angin: 12 km/jam</p>
            </div>
          </div>
        </div>
      </div>
    </main>

    <!-- Click Outside Handler -->
    <div v-if="showProfileDropdown" class="fixed inset-0 z-40" @click="closeProfileDropdown"></div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const loading = ref(false)
const allBookings = ref([])

// User data
const imageKey = ref(0)
const user = ref({
  nama: '',
  foto_profil: ''
})
const userName = ref('Resepsionis')

// Profile Dropdown
const showProfileDropdown = ref(false)
const profileRef = ref(null)

// Computed stats from database
const totalPemesanan = computed(() => {
  return allBookings.value.length
})

const menungguPembayaran = computed(() => {
  return allBookings.value.filter(b => b.status === 'menunggu_pembayaran').length
})

const menungguVerifikasi = computed(() => {
  return allBookings.value.filter(b => b.status === 'menunggu_verifikasi').length
})

const checkInHariIni = computed(() => {
  const today = new Date().toISOString().split('T')[0]
  return allBookings.value.filter(b => {
    if (!b.check_in) return false
    const checkIn = new Date(b.check_in).toISOString().split('T')[0]
    return checkIn === today
  }).length
})

const toggleProfileDropdown = (e) => {
  e.stopPropagation()
  showProfileDropdown.value = !showProfileDropdown.value
}

const closeProfileDropdown = () => {
  showProfileDropdown.value = false
}

// Helper URL foto
const getUserFotoUrl = (foto) => {
  if (!foto || foto === '' || foto === 'logo.jpg' || foto === null) {
    const name = sessionStorage.getItem('user_name') || 'Resepsionis'
    return `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=1e40af&color=fff&size=128&_r=${Date.now()}`
  }
  
  if (foto.startsWith('http://') || foto.startsWith('https://') || foto.startsWith('')) {
    const separator = foto.includes('?') ? '&' : '?'
    return `${foto}${separator}_r=${Date.now()}`
  }
  
  return `http://localhost:8000/storage/${foto}?_r=${Date.now()}`
}

const handleProfileImageError = (e) => {
  const name = user.value.nama || 'Resepsionis'
  e.target.src = `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=1e40af&color=fff&size=128&_r=${Date.now()}`
}

const handleImageError = (e) => {
  const name = user.value.nama || 'Resepsionis'
  e.target.src = `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=1e40af&color=fff&size=128&_r=${Date.now()}`
}

const loadUserData = () => {
  const nama = sessionStorage.getItem('user_name') || 'Resepsionis'
  const foto = sessionStorage.getItem('user_foto') || ''
  
  user.value = {
    nama: nama,
    foto_profil: foto
  }
  userName.value = nama
  imageKey.value = Date.now()
}

// Fetch data from database
const fetchData = async () => {
  try {
    loading.value = true
    const token = sessionStorage.getItem('auth_token')
    
    const response = await $fetch('http://localhost:8000/api/resepsionis/pemesanan?page=1&per_page=1000', {
      headers: { 
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json'
      }
    })
    
    if (response.success) {
      allBookings.value = response.data || []
      console.log('Total pemesanan:', allBookings.value.length)
    }
  } catch (error) {
    console.error('Gagal mengambil data:', error)
    if (error.statusCode === 401) {
      alert("Sesi habis, silakan login ulang.")
      handleLogout()
    }
  } finally {
    loading.value = false
  }
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
  
  loadUserData()
  fetchData()
  document.addEventListener('click', handleClickOutside)
})

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside)
})
</script>

<style scoped>
* { transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease; }

@keyframes fade-in {
  from {
    opacity: 0;
    transform: translateY(-20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-fade-in {
  animation: fade-in 0.6s ease-out;
}

/* Custom scrollbar */
.overflow-y-auto::-webkit-scrollbar {
  width: 8px;
}

.overflow-y-auto::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 10px;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
  background: #888;
  border-radius: 10px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
  background: #555;
}
</style>