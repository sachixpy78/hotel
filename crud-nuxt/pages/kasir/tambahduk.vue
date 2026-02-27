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
        <router-link to="/kasir/transaksi/keranjang" class="cart-icon">
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
            <button @click="goToProfile">Profil</button>
            <button @click="logout">Logout</button>
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
          <!-- Tombol Logout di Sidebar -->
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

      <!-- Konten: Form di tengah -->
      <main class="main-content">
        <div class="form-wrapper">
          <h1 class="form-title">Tambah Produk</h1>
          <p class="form-subtitle">Isi data produk baru</p>

          <!-- Form Card -->
          <div class="form-card">
            <!-- Preview Gambar -->
            <div class="flex justify-center mb-4">
              <div class="relative">
                <img
                  :src="imagePreview || 'https://via.placeholder.com/120  '"
                  alt="Preview"
                  class="w-20 h-20 object-cover rounded-lg border"
                  @error="handleImageError"
                />
                <button
                  v-if="imagePreview"
                  @click="removePhoto"
                  class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-4 h-4 flex items-center justify-center text-xs"
                >
                  &times;
                </button>
              </div>
            </div>

            <!-- Input File Upload -->
            <div class="mb-4">
              <label class="block text-sm font-medium mb-1">Pilih Gambar (opsional)</label>
              <input
                type="file"
                accept="image/*"
                @change="handleFileUpload"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"
              />
            </div>

            <!-- Form Fields -->
            <div class="space-y-3">
              <!-- Nama Produk -->
              <div>
                <label class="block text-sm font-medium mb-1">Nama Produk</label>
                <input
                  v-model="newProduct.nama_produk"
                  type="text"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"
                  placeholder="Nama produk"
                />
              </div>

              <!-- Kategori -->
              <div>
                <label class="block text-sm font-medium mb-1">Kategori</label>
                <select
                  v-model="newProduct.fid_kategori"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"
                >
                  <option value="">Pilih Kategori</option>
                  <option v-for="kat in categories" :key="kat.id" :value="kat.id">{{ kat.kategori }}</option>
                </select>
              </div>

              <!-- Ketersediaan -->
              <div>
                <label class="block text-sm font-medium mb-1">Ketersediaan</label>
                <select
                  v-model="newProduct.ketersediaan"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"
                >
                  <option value="tersedia">Tersedia</option>
                  <option value="tidaktersedia">Tidak Tersedia</option>
                </select>
              </div>

              <!-- Modal -->
              <div>
                <label class="block text-sm font-medium mb-1">Modal</label>
                <input
                  v-model.number="newProduct.modal"
                  type="number"
                  min="0"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"
                  placeholder="Harga modal"
                />
              </div>

              <!-- Stok -->
              <div>
                <label class="block text-sm font-medium mb-1">Stok</label>
                <input
                  v-model.number="newProduct.stok"
                  type="number"
                  min="0"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"
                  placeholder="Jumlah stok"
                />
                <div v-if="newProduct.ketersediaan === 'tidaktersedia'" class="text-orange-500 mt-1 text-sm">
                  Pre-order: stok bersifat estimasi
                </div>
              </div>

              <!-- Harga Jual -->
              <div>
                <label class="block text-sm font-medium mb-1">Harga Jual</label>
                <input
                  v-model.number="newProduct.harga_jual"
                  type="number"
                  min="0"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"
                  placeholder="Harga jual"
                />
              </div>

              <!-- Estimasi -->
              <div>
                <label class="block text-sm font-medium mb-1">Estimasi</label>
                <select
                  v-model="newProduct.estimasi"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"
                >
                  <option value="langsung_ambil">Ambil di Tempat</option>
                  <option value="7_hari_kerja">7 hari kerja</option>
                </select>
              </div>

              <!-- Deskripsi -->
              <div>
                <label class="block text-sm font-medium mb-1">Deskripsi</label>
                <textarea
                  v-model="newProduct.deskripsi"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"
                  rows="2"
                  placeholder="Deskripsi produk"
                ></textarea>
              </div>

              <!-- Keuntungan -->
              <div>
                <label class="block text-sm font-medium mb-1">Keuntungan</label>
                <input
                  :value="keuntungan"
                  type="text"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-sm"
                  readonly
                />
              </div>

              <!-- Barcode -->
              <div>
                <label class="block text-sm font-medium mb-1">Barcode</label>
                <div class="border border-gray-300 rounded-lg p-3 bg-white text-center">
                  <canvas
                    ref="barcodeCanvas"
                    class="w-full h-12 mx-auto"
                    v-if="newProduct.barcode"
                  ></canvas>
                  <div v-else class="text-gray-500 text-xs">Akan dibuat otomatis</div>
                </div>
              </div>
            </div>

            <!-- Tombol -->
            <div class="flex justify-end space-x-2 pt-4">
              <router-link to="/kasir/produk" class="px-3 py-2 text-gray-600 hover:bg-gray-100 rounded text-sm">
                Batal
              </router-link>
              <button @click="submitProduct" class="px-3 py-2 bg-blue-600 text-white rounded text-sm hover:bg-blue-700">
                Simpan
              </button>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed, watch } from 'vue'
import { useRouter } from 'vue-router'
import JsBarcode from 'jsbarcode'

const router = useRouter()

// Data
const categories = ref([])
const imagePreview = ref(null)
const selectedFile = ref(null)
const productsList = ref([])

// === FORM TAMBAH PRODUK ===
const newProduct = ref({
  nama_produk: '',
  fid_kategori: '',
  stok: 0,
  harga_jual: 0,
  modal: 0,
  ketersediaan: 'tersedia',
  estimasi: 'langsung_ambil',
  deskripsi: '',
  barcode: null
})

// === REF UNTUK CANVAS BARCODE ===
const barcodeCanvas = ref(null)

// User Info
const userName = ref('Kasir')
const userAvatar = ref('/logo.jpg')

// Dropdown
const userDropdown = ref(null)
const showDropdown = ref(false)

// Load Data
onMounted(() => {
  loadUserProfile()
  getCategories()
  getProducts()
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
  showDropdown.value = false
  localStorage.removeItem('auth_token')
  localStorage.removeItem('user_id')
  localStorage.removeItem('user_level')
  localStorage.removeItem('user_name')
  localStorage.removeItem('user_foto')
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

async function getCategories() {
  try {
    const res = await fetch('http://localhost:8000/api/kategori')
    const data = await res.json()
    categories.value = data.data || []
  } catch (err) {
    console.error('Gagal memuat kategori:', err)
    alert('Gagal memuat kategori.')
  }
}
async function getProducts() {
  try {
    const res = await fetch('http://localhost:8000/api/produk');
    const data = await res.json();
    productsList.value = data.data || [];
  } catch (err) {
    console.error('Gagal memuat produk:', err);
  }
}

// Computed Keuntungan
const keuntungan = computed(() => {
  const modal = Number(newProduct.value.modal) || 0
  const hargaJual = Number(newProduct.value.harga_jual) || 0
  return Math.max(0, hargaJual - modal)
})

// ✅ WATCHER KETERSEDIAAN
// ✅ WATCHER KETERSEDIAAN
watch(() => newProduct.value.ketersediaan, (newValue) => {
  if (newValue === 'tidaktersedia') {
    newProduct.value.estimasi = '7_hari_kerja'
  }
})

// === RENDER BARCODE ===
function renderBarcode(canvasRef, barcodeText) {
  if (!canvasRef.value || !barcodeText) return
  try {
    JsBarcode(canvasRef.value, barcodeText, {
      format: "CODE39",
      lineColor: "#000",
      width: 2,
      height: 30,
      displayValue: true,
      fontSize: 10,
      textMargin: 3,
      margin: 5,
      background: "#fff"
    })
  } catch (err) {
    const ctx = canvasRef.value.getContext('2d')
    ctx.fillStyle = '#000'
    ctx.font = '10px Arial'
    ctx.fillText('Barcode', 10, 15)
  }
}

// File Upload
function handleFileUpload(event) {
  const file = event.target.files[0]
  if (file) {
    selectedFile.value = file
    const reader = new FileReader()
    reader.onload = (e) => { imagePreview.value = e.target.result }
    reader.readAsDataURL(file)
  }
}

function removePhoto() {
  selectedFile.value = null
  imagePreview.value = null
}

// Submit
async function submitProduct() {
  const isDuplicate = productsList.value.some(prod =>
    prod.nama_produk.toLowerCase() === newProduct.value.nama_produk.toLowerCase()
  )
  if (isDuplicate) {
    alert('Nama produk sudah ada!')
    return
  }

  const formData = new FormData()
  formData.append('nama_produk', newProduct.value.nama_produk)
  formData.append('fid_kategori', newProduct.value.fid_kategori)
  formData.append('stok', newProduct.value.stok)
  formData.append('harga_jual', newProduct.value.harga_jual)
  formData.append('modal', newProduct.value.modal)
  formData.append('ketersediaan', newProduct.value.ketersediaan)
  formData.append('estimasi', newProduct.value.estimasi)
  formData.append('deskripsi', newProduct.value.deskripsi)
  if (selectedFile.value) formData.append('gambar', selectedFile.value)

  try {
    const res = await fetch('http://localhost:8000/api/produk', { method: 'POST', body: formData })
    if (res.ok) {
      alert('Produk berhasil ditambahkan!')
      router.push('/kasir/produk')
    } else {
      const err = await res.json().catch(() => ({}))
      alert(err.message || 'Gagal menambah produk.')
    }
  } catch (err) {
    alert('Error: pastikan Laravel jalan di port 8000')
  }
}

function handleImageError(e) {
  e.target.src = 'https://via.placeholder.com/120  '
}
</script>

<style scoped>
.kasir-app {
  min-height: 100vh;
  background: #f8fafc;
  display: flex;
  flex-direction: column;
}

/* Header */
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
  box-shadow: 0 1px 3px rgba(0,0,0,0.1);
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
}

.school-name {
  font-weight: 600;
  font-size: 1.125rem;
  color: #1a202c;
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
}

.cart-icon {
  width: 2.5rem;
  height: 2.5rem;
  border-radius: 50%;
  background: #fef2f2;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #800000;
}

.user-info {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  cursor: pointer;
}

.avatar {
  width: 2rem;
  height: 2rem;
  border-radius: 50%;
  border: 2px solid #e5e7eb;
}

.dropdown-menu {
  position: absolute;
  top: 40px;
  right: 0;
  background: white;
  border: 1px solid #e5e7eb;
  border-radius: 0.5rem;
  box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
  min-width: 10rem;
  z-index: 1000;
}

.dropdown-menu button {
  display: block;
  width: 100%;
  padding: 0.75rem 1rem;
  text-align: left;
  font-size: 0.875rem;
  color: #374151;
  background: none;
  border: none;
  cursor: pointer;
}

.dropdown-menu button:hover {
  background: #fef2f2;
  color: #800000;
}

/* Sidebar */
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
  gap: 0.5rem;
  padding: 0 1rem;
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
}

.menu-icon {
  width: 1.5rem;
  height: 1.5rem;
  display: flex;
  align-items: center;
  justify-content: center;
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
}

/* Main Content - Form di tengah */
.main-content {
  flex: 1;
  display: flex;
  justify-content: center;
  align-items: flex-start;
  padding: 2rem 1rem;
  background: #f8fafc;
}

.form-wrapper {
  width: 100%;
  max-width: 400px;
}

.form-title {
  font-size: 1.25rem;
  font-weight: 700;
  color: #1a202c;
  margin: 0 0 0.5rem 0;
}

.form-subtitle {
  font-size: 0.875rem;
  color: #64748b;
  margin: 0 0 1.5rem 0;
}

.form-card {
  background: white;
  border-radius: 0.75rem;
  box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);
  padding: 1.5rem;
  border: 1px solid #e5e7eb;
  max-height: 85vh;
  overflow-y: auto;
}

/* Input styling kecil */
.form-card input,
.form-card select,
.form-card textarea {
  font-size: 0.875rem;
}

.form-card .btn {
  font-size: 0.875rem;
  padding: 0.5rem 0.75rem;
}

/* Barcode kecil */
.form-card canvas {
  height: 30px !important;
}
</style>