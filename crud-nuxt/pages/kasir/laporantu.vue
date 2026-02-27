<template>
  <div class="kasir-app">
    <!-- Header -->
    <header class="app-header">
      <div class="header-left">
        <img src="/logo.jpg" alt="Logo SMK" class="logo-img" />
        <div class="header-text">
          <div class="school-name">SMK Negeri 71</div>
          <div class="role-name">Kasir</div>
        </div>
      </div>

      <div class="header-right" @click="toggleDropdown" ref="userDropdown">
        <router-link to="/kasir/keranjang" class="cart-icon">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
          </svg>
        </router-link>

        <div class="user-info">
          <span>{{ userName }}</span>
          <img
            :src="userAvatar"
            alt="Profile"
            class="avatar"
            @error="fallbackAvatar"
          />
          <div v-if="showDropdown" class="dropdown-menu">
            <button @click="goToProfile">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
              </svg>
              Profil
            </button>
            <button @click="logout">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
              </svg>
              Logout
            </button>
          </div>
        </div>
      </div>
    </header>

    <!-- Layout Utama -->
    <div class="app-layout">
      <!-- Sidebar -->
      <aside class="sidebar">
        <nav class="sidebar-nav">
          <router-link to="/kasir/kategori" class="menu-item">
            <div class="menu-icon">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
              </svg>
            </div>
            <span class="menu-text">Kategori</span>
          </router-link>
          
          <router-link to="/kasir/produk" class="menu-item">
            <div class="menu-icon">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
              </svg>
            </div>
            <span class="menu-text">Produk</span>
          </router-link>
          
          <router-link to="/kasir/transaksi" class="menu-item">
            <div class="menu-icon">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
              </svg>
            </div>
            <span class="menu-text">Transaksi</span>
          </router-link>
          
          <router-link to="/kasir/laporantu" class="menu-item">
            <div class="menu-icon">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
              </svg>
            </div>
            <span class="menu-text">Laporan</span>
          </router-link>

          <div class="menu-item logout-sidebar" @click="logout">
            <div class="menu-icon">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
              </svg>
            </div>
            <span class="menu-text">Logout</span>
          </div>
        </nav>
      </aside>

      <!-- Konten -->
      <main class="main-content">
        <div class="content-header">
          <h1 class="page-title">Laporan Transaksi</h1>
          <p class="page-subtitle">Riwayat transaksi untuk kasir: {{ userName }}</p>
        </div>

        <!-- Filter Tanggal -->
        <div class="filter-section mb-6">
          <label class="block text-sm font-medium mb-1">Tanggal Awal</label>
          <input
            v-model="startDate"
            type="date"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
          />
          <label class="block text-sm font-medium mt-4 mb-1">Tanggal Akhir</label>
          <input
            v-model="endDate"
            type="date"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
          />
          <div class="mt-4">
            <button @click="applyFilters" class="btn btn-primary">Terapkan Filter</button>
          </div>
        </div>

        <!-- Tombol Export CSV -->
        <div class="mb-6 flex justify-end">
          <button @click="exportToCSV" class="btn btn-export">
            Export CSV
          </button>
        </div>

        <!-- Tabel Laporan -->
        <div class="report-table-container">
          <table id="report-table" class="report-table">
            <thead>
              <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Total Harga</th>
                <th>Total Keuntungan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(trans, index) in filteredTransactions" :key="trans.id">
                <td>{{ index + 1 }}</td>
                <td>{{ formatDate(trans.tanggal_pembelian) }}</td>
                <td>{{ formatRupiah(trans.total_harga) }}</td>
                <td>{{ formatRupiah(trans.total_keuntungan) }}</td>
                <td>
                  <button @click="showDetail(trans)" class="btn btn-detail">Detail</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </main>
    </div>

    <!-- Modal Detail Struk -->
    <div v-if="showDetailModal" class="modal-overlay" @click.self="closeDetailModal">
      <div class="modal-content">
        <h3 class="text-center font-bold mb-3">Detail Transaksi</h3>
        <div class="struk-content">
          <div class="struk-header">
            <h4>Kasir SMK Negeri 71</h4>
            <p>Jl. Dr. KRT Radjiman Widyodiningrat, Jatinegara, Kec. Cakung, Kota Jakarta Timur</p>
            <p>Tanggal: {{ formatDate(selectedTransaction?.tanggal_pembelian) }}</p>
          </div>
          <div class="struk-items">
            <div v-for="(item, idx) in parseDetail(selectedTransaction?.detail)" :key="idx" class="struk-item">
              <div class="item-row">
                <span>{{ item.nama_produk }}</span>
                <span>{{ item.quantity }} × {{ formatRupiah(item.harga_jual) }} = {{ formatRupiah(item.total) }}</span>
              </div>
            </div>
          </div>
          <div class="struk-summary">
            <div class="summary-row">
              <span>Grand Total</span>
              <span>{{ formatRupiah(selectedTransaction?.total_harga) }}</span>
            </div>
            <div class="summary-row">
              <span>Total Keuntungan</span>
              <span>{{ formatRupiah(selectedTransaction?.total_keuntungan) }}</span>
            </div>
            <div class="summary-row">
              <span>Tunai</span>
              <span>{{ formatRupiah(selectedTransaction?.tunai || 0) }}</span>
            </div>
            <div class="summary-row">
              <span>Kembalian</span>
              <span>{{ formatRupiah(selectedTransaction?.kembalian || 0) }}</span>
            </div>
            <!-- INFO PRE ORDER -->
<div
  v-if="hasPreOrder(selectedTransaction)"
  class="mt-2 text-sm"
>
  <strong>Pre-order dikirim dalam:</strong>
  {{ getPreOrderDays(selectedTransaction) }} hari
</div>

          </div>
          <div class="struk-footer">
            <p>TERIMA KASIH ATAS KUNJUNGANNYA</p>
          </div>
        </div>
        <div class="flex justify-center mt-4">
          <button @click="closeDetailModal" class="btn-close">Tutup</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

// Data
const transactions = ref([])
const showDetailModal = ref(false)
const selectedTransaction = ref(null)

// Filter
const startDate = ref('')
const endDate = ref('')

// User Info
const userName = ref('Kasir')
const userAvatar = ref('/logo.jpg')
const userDropdown = ref(null)
const showDropdown = ref(false)

// Load Data
onMounted(() => {
  loadUserProfile()
  fetchTransactions()
  document.addEventListener('click', clickOutside)
})

onUnmounted(() => {
  document.removeEventListener('click', clickOutside)
})

function clickOutside(e) {
  if (showDropdown.value && userDropdown.value && !userDropdown.value.contains(e.target)) {
    showDropdown.value = false
  }
}

function toggleDropdown() {
  showDropdown.value = !showDropdown.value
}

function goToProfile() {
  showDropdown.value = false
  router.push('/kasir/profile')
}

function logout() {
  localStorage.clear()
  router.push('/')
}

function loadUserProfile() {
  const name = localStorage.getItem('user_name') || 'Kasir'
  const avatarPath = localStorage.getItem('user_foto')
  userName.value = name
  userAvatar.value = avatarPath
    ? `http://localhost:8000/storage/profile/${avatarPath}`
    : '/login.png'
}

function fallbackAvatar() {
  userAvatar.value = '/logo.jpg'
}

async function fetchTransactions() {
  try {
    const res = await fetch('http://localhost:8000/api/transaksi')
    const data = await res.json()
    // Simpan semua data
    transactions.value = data.data || []
  } catch (err) {
    console.error('Gagal memuat transaksi:', err)
    alert('Gagal memuat laporan.')
  }
}

function formatDate(dateString) {
  if (!dateString) return '-'
  const date = new Date(dateString)
  return date.toLocaleDateString('id-ID')
}

function formatRupiah(angka) {
  if (angka == null || angka === '') return 'Rp 0'
  return 'Rp ' + Number(angka).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.')
}

function parseDetail(detail) {
  if (!detail) return []

  // 🔥 JIKA SUDAH ARRAY (dari API Laravel)
  if (Array.isArray(detail)) return detail

  // 🔥 JIKA MASIH STRING
  try {
    return JSON.parse(detail)
  } catch (e) {
    return []
  }
}


function hasPreOrder(trans) {
  if (!trans?.detail) return false
  const items = parseDetail(trans.detail)
  return items.some(item => item.stok === -1 && item.estimasiPreOrder)
}

function getPreOrderDays(trans) {
  if (!trans?.detail) return '-'
  const items = parseDetail(trans.detail)
  const pre = items.find(item => item.stok === -1 && item.estimasiPreOrder)
  if (pre?.estimasiPreOrder) {
    // Ekstrak angka dari "3 hari", "5 hari", dll
    const match = pre.estimasiPreOrder.match(/(\d+)\s+hari/)
    return match ? match[1] : pre.estimasiPreOrder
  }
  return '-'
}




function showDetail(trans) {
  selectedTransaction.value = trans
  showDetailModal.value = true
}

function closeDetailModal() {
  showDetailModal.value = false
  selectedTransaction.value = null
}

// ✅ FILTER TRANSAKSI BERDASARKAN TANGGAL & KASIR
const filteredTransactions = computed(() => {
  let filtered = [...transactions.value]

  // Filter berdasarkan kasir (nama)
  // ⚠️ Jika kamu simpan `user_id` di localStorage, gunakan `fid_admin`
  // Contoh: jika user_id = 12 → filter fid_admin = 12
  const userId = localStorage.getItem('user_id')
  if (userId) {
    filtered = filtered.filter(t => t.fid_admin == userId)
  }

  // Filter berdasarkan tanggal
  if (startDate.value) {
    filtered = filtered.filter(t => new Date(t.tanggal_pembelian) >= new Date(startDate.value))
  }
  if (endDate.value) {
    filtered = filtered.filter(t => new Date(t.tanggal_pembelian) <= new Date(endDate.value))
  }

  return filtered
})

function applyFilters() {
  // Tidak perlu fetch ulang — sudah di-filter di frontend
}

// ✅ EXPORT KE CSV (Manual)
function exportToCSV() {
  const table = document.getElementById('report-table');
  if (!table) return;

  // Ambil header
  const headers = [];
  const headerRow = table.querySelector('thead tr');
  if (headerRow) {
    headerRow.querySelectorAll('th').forEach(th => {
      headers.push('"' + th.innerText.replace(/"/g, '""') + '"');
    });
  }

  // Ambil data
  const rows = [];
  table.querySelectorAll('tbody tr').forEach(tr => {
    const cols = [];
    tr.querySelectorAll('td').forEach(td => {
      cols.push('"' + td.innerText.replace(/"/g, '""') + '"');
    });
    rows.push(cols.join(','));
  });

  // Buat konten CSV
  const csvContent = [headers.join(','), ...rows].join('\n');

  // Buat file & download
  const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
  const url = URL.createObjectURL(blob);
  const a = document.createElement('a');
  a.href = url;
  a.setAttribute('download', `laporan-transaksi-${new Date().toISOString().slice(0, 10)}.csv`);
  document.body.appendChild(a);
  a.click();
  document.body.removeChild(a);
  URL.revokeObjectURL(url);
}
</script>

<style scoped>
.struk-footer p:last-child {
  font-weight: 600;
  color: #800000;
}

.kasir-app {
  min-height: 100vh;
  background: #f8fafc;
  display: flex;
  flex-direction: column;
}

/* Header Styles */
.app-header {
  position: sticky;
  top: 0;
  z-index: 100;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem 2rem;
  background: white;
  border-bottom: 1px solid #e2e8f0;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.header-left {
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.logo-img {
  width: 2.5rem;
  height: 2.5rem;
  border-radius: 0.5rem;
  object-fit: cover;
}

.school-name {
  font-weight: 600;
  font-size: 1.125rem;
  color: #1a202c;
  line-height: 1.2;
}

.role-name {
  font-size: 0.875rem;
  color: #800000;
  font-weight: 500;
}

.header-right {
  display: flex;
  align-items: center;
  gap: 1.5rem;
  position: relative;
}

.cart-icon {
  width: 2.5rem;
  height: 2.5rem;
  border-radius: 50%;
  background: #fef2f2;
  display: flex;
  align-items: center;
  justify-content: center;
  text-decoration: none;
  color: #800000;
  transition: all 0.3s ease;
}

.cart-icon:hover {
  background: #fee2e2;
  transform: scale(1.05);
}

.user-info {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  cursor: pointer;
  position: relative;
  padding: 0.5rem;
}

.user-info span {
  font-size: 0.875rem;
  font-weight: 500;
  color: #374151;
}

.avatar {
  width: 2rem;
  height: 2rem;
  border-radius: 50%;
  object-fit: cover;
  border: 2px solid #e5e7eb;
}

.dropdown-menu {
  position: absolute;
  top: 40px;
  right: 0;
  background: white;
  border: 1px solid #e5e7eb;
  border-radius: 0.5rem;
  box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
  min-width: 10rem;
  z-index: 1000;
  overflow: hidden;
}

.dropdown-menu button {
  display: block;
  width: 100%;
  padding: 0.75rem 1rem;
  background: none;
  border: none;
  text-align: left;
  cursor: pointer;
  font-size: 0.875rem;
  color: #374151;
}

.dropdown-menu button:hover {
  background: #fef2f2;
  color: #800000;
}

/* Layout */
.app-layout {
  display: flex;
  flex: 1;
  height: calc(100vh - 80px);
  overflow: hidden;
}

.sidebar {
  position: fixed;
  top: 80px;
  left: 0;
  width: 16rem;
  height: calc(100vh - 80px);
  background: white;
  border-right: 1px solid #e2e8f0;
  padding: 1.5rem 0;
  overflow-y: auto;
  z-index: 99;
}

.sidebar-nav {
  display: flex;
  flex-direction: column;
  gap: 0.25rem;
  padding: 0 1rem;
  flex: 1;
}

.menu-item {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  padding: 0.75rem 1rem;
  color: #64748b;
  text-decoration: none;
  border-radius: 0.5rem;
  transition: all 0.3s ease;
  font-weight: 500;
}

.menu-item:hover,
.menu-item.router-link-active {
  background: #fef2f2;
  color: #800000;
  transform: translateX(4px);
}

.menu-icon {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 1.5rem;
  height: 1.5rem;
}

.menu-text {
  font-size: 0.875rem;
}

.logout-sidebar {
  margin-top: auto;
  background: #fef2f2;
  color: #dc2626;
  border: 1px solid #fecaca;
  cursor: pointer;
}

.logout-sidebar:hover {
  background: #dc2626;
  color: white;
  transform: translateX(4px);
}

.main-content {
  flex: 1;
  padding: 2rem;
  background: #f8fafc;
  overflow-y: auto;
  margin-left: 16rem;
}

.content-header {
  margin-bottom: 2rem;
}

.page-title {
  font-size: 1.5rem;
  font-weight: 700;
  color: #1a202c;
  margin: 0 0 0.5rem 0;
}

.page-subtitle {
  font-size: 0.875rem;
  color: #64748b;
  margin: 0;
}

/* Filter Section */
.filter-section {
  background: white;
  border-radius: 12px;
  padding: 1.5rem;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.filter-section label {
  font-size: 0.875rem;
  font-weight: 500;
  color: #374151;
  margin-bottom: 0.5rem;
}

.filter-section input {
  width: 100%;
  padding: 0.5rem;
  border: 1px solid #d1d5db;
  border-radius: 0.5rem;
  font-size: 0.875rem;
  transition: border-color 0.2s;
}

.filter-section input:focus {
  outline: none;
  border-color: #800000;
  box-shadow: 0 0 0 3px rgba(128, 0, 0, 0.1);
}

.btn-primary {
  padding: 0.5rem 1rem;
  background: #800000;
  color: white;
  border: none;
  border-radius: 0.5rem;
  font-size: 0.875rem;
  font-weight: 500;
  cursor: pointer;
  transition: background 0.2s;
}

.btn-primary:hover {
  background: #990000;
}

/* Report Table */
.report-table-container {
  background: white;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
}

.report-table {
  width: 100%;
  border-collapse: collapse;
}

.report-table th,
.report-table td {
  padding: 14px 16px;
  text-align: left;
  font-size: 14px;
}

.report-table th {
  background: #f8fafc;
  font-weight: 600;
  color: #374151;
  border-bottom: 1px solid #e2e8f0;
}

.report-table td {
  border-bottom: 1px solid #f1f5f9;
  color: #4b5563;
}

.report-table tr:last-child td {
  border-bottom: none;
}

/* Buttons */
.btn-export {
  background: #10b981;
  color: white;
  padding: 0.5rem 1rem;
  border: none;
  border-radius: 0.375rem;
  font-size: 0.875rem;
  font-weight: 500;
  cursor: pointer;
  transition: background 0.2s;
}

.btn-export:hover {
  background: #0da271;
}

.btn-detail {
  background: #3b82f6;
  color: white;
  padding: 0.375rem 0.75rem;
  border: none;
  border-radius: 0.25rem;
  font-size: 0.75rem;
  cursor: pointer;
}

.btn-detail:hover {
  background: #2563eb;
}

.btn-close {
  background: #800000;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 8px;
  cursor: pointer;
  font-weight: 600;
  font-size: 15px;
  transition: background 0.2s;
}

.btn-close:hover {
  background: #990000;
}

/* Modal */
.modal-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.6);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 2000;
}

.modal-content {
  background: white;
  padding: 24px;
  border-radius: 12px;
  width: 90%;
  max-width: 400px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
}

.struk-content {
  font-family: 'Courier New', monospace;
  font-size: 14px;
  line-height: 1.6;
  text-align: center;
  padding: 20px;
  background: #f8fafc;
  border-radius: 10px;
  box-shadow: inset 0 0 5px rgba(0,0,0,0.05);
}

.struk-header h4 {
  font-size: 20px;
  font-weight: 700;
  margin: 0 0 12px;
  color: #1677ff;
}

.struk-header p {
  font-size: 13px;
  margin: 5px 0;
  color: #4b5563;
}

.struk-items {
  margin: 20px 0;
  text-align: left;
}

.item-row {
  display: flex;
  justify-content: space-between;
  margin-bottom: 10px;
  font-size: 14px;
}

.struk-summary .summary-row {
  display: flex;
  justify-content: space-between;
  padding: 5px 0;
  font-weight: 600;
}

/* Responsive */
@media (max-width: 768px) {
  .sidebar {
    width: 14rem;
    top: 72px;
    height: calc(100vh - 72px);
  }

  .main-content {
    margin-left: 14rem;
    padding: 1.5rem;
  }

  .report-table {
    font-size: 12px;
  }

  .report-table th,
  .report-table td {
    padding: 10px 8px;
  }

  .filter-section {
    padding: 1rem;
  }
}
</style>