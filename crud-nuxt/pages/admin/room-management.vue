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
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
          </div>
          <div>
            <h1 class="text-2xl font-bold bg-gradient-to-r from-slate-800 to-slate-600 bg-clip-text text-transparent">Manajemen Kamar</h1>
            <p class="text-sm text-gray-500">Kelola data kamar hotel</p>
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
                <p class="text-sm font-medium text-gray-500 mb-1">Total Kamar</p>
                <p class="text-3xl font-bold text-gray-800 group-hover:scale-110 transition-transform origin-left">{{ rooms.length }}</p>
              </div>
              <div class="p-4 bg-gradient-to-br from-blue-100 to-blue-50 rounded-2xl group-hover:scale-110 transition-transform duration-300 shadow-lg shadow-blue-900/10">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
              </div>
            </div>
            <div class="mt-4 h-1 bg-gradient-to-r from-blue-400 to-blue-600 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
          </div>
          <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-xl hover:shadow-green-900/5 transition-all duration-300 group">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Tersedia</p>
                <p class="text-3xl font-bold text-gray-800 group-hover:scale-110 transition-transform origin-left">{{ rooms.filter(r => r.status === 'tersedia').length }}</p>
              </div>
              <div class="p-4 bg-gradient-to-br from-green-100 to-green-50 rounded-2xl group-hover:scale-110 transition-transform duration-300 shadow-lg shadow-green-900/10">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
            </div>
            <div class="mt-4 h-1 bg-gradient-to-r from-green-400 to-green-600 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
          </div>
          <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-xl hover:shadow-yellow-900/5 transition-all duration-300 group">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Dibersihkan</p>
                <p class="text-3xl font-bold text-gray-800 group-hover:scale-110 transition-transform origin-left">{{ rooms.filter(r => r.status === 'dibersihkan').length }}</p>
              </div>
              <div class="p-4 bg-gradient-to-br from-yellow-100 to-yellow-50 rounded-2xl group-hover:scale-110 transition-transform duration-300 shadow-lg shadow-yellow-900/10">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
            </div>
            <div class="mt-4 h-1 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
          </div>
          <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-xl hover:shadow-red-900/5 transition-all duration-300 group">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Rusak</p>
                <p class="text-3xl font-bold text-gray-800 group-hover:scale-110 transition-transform origin-left">{{ rooms.filter(r => r.status === 'rusak').length }}</p>
              </div>
              <div class="p-4 bg-gradient-to-br from-red-100 to-red-50 rounded-2xl group-hover:scale-110 transition-transform duration-300 shadow-lg shadow-red-900/10">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
              </div>
            </div>
            <div class="mt-4 h-1 bg-gradient-to-r from-red-400 to-red-600 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
          </div>
        </div>

        <!-- Header dengan tombol Tambah - DIPINDAH KE ATAS (sebelum search) -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
          <div>
            <h2 class="text-2xl font-bold text-gray-800 flex items-center">
              <span class="w-1 h-8 bg-gradient-to-b from-blue-600 to-blue-400 rounded-full mr-3"></span>
              Daftar Kamar
            </h2>
            <p class="text-sm text-gray-500 mt-1">Kelola data kamar hotel</p>
          </div>
          <button 
            @click="openModal()"
            class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-3 rounded-xl shadow-lg shadow-blue-600/30 transition-all duration-200 flex items-center gap-2 font-semibold hover:scale-105"
          >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Kamar
          </button>
        </div>

        <!-- Filter & Search - DIPINDAH KE BAWAH (setelah header Daftar Kamar) -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-6">
          <div class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[250px]">
              <div class="relative">
                <input 
                  v-model="search" 
                  @input="fetchRooms"
                  type="text" 
                  placeholder="Cari nomor kamar..." 
                  class="w-full pl-11 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all hover:border-gray-400"
                />
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 absolute left-3.5 top-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
              </div>
            </div>
            <select 
              v-model="filterStatus" 
              @change="fetchRooms" 
              class="px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white hover:border-gray-400 transition-all font-medium text-gray-700"
            >
              <option value="">Semua Status</option>
              <option value="tersedia">Tersedia</option>
              <option value="dibersihkan">Dibersihkan</option>
              <option value="rusak">Rusak</option>
              <option value="terisi">Terisi</option>
            </select>
          </div>
        </div>

        <!-- Loading -->
        <div v-if="loading" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
          <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-50 mb-4">
            <div class="animate-spin rounded-full h-8 w-8 border-4 border-blue-600 border-t-transparent"></div>
          </div>
          <p class="text-gray-600 font-medium">Memuat data kamar...</p>
        </div>

        <!-- Table -->
        <div v-else class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
          <div class="overflow-x-auto">
            <table class="w-full">
              <thead class="bg-gradient-to-r from-slate-50 to-gray-50 border-b border-gray-200">
                <tr>
                  <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No. Kamar</th>
                  <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tipe Kamar</th>
                  <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                  <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Keterangan</th>
                  <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-100">
                <tr v-for="room in filteredRooms" :key="room.id" class="hover:bg-gradient-to-r hover:from-blue-50/50 hover:to-transparent transition-all duration-300 group">
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-bold text-gray-900">{{ room.nomor_kamar }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                    {{ room.tipe_kamar?.nama || '-' }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span :class="getStatusClass(room.status)" class="px-3 py-1.5 rounded-full text-xs font-semibold inline-flex items-center">
                      <span class="w-1.5 h-1.5 bg-current rounded-full mr-2 opacity-60"></span>
                      {{ room.status.toUpperCase() }}
                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                    {{ room.keterangan || '-' }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center space-x-2">
                      <!-- Edit Icon Button -->
                      <button 
                        @click="openModal(room)" 
                        class="p-2 bg-gradient-to-br from-blue-50 to-blue-100 text-blue-700 rounded-lg hover:from-blue-100 hover:to-blue-200 transition-all border border-blue-200 hover:scale-110"
                        title="Edit"
                      >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                      </button>
                      <!-- Delete Icon Button -->
                      <button 
                        @click="confirmDelete(room)" 
                        :disabled="room.status === 'terisi'"
                        :title="room.status === 'terisi' ? 'Kamar masih terisi' : 'Hapus kamar'"
                        class="p-2 bg-gradient-to-br from-red-50 to-red-100 text-red-700 rounded-lg hover:from-red-100 hover:to-red-200 transition-all border border-red-200 hover:scale-110 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100"
                      >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                      </button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
            <div v-if="filteredRooms.length === 0 && !loading" class="text-center py-12">
              <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
              </div>
              <p class="text-gray-500 font-medium">Tidak ada data kamar</p>
            </div>
          </div>
        </div>
      </main>
    </div>

    <!-- Modal Tambah/Edit -->
    <div v-if="showModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4 z-50" @click.self="closeModal">
      <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden border border-gray-200 animate-scale-in">
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 flex justify-between items-center">
          <div class="flex items-center space-x-3">
            <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
              </svg>
            </div>
            <h3 class="text-lg font-bold text-white">{{ isEdit ? 'Edit Kamar' : 'Tambah Kamar Baru' }}</h3>
          </div>
          <button @click="closeModal" class="text-white/80 hover:text-white transition-colors text-2xl w-8 h-8 flex items-center justify-center rounded-lg hover:bg-white/10">&times;</button>
        </div>
        
        <form @submit.prevent="saveRoom" class="p-6 space-y-4">
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Kamar <span class="text-red-500">*</span></label>
            <input v-model="form.nomor_kamar" type="text" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all hover:border-gray-400" placeholder="Contoh: 101, 205A" />
          </div>
          
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Tipe Kamar</label>
            <select v-model="form.id_tipe_kamar" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white hover:border-gray-400 transition-all">
              <option value="">-- Pilih Tipe Kamar --</option>
              <option v-for="type in roomTypes" :key="type.id" :value="type.id">{{ type.nama }}</option>
            </select>
            <p class="text-xs text-gray-500 mt-1">Opsional, bisa diisi nanti</p>
          </div>

          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Status <span class="text-red-500">*</span></label>
            <select v-model="form.status" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white hover:border-gray-400 transition-all">
              <option value="tersedia">Tersedia</option>
              <option value="dibersihkan">Dibersihkan</option>
              <option value="rusak">Rusak</option>
              <option value="terisi">Terisi</option>
            </select>
          </div>

          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Keterangan</label>
            <textarea v-model="form.keterangan" rows="3" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none resize-none hover:border-gray-400 transition-all" placeholder="Opsional (contoh: Lantai 2, View laut, dll)"></textarea>
          </div>

          <div class="flex gap-3 pt-2">
            <button type="button" @click="closeModal" class="flex-1 px-4 py-2.5 border border-gray-300 rounded-xl hover:bg-gray-50 transition-all font-semibold text-gray-700">Batal</button>
            <button type="submit" :disabled="saving" class="flex-1 px-4 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl hover:from-blue-700 hover:to-blue-800 disabled:opacity-50 transition-all font-semibold shadow-lg shadow-blue-600/30 hover:shadow-xl hover:shadow-blue-600/40">
              {{ saving ? 'Menyimpan...' : (isEdit ? 'Update' : 'Simpan') }}
            </button>
          </div>
        </form>
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
        <h3 class="text-xl font-bold mb-2 text-gray-800">Hapus Kamar?</h3>
        <p class="text-gray-500 text-sm mb-6">Kamar <strong class="text-gray-800">{{ selectedRoom?.nomor_kamar }}</strong> akan dihapus permanen.</p>
        <div class="flex gap-3">
          <button @click="showDelete = false" class="flex-1 px-4 py-2.5 border border-gray-300 rounded-xl hover:bg-gray-50 transition-all font-semibold text-gray-700">Batal</button>
          <button @click="deleteRoom" :disabled="saving" class="flex-1 px-4 py-2.5 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-xl hover:from-red-700 hover:to-red-800 disabled:opacity-50 transition-all font-semibold shadow-lg shadow-red-600/30">Hapus</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const rooms = ref([])
const roomTypes = ref([])
const loading = ref(false)
const saving = ref(false)
const showModal = ref(false)
const showDelete = ref(false)
const showProfileMenu = ref(false)
const isEdit = ref(false)
const search = ref('')
const filterStatus = ref('')
const selectedRoom = ref(null)
const imageKey = ref(0)
let autoCleanInterval = null // ✅ Timer untuk auto-clean polling

// ✅ User ref dengan default kosong
const user = ref({
  name: '',
  foto_profil: '',
  role: ''
})

const form = ref({ 
  id: null, 
  nomor_kamar: '', 
  id_tipe_kamar: null,
  status: 'tersedia', 
  keterangan: '' 
})

// ✅ Helper URL foto dengan cache-buster PASTI
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

// ✅ Load user data - GUNAKAN KEY 'user_foto' YANG KONSISTEN!
const loadUserData = () => {
  const name = sessionStorage.getItem('user_name') || 'Administrator'
  const foto = sessionStorage.getItem('user_foto') || ''
  const role = sessionStorage.getItem('user_role') || 'Admin'
  
  console.log('🔄 [room-management loadUserData] name:', name, 'foto:', foto)
  
  user.value = {
    name: name,
    foto_profil: getUserFotoUrl(foto),
    role: role.charAt(0).toUpperCase() + role.slice(1).toLowerCase()
  }
  
  imageKey.value = Date.now()
  
  console.log('✅ [room-management] user.foto_profil:', user.value.foto_profil)
}

const getStatusClass = (status) => {
  const classes = {
    tersedia: 'bg-green-100 text-green-700 border border-green-200',
    dibersihkan: 'bg-yellow-100 text-yellow-700 border border-yellow-200',
    rusak: 'bg-red-100 text-red-700 border border-red-200',
    terisi: 'bg-blue-100 text-blue-700 border border-blue-200'
  }
  return classes[status] || 'bg-gray-100 text-gray-700 border border-gray-200'
}

const filteredRooms = computed(() => {
  let result = rooms.value
  if (search.value) {
    result = result.filter(r => r.nomor_kamar.toLowerCase().includes(search.value.toLowerCase()))
  }
  if (filterStatus.value) {
    result = result.filter(r => r.status === filterStatus.value)
  }
  return result
})

const fetchRoomTypes = async () => {
  try {
    const res = await $fetch('http://localhost:8000/api/room-types')
    if (res.data && Array.isArray(res.data)) {
      roomTypes.value = res.data
    } else if (Array.isArray(res)) {
      roomTypes.value = res
    } else {
      roomTypes.value = []
    }
  } catch (error) {
    console.error('Error loading room types:', error)
    roomTypes.value = []
  }
}

const fetchRooms = async () => {
  loading.value = true
  try {
    const res = await $fetch('http://localhost:8000/api/kamar')
    rooms.value = Array.isArray(res) ? res : []
  } catch (err) {
    console.error('Gagal memuat kamar:', err)
    alert('❌ Gagal memuat data kamar')
  } finally {
    loading.value = false
  }
}

// ✅ FUNCTION BARU: Auto-clean polling setiap 5 detik
const startAutoCleanPolling = () => {
  autoCleanInterval = setInterval(async () => {
    try {
      await $fetch('http://localhost:8000/api/kamar/auto-clean', {
        method: 'POST',
        headers: {
          'Authorization': `Bearer ${sessionStorage.getItem('auth_token')}`
        }
      })
      // Refresh data jika ada kamar yang berubah status
      fetchRooms()
      fetchRoomTypes()
    } catch (err) {
      // Silent fail, tidak ganggu user
      console.log('Auto-clean running...')
    }
  }, 5000) // Cek setiap 5 detik
}

const openModal = (room = null) => {
  isEdit.value = !!room
  if (room) {
    selectedRoom.value = room
    form.value = { 
      id: room.id,
      nomor_kamar: room.nomor_kamar,
      id_tipe_kamar: room.id_tipe_kamar || null,
      status: room.status,
      keterangan: room.keterangan || ''
    }
  } else {
    form.value = { id: null, nomor_kamar: '', id_tipe_kamar: null, status: 'tersedia', keterangan: '' }
  }
  showModal.value = true
}

const closeModal = () => { showModal.value = false }

const saveRoom = async () => {
  saving.value = true
  try {
    const url = isEdit.value ? `http://localhost:8000/api/kamar/${form.value.id}` : 'http://localhost:8000/api/kamar'
    const method = isEdit.value ? 'PUT' : 'POST'

    await $fetch(url, { 
      method, 
      body: form.value,
      headers: { 'Accept': 'application/json', 'Content-Type': 'application/json' }
    })
    
    alert(`✅ Kamar berhasil ${isEdit.value ? 'diupdate' : 'ditambahkan'}!`)
    closeModal()
    fetchRooms()
  } catch (err) {
    const msg = err?.data?.message || (err?.data?.errors ? JSON.stringify(err.data.errors) : 'Gagal menyimpan data')
    alert(`❌ ${msg}`)
  } finally {
    saving.value = false
  }
}

const confirmDelete = (room) => { selectedRoom.value = room; showDelete.value = true }

const deleteRoom = async () => {
  saving.value = true
  try {
    await $fetch(`http://localhost:8000/api/kamar/${selectedRoom.value.id}`, {
      method: 'DELETE',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${sessionStorage.getItem('auth_token')}`
      }
    })
    alert('✅ Kamar berhasil dihapus!')
    showDelete.value = false
    fetchRooms()
  } catch (err) {
    const errorMsg = err?.data?.message || err?.message || 'Gagal menghapus kamar'
    if (errorMsg.includes('masih terisi')) {
      alert('⚠️ Kamar masih terisi. Tidak dapat dihapus.')
    } else {
      alert('❌ ' + errorMsg)
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

// ✅ Handle image error dengan fallback
const handleImageError = (e) => {
  const name = user.value.name || 'User'
  e.target.src = `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=1e40af&color=fff&size=128&_r=${Date.now()}`
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
  
  await Promise.all([fetchRoomTypes(), fetchRooms()])
  
  // ✅ START AUTO-CLEAN POLLING
  startAutoCleanPolling()
  
  document.addEventListener('click', handleClickOutside)
})

onBeforeUnmount(() => {
  document.removeEventListener('click', handleClickOutside)
  // ✅ CLEAR INTERVAL saat komponen di-unmount
  if (autoCleanInterval) {
    clearInterval(autoCleanInterval)
  }
})
</script>

<style scoped>
* { transition: background-color 0.2s, transform 0.2s, box-shadow 0.2s; }
.overflow-x-auto::-webkit-scrollbar { height: 6px; }
.overflow-x-auto::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 3px; }
.overflow-x-auto::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
.overflow-x-auto::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

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

@keyframes scale-in {
  from {
    opacity: 0;
    transform: scale(0.95);
  }
  to {
    opacity: 1;
    transform: scale(1);
  }
}

.animate-fade-in {
  animation: fade-in 0.2s ease-out;
}

.animate-scale-in {
  animation: scale-in 0.3s ease-out;
}
</style>