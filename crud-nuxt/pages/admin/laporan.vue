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
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
          </div>
          <div>
            <h1 class="text-2xl font-bold bg-gradient-to-r from-slate-800 to-slate-600 bg-clip-text text-transparent">Laporan Pemesanan Hotel</h1>
            <p class="text-sm text-gray-500">Detail transaksi pemesanan kamar berdasarkan periode dan resepsionis</p>
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
        <!-- Controls -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
          <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center gap-4">
            
            <!-- Filters -->
            <div class="flex flex-wrap items-center gap-3">
              <!-- Filter Bulan -->
              <select v-model="selectedMonth" class="px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white hover:border-gray-400 transition-all font-medium">
                <option v-for="(m, idx) in months" :key="idx" :value="idx + 1">{{ m }}</option>
              </select>

              <!-- Filter Tahun -->
              <select v-model="selectedYear" class="px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white hover:border-gray-400 transition-all font-medium">
                <option v-for="y in years" :key="y" :value="y">{{ y }}</option>
              </select>

              <!-- Filter Resepsionis -->
              <select v-model="selectedResepsionis" class="px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white hover:border-gray-400 transition-all font-medium min-w-[180px]">
                <option value="">Semua Resepsionis</option>
                <option v-for="res in resepsionisList" :key="res.id" :value="res.id">
                  {{ res.nama }}
                </option>
              </select>

              <!-- Tombol Terapkan dengan warna BIRU -->
              <button @click="loadTable" class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all flex items-center gap-2 font-semibold shadow-lg shadow-blue-600/30 hover:shadow-xl hover:shadow-blue-600/40 hover:scale-105">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                Terapkan
              </button>

              <button @click="resetFilter" class="px-4 py-2.5 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all font-semibold">
                Reset
              </button>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-3">
              <button @click="exportExcel" class="px-4 py-2.5 border-2 border-green-500 text-green-700 rounded-xl text-sm hover:bg-green-50 transition-all flex items-center gap-2 font-semibold hover:scale-105">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Export Excel
              </button>

              <button @click="exportPDF" class="px-4 py-2.5 border-2 border-red-500 text-red-700 rounded-xl text-sm hover:bg-red-50 transition-all flex items-center gap-2 font-semibold hover:scale-105">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
                Export PDF
              </button>

              <button @click="goBack" class="px-4 py-2.5 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all flex items-center gap-2 font-semibold hover:scale-105">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
              </button>
            </div>
          </div>
        </div>

        <!-- TABLE -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
          
          <!-- Loading -->
          <div v-if="loading" class="text-center py-16 text-gray-500">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-50 mb-4">
              <div class="animate-spin rounded-full h-8 w-8 border-4 border-blue-600 border-t-transparent"></div>
            </div>
            <p class="font-medium">Memuat data pemesanan...</p>
          </div>

          <!-- Empty state -->
          <div v-else-if="tableData.length === 0" class="text-center py-16 text-gray-500">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
              <svg class="w-10 h-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
              </svg>
            </div>
            <p class="font-medium text-gray-700">Tidak ada data pemesanan di periode ini.</p>
            <p v-if="selectedResepsionis" class="text-sm mt-2 text-gray-500">Resepsionis: {{ getResepsionisName(selectedResepsionis) }}</p>
          </div>

          <!-- Real Table -->
          <div v-else class="overflow-x-auto">
            <table class="w-full">
              <thead class="bg-gradient-to-r from-slate-50 to-gray-50 border-b border-gray-200">
  <tr>
    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No. Pemesanan</th>
    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal</th>
    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Tamu</th>
    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tipe Kamar</th>
    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Check-in / Check-out</th>
    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Total</th>
    <!-- ✅ TAMBAHKAN KOLOM JAM TERLAMBAT -->
    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Jam Terlambat</th>
    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Denda</th>
    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Resepsionis</th>
  </tr>
</thead>
              <tbody class="divide-y divide-gray-100">
                <tr v-for="(item, index) in tableData" :key="item.id || index" class="hover:bg-gradient-to-r hover:from-blue-50/50 hover:to-transparent transition-all duration-300">
                  <td class="px-6 py-4 text-sm font-mono font-medium text-gray-700">{{ item.nomor_pemesanan }}</td>
                  <td class="px-6 py-4 text-sm text-gray-600">{{ formatDate(item.created_at || item.tanggal_pemesanan) }}</td>
                  <td class="px-6 py-4 text-sm font-semibold text-gray-800">{{ item.nama_tamu || item.user?.name || item.user?.nama || '-' }}</td>
                  <td class="px-6 py-4 text-sm text-gray-700">{{ item.tipe_kamar?.nama || item.nama_kamar || '-' }}</td>
                  <!-- Di bagian tabel, ganti kolom Check-in / Check-out -->
<td class="px-6 py-4 text-sm">
  <div class="space-y-1">
    <div class="flex items-center gap-2">
      <span class="text-xs font-medium text-green-600 bg-green-50 px-2 py-1 rounded-md">In:</span>
      <span class="text-gray-600 font-mono text-xs">{{ item.check_in_with_time || item.check_in || '-' }}</span>
    </div>
    <div class="flex items-center gap-2">
      <span class="text-xs font-medium text-red-600 bg-red-50 px-2 py-1 rounded-md">Out:</span>
      <span class="text-gray-600 font-mono text-xs">{{ item.check_out_with_time || item.check_out || '-' }}</span>
    </div>
  </div>
</td>
                  <td class="px-6 py-4 text-sm font-bold text-red-600">Rp {{ formatNumber(item.total_harga) }}</td>
                  <!-- ✅ KOLOM JAM TERLAMBAT - BARU DITAMBAHKAN -->
    <td class="px-6 py-4 text-sm text-center">
      <span v-if="item.jam_terlambat > 0" class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">
        {{ item.jam_terlambat }} jam
      </span>
      <span v-else class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
        Tepat waktu
      </span>
    </td>
                  <!-- ✅ KOLOM DENDA - Pastikan menampilkan denda_keterlambatan -->
                  <td class="px-6 py-4 text-sm" :class="{'text-orange-600 font-semibold': (item.denda_keterlambatan || 0) > 0}">
                  {{ formatNumber(item.denda_keterlambatan || 0) }}
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-600">{{ item.resepsionis_nama || item.verified_by_name || '-' }}</td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- Pagination -->
          <div v-if="pagination && pagination.total_pages > 1 && tableData.length > 0" class="px-6 py-4 border-t border-gray-100 flex justify-center items-center gap-3">
            <button 
              @click="changePage(pagination.current_page - 1)" 
              :disabled="pagination.current_page === 1"
              class="px-4 py-2 border border-gray-300 rounded-xl text-sm disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-50 transition-all font-medium"
            >
              ← Prev
            </button>
            
            <span class="px-4 py-2 text-sm text-gray-600 font-medium bg-gray-50 rounded-xl">
              Halaman {{ pagination.current_page }} dari {{ pagination.total_pages }}
            </span>
            
            <button 
              @click="changePage(pagination.current_page + 1)" 
              :disabled="pagination.current_page === pagination.total_pages"
              class="px-4 py-2 border border-gray-300 rounded-xl text-sm disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-50 transition-all font-medium"
            >
              Next →
            </button>
          </div>
        </div>

        <!-- Summary -->
        <div v-if="tableData.length > 0" class="mt-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl border border-blue-200 p-6">
          <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
              <p class="text-sm font-medium text-gray-600 mb-1">💰 Total Pendapatan Periode Ini:</p>
              <p class="text-3xl font-bold text-blue-600">Rp {{ formattedTotal }}</p>
              <p class="text-xs text-gray-500 mt-2">* Belum termasuk pajak & service charge</p>
            </div>
            <div class="flex gap-6 text-sm">
              <div class="text-center">
                <p class="text-2xl font-bold text-gray-800">{{ totalBookings }}</p>
                <p class="text-xs text-gray-500">Total Booking</p>
              </div>
              <div class="text-center">
                <p class="text-2xl font-bold text-yellow-600">{{ pendingCount }}</p>
                <p class="text-xs text-gray-500">Menunggu</p>
              </div>
              <div class="text-center">
                <p class="text-2xl font-bold text-green-600">{{ todayCheckIn }}</p>
                <p class="text-xs text-gray-500">Check-in Hari Ini</p>
              </div>
            </div>
          </div>
        </div>

      </main>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed, watch } from 'vue'
import { useRouter, useRoute } from 'vue-router'

const router = useRouter()
const route = useRoute()

const imageKey = ref(0)
const showProfileMenu = ref(false)

// ✅ User ref dengan default kosong
const user = ref({
  name: '',
  foto_profil: '',
  role: ''
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

// ✅ Load user data
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

// ✅ Handle image error
const handleImageError = (e) => {
  const name = user.value.name || 'User'
  e.target.src = `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=1e40af&color=fff&size=128&_r=${Date.now()}`
}

const logout = () => {
  if (confirm('Apakah Anda yakin ingin logout?')) {
    sessionStorage.clear()
    router.push('/')
  }
}

// =========================
// BULAN & TAHUN
// =========================
const months = [
  'Januari','Februari','Maret','April','Mei','Juni',
  'Juli','Agustus','September','Oktober','November','Desember'
]

const now = new Date()
const selectedMonth = ref(now.getMonth() + 1)
const selectedYear = ref(now.getFullYear())
const selectedStatus = ref('')
const selectedResepsionis = ref('')
const currentPage = ref(1)

const years = []
for (let y = now.getFullYear(); y >= now.getFullYear() - 5; y--) years.push(y)

// =========================
// DAFTAR RESEPSIONIS
// =========================
const resepsionisList = ref([])

async function loadResepsionisList() {
  try {
    const token = sessionStorage.getItem('auth_token')
    const res = await fetch("http://localhost:8000/api/admin", {
      headers: { 'Authorization': `Bearer ${token}` }
    })
    const data = await res.json()

    const admins = Array.isArray(data) ? data : (data?.data || [])
    resepsionisList.value = admins
      .filter(user => user.level === "resepsionis")
      .map(user => ({
        id: user.id,
        nama: user.username || user.nama
      }))
  } catch (err) {
    console.error("Gagal memuat daftar resepsionis:", err)
  }
}

// =========================
// DATA TABEL
// =========================
const tableData = ref([])
const loading = ref(false)
const totalSum = ref(0)
const pagination = ref(null)

const formattedTotal = computed(() => {
  return Number(totalSum.value || 0).toLocaleString('id-ID')
})

const totalBookings = computed(() => tableData.value.length)

const pendingCount = computed(() => {
  return tableData.value.filter(item => 
    ['menunggu_pembayaran', 'menunggu_verifikasi', 'baru'].includes(item.status)
  ).length
})

const todayCheckIn = computed(() => {
  const today = now.toISOString().split('T')[0]
  return tableData.value.filter(item => 
    item.check_in?.startsWith(today) && item.status === 'check_in'
  ).length
})

// =========================
// CEK ROLE & INIT
// =========================
onMounted(async () => {
  // Load user data
  loadUserData()
  
  const role = sessionStorage.getItem('user_role')
  if (role !== 'admin' && role !== 'super_admin') {
    alert('Akses ditolak. Hanya admin yang dapat mengakses laporan.')
    router.push('/admin')
    return
  }

  // Load params dari URL jika ada
  if (route.query.bulan) selectedMonth.value = parseInt(route.query.bulan)
  if (route.query.tahun) selectedYear.value = parseInt(route.query.tahun)
  if (route.query.status) selectedStatus.value = route.query.status
  if (route.query.id_resepsionis) selectedResepsionis.value = route.query.id_resepsionis

  await loadResepsionisList()
  loadTable()
})

// =========================
// LOAD DATA TABEL
// =========================
  async function loadTable(page = 1) {
  loading.value = true
  currentPage.value = page

  try {
    const token = sessionStorage.getItem('auth_token')
    
    let url = `http://localhost:8000/api/admin/laporan/pemesanan?bulan=${selectedMonth.value}&tahun=${selectedYear.value}&page=${page}&per_page=20`
    
    if (selectedStatus.value) {
      url += `&status=${selectedStatus.value}`
    }
    
    if (selectedResepsionis.value) {
      const id = parseInt(selectedResepsionis.value)
      if (!isNaN(id) && id > 0) {
        url += `&id_resepsionis=${id}`
      }
    }

    const res = await fetch(url, {
      headers: { 
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json'
      }
    })
    
    const data = await res.json()
    
    if (data.data) {
      tableData.value = data.data
      pagination.value = {
        current_page: data.current_page,
        total_pages: data.last_page,
        total: data.total
      }
    } else {
      tableData.value = Array.isArray(data) ? data : []
    }

    // ✅ HITUNG TOTAL: harga + denda (code simpel)
    totalSum.value = tableData.value.reduce((sum, item) => {
      if (item.status === 'batal') return sum
      const harga = Number(item.total_harga) || 0
      const denda = Number(item.denda_keterlambatan) || 0
      return sum + harga + denda
    }, 0)

  } catch (err) {
    console.error('Error loading laporan:', err)
    alert('Gagal memuat data laporan.')
  }

  loading.value = false
}

// =========================
// PAGINATION
// =========================
function changePage(page) {
  if (page < 1 || (pagination.value && page > pagination.value.total_pages)) return
  loadTable(page)
}

// =========================
// FORMAT HELPER
// =========================
function formatNumber(num) {
  if (!num) return '0'
  const cleaned = String(num).replace(/[^0-9.]/g, '')
  return Number(cleaned).toLocaleString('id-ID')
}

function formatDate(dateString) {
  if (!dateString) return '-'
  return new Date(dateString).toLocaleDateString('id-ID', { 
    day: 'numeric', month: 'short', year: 'numeric' 
  })
}

function formatDateShort(dateString) {
  if (!dateString) return '-'
  return new Date(dateString).toLocaleDateString('id-ID', { 
    day: 'numeric', month: 'short' 
  })
}

function getStatusBadge(status) {
  const map = {
    'baru': 'bg-blue-100 text-blue-700 border border-blue-300',
    'menunggu_pembayaran': 'bg-yellow-100 text-yellow-700 border border-yellow-300',
    'menunggu_verifikasi': 'bg-orange-100 text-orange-700 border border-orange-300',
    'terkonfirmasi': 'bg-green-100 text-green-700 border border-green-300',
    'check_in': 'bg-purple-100 text-purple-700 border border-purple-300',
    'check_out': 'bg-gray-100 text-gray-700 border border-gray-300',
    'batal': 'bg-red-100 text-red-700 border border-red-300'
  }
  return map[status] || 'bg-gray-100 text-gray-700'
}

function getStatusLabel(status) {
  const map = {
    'baru': '🆕 Baru',
    'menunggu_pembayaran': '⏳ Menunggu Bayar',
    'menunggu_verifikasi': '🔍 Verifikasi',
    'terkonfirmasi': '✅ Terkonfirmasi',
    'check_in': '🛏️ Check-in',
    'check_out': '🚪 Check-out',
    'batal': '❌ Batal'
  }
  return map[status] || status
}

function getResepsionisName(id) {
  const res = resepsionisList.value.find(r => r.id == id)
  return res ? res.nama : ''
}

// =========================
// EXPORT EXCEL - DOWNLOAD FILE
// =========================
async function exportExcel() {
  const token = sessionStorage.getItem('auth_token')
  if (!token) {
    alert('Silakan login ulang')
    return
  }

  const headers = ['No', 'No. Pemesanan', 'Tanggal', 'Nama Tamu', 'Email', 'Tipe Kamar', 'Check-in', 'Check-out', 'Malam', 'Total Harga', 'Jam Terlambat', 'Denda', 'Resepsionis'];
  const rows = tableData.value.map(item => [
  item.jam_terlambat + ' jam',  // ✅ TAMBAHKAN INI
  item.denda_keterlambatan || 0,
]);
  
  let url = `http://localhost:8000/api/admin/laporan/export-excel?bulan=${selectedMonth.value}&tahun=${selectedYear.value}&token=${token}`
  
  if (selectedResepsionis.value) {
    url += `&id_resepsionis=${selectedResepsionis.value}`
  }
  
  // Buka di tab baru untuk trigger download
  window.open(url, '_blank')
}

// =========================
// EXPORT PDF - DOWNLOAD FILE
// =========================
async function exportPDF() {
  const token = sessionStorage.getItem('auth_token')
  if (!token) {
    alert('Silakan login ulang')
    return
  }
  
  let url = `http://localhost:8000/api/admin/laporan/export-pdf?bulan=${selectedMonth.value}&tahun=${selectedYear.value}&token=${token}`
  
  if (selectedResepsionis.value) {
    url += `&id_resepsionis=${selectedResepsionis.value}`
  }
  
  // Buka di tab baru untuk trigger download
  window.open(url, '_blank')
}

// =========================
// BACK / RESET
// =========================
function goBack() {
  router.back() // Opsi 1: Kembali ke halaman sebelumnya di history browser
}

function resetFilter() {
  selectedMonth.value = now.getMonth() + 1
  selectedYear.value = now.getFullYear()
  selectedStatus.value = ''
  selectedResepsionis.value = ''
  currentPage.value = 1
  loadTable(1)
}

// Watch query changes
watch(() => route.query, (newQuery) => {
  if (newQuery.refresh) {
    loadTable()
  }
}, { deep: true })
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
</style>