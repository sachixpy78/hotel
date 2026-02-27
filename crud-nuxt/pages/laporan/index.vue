<template>
  <div class="min-h-screen bg-gray-50 p-6 flex justify-center">
    <div class="w-full max-w-4xl">

      <!-- Tombol Back ke Dashboard -->
      <button
        @click="router.push('/dashboard')"
        class="mb-4 flex items-center gap-2 text-maroon hover:text-red-800 transition-colors duration-300 hover:scale-105"
      >
        <svg xmlns="http://www.w3.org/2000/svg"
             fill="none"
             viewBox="0 0 24 24"
             stroke-width="1.5"
             stroke="currentColor"
             class="w-5 h-5">
          <path stroke-linecap="round" stroke-linejoin="round"
                d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
        </svg>
        <span>Kembali ke Dashboard</span>
      </button>

      <!-- Header -->
      <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold text-gray-900">Laporan Penjualan</h1>
        <p class="text-sm text-gray-500">Ringkasan penjualan per tanggal dan kasir</p>
      </div>

      <!-- Card -->
      <div class="bg-white rounded-lg shadow-sm border border-gray-300 p-6">
        
        <!-- Controls -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
          
          <!-- Dropdowns -->
          <div class="flex flex-wrap items-center gap-3">
            <select v-model="selectedMonth" class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all duration-300">
              <option v-for="(m, idx) in months" :key="idx" :value="idx+1">{{ m }}</option>
            </select>

            <select v-model="selectedYear" class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all duration-300">
              <option v-for="y in years" :key="y" :value="y">{{ y }}</option>
            </select>

            <select v-model="selectedKasir" class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all duration-300 min-w-[140px]">
              <option value="">Semua Kasir</option>
              <option
                v-for="kasir in kasirList"
                :key="kasir.id"
                :value="kasir.id"
              >
                {{ kasir.nama }}
              </option>
            </select>

            <button @click="loadChart" class="px-4 py-2 bg-maroon text-white rounded-md hover:bg-red-800 hover:scale-105 transition-all duration-300">
              Terapkan
            </button>

            <button @click="resetFilter" class="px-3 py-2 bg-yellow-100 text-yellow-700 rounded-md hover:bg-yellow-200 hover:scale-105 transition-all duration-300">
              Reset
            </button>
          </div>

          <!-- Buttons -->
          <div class="flex items-center gap-3">
            <button @click="exportChartExcel" class="px-3 py-2 border border-gray-300 rounded-md text-sm hover:bg-gray-50 hover:scale-105 transition-all duration-300">
              Export Excel
            </button>

            <button @click="goToTable" class="px-3 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 hover:scale-105 transition-all duration-300">
              Next →
            </button>
          </div>
        </div>

        <!-- Chart Area -->
        <div class="mb-6 h-64 flex items-center justify-center relative">

          <div v-if="loading" class="absolute text-gray-500">
            Memuat grafik...
          </div>

          <div v-else-if="labels.length === 0" class="absolute text-gray-500">
            Tidak ada data penjualan pada bulan ini.
          </div>

          <canvas
            v-show="!loading && labels.length > 0"
            ref="chartCanvas"
            class="w-full h-full">
          </canvas>
        </div>

        <!-- Summary -->
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm text-gray-600">Total Pendapatan:</p>
            <p class="text-xl font-semibold text-gray-800">Rp {{ formattedTotal }}</p>
          </div>
          <div>
            <p class="text-sm text-gray-500">
              Bulan: <span class="font-medium">{{ months[selectedMonth-1] }} {{ selectedYear }}</span>
              <span v-if="selectedKasir"> • Kasir: {{ getKasirName(selectedKasir) }}</span>
            </p>
          </div>
        </div>

      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, nextTick, computed } from 'vue'
import { useRouter } from 'vue-router'
import { Chart, registerables } from 'chart.js'
Chart.register(...registerables)

const router = useRouter()

// =====================================
// DROPDOWN BULAN & TAHUN
// =====================================
const months = [
  'Januari','Februari','Maret','April','Mei','Juni',
  'Juli','Agustus','September','Oktober','November','Desember'
]

const now = new Date()
const selectedMonth = ref(now.getMonth() + 1)
const selectedYear = ref(now.getFullYear())
const selectedKasir = ref('') // string kosong = semua kasir

const years = []
for (let y = now.getFullYear(); y >= now.getFullYear() - 5; y--) {
  years.push(y)
}

// =====================================
// DAFTAR KASIR — DIPERBAIKI
// =====================================
const kasirList = ref([])

async function loadKasirList() {
  try {
    // 🔥 GANTI KE /api/admin, BUKAN /api/kasir
    const res = await fetch('http://localhost:8000/api/admin')
    const data = await res.json()

    let admins = []
    if (Array.isArray(data)) {
      admins = data
    } else if (data && data.data && Array.isArray(data.data)) {
      admins = data.data
    } else {
      console.warn('Format respons API tidak dikenali:', data)
      kasirList.value = []
      return
    }

    // 🔥 Filter kasir & gunakan username sebagai nama
    kasirList.value = admins
      .filter(user => user.level === 'kasir')
      .map(user => ({
        id: user.id,
        nama: user.username // ← ini kunci!
      }))

  } catch (err) {
    console.error('Gagal memuat daftar kasir:', err)
    alert('Gagal memuat daftar kasir. Cek koneksi ke API.')
    kasirList.value = []
  }
}

// =====================================
// DATA CHART
// =====================================
const labels = ref([])
const values = ref([])
const totalSum = ref(0)
const loading = ref(false)

const formattedTotal = computed(() => {
  const n = Number(totalSum.value) || 0
  return n.toLocaleString('id-ID')
})

let chartInstance = null
const chartCanvas = ref(null)

// =====================================
// CEK LEVEL SUPER_ADMIN
// =====================================
onMounted(async () => {
  const userLevel = localStorage.getItem('user_level') || ''
  if (userLevel !== 'super_admin') {
    router.push('/')
    return
  }
  await loadKasirList()
  loadChart()
})

// =====================================
// LOAD DATA CHART DARI BACKEND
// =====================================
async function loadChart() {
  loading.value = true

  try {
    let url = `http://localhost:8000/api/laporan/grafik?bulan=${selectedMonth.value}&tahun=${selectedYear.value}`
    if (selectedKasir.value) {
      url += `&id_kasir=${selectedKasir.value}`
    }

    const res = await fetch(url)
    const data = await res.json()

    labels.value = data.map(d => d.tanggal)
    values.value = data.map(d => Number(d.total) || 0)
    totalSum.value = values.value.reduce((a, b) => a + b, 0)

    await nextTick()
    renderChart()

  } catch (err) {
    console.error('Gagal memuat grafik:', err)
    alert('Gagal memuat data grafik.')
  }

  loading.value = false
}

// =====================================
// RENDER GRAFIK
// =====================================
function renderChart() {
  if (!chartCanvas.value) return

  const ctx = chartCanvas.value.getContext('2d')

  if (chartInstance) {
    chartInstance.destroy()
  }

  chartInstance = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: labels.value,
      datasets: [{
        label: 'Total Penjualan (Rp)',
        data: values.value,
        backgroundColor: 'rgba(128, 0, 0, 0.6)',
        borderColor: 'rgba(128, 0, 0, 1)',
        borderWidth: 1,
        borderRadius: 4
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      animation: { duration: 700 },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            callback: (value) => 'Rp ' + value.toLocaleString('id-ID')
          }
        }
      },
      plugins: {
        legend: { display: false },
        tooltip: {
          callbacks: {
            label: (ctx) => 'Rp ' + Number(ctx.raw).toLocaleString('id-ID')
          }
        }
      }
    }
  })
}

// =====================================
// TOMBOL NEXT → HALAMAN TABEL
// =====================================
function goToTable() {
  const query = {
    bulan: selectedMonth.value,
    tahun: selectedYear.value
  }
  if (selectedKasir.value) {
    query.id_kasir = selectedKasir.value
  }
  router.push({ path: '/laporan/table', query })
}

// =====================================
// EXPORT EXCEL
// =====================================
function exportChartExcel() {
  let url = `http://localhost:8000/api/laporan/export?bulan=${selectedMonth.value}&tahun=${selectedYear.value}`
  if (selectedKasir.value) {
    url += `&id_kasir=${selectedKasir.value}`
  }
  window.open(url, '_blank')
}

// =====================================
// RESET FILTER
// =====================================
function resetFilter() {
  selectedMonth.value = now.getMonth() + 1
  selectedYear.value = now.getFullYear()
  selectedKasir.value = ''
  loadChart()
}

// =====================================
// HELPER: GET NAMA KASIR
// =====================================
function getKasirName(id) {
  const kasir = kasirList.value.find(k => k.id == id)
  return kasir ? kasir.nama : ''
}
</script>

<style scoped>
canvas {
  min-height: 260px;
}

.bg-maroon {
  background-color: #800000;
}

.text-maroon {
  color: #800000;
}

.border-maroon {
  border-color: #800000;
}
</style>