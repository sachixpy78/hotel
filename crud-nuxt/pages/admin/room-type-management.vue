<template>
  <div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50/30 flex">
    <!-- SIDEBAR -->
    <aside class="w-72 bg-gradient-to-b from-slate-900 via-blue-900 to-slate-900 min-h-screen text-white fixed left-0 top-0 z-30 shadow-2xl">
      <!-- Profile Section -->
      <div class="p-8 text-center border-b border-blue-800/50 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-blue-600/20 to-transparent pointer-events-none"></div>
        <div class="relative">
          <div class="mb-4 inline-block p-1 rounded-full bg-gradient-to-r from-blue-400 to-blue-600">
            <img 
              :key="imageKey"
              :src="user.foto_profil" 
              @error="handleImageError"
              alt="Administrator" 
              class="h-24 w-24 rounded-full border-4 border-slate-900 object-cover shadow-xl"
            />
          </div>
          <div class="absolute bottom-4 right-1/4 w-4 h-4 bg-green-500 border-4 border-slate-900 rounded-full"></div>
        </div>
        <h3 class="font-bold text-xl mt-3 bg-gradient-to-r from-white to-blue-200 bg-clip-text text-transparent">{{ user.name }}</h3>
        <p class="text-xs text-blue-300 mt-1 font-medium tracking-wide uppercase">{{ user.role }}</p>
      </div>

      <!-- Menu Navigation -->
      <nav class="mt-6 px-3">
        <NuxtLink 
          to="/admin/" 
          class="group flex items-center px-4 py-3.5 mb-1 rounded-xl transition-all duration-300 hover:shadow-lg hover:shadow-blue-900/50"
          :class="{ 'bg-gradient-to-r from-blue-600 to-blue-700 shadow-lg shadow-blue-900/50': $route.path === '/admin/' }"
        >
          <div class="p-2 rounded-lg mr-3 transition-all duration-300 group-hover:scale-110" :class="$route.path === '/admin/' ? 'bg-white/20' : 'bg-blue-800/50 group-hover:bg-blue-700'">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
          </div>
          <span class="font-medium text-sm">User Management</span>
          <svg v-if="$route.path === '/admin/'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-auto opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </NuxtLink>

        <NuxtLink 
          to="/admin/room-management" 
          class="group flex items-center px-4 py-3.5 mb-1 rounded-xl transition-all duration-300 hover:shadow-lg hover:shadow-blue-900/50"
          :class="{ 'bg-gradient-to-r from-blue-600 to-blue-700 shadow-lg shadow-blue-900/50': $route.path.includes('room-management') }"
        >
          <div class="p-2 rounded-lg mr-3 transition-all duration-300 group-hover:scale-110" :class="$route.path.includes('room-management') ? 'bg-white/20' : 'bg-blue-800/50 group-hover:bg-blue-700'">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
            </svg>
          </div>
          <span class="font-medium text-sm">Room Management</span>
          <svg v-if="$route.path.includes('room-management')" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-auto opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </NuxtLink>

        <NuxtLink 
          to="/admin/room-type-management" 
          class="group flex items-center px-4 py-3.5 mb-1 rounded-xl transition-all duration-300 hover:shadow-lg hover:shadow-blue-900/50"
          :class="{ 'bg-gradient-to-r from-blue-600 to-blue-700 shadow-lg shadow-blue-900/50': $route.path.includes('room-type') }"
        >
          <div class="p-2 rounded-lg mr-3 transition-all duration-300 group-hover:scale-110" :class="$route.path.includes('room-type') ? 'bg-white/20' : 'bg-blue-800/50 group-hover:bg-blue-700'">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>
          </div>
          <span class="font-medium text-sm">Room Type</span>
          <svg v-if="$route.path.includes('room-type')" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-auto opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </NuxtLink>

        <NuxtLink 
          to="/admin/laporan" 
          class="group flex items-center px-4 py-3.5 mb-1 rounded-xl transition-all duration-300 hover:shadow-lg hover:shadow-blue-900/50"
          :class="{ 'bg-gradient-to-r from-blue-600 to-blue-700 shadow-lg shadow-blue-900/50': $route.path.includes('laporan') }"
        >
          <div class="p-2 rounded-lg mr-3 transition-all duration-300 group-hover:scale-110" :class="$route.path.includes('laporan') ? 'bg-white/20' : 'bg-blue-800/50 group-hover:bg-blue-700'">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
          </div>
          <span class="font-medium text-sm">Laporan</span>
          <svg v-if="$route.path.includes('laporan')" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-auto opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </NuxtLink>
      </nav>

      <!-- Bottom decoration -->
      <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-500 via-purple-500 to-blue-500"></div>
    </aside>

    <!-- MAIN CONTENT AREA -->
    <div class="flex-1 ml-72">
      <!-- HEADER -->
      <header class="bg-white/80 backdrop-blur-xl border-b border-gray-200/60 px-8 py-5 flex items-center justify-between sticky top-0 z-40 shadow-sm">
        <div class="flex items-center space-x-3">
          <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-600 to-blue-700 flex items-center justify-center shadow-lg shadow-blue-600/30">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>
          </div>
          <div>
            <h1 class="text-2xl font-bold bg-gradient-to-r from-slate-800 to-slate-600 bg-clip-text text-transparent">Manajemen Tipe Kamar</h1>
            <p class="text-sm text-gray-500">Kelola tipe kamar hotel</p>
          </div>
        </div>
        
        <div class="flex items-center space-x-4">
          <div class="relative">
            <button 
              @click="showProfileMenu = !showProfileMenu"
              class="flex items-center space-x-3 bg-white border border-gray-200 px-4 py-2.5 rounded-xl hover:bg-gray-50 hover:border-gray-300 hover:shadow-md transition-all duration-300 group"
            >
              <div class="text-right hidden sm:block">
                <p class="text-sm font-semibold text-gray-800 group-hover:text-blue-600 transition-colors">{{ user.name }}</p>
                <p class="text-xs text-gray-500">Administrator</p>
              </div>
              <div class="relative">
                <img 
                  :key="imageKey + 'header'"
                  :src="user.foto_profil" 
                  @error="handleImageError"
                  alt="Profile" 
                  class="h-10 w-10 rounded-xl border-2 border-gray-200 object-cover shadow-sm group-hover:border-blue-300 transition-colors"
                />
                <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></div>
              </div>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 group-hover:text-blue-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>

            <div v-if="showProfileMenu" class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-2xl border border-gray-100 py-2 z-50 overflow-hidden animate-fade-in">
              <div class="px-4 py-3 border-b border-gray-100 bg-gradient-to-r from-blue-50/50 to-transparent">
                <p class="text-sm font-semibold text-gray-800">Role: {{ user.role }}</p>
              </div>
              <NuxtLink 
                to="/admin/editprofile" 
                class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors duration-300"
                @click="showProfileMenu = false"
              >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Edit Profil
              </NuxtLink>
              <hr class="my-2 border-gray-200" />
              <button 
                @click="logout"
                class="flex items-center w-full px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors duration-300"
              >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Logout
              </button>
            </div>
          </div>
        </div>
      </header>

      <!-- MAIN CONTENT -->
      <main class="p-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
          <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-xl hover:shadow-blue-900/5 transition-all duration-300 group">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Total Tipe Kamar</p>
                <p class="text-3xl font-bold text-gray-800 group-hover:scale-110 transition-transform origin-left">{{ roomTypes.length }}</p>
              </div>
              <div class="p-4 bg-gradient-to-br from-blue-100 to-blue-50 rounded-2xl group-hover:scale-110 transition-transform duration-300 shadow-lg shadow-blue-900/10">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
              </div>
            </div>
            <div class="mt-4 h-1 bg-gradient-to-r from-blue-400 to-blue-600 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
          </div>
          <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-xl hover:shadow-green-900/5 transition-all duration-300 group">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Harga Terendah</p>
                <p class="text-3xl font-bold text-gray-800 group-hover:scale-110 transition-transform origin-left">{{ formatRupiah(minPrice) }}</p>
              </div>
              <div class="p-4 bg-gradient-to-br from-green-100 to-green-50 rounded-2xl group-hover:scale-110 transition-transform duration-300 shadow-lg shadow-green-900/10">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
              </div>
            </div>
            <div class="mt-4 h-1 bg-gradient-to-r from-green-400 to-green-600 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
          </div>
          <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-xl hover:shadow-red-900/5 transition-all duration-300 group">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Harga Tertinggi</p>
                <p class="text-3xl font-bold text-gray-800 group-hover:scale-110 transition-transform origin-left">{{ formatRupiah(maxPrice) }}</p>
              </div>
              <div class="p-4 bg-gradient-to-br from-red-100 to-red-50 rounded-2xl group-hover:scale-110 transition-transform duration-300 shadow-lg shadow-red-900/10">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
              </div>
            </div>
            <div class="mt-4 h-1 bg-gradient-to-r from-red-400 to-red-600 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
          </div>
          <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-xl hover:shadow-orange-900/5 transition-all duration-300 group">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Total Stok</p>
                <p class="text-3xl font-bold text-gray-800 group-hover:scale-110 transition-transform origin-left">{{ totalStok }}</p>
              </div>
              <div class="p-4 bg-gradient-to-br from-orange-100 to-orange-50 rounded-2xl group-hover:scale-110 transition-transform duration-300 shadow-lg shadow-orange-900/10">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
              </div>
            </div>
            <div class="mt-4 h-1 bg-gradient-to-r from-orange-400 to-orange-600 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
          </div>
        </div>

        <!-- Header dengan tombol Tambah -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
          <div>
            <h2 class="text-2xl font-bold text-gray-800 flex items-center">
              <span class="w-1 h-8 bg-gradient-to-b from-blue-600 to-blue-400 rounded-full mr-3"></span>
              Daftar Tipe Kamar
            </h2>
            <p class="text-sm text-gray-500 mt-1">Kelola tipe kamar hotel</p>
          </div>
          <button 
            @click="openModal()"
            class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-3 rounded-xl shadow-lg shadow-blue-600/30 transition-all duration-200 flex items-center gap-2 font-semibold hover:scale-105"
          >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Tipe Kamar
          </button>
        </div>

        <!-- Filter & Search -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-6">
          <div class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[250px]">
              <div class="relative">
                <input 
                  v-model="search" 
                  type="text" 
                  placeholder="Cari nama tipe kamar..." 
                  class="w-full pl-11 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all hover:border-gray-400"
                />
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 absolute left-3.5 top-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
              </div>
            </div>
            <select 
              v-model="filterStatus" 
              class="px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white hover:border-gray-400 transition-all font-medium text-gray-700"
            >
              <option value="">Semua Status</option>
              <option value="true">Tersedia</option>
              <option value="false">Tidak Tersedia</option>
            </select>
          </div>
        </div>

        <!-- Loading -->
        <div v-if="loading" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
          <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-50 mb-4">
            <div class="animate-spin rounded-full h-8 w-8 border-4 border-blue-600 border-t-transparent"></div>
          </div>
          <p class="text-gray-600 font-medium">Memuat data tipe kamar...</p>
        </div>

        <!-- GRID CARDS - 3 kolom -->
        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div 
            v-for="room in filteredRoomTypes" 
            :key="room.id" 
            class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:shadow-blue-900/5 hover:-translate-y-1 transition-all duration-300 group"
          >
            <!-- Foto -->
            <div class="h-48 bg-gradient-to-br from-gray-100 to-gray-200 relative overflow-hidden">
              <img 
                :src="getFotoUrl(room)" 
                :alt="room.nama"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                @error="$event.target.src = '/default-room.jpg'"
              />
              <div 
                v-if="!room.tersedia"
                class="absolute top-3 right-3 bg-red-500 text-white px-3 py-1 rounded-full text-xs font-semibold shadow-lg"
              >
                Tidak Tersedia
              </div>
              <div 
                v-if="room.stok === 0"
                class="absolute bottom-3 left-3 bg-gray-800 text-white px-3 py-1 rounded-full text-xs font-semibold shadow-lg"
              >
                Stok Habis
              </div>
            </div>

            <!-- Content -->
            <div class="p-5">
              <h3 class="text-xl font-bold text-gray-800 text-center mb-3">{{ room.nama }}</h3>
              
              <!-- Fasilitas -->
              <div class="text-sm text-gray-500 text-center space-y-1 mb-4 min-h-[60px]">
                <div v-for="(fasilitasItem, index) in parseFasilitas(room.fasilitas).slice(0, 3)" :key="index">
                  {{ fasilitasItem }}
                </div>
                <div v-if="parseFasilitas(room.fasilitas).length > 3" class="text-xs text-blue-500">
                  +{{ parseFasilitas(room.fasilitas).length - 3 }} fasilitas lainnya
                </div>
                <div v-if="parseFasilitas(room.fasilitas).length === 0" class="text-gray-400">
                  Tidak ada fasilitas
                </div>
              </div>

              <!-- Info Harga & Stok -->
              <div class="border-t border-gray-100 pt-4">
                <div class="flex justify-between items-center mb-2">
                  <span class="font-bold text-blue-600 text-lg">{{ formatRupiah(room.harga_per_malam) }}</span>
                  <span class="text-gray-500 text-sm">Stok: {{ room.stok ?? 0 }} kamar</span>
                </div>
                <div class="flex justify-between items-center text-sm">
                  <span :class="room.tersedia ? 'text-green-600' : 'text-red-600'" class="font-medium">
                    {{ room.tersedia ? '✓ Tersedia' : '✗ Tidak Tersedia' }}
                  </span>
                  <span class="text-gray-500">{{ room.tipe_tempat_tidur || '-' }}</span>
                </div>
              </div>

              <!-- Actions - TOMBOL HAPUS DINONAKTIFKAN JIKA STOK > 0 -->
              <div class="flex gap-3 mt-5">
                <button 
                  @click="editRoomType(room)" 
                  class="flex-1 px-3 py-2.5 bg-gradient-to-r from-blue-50 to-blue-100 text-blue-700 rounded-xl hover:from-blue-100 hover:to-blue-200 text-sm font-semibold transition-all hover:scale-105"
                >
                  ✏️ Edit
                </button>
                <button 
                  @click="confirmDelete(room)" 
                  :disabled="room.stok > 0"
                  :title="room.stok > 0 ? `Tidak dapat dihapus karena masih memiliki stok ${room.stok} kamar. Kurangi stok menjadi 0 terlebih dahulu.` : 'Hapus tipe kamar'"
                  class="flex-1 px-3 py-2.5 bg-gradient-to-r from-red-50 to-red-100 text-red-700 rounded-xl hover:from-red-100 hover:to-red-200 text-sm font-semibold transition-all hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100"
                >
                  🗑️ Hapus
                </button>
              </div>
              <!-- Pesan peringatan jika stok > 0 -->
              <div v-if="room.stok > 0" class="mt-2 text-xs text-center text-orange-600 bg-orange-50 p-1.5 rounded-lg">
                ⚠️ stok kamar masih ada
              </div>
            </div>
          </div>
        </div>

        <!-- Empty State -->
        <div v-if="filteredRoomTypes.length === 0 && !loading" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
          <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
          </div>
          <p class="text-gray-500 font-medium">Tidak ada data tipe kamar</p>
          <p class="text-sm text-gray-400 mt-1">Klik tombol "Tambah Tipe Kamar" untuk menambahkan</p>
        </div>

        <!-- Show Count -->
        <div v-if="filteredRoomTypes.length > 0" class="mt-4 text-sm text-gray-500 text-right">
          Menampilkan {{ filteredRoomTypes.length }} dari {{ roomTypes.length }} tipe kamar
        </div>
      </main>
    </div>

    <!-- Modal Tambah/Edit - BISA DI-SCROLL -->
    <div v-if="showModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4 z-50" @click.self="closeModal">
      <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md max-h-[90vh] flex flex-col border border-gray-200 animate-scale-in">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 flex justify-between items-center rounded-t-2xl flex-shrink-0">
          <div class="flex items-center space-x-3">
            <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
              </svg>
            </div>
            <h3 class="text-lg font-bold text-white">{{ isEdit ? 'Edit Tipe Kamar' : 'Tambah Tipe Kamar Baru' }}</h3>
          </div>
          <button @click="closeModal" class="text-white/80 hover:text-white transition-colors text-2xl w-8 h-8 flex items-center justify-center rounded-lg hover:bg-white/10">&times;</button>
        </div>
        
        <!-- FORM - BISA DI-SCROLL -->
        <div class="overflow-y-auto flex-1 px-6" style="max-height: calc(90vh - 130px);">
          <form @submit.prevent="saveRoomType" class="py-4 space-y-4">
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Tipe Kamar <span class="text-red-500">*</span></label>
              <input 
                v-model="form.nama" 
                type="text" 
                required 
                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all hover:border-gray-400" 
                placeholder="Contoh: Deluxe Suite"
              />
            </div>

            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Kamar</label>
              <input 
                type="file" 
                @change="handleFileUpload"
                accept="image/*"
                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
              />
              <img 
                v-if="previewFoto || form.foto" 
                :src="previewFoto || getFotoUrl(form)" 
                class="mt-2 w-full h-32 object-cover rounded-lg border"
              />
            </div>

            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">Harga per Malam (Rp) <span class="text-red-500">*</span></label>
              <input v-model.number="form.harga_per_malam" type="number" required min="0" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all hover:border-gray-400" placeholder="Contoh: 500000" />
            </div>

            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">Stok Kamar <span class="text-red-500">*</span></label>
              <input v-model.number="form.stok" type="number" required min="0" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all hover:border-gray-400" placeholder="Contoh: 10" />
              <p class="text-xs text-gray-500 mt-1">Jumlah kamar yang tersedia untuk tipe ini</p>
            </div>

            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">Fasilitas</label>
              <textarea v-model="form.fasilitas" rows="3" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none resize-none hover:border-gray-400 transition-all" placeholder="Toiletries&#10;Wifi&#10;Air conditioned..."></textarea>
              <p class="text-xs text-gray-500 mt-1">Pisahkan setiap fasilitas dengan enter atau koma</p>
            </div>

            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">Tipe Tempat Tidur</label>
              <select v-model="form.tipe_tempat_tidur" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white hover:border-gray-400 transition-all">
                <option value="">Pilih Tipe</option>
                <option value="King">King</option>
                <option value="Queen">Queen</option>
                <option value="Twin">Twin</option>
                <option value="Single">Single</option>
                <option value="Double">Double</option>
              </select>
            </div>

            <div class="flex items-center gap-2">
              <input v-model="form.tersedia" type="checkbox" id="tersedia" class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500" />
              <label for="tersedia" class="text-sm font-medium text-gray-700">Tersedia untuk booking</label>
            </div>
          </form>
        </div>

        <!-- BUTTONS -->
        <div class="flex gap-3 p-6 pt-2 border-t border-gray-100 flex-shrink-0">
          <button type="button" @click="closeModal" class="flex-1 px-4 py-2.5 border border-gray-300 rounded-xl hover:bg-gray-50 transition-all font-semibold text-gray-700">Batal</button>
          <button 
            @click="saveRoomType"
            :disabled="saving" 
            class="flex-1 px-4 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl hover:from-blue-700 hover:to-blue-800 disabled:opacity-50 transition-all font-semibold shadow-lg shadow-blue-600/30 hover:shadow-xl hover:shadow-blue-600/40"
          >
            {{ saving ? 'Menyimpan...' : (isEdit ? 'Update' : 'Simpan') }}
          </button>
        </div>
      </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div v-if="showDelete" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4 z-50" @click.self="showDelete = false">
      <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-8 text-center border border-gray-200 animate-scale-in">
        <div class="w-20 h-20 bg-gradient-to-br from-red-100 to-red-50 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg shadow-red-900/10">
          <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
          </svg>
        </div>
        <h3 class="text-xl font-bold mb-2 text-gray-800">Hapus Tipe Kamar?</h3>
        <p class="text-gray-500 text-sm mb-6">Tipe kamar <strong class="text-gray-800">{{ selectedRoomType?.nama }}</strong> akan dihapus permanen.</p>
        <div class="flex gap-3">
          <button @click="showDelete = false" class="flex-1 px-4 py-2.5 border border-gray-300 rounded-xl hover:bg-gray-50 transition-all font-semibold text-gray-700">Batal</button>
          <button @click="deleteRoomType" :disabled="saving" class="flex-1 px-4 py-2.5 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-xl hover:from-red-700 hover:to-red-800 disabled:opacity-50 transition-all font-semibold shadow-lg shadow-red-600/30">Hapus</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const API_URL = 'http://localhost:8000/api'

const roomTypes = ref([])
const loading = ref(false)
const saving = ref(false)
const showModal = ref(false)
const showDelete = ref(false)
const showProfileMenu = ref(false)
const isEdit = ref(false)
const search = ref('')
const filterStatus = ref('')
const selectedRoomType = ref(null)
const imageKey = ref(0)

// User data
const user = ref({
  name: '',
  foto_profil: '',
  role: ''
})

// Form data
const form = ref({
  id: null,
  nama: '',
  foto: null,
  harga_per_malam: 0,
  fasilitas: '',
  tipe_tempat_tidur: '',
  tersedia: true,
  stok: 0
})

const previewFoto = ref(null)
const selectedFile = ref(null)

// Computed
const totalStok = computed(() => {
  return roomTypes.value.reduce((total, room) => total + (room.stok || 0), 0)
})

const minPrice = computed(() => {
  if (roomTypes.value.length === 0) return 0
  return Math.min(...roomTypes.value.map(t => t.harga_per_malam))
})

const maxPrice = computed(() => {
  if (roomTypes.value.length === 0) return 0
  return Math.max(...roomTypes.value.map(t => t.harga_per_malam))
})

const filteredRoomTypes = computed(() => {
  let result = roomTypes.value
  if (search.value) {
    result = result.filter(room => 
      room.nama.toLowerCase().includes(search.value.toLowerCase())
    )
  }
  if (filterStatus.value !== '') {
    result = result.filter(room => room.tersedia === (filterStatus.value === 'true'))
  }
  return result
})

// Helper functions
const formatRupiah = (amount) => {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0
  }).format(amount)
}

const parseFasilitas = (fasilitas) => {
  if (!fasilitas) return []
  return fasilitas.split(/[\n,]+/).map(f => f.trim()).filter(f => f)
}

const getFotoUrl = (room) => {
  if (room && room.foto) {
    if (room.foto.startsWith('http')) return room.foto
    return `http://localhost:8000/storage/${room.foto}`
  }
  return '/default-room.jpg'
}

const getUserFotoUrl = (foto) => {
  if (!foto || foto === '' || foto === 'logo.jpg' || foto === null) {
    const name = sessionStorage.getItem('user_name') || 'Administrator'
    return `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=1e40af&color=fff&size=128&_r=${Date.now()}`
  }
  if (foto.startsWith('http://') || foto.startsWith('https://') || foto.startsWith('data:')) {
    const separator = foto.includes('?') ? '&' : '?'
    return `${foto}${separator}_r=${Date.now()}`
  }
  return `http://localhost:8000/storage/${foto}?_r=${Date.now()}`
}

const loadUserData = () => {
  const name = sessionStorage.getItem('user_name') || 'Administrator'
  const foto = sessionStorage.getItem('user_foto') || ''
  const role = sessionStorage.getItem('user_role') || 'Admin'
  
  user.value = {
    name: name,
    foto_profil: getUserFotoUrl(foto),
    role: role.charAt(0).toUpperCase() + role.slice(1).toLowerCase()
  }
  imageKey.value = Date.now()
}

const handleImageError = (e) => {
  const name = user.value.name || 'User'
  e.target.src = `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=1e40af&color=fff&size=128&_r=${Date.now()}`
}

const handleFileUpload = (event) => {
  const file = event.target.files[0]
  if (file) {
    selectedFile.value = file
    previewFoto.value = URL.createObjectURL(file)
  }
}

// CEK DUPLIKAT NAMA
const checkDuplicateName = async (nama, excludeId = null) => {
  try {
    const response = await $fetch(`${API_URL}/room-types/check-duplicate`, {
      method: 'POST',
      body: { nama, exclude_id: excludeId }
    })
    return response.isDuplicate
  } catch (error) {
    console.error('Error checking duplicate:', error)
    return false
  }
}

// API Calls
const fetchRoomTypes = async () => {
  loading.value = true
  try {
    const res = await $fetch(`${API_URL}/room-types`, {
      method: 'GET',
      headers: { 'Accept': 'application/json' }
    })
    
    if (res.success && res.data) {
      roomTypes.value = res.data
    } else if (Array.isArray(res)) {
      roomTypes.value = res
    } else {
      roomTypes.value = []
    }
  } catch (error) {
    console.error('Error fetching room types:', error)
    roomTypes.value = []
  } finally {
    loading.value = false
  }
}

const openModal = () => {
  isEdit.value = false
  form.value = {
    id: null,
    nama: '',
    foto: null,
    harga_per_malam: 0,
    fasilitas: '',
    tipe_tempat_tidur: '',
    tersedia: true,
    stok: 0
  }
  previewFoto.value = null
  selectedFile.value = null
  showModal.value = true
}

const editRoomType = (room) => {
  isEdit.value = true
  form.value = {
    id: room.id,
    nama: room.nama,
    foto: room.foto,
    harga_per_malam: room.harga_per_malam,
    fasilitas: room.fasilitas || '',
    tipe_tempat_tidur: room.tipe_tempat_tidur || '',
    tersedia: room.tersedia,
    stok: room.stok || 0
  }
  previewFoto.value = null
  selectedFile.value = null
  showModal.value = true
}

const closeModal = () => {
  showModal.value = false
}

// SAVE DENGAN CEK DUPLIKAT
const saveRoomType = async () => {
  // Validasi nama tidak boleh kosong
  if (!form.value.nama || form.value.nama.trim() === '') {
    alert('Nama tipe kamar tidak boleh kosong!')
    return
  }

  saving.value = true
  
  try {
    // Cek duplikat nama
    const isDuplicate = await checkDuplicateName(form.value.nama.trim(), isEdit.value ? form.value.id : null)
    
    if (isDuplicate) {
      alert(`❌ Gagal! Nama tipe kamar "${form.value.nama}" sudah ada. Gunakan nama lain.`)
      saving.value = false
      return
    }

    const formData = new FormData()
    formData.append('nama', form.value.nama.trim())
    formData.append('harga_per_malam', form.value.harga_per_malam)
    formData.append('fasilitas', form.value.fasilitas)
    formData.append('tipe_tempat_tidur', form.value.tipe_tempat_tidur)
    formData.append('tersedia', form.value.tersedia ? 1 : 0)
    formData.append('stok', form.value.stok || 0)
    
    if (selectedFile.value) {
      formData.append('foto', selectedFile.value)
    }

    const url = isEdit.value 
      ? `${API_URL}/room-types/${form.value.id}`
      : `${API_URL}/room-types`
    
    if (isEdit.value) {
      formData.append('_method', 'PUT')
      await $fetch(url, {
        method: 'POST',
        body: formData
      })
      alert('✅ Berhasil mengupdate tipe kamar!')
    } else {
      await $fetch(url, {
        method: 'POST',
        body: formData
      })
      alert('✅ Berhasil menambahkan tipe kamar baru!')
    }
    
    closeModal()
    await fetchRoomTypes()
  } catch (error) {
    console.error('Error:', error)
    const errorMessage = error.data?.message || error.message || 'Gagal menyimpan data'
    
    if (errorMessage.toLowerCase().includes('duplicate') || errorMessage.toLowerCase().includes('already exists')) {
      alert(`❌ Nama tipe kamar "${form.value.nama}" sudah ada! Gunakan nama lain.`)
    } else {
      alert('❌ Gagal menyimpan: ' + errorMessage)
    }
  } finally {
    saving.value = false
  }
}

const confirmDelete = (room) => {
  // Validasi tambahan sebelum buka modal konfirmasi
  if (room.stok > 0) {
    alert(`❌ Tidak dapat menghapus "${room.nama}" karena masih memiliki stok ${room.stok} kamar. Kurangi stok menjadi 0 terlebih dahulu.`)
    return
  }
  selectedRoomType.value = room
  showDelete.value = true
}

const deleteRoomType = async () => {
  saving.value = true
  try {
    await $fetch(`${API_URL}/room-types/${selectedRoomType.value.id}`, {
      method: 'DELETE'
    })
    alert('✅ Berhasil menghapus tipe kamar')
    showDelete.value = false
    await fetchRoomTypes()
  } catch (error) {
    console.error('Error:', error)
    const errorMessage = error.data?.message || error.message || 'Gagal menghapus tipe kamar'
    
    if (errorMessage.toLowerCase().includes('stok') || errorMessage.toLowerCase().includes('stock')) {
      alert(`❌ Tidak dapat menghapus karena masih memiliki stok. ${errorMessage}`)
    } else if (errorMessage.toLowerCase().includes('used') || errorMessage.toLowerCase().includes('referenced')) {
      alert('❌ Tipe kamar sedang digunakan oleh kamar, tidak dapat dihapus!')
    } else {
      alert('❌ ' + errorMessage)
    }
  } finally {
    saving.value = false
  }
}

const logout = () => {
  if (confirm('Apakah Anda yakin ingin logout?')) {
    sessionStorage.clear()
    router.push('/')
  }
}

const handleClickOutside = (e) => {
  if (showProfileMenu.value && !e.target.closest('.relative')) {
    showProfileMenu.value = false
  }
}

onMounted(async () => {
  loadUserData()
  
  const role = sessionStorage.getItem('user_role')
  if (role !== 'admin') {
    alert('⛔ Akses ditolak. Halaman ini khusus admin.')
    router.push('/')
    return
  }
  
  await fetchRoomTypes()
  document.addEventListener('click', handleClickOutside)
})

onBeforeUnmount(() => {
  document.removeEventListener('click', handleClickOutside)
})
</script>

<style scoped>
* { transition: background-color 0.2s, transform 0.2s, box-shadow 0.2s; }

@keyframes fade-in {
  from { opacity: 0; transform: translateY(-10px); }
  to { opacity: 1; transform: translateY(0); }
}

@keyframes scale-in {
  from { opacity: 0; transform: scale(0.95); }
  to { opacity: 1; transform: scale(1); }
}

.animate-fade-in { animation: fade-in 0.2s ease-out; }
.animate-scale-in { animation: scale-in 0.3s ease-out; }
</style>