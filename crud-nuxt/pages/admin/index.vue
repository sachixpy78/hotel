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
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
          </div>
          <div>
            <h1 class="text-2xl font-bold bg-gradient-to-r from-slate-800 to-slate-600 bg-clip-text text-transparent">User Management</h1>
            <p class="text-sm text-gray-500">Kelola akun resepsionis dan persetujuan</p>
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
                to="/admin/profil" 
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
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
          <div class="group bg-white/90 backdrop-blur-xl rounded-2xl p-6 border border-gray-200 shadow-lg hover:shadow-2xl transition-all duration-300 hover:scale-105 hover:-translate-y-1 cursor-pointer">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-gray-600 text-sm font-semibold mb-1">Menunggu Persetujuan</p>
                <p class="text-4xl font-bold text-yellow-600">{{ pendingCount }}</p>
                <p class="text-xs text-gray-400 mt-1">Perlu aktivasi</p>
              </div>
              <div class="w-14 h-14 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl flex items-center justify-center shadow-lg shadow-yellow-500/30 group-hover:scale-110 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
            </div>
          </div>
          
          <div class="group bg-white/90 backdrop-blur-xl rounded-2xl p-6 border border-gray-200 shadow-lg hover:shadow-2xl transition-all duration-300 hover:scale-105 hover:-translate-y-1 cursor-pointer">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-gray-600 text-sm font-semibold mb-1">Aktif</p>
                <p class="text-4xl font-bold text-green-600">{{ activeCount }}</p>
                <p class="text-xs text-gray-400 mt-1">Sedang beroperasi</p>
              </div>
              <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg shadow-green-500/30 group-hover:scale-110 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
            </div>
          </div>
          
          <div class="group bg-white/90 backdrop-blur-xl rounded-2xl p-6 border border-gray-200 shadow-lg hover:shadow-2xl transition-all duration-300 hover:scale-105 hover:-translate-y-1 cursor-pointer">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-gray-600 text-sm font-semibold mb-1">Diblokir</p>
                <p class="text-4xl font-bold text-red-600">{{ blockedCount }}</p>
                <p class="text-xs text-gray-400 mt-1">Akses ditangguhkan</p>
              </div>
              <div class="w-14 h-14 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl flex items-center justify-center shadow-lg shadow-red-500/30 group-hover:scale-110 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                </svg>
              </div>
            </div>
          </div>
        </div>

        <!-- Table Section -->
        <div class="bg-white/90 backdrop-blur-xl rounded-2xl border border-gray-200 shadow-lg overflow-hidden">
          <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-slate-50/80 to-white/80">
            <h2 class="text-xl font-bold text-gray-800">Daftar Resepsionis</h2>
          </div>
          
          <!-- Loading -->
          <div v-if="loading" class="text-center py-16 text-gray-500">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-50 mb-4">
              <div class="animate-spin rounded-full h-8 w-8 border-4 border-blue-600 border-t-transparent"></div>
            </div>
            <p class="font-medium">Memuat data resepsionis...</p>
          </div>

          <!-- Table -->
          <div v-else class="overflow-x-auto">
            <table class="w-full">
              <thead class="bg-gradient-to-r from-slate-50 to-gray-50 border-b border-gray-200">
                <tr>
                  <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Foto</th>
                  <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                  <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Username</th>
                  <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No. Telp</th>
                  <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                  <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-100">
                <tr v-for="resepsionis in resepsionisList" :key="resepsionis.id" class="hover:bg-gradient-to-r hover:from-blue-50/30 hover:to-transparent transition-all duration-300">
                  <td class="px-6 py-4 whitespace-nowrap">
                    <img :src="getFotoUrl(resepsionis.gambar)" alt="Foto" class="h-10 w-10 rounded-full object-cover border-2 border-gray-200 shadow-sm" />
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 font-medium">{{ resepsionis.email }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ resepsionis.username }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ resepsionis.no_telp || '-' }}</td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span 
                      v-if="resepsionis.status === 'on'"
                      class="px-3 py-1.5 bg-green-100 text-green-700 rounded-full text-xs font-semibold shadow-sm"
                    >
                      ✅ Aktif
                    </span>
                    <span 
                      v-else-if="resepsionis.status === 'off'"
                      class="px-3 py-1.5 bg-yellow-100 text-yellow-700 rounded-full text-xs font-semibold shadow-sm"
                    >
                      ⏳ Menunggu
                    </span>
                    <span 
                      v-else-if="resepsionis.status === 'blokir'"
                      class="px-3 py-1.5 bg-red-100 text-red-700 rounded-full text-xs font-semibold shadow-sm"
                    >
                      🚫 Diblokir
                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap space-x-2">
                    <!-- Edit Button -->
                    <button 
                      @click="showEditModal(resepsionis)"
                      class="px-3 py-1.5 bg-blue-100 text-blue-700 rounded-lg text-xs font-semibold hover:bg-blue-200 transition-all duration-300 hover:scale-105 shadow-sm"
                      title="Edit"
                    >
                      ✏️ Edit
                    </button>
                    
                    <!-- Activate Button (for pending) -->
                    <button 
                      v-if="resepsionis.status === 'off'"
                      @click="approveResepsionis(resepsionis)"
                      class="px-3 py-1.5 bg-green-100 text-green-700 rounded-lg text-xs font-semibold hover:bg-green-200 transition-all duration-300 hover:scale-105 shadow-sm"
                      title="Aktifkan"
                    >
                      ✅ Aktifkan
                    </button>
                    
                    <!-- Deactivate Button (for active) -->
                    <button 
                      v-if="resepsionis.status === 'on'"
                      @click="toggleStatus(resepsionis, 'off')"
                      class="px-3 py-1.5 bg-yellow-100 text-yellow-700 rounded-lg text-xs font-semibold hover:bg-yellow-200 transition-all duration-300 hover:scale-105 shadow-sm"
                      title="Nonaktifkan"
                    >
                      ⏸️ Nonaktif
                    </button>
                    
                    <!-- Unblock Button -->
                    <button 
                      v-if="resepsionis.status === 'blokir'"
                      @click="unblockResepsionis(resepsionis)"
                      class="px-3 py-1.5 bg-orange-100 text-orange-700 rounded-lg text-xs font-semibold hover:bg-orange-200 transition-all duration-300 hover:scale-105 shadow-sm"
                      title="Buka Blokir"
                    >
                      🔓 Buka
                    </button>
                    
                    <!-- Delete Button -->
                    <button 
                      @click="showDeleteModal(resepsionis)"
                      class="px-3 py-1.5 bg-red-100 text-red-700 rounded-lg text-xs font-semibold hover:bg-red-200 transition-all duration-300 hover:scale-105 shadow-sm"
                      title="Hapus"
                    >
                      🗑️ Hapus
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- Empty State -->
          <div v-if="!loading && resepsionisList.length === 0" class="text-center py-16 text-gray-500">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <p class="font-medium text-gray-700">Tidak ada data resepsionis</p>
            <p class="text-sm mt-1 text-gray-500">Data akan muncul setelah ada pendaftaran</p>
          </div>
        </div>
      </main>
    </div>

    <!-- Edit Modal - Styled like laporan.vue modals -->
    <Teleport to="body">
      <div v-if="showEdit" class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4 animate-fade-in" @click.self="showEdit = false">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
          <!-- Modal Header -->
          <div class="flex justify-between items-center p-6 border-b border-gray-200">
            <h3 class="text-xl font-bold text-gray-800">Edit Resepsionis</h3>
            <button @click="showEdit = false" class="text-gray-400 hover:text-gray-600 p-2 hover:bg-gray-100 rounded-xl transition">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
          
          <!-- Modal Body -->
          <div class="p-6 space-y-4">
            <!-- Upload Foto -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">Ganti Foto Profil <span class="text-gray-400 font-normal">(optional)</span></label>
              <input type="file" accept="image/*" @change="handleImageUpload" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-colors" />
            </div>

            <!-- Email -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
              <input v-model="editForm.email" type="email" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" />
            </div>

            <!-- Username -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-1">Username <span class="text-red-500">*</span></label>
              <input v-model="editForm.username" type="text" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" />
            </div>

            <!-- No. Telepon -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-1">No. Telepon</label>
              <input v-model="editForm.no_telp" type="text" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" />
            </div>

            <!-- Alamat -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat</label>
              <textarea v-model="editForm.alamat" rows="3" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all resize-none" />
            </div>

            <!-- Reset Password -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-1">Reset Password <span class="text-gray-400 text-xs">(kosongkan jika tidak diubah)</span></label>
              <input v-model="editForm.password" type="password" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" />
            </div>

            <!-- Status -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
              <div class="flex items-center space-x-6">
                <label class="inline-flex items-center cursor-pointer">
                  <input v-model="editForm.status" type="radio" value="on" class="form-radio h-4 w-4 text-blue-600" />
                  <span class="ml-2 text-sm text-gray-700">Aktif</span>
                </label>
                <label class="inline-flex items-center cursor-pointer">
                  <input v-model="editForm.status" type="radio" value="off" class="form-radio h-4 w-4 text-blue-600" />
                  <span class="ml-2 text-sm text-gray-700">Nonaktif</span>
                </label>
                <label class="inline-flex items-center cursor-pointer">
                  <input v-model="editForm.status" type="radio" value="blokir" class="form-radio h-4 w-4 text-blue-600" />
                  <span class="ml-2 text-sm text-gray-700">Blokir</span>
                </label>
              </div>
            </div>
          </div>
          
          <!-- Modal Footer -->
          <div class="flex space-x-3 p-6 border-t border-gray-200">
            <button @click="showEdit = false" class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 rounded-xl text-sm font-semibold hover:bg-gray-200 transition-all">
              Batal
            </button>
            <button @click="saveEdit" :disabled="saving" class="flex-1 px-4 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl text-sm font-semibold hover:from-blue-700 hover:to-blue-800 transition-all disabled:opacity-50 disabled:cursor-not-allowed shadow-lg shadow-blue-600/30">
              {{ saving ? 'Menyimpan...' : 'Simpan Perubahan' }}
            </button>
          </div>
        </div>
      </div>
    </Teleport>

    <!-- Delete Confirmation Modal -->
    <Teleport to="body">
      <div v-if="showDelete" class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4 animate-fade-in" @click.self="showDelete = false">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full">
          <div class="flex justify-between items-center p-6 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-800">Hapus Resepsionis</h3>
            <button @click="showDelete = false" class="text-gray-400 hover:text-gray-600 p-2 hover:bg-gray-100 rounded-xl transition">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
          <div class="p-6 text-center">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
              </svg>
            </div>
            <p class="text-sm text-gray-600 mb-4">Apakah Anda yakin ingin menghapus resepsionis ini?</p>
            <div class="text-left text-sm mb-4 bg-gray-50 p-4 rounded-xl border border-gray-200">
              <p><strong class="text-gray-700">Email:</strong> <span class="text-gray-600">{{ selectedResepsionis?.email }}</span></p>
              <p><strong class="text-gray-700">Username:</strong> <span class="text-gray-600">{{ selectedResepsionis?.username }}</span></p>
            </div>
            <p class="text-xs text-red-600 font-semibold">⚠️ Data yang dihapus tidak dapat dikembalikan!</p>
          </div>
          <div class="flex space-x-3 p-6 border-t border-gray-200">
            <button @click="showDelete = false" class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 rounded-xl text-sm font-semibold hover:bg-gray-200 transition-all">
              Batal
            </button>
            <button @click="deleteResepsionis(selectedResepsionis)" class="flex-1 px-4 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl text-sm font-semibold hover:from-red-600 hover:to-red-700 transition-all shadow-lg shadow-red-600/30">
              Hapus
            </button>
          </div>
        </div>
      </div>
    </Teleport>
  </div>
</template>

<script setup>
import { ref, onMounted, computed, onBeforeUnmount } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

const loading = ref(true)
const saving = ref(false)
const resepsionisList = ref([])
const showProfileMenu = ref(false)
const showEdit = ref(false)
const showDelete = ref(false)
const selectedResepsionis = ref(null)
const imageKey = ref(0)
let imageFile = null

// User ref
const user = ref({
  name: '',
  foto_profil: '',
  role: ''
})

const editForm = ref({
  email: '',
  username: '',
  no_telp: '',
  alamat: '',
  password: '',
  status: 'on'
})

// Computed properties untuk stats
const pendingCount = computed(() => resepsionisList.value.filter(r => r.status === 'off').length)
const activeCount = computed(() => resepsionisList.value.filter(r => r.status === 'on').length)
const blockedCount = computed(() => resepsionisList.value.filter(r => r.status === 'blokir').length)

// Helper URL foto dengan cache-buster
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

// Load user data
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

// GET DATA RESEPSIONIS DENGAN TOKEN
const fetchResepsionis = async () => {
  try {
    loading.value = true
    const authToken = sessionStorage.getItem('auth_token')
    
    if (!authToken) {
      alert('Session expired. Silakan login ulang.')
      router.push('/')
      return
    }
    
    const response = await $fetch('http://localhost:8000/api/admin', {
      method: 'GET',
      headers: {
        'Authorization': `Bearer ${authToken}`,
        'Accept': 'application/json',
        'Content-Type': 'application/json'
      }
    })
    
    resepsionisList.value = response.filter(admin => admin.level === 'resepsionis')
    
  } catch (err) {
    console.error('❌ Error fetching resepsionis:', err)
    
    if (err.response?.status === 401) {
      alert('Session expired. Silakan login ulang.')
      sessionStorage.removeItem('auth_token')
      router.push('/')
    } else {
      alert('Gagal memuat data resepsionis: ' + (err.data?.message || err.message))
    }
  } finally {
    loading.value = false
  }
}

// GET FOTO URL
const getFotoUrl = (gambar) => {
  if (!gambar || gambar === 'logo.jpg') return '/logo.jpg'
  if (gambar.startsWith('data:')) return gambar
  return `http://localhost:8000/storage/${gambar}`
}

// APPROVE RESEPSIONIS
const approveResepsionis = async (resepsionis) => {
  if (!confirm('Aktifkan akun resepsionis ini?')) return
  
  try {
    const authToken = sessionStorage.getItem('auth_token')
    
    await $fetch(`http://localhost:8000/api/admin/${resepsionis.id}/activate`, {
      method: 'PUT',
      headers: {
        'Authorization': `Bearer ${authToken}`,
        'Accept': 'application/json'
      }
    })
    alert('✅ Akun resepsionis berhasil diaktifkan!')
    fetchResepsionis()
  } catch (err) {
    console.error('Error:', err)
    alert('❌ Gagal mengaktifkan akun.')
  }
}

// TOGGLE STATUS
const toggleStatus = (resepsionis, status) => {
  const action = status === 'on' ? 'menonaktifkan' : 'mengaktifkan'
  if (!confirm(`Apakah Anda yakin ingin ${action} akun ini?`)) return
  updateStatus(resepsionis, status)
}

// UPDATE STATUS
const updateStatus = async (resepsionis, status) => {
  try {
    const authToken = sessionStorage.getItem('auth_token')
    const endpoint = status === 'on' ? 'deactivate' : 'activate'
    
    await $fetch(`http://localhost:8000/api/admin/${resepsionis.id}/${endpoint}`, {
      method: 'PUT',
      headers: {
        'Authorization': `Bearer ${authToken}`,
        'Accept': 'application/json'
      }
    })
    alert(`✅ Status berhasil diubah menjadi ${status === 'on' ? 'Nonaktif' : 'Aktif'}`)
    fetchResepsionis()
  } catch (err) {
    console.error('Error:', err)
    alert('❌ Gagal mengubah status.')
  }
}

// UNBLOCK RESEPSIONIS
const unblockResepsionis = async (resepsionis) => {
  if (!confirm('Buka blokir akun ini?')) return
  
  try {
    const authToken = sessionStorage.getItem('auth_token')
    
    await $fetch(`http://localhost:8000/api/admin/${resepsionis.id}/activate`, {
      method: 'PUT',
      headers: {
        'Authorization': `Bearer ${authToken}`,
        'Accept': 'application/json'
      }
    })
    alert('✅ Blokir akun berhasil diangkat!')
    fetchResepsionis()
  } catch (err) {
    console.error('Error:', err)
    alert('❌ Gagal membuka blokir akun.')
  }
}

// SHOW EDIT MODAL
const showEditModal = (resepsionis) => {
  selectedResepsionis.value = resepsionis
  editForm.value = {
    email: resepsionis.email,
    username: resepsionis.username,
    no_telp: resepsionis.no_telp || '',
    alamat: resepsionis.alamat || '',
    password: '',
    status: resepsionis.status
  }
  imageFile = null
  showEdit.value = true
}

// SHOW DELETE MODAL
const showDeleteModal = (resepsionis) => {
  selectedResepsionis.value = resepsionis
  showDelete.value = true
}

// HANDLE IMAGE UPLOAD
const handleImageUpload = (e) => {
  const file = e.target.files[0]
  if (!file) return
  if (file.size > 2 * 1024 * 1024) {
    alert('⚠️ Ukuran file maksimal 2MB')
    return
  }
  imageFile = file
}

// SAVE EDIT
const saveEdit = async () => {
  if (!selectedResepsionis.value) return
  
  saving.value = true
  try {
    const authToken = sessionStorage.getItem('auth_token')
    
    if (!authToken) {
      alert('Session expired. Silakan login ulang.')
      router.push('/')
      return
    }
    
    const formData = new FormData()
    formData.append('_method', 'PUT')
    formData.append('email', editForm.value.email)
    formData.append('username', editForm.value.username)
    formData.append('no_telp', editForm.value.no_telp || '')
    formData.append('alamat', editForm.value.alamat || '')
    if (editForm.value.password) {
      formData.append('password', editForm.value.password)
    }
    formData.append('status', editForm.value.status)
    formData.append('level', 'resepsionis')
    if (imageFile) {
      formData.append('gambar', imageFile)
    }

    await $fetch(`http://localhost:8000/api/admin/${selectedResepsionis.value.id}`, {
      method: 'POST',
      body: formData,
      headers: {
        'Authorization': `Bearer ${authToken}`,
        'Accept': 'application/json'
      }
    })

    alert('✅ Data resepsionis berhasil diperbarui!')
    showEdit.value = false
    fetchResepsionis()
  } catch (err) {
    console.error('❌ Error saving:', err)
    
    let errorMessage = 'Gagal menyimpan perubahan.'
    if (err.data?.message) {
      errorMessage = err.data.message
    } else if (err.response?.status === 401) {
      errorMessage = 'Session expired. Silakan login ulang.'
      sessionStorage.removeItem('auth_token')
      router.push('/')
    }
    
    alert('❌ ' + errorMessage)
  } finally {
    saving.value = false
  }
}

// DELETE RESEPSIONIS
const deleteResepsionis = async (resepsionis) => {
  try {
    const authToken = sessionStorage.getItem('auth_token')
    
    await $fetch(`http://localhost:8000/api/admin/${resepsionis.id}`, {
      method: 'DELETE',
      headers: {
        'Authorization': `Bearer ${authToken}`,
        'Accept': 'application/json'
      }
    })
    alert('✅ Resepsionis berhasil dihapus!')
    showDelete.value = false
    fetchResepsionis()
  } catch (err) {
    console.error('Error:', err)
    alert('❌ ' + (err?.data?.message || 'Gagal menghapus data.'))
  }
}

// LOGOUT
const logout = () => {
  if (confirm('Apakah Anda yakin ingin logout?')) {
    sessionStorage.clear()
    router.push('/')
  }
}

// Handle image error
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
  
  const auth_token = sessionStorage.getItem('auth_token')
  if (!auth_token) {
    router.push('/')
    return
  }
  
  const role = sessionStorage.getItem('user_role')
  if (role !== 'admin') {
    alert('⛔ Akses ditolak. Halaman ini khusus admin.')
    router.push('/')
    return
  }
  
  await fetchResepsionis()
  
  document.addEventListener('click', handleClickOutside)
})

onBeforeUnmount(() => {
  document.removeEventListener('click', handleClickOutside)
})
</script>

<style scoped>
* { transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease; }

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

/* Custom scrollbar */
.overflow-x-auto::-webkit-scrollbar {
  height: 6px;
}
.overflow-x-auto::-webkit-scrollbar-track {
  background: #f1f5f9;
  border-radius: 3px;
}
.overflow-x-auto::-webkit-scrollbar-thumb {
  background: #cbd5e1;
  border-radius: 3px;
}
.overflow-x-auto::-webkit-scrollbar-thumb:hover {
  background: #94a3b8;
}
</style>