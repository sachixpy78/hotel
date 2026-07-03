<template>
  <div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50/30 flex">
    <!-- Sidebar - SAMAKAN DENGAN ADMIN -->
    <aside class="w-72 bg-gradient-to-b from-slate-900 via-blue-900 to-slate-900 min-h-screen text-white fixed left-0 top-0 z-30 shadow-2xl">
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
      <!-- Header - SAMAKAN DENGAN DASHBOARD -->
      <header class="bg-white/80 backdrop-blur-xl border-b border-gray-200/60 px-8 py-5 flex items-center justify-between sticky top-0 z-40 shadow-sm">
        <div class="flex items-center space-x-3">
          <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-600 to-blue-700 flex items-center justify-center shadow-lg shadow-blue-600/30">
            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
          </div>
          <div>
            <h1 class="text-2xl font-bold bg-gradient-to-r from-slate-800 to-slate-600 bg-clip-text text-transparent">Laporan Resepsionis</h1>
            <p class="text-sm text-gray-500">Data tamu yang sudah check-out</p>
          </div>
        </div>
        
        <div class="flex items-center gap-4">
          <button @click="exportToCSV" class="px-5 py-2.5 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white rounded-xl text-sm transition-all flex items-center gap-2 font-semibold shadow-lg shadow-green-600/30 hover:shadow-xl hover:shadow-green-600/40 hover:scale-105">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
            </svg>
            Export CSV
          </button>
          <button @click="fetchLaporan" class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-xl text-sm transition-all flex items-center gap-2 font-semibold shadow-lg shadow-blue-600/30 hover:shadow-xl hover:shadow-blue-600/40 hover:scale-105">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
            </svg>
            Refresh
          </button>
        </div>
      </header>

      <!-- Content -->
      <div class="p-8">
        <!-- Filters -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
          <h3 class="text-lg font-bold text-gray-800 mb-4">Filter Laporan</h3>
          <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Mulai</label>
              <input 
                v-model="filters.tanggal_mulai" 
                type="date" 
                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition hover:border-gray-400"
                @change="fetchLaporan"
              />
            </div>
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Selesai</label>
              <input 
                v-model="filters.tanggal_selesai" 
                type="date" 
                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition hover:border-gray-400"
                @change="fetchLaporan"
              />
            </div>
            <div class="flex items-end">
              <button 
                @click="resetFilters" 
                class="w-full px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-semibold transition"
              >
                Reset
              </button>
            </div>
          </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
          <!-- Total Transaksi -->
          <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-xl hover:shadow-blue-900/5 transition-all duration-300 group">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Total Transaksi</p>
                <p class="text-3xl font-bold text-gray-800 group-hover:scale-110 transition-transform origin-left">{{ summary.total_transaksi || 0 }}</p>
              </div>
              <div class="p-4 bg-gradient-to-br from-blue-100 to-blue-50 rounded-2xl group-hover:scale-110 transition-transform duration-300 shadow-lg shadow-blue-900/10">
                <svg class="w-8 h-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
              </div>
            </div>
            <div class="mt-4 h-1 bg-gradient-to-r from-blue-400 to-blue-600 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
          </div>

          <!-- Total Pendapatan -->
          <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-xl hover:shadow-green-900/5 transition-all duration-300 group">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Total Pendapatan</p>
                <p class="text-2xl font-bold text-green-600 group-hover:scale-110 transition-transform origin-left">{{ formatRupiah(summary.total_pendapatan || 0) }}</p>
              </div>
              <div class="p-4 bg-gradient-to-br from-green-100 to-green-50 rounded-2xl group-hover:scale-110 transition-transform duration-300 shadow-lg shadow-green-900/10">
                <svg class="w-8 h-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
            </div>
            <div class="mt-4 h-1 bg-gradient-to-r from-green-400 to-green-600 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
          </div>

          <!-- Total Denda -->
          <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-xl hover:shadow-orange-900/5 transition-all duration-300 group">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Total Denda</p>
                <p class="text-2xl font-bold text-orange-600 group-hover:scale-110 transition-transform origin-left">{{ formatRupiah(summary.total_denda || 0) }}</p>
              </div>
              <div class="p-4 bg-gradient-to-br from-orange-100 to-orange-50 rounded-2xl group-hover:scale-110 transition-transform duration-300 shadow-lg shadow-orange-900/10">
                <svg class="w-8 h-8 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
              </div>
            </div>
            <div class="mt-4 h-1 bg-gradient-to-r from-orange-400 to-orange-600 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
          </div>

          <!-- Grand Total -->
          <div class="bg-gradient-to-br from-purple-600 to-purple-700 rounded-2xl p-6 shadow-lg hover:shadow-xl hover:shadow-purple-600/30 transition-all duration-300 group hover:scale-105">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-purple-100 text-sm mb-1">Grand Total</p>
                <p class="text-2xl font-bold text-white group-hover:scale-110 transition-transform origin-left">{{ formatRupiah(summary.grand_total || 0) }}</p>
              </div>
              <div class="p-4 bg-white/20 rounded-2xl group-hover:scale-110 transition-transform duration-300">
                <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
              </div>
            </div>
          </div>
        </div>

        <!-- Laporan Table - PERBAIKAN DI SINI -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
          <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-800">Daftar Check-out</h3>
          </div>
          
          <div class="overflow-x-auto">
            <table class="w-full">
              <thead class="bg-gradient-to-r from-slate-50 to-gray-50 border-b border-gray-200">
                <tr>
                  <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No. Pemesanan</th>
                  <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Tamu</th>
                  <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kamar</th>
                  <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Check-in</th>
                  <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Check-out</th>
                  <th class="px-4 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Total Harga</th>
                  <th class="px-4 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Jam Terlambat</th>
                  <th class="px-4 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Denda</th>
                  <th class="px-4 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Grand Total</th>
                </tr>
</thead>
              <tbody class="divide-y divide-gray-100">
                <tr v-for="item in laporanData" :key="item.id" 
                    :class="{
                      'bg-red-50 border-l-4 border-red-500': item.jam_terlambat > 0,
                      'hover:bg-gradient-to-r hover:from-blue-50/50 hover:to-transparent': true
                    }"
                    class="transition-all duration-300"
                >
                  <td class="px-4 py-4 text-sm font-mono font-semibold text-gray-800">{{ item.nomor_pemesanan }}</td>
                  <td class="px-4 py-4 text-sm font-semibold text-gray-800">{{ item.nama_pemesan }}</td>
                  <td class="px-4 py-4 text-sm text-gray-600">{{ item.tipe_kamar }}</td>
                  <td class="px-4 py-4 text-sm text-gray-600">
  <div>
    <span class="font-mono text-xs">{{ item.check_in }}</span>
  </div>
</td>
                  <td class="px-4 py-4 text-sm">
                    <div>
                      <span class="text-gray-600">{{ item.check_out }}</span>
                      <span v-if="item.jam_terlambat > 0" class="block text-xs text-red-600 font-semibold mt-0.5">⚠️ Terlambat</span>
                    </div>
                  </td>
                  <td class="px-4 py-4 text-sm text-right font-semibold text-gray-800">{{ formatRupiah(item.total_harga) }}</td>
                  <td class="px-4 py-4 text-sm text-center">
                    <span v-if="item.jam_terlambat > 0" class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">
                      {{ item.jam_terlambat }} jam
                    </span>
                    <span v-else class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                      Tepat waktu
                    </span>
                  </td>
    <td class="px-4 py-4 text-sm text-right">
                    <span :class="item.denda_keterlambatan > 0 ? 'text-red-600 font-bold' : 'text-gray-400'">
                      {{ formatRupiah(item.denda_keterlambatan) }}
                    </span>
                  </td>
                  <td class="px-4 py-4 text-sm text-right font-bold text-green-600">{{ formatRupiah(item.grand_total) }}</td>
                </tr>
                <tr v-if="laporanData.length === 0">
                  <td colspan="9" class="px-6 py-12 text-center text-gray-500">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                      <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                      </svg>
                    </div>
                    <p class="font-medium text-gray-700">Belum ada data check-out pada periode ini</p>
                    <p class="text-sm mt-1">Data akan muncul setelah tamu melakukan check-out</p>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          
          <!-- Pagination -->
          <div v-if="pagination.total > 0" class="px-6 py-4 border-t border-gray-200 flex items-center justify-between">
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

    <!-- Success Toast -->
    <div v-if="showToast" class="fixed bottom-6 right-6 bg-gradient-to-r from-green-600 to-green-700 text-white px-6 py-3 rounded-xl shadow-2xl z-50 animate-pulse font-semibold">
      {{ toastMessage }}
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const imageKey = ref(0)

// User data
const user = ref({
  nama: '',
  foto_profil: ''
})

// State
const isLoading = ref(false)
const filters = ref({
  tanggal_mulai: '',
  tanggal_selesai: ''
})
const laporanData = ref([])
const summary = ref({
  total_transaksi: 0,
  total_pendapatan: 0,
  total_denda: 0,
  grand_total: 0
})
const pagination = ref({ current_page: 1, last_page: 1, total: 0, from: 0, to: 0 })

// Toast
const showToast = ref(false)
const toastMessage = ref('')

// ✅ Helper URL foto dengan cache-buster PASTI
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

// ✅ Handle image error
const handleImageError = (e) => {
  const name = user.value.nama || 'Resepsionis'
  e.target.src = `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=1e40af&color=fff&size=128&_r=${Date.now()}`
}

// Load user data
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

const showToastMsg = (message) => {
  toastMessage.value = message
  showToast.value = true
  setTimeout(() => showToast.value = false, 3000)
}

// Fetch Laporan from API
const fetchLaporan = async () => {
  try {
    const token = sessionStorage.getItem('auth_token')
    const params = new URLSearchParams()
    
    if (filters.value.tanggal_mulai) {
      params.append('tanggal_mulai', filters.value.tanggal_mulai)
    }
    if (filters.value.tanggal_selesai) {
      params.append('tanggal_selesai', filters.value.tanggal_selesai)
    }
    params.append('page', pagination.value.current_page)
    
    const response = await $fetch(`http://localhost:8000/api/resepsionis/laporan?${params}`, {
      headers: { 
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json'
      }
    })
    
    if (response.success) {
      laporanData.value = response.data || []
      summary.value = response.summary || {}
      pagination.value = response.pagination || {}
    }
  } catch (error) {
    console.error('Gagal fetch laporan:', error)
    if (error.statusCode === 401) {
      alert('Session habis. Silakan login ulang.')
      router.push('/')
    }
  }
}

const resetFilters = () => {
  filters.value = { tanggal_mulai: '', tanggal_selesai: '' }
  pagination.value.current_page = 1
  fetchLaporan()
  showToastMsg('Filter direset')
}

const changePage = (page) => {
  if (page < 1 || page > pagination.value.last_page) return
  pagination.value.current_page = page
  fetchLaporan()
}

const exportToCSV = () => {
  if (laporanData.value.length === 0) {
    alert('Tidak ada data untuk diexport')
    return
  }
  
  const headers = [
    'No. Pemesanan',
    'Nama Tamu',
    'Kamar',
    'Check-in',
    'Check-out',
    'Total Harga',
    'Jam Terlambat',
    'Denda',
    'Grand Total'
  ]
  
  const rows = laporanData.value.map(item => [
    item.nomor_pemesanan,
    item.nama_pemesan,
    item.tipe_kamar,
    item.check_in,
    item.check_out,
    item.total_harga,
    item.jam_terlambat + ' jam',
    item.denda_keterlambatan,
    item.grand_total
  ])
  
  let csvContent = headers.join(',') + '\n'
  rows.forEach(row => {
    csvContent += row.map(cell => `"${cell}"`).join(',') + '\n'
  })
  
  csvContent += '\nRINGKASAN\n'
  csvContent += `Total Transaksi,${summary.value.total_transaksi}\n`
  csvContent += `Total Pendapatan,${summary.value.total_pendapatan}\n`
  csvContent += `Total Denda,${summary.value.total_denda}\n`
  csvContent += `Grand Total,${summary.value.grand_total}\n`
  
  const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' })
  const link = document.createElement('a')
  const url = URL.createObjectURL(blob)
  link.setAttribute('href', url)
  link.setAttribute('download', `laporan-resepsionis-${new Date().toISOString().split('T')[0]}.csv`)
  link.style.visibility = 'hidden'
  document.body.appendChild(link)
  link.click()
  document.body.removeChild(link)
  
  showToastMsg('Laporan berhasil diexport!')
}

const handleLogout = () => {
  if (confirm('Apakah Anda yakin ingin logout?')) {
    sessionStorage.clear()
    router.push('/')
  }
}

onMounted(() => {
  const token = sessionStorage.getItem('auth_token')
  if (!token) {
    router.push('/')
    return
  }
  
  loadUserData()
  fetchLaporan()
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
</style>