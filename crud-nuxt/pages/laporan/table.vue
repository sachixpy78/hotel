<template>
  <div class="min-h-screen bg-gray-50 p-6">
    <!-- Header -->
    <div class="mb-6 text-center">
      <h1 class="text-2xl font-bold text-gray-900">Laporan Penjualan</h1>
      <p class="text-sm text-gray-500">Detail transaksi berdasarkan tanggal dan kasir</p>
    </div>

    <!-- Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-300 p-6 max-w-7xl mx-auto">
      
      <!-- Controls -->
      <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-5 gap-4">
        
        <!-- Dropdowns -->
        <div class="flex flex-wrap items-center gap-3">
          <select v-model="selectedMonth" class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all duration-300">
            <option v-for="(m, idx) in months" :key="idx" :value="idx + 1">{{ m }}</option>
          </select>

          <select v-model="selectedYear" class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all duration-300">
            <option v-for="y in years" :key="y" :value="y">{{ y }}</option>
          </select>

          <select v-model="selectedKasir" class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all duration-300 min-w-[140px]">
            <option value="">Semua Kasir</option>
            <option v-for="kasir in kasirList" :key="kasir.id" :value="kasir.id">
              {{ kasir.nama }}
            </option>
          </select>

          <button @click="loadTable" class="px-4 py-2 bg-maroon text-white rounded-md hover:bg-red-800 hover:scale-105 transition-all duration-300">
            Terapkan
          </button>

          <button @click="resetFilter" class="px-3 py-2 bg-yellow-100 text-yellow-700 rounded-md hover:bg-yellow-200 hover:scale-105 transition-all duration-300">
            Reset
          </button>
        </div>

        <!-- Buttons -->
        <div class="flex items-center gap-3">
          <button @click="exportExcel" class="px-3 py-2 border border-gray-300 rounded-md text-sm hover:bg-gray-50 hover:scale-105 transition-all duration-300">
            Export Excel
          </button>

          <button @click="goBack" class="px-3 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 hover:scale-105 transition-all duration-300">
            ← Back
          </button>
        </div>
      </div>

      <!-- TABLE -->
      <div class="overflow-x-auto border border-gray-300 rounded-lg">
        
        <!-- Loading -->
        <div v-if="loading" class="text-center py-6 text-gray-500">
          Memuat data...
        </div>

        <!-- Empty state -->
        <div v-else-if="tableData.length === 0" class="text-center py-6 text-gray-500">
          <p>Tidak ada transaksi di bulan ini.</p>
          <p v-if="selectedKasir">Untuk kasir: {{ getKasirName(selectedKasir) }}</p>
        </div>

        <!-- Real Table -->
        <table v-else class="min-w-full border-collapse">
          <thead class="bg-gray-50">
            <tr>
              <th class="border-b px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Tanggal</th>
              <th class="border-b px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Kasir</th>
              <th class="border-b px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Nama Produk</th>
              <th class="border-b px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Deskripsi</th>
              <th class="border-b px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Total Harga</th>
              <th class="border-b px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Keuntungan</th>
            </tr>
          </thead>
          <tbody>
            <tr 
              v-for="(item, index) in paginatedData" 
              :key="index"
              class="hover:bg-red-50 transition-colors duration-200 border-b"
            >
              <td class="px-4 py-3 text-sm">{{ formatDate(item.tanggal_pembelian) }}</td>
              <td class="px-4 py-3 text-sm">{{ item.kasir_nama || '-' }}</td>
              <td class="px-4 py-3 text-sm">{{ item.nama_produk }}</td>
              <td class="px-4 py-3 text-sm">{{ item.deskripsi || '-' }}</td>
              <td class="px-4 py-3 text-sm">Rp {{ formatNumber(item.total_harga) }}</td>
              <td class="px-4 py-3 text-sm">Rp {{ formatNumber(item.total_keuntungan) }}</td>
            </tr>
          </tbody>
        </table>

        <!-- Pagination -->
        <div v-if="tableData.length > 0" class="flex justify-between items-center p-4 bg-white border-t">
          <div class="text-sm text-gray-600">
            Menampilkan {{ startIndex + 1 }} - {{ endIndex }} dari {{ tableData.length }} entri
          </div>
          <div class="flex space-x-2">
            <button 
              @click="prevPage" 
              :disabled="currentPage === 1"
              class="px-3 py-1 border border-gray-300 rounded-md text-sm disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-100 transition"
            >
              Sebelumnya
            </button>
            <button 
              @click="nextPage" 
              :disabled="currentPage === totalPages"
              class="px-3 py-1 border border-gray-300 rounded-md text-sm disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-100 transition"
            >
              Berikutnya
            </button>
          </div>
        </div>

      </div>

      <!-- Summary -->
      <div class="mt-5 text-right">
        <p class="text-sm text-gray-600">Total Pendapatan:</p>
        <p class="text-2xl font-bold text-gray-800">Rp {{ formattedTotal }}</p>
      </div>

    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed, nextTick } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

// =========================
// BULAN & TAHUN
// ==========================
const months = [
  'Januari','Februari','Maret','April','Mei','Juni',
  'Juli','Agustus','September','Oktober','November','Desember'
]

const now = new Date()
const selectedMonth = ref(now.getMonth() + 1)
const selectedYear = ref(now.getFullYear())
const selectedKasir = ref('') // default: semua kasir

const years = []
for (let y = now.getFullYear(); y >= now.getFullYear() - 5; y--) years.push(y)

// =========================
// DAFTAR KASIR
// =========================
const kasirList = ref([])

async function loadKasirList() {
  try {
    const res = await fetch('http://localhost:8000/api/admin')
    const data = await res.json()

    let admins = []
    if (Array.isArray(data)) {
      admins = data
    } else if (data && data.data && Array.isArray(data.data)) {
      admins = data.data
    }

    kasirList.value = admins
      .filter(user => user.level === 'kasir')
      .map(user => ({
        id: user.id,
        nama: user.username
      }))
  } catch (err) {
    console.error('Gagal muat daftar kasir:', err)
    alert('Gagal memuat daftar kasir.')
  }
}

// =========================
// DATA TABEL
// =========================
const tableData = ref([])
const loading = ref(false)
const totalSum = ref(0)
const currentPage = ref(1)
const itemsPerPage = 10

const startIndex = computed(() => (currentPage.value - 1) * itemsPerPage)
const endIndex = computed(() => Math.min(startIndex.value + itemsPerPage, tableData.value.length))
const paginatedData = computed(() => tableData.value.slice(startIndex.value, endIndex.value))
const totalPages = computed(() => Math.ceil(tableData.value.length / itemsPerPage))

function prevPage() {
  if (currentPage.value > 1) currentPage.value--
}
function nextPage() {
  if (currentPage.value < totalPages.value) currentPage.value++
}

const formattedTotal = computed(() => {
  const n = Number(totalSum.value) || 0
  return n.toLocaleString('id-ID')
})

// =========================
// CEK LEVEL
// =========================
onMounted(async () => {
  const userLevel = localStorage.getItem('user_level') || ''
  if (userLevel !== 'super_admin') {
    alert('Akses ditolak.')
    router.push('/')
    return
  }
  await loadKasirList()
  loadTable()
})

// =========================
// LOAD DATA TABEL
// =========================
async function loadTable() {
  loading.value = true

  try {
    let url = `http://localhost:8000/api/laporan/tabel?bulan=${selectedMonth.value}&tahun=${selectedYear.value}`
    if (selectedKasir.value) {
      url += `&id_kasir=${selectedKasir.value}`
    }

    const res = await fetch(url)
    const data = await res.json()

    // Proses data: ambil deskripsi dari produk
    const processedData = data.map(item => {
      let deskripsi = '-'
      let kasir_nama = '-'

      try {
        // Ambil deskripsi dari produk (jika tersedia)
        if (item.produk_deskripsi) {
          deskripsi = item.produk_deskripsi
        }
        // Ambil nama kasir jika tersedia
        if (item.kasir_nama) {
          kasir_nama = item.kasir_nama
        }
      } catch (e) {
        console.warn('Gagal parse detail:', e)
      }

      return {
        ...item,
        deskripsi: deskripsi,
        kasir_nama: kasir_nama
      }
    })

    tableData.value = processedData
    currentPage.value = 1 // reset ke halaman 1 saat filter berubah

    // Hitung total harga
    totalSum.value = data.reduce((sum, item) => {
      const cleaned = String(item.total_harga).replace(/[^0-9]/g, '')
      return sum + Number(cleaned)
    }, 0)

  } catch (err) {
    console.error('Error:', err)
    alert('Gagal memuat data tabel.')
  }

  loading.value = false
}

// =========================
// FORMAT ANGKA & TANGGAL
// =========================
function formatNumber(num) {
  const n = Number(String(num).replace(/[^0-9]/g, ''))
  return n.toLocaleString('id-ID')
}

function formatDate(dateString) {
  const date = new Date(dateString)
  return date.toLocaleDateString('id-ID')
}

// =========================
// EXPORT EXCEL
// =========================
function exportExcel() {
  let url = `http://localhost:8000/api/laporan/export-tabel?bulan=${selectedMonth.value}&tahun=${selectedYear.value}`
  if (selectedKasir.value) {
    url += `&id_kasir=${selectedKasir.value}`
  }
  window.open(url, '_blank')
}

// =========================
// BACK KE GRAFIK
// =========================
function goBack() {
  router.push('/laporan')
}

// =========================
// RESET FILTER
// =========================
function resetFilter() {
  selectedMonth.value = now.getMonth() + 1
  selectedYear.value = now.getFullYear()
  selectedKasir.value = ''
  loadTable()
}

// =========================
// HELPER: GET NAMA KASIR
// =========================
function getKasirName(id) {
  const kasir = kasirList.value.find(k => k.id == id)
  return kasir ? kasir.nama : ''
}
</script>

<style scoped>
.bg-maroon {
  background-color: #800000;
}

.text-maroon {
  color: #800000;
}

.border-maroon {
  border-color: #800000;
}

/* Styling tabel lebih rapi */
table th {
  font-weight: 600;
  background-color: #f3f4f6;
  font-size: 0.75rem;
  padding-top: 0.75rem;
  padding-bottom: 0.75rem;
  text-align: left;
}

table td {
  padding: 0.75rem;
  font-size: 0.875rem;
  text-align: left;
}

table tbody tr:hover {
  background-color: #fef2f2;
}

/* Pagination styling */
button:disabled {
  cursor: not-allowed;
  opacity: 0.5;
}

/* Header style */
h1 {
  font-weight: 700;
  letter-spacing: -0.5px;
}

p.text-sm.text-gray-500 {
  margin-top: 0.25rem;
  font-size: 0.875rem;
}
</style>