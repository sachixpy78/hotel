<template>
  <div class="kasir-app">
    <!-- Header -->
    <header class="app-header">
      <div class="header-left">
        <img src="/logo.jpg" alt="Logo SMK" class="logo-img" />
        <div class="header-text">
          <div class="line1">Kasir SMK</div>
          <div class="line2">Negeri 71</div>
        </div>
      </div>

      <div class="header-right" @click="toggleDropdown" ref="userDropdown">
        <router-link to="/kasir/keranjang" class="cart-icon">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#1677ff" stroke-width="2">
            <circle cx="9" cy="21" r="1"></circle>
            <circle cx="20" cy="21" r="1"></circle>
            <path d="M1 1h4l2.68 12.39A2 2 0 0 0 9.62 15h9.76a2 2 0 0 0 1.94-1.61L23 6H6"></path>
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
      <!-- Sidebar - Disesuaikan dengan kategori.vue -->
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

      <!-- Konten Utama -->
      <main class="main-content">
        <div class="flex justify-between items-center mb-6">
          <h2>Keranjang</h2>
          <div class="flex gap-2">
            <button @click="clearCart" class="btn btn-secondary">Bersihkan Keranjang</button>
            <button @click="goToTransaksi" class="btn btn-primary">Lihat Invoice</button>
          </div>
        </div>

        <!-- Checkbox Pilih Semua -->
        <div class="select-all-row mb-4">
          <label class="select-all-checkbox">
            <input type="checkbox" v-model="selectAll" />
            <span>Pilih Semua Barang</span>
          </label>
        </div>

        <!-- Daftar Produk di Keranjang -->
        <div class="cart-items">
          <div v-for="(item, index) in cartItems" :key="item.id || index" class="cart-item">
            <div class="item-checkbox">
              <input
                type="checkbox"
                :id="'item-' + index"
                v-model="selectedItems"
                :value="item"
              />
            </div>
            <div class="item-image">
              <img :src="item.gambar ? `http://localhost:8000/storage/${item.gambar}` : '/placeholder.jpg'" alt="Gambar Produk" />
            </div>
            <div class="item-details">
              <h3 class="item-name">{{ item.nama_produk }}</h3>
              <p class="item-price"> {{ formatRupiah(item.harga_jual) }}</p>
              <p class="item-stock">
                <span v-if="item.ketersediaan === 'tersedia'">Stok: {{ item.stok }}</span>
              </p>
              
              <!-- Input Estimasi untuk Pre-Order (menggantikan tulisan Pre-order) -->
              <div v-if="item.ketersediaan === 'tidaktersedia'" class="preorder-estimasi">
                <div class="delivery-input-wrapper">
                  <div 
                    v-if="!item.showDeliveryInput" 
                    class="delivery-placeholder"
                    @click="toggleDeliveryInput(index)"
                  >
                    <span class="placeholder-text">hh/bb/tttt</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" class="calendar-icon">
                      <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                    </svg>
                  </div>
                  
                  <div v-else class="delivery-input-container">
                    <input
                      :ref="el => setDateInputRef(el, index)"
                      type="date"
                      v-model="item.estimasiTanggal"
                      :min="minDate"
                      :max="maxDate"
                      class="date-input"
                      @blur="handleDateBlur(index)"
                    />
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" class="calendar-icon">
                      <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                    </svg>
                  </div>
                </div>
                <span v-if="item.estimasiTanggal" class="ml-2 text-sm text-gray-600">
                  (≈ {{ getDaysFromToday(item.estimasiTanggal) }} hari)
                </span>
              </div>
            </div>
            <div class="item-quantity">
              <button @click="decreaseQuantity(index)" class="qty-btn">-</button>
              <span class="qty-value">{{ item.quantity }}</span>
              <button @click="increaseQuantity(index)" class="qty-btn">+</button>
            </div>
            <div class="item-total">
               {{ formatRupiah(item.total) }}
            </div>
            <button @click="removeItem(index)" class="item-remove">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" class="delete-icon">
                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V11a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
              </svg>
            </button>
          </div>
        </div>

        <!-- Ringkasan Total + Tombol Konfirmasi -->
        <div class="cart-summary">
          <div class="summary-row">
            <span>Total Item:</span>
            <span>{{ totalSelectedItems }}</span>
          </div>
          <div class="summary-row">
            <span>Total Harga:</span>
            <span>{{ formatRupiah(totalPriceSelected) }}</span>
          </div>

          <div class="flex justify-end mt-4">
            <button
              @click="confirmCheckout"
              :disabled="selectedItems.length === 0"
              class="btn btn-confirm"
              :class="{ 'opacity-50 cursor-not-allowed': selectedItems.length === 0 }"
            >
              Konfirmasi
            </button>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted, watch, nextTick } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

// Data Keranjang
const cartItems = ref([])
const selectedItems = ref([]) // produk yang dipilih
const selectAll = ref(false)

// === BARCODE SCANNER ===
let barcodeBuffer = ''
let barcodeTimer = null

// ✅ TAMBAHKAN INI: state untuk menyimpan data produk
const products = ref([])

// User Info
const userName = ref('Kasir')
const userAvatar = ref('/logo.jpg')

// Ref untuk dropdown
const userDropdown = ref(null)
const showDropdown = ref(false)

// Ref untuk date inputs (array untuk multiple inputs)
const dateInputRefs = ref({})

// Load Data
onMounted(() => {
  loadUserProfile()
  loadCartFromStorage()
  getProducts()
  document.addEventListener('click', clickOutside)
  document.addEventListener('keypress', handleBarcodeInput)
})

onUnmounted(() => {
  document.removeEventListener('click', clickOutside)
  document.removeEventListener('keypress', handleBarcodeInput)
})

// === PROFIL ===
function loadUserProfile() {
  const name = localStorage.getItem('user_name') || 'Kasir'
  const avatarPath = localStorage.getItem('user_foto')
  userName.value = name
  userAvatar.value = avatarPath
    ? `http://localhost:8000/storage/profile/${avatarPath}`
    : '/login.jpg'
}

function fallbackAvatar() {
  userAvatar.value = '/logo.jpg'
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

function clickOutside(e) {
  if (showDropdown.value && userDropdown.value && !userDropdown.value.contains(e.target)) {
    showDropdown.value = false
  }
}

// === KERANJANG ===
function loadCartFromStorage() {
  const savedCart = localStorage.getItem('cart')
  if (savedCart) {
    try {
      const cart = JSON.parse(savedCart)
      // Convert all numeric values to numbers dan tambahkan field ketersediaan
      cartItems.value = cart.map(item => ({
        ...item,
        harga_jual: Number(item.harga_jual),
        modal: Number(item.modal) || 0,
        total: Number(item.total),
        stok: Number(item.stok),
        quantity: Number(item.quantity) || 1,
        ketersediaan: item.ketersediaan || 'tersedia',
        estimasi: item.estimasi || 'langsung_ambil',
        estimasiTanggal: item.estimasiTanggal || '',
        showDeliveryInput: item.showDeliveryInput || false
      }))
    } catch (e) {
      cartItems.value = []
      localStorage.removeItem('cart')
    }
  }
}

function saveCartToStorage() {
  localStorage.setItem('cart', JSON.stringify(cartItems.value))
}

function removeItem(index) {
  cartItems.value.splice(index, 1)
  saveCartToStorage()
}

function increaseQuantity(index) {
  const item = cartItems.value[index]
  
  // Jika pre-order (ketersediaan = tidaktersedia), max 8
  if (item.ketersediaan === 'tidaktersedia') {
    if (item.quantity >= 8) {
      alert('Maksimal quantity untuk pre-order adalah 8!')
      return
    }
    item.quantity += 1
    item.total = item.quantity * Number(item.harga_jual)
    saveCartToStorage()
    return
  }
  
  // Untuk produk tersedia, cek stok
  if (item.quantity >= item.stok) {
    alert(`Stok ${item.nama_produk} hanya tersedia ${item.stok}!`)
    return
  }
  
  item.quantity += 1
  item.total = item.quantity * Number(item.harga_jual)
  saveCartToStorage()
}

function decreaseQuantity(index) {
  if (cartItems.value[index].quantity > 1) {
    cartItems.value[index].quantity -= 1
    cartItems.value[index].total = cartItems.value[index].quantity * Number(cartItems.value[index].harga_jual)
    saveCartToStorage()
  } else {
    removeItem(index)
  }
}

function clearCart() {
  cartItems.value = []
  selectedItems.value = []
  selectAll.value = false
  saveCartToStorage()
}

// Toggle delivery input untuk item tertentu
function toggleDeliveryInput(index) {
  cartItems.value[index].showDeliveryInput = true
  // Force focus setelah render
  setTimeout(() => {
    const input = dateInputRefs.value[index]
    if (input) {
      input.focus()
      input.showPicker() // ✅ Paksa buka date picker
    }
  }, 50)
}

function setDateInputRef(el, index) {
  if (el) {
    dateInputRefs.value[index] = el
    // Auto focus saat element sudah di-render
    setTimeout(() => {
      if (el && cartItems.value[index]?.showDeliveryInput) {
        el.focus()
        el.showPicker() // ✅ Paksa buka date picker
      }
    }, 50)
  }
}

// Handler untuk blur pada input date
function handleDateBlur(index) {
  if (!cartItems.value[index].estimasiTanggal) {
    cartItems.value[index].showDeliveryInput = false
  }
}

// Hitung hari dari today
function getDaysFromToday(dateStr) {
  if (!dateStr) return 0
  const today = new Date()
  today.setHours(0, 0, 0, 0)
  const delivery = new Date(dateStr)
  delivery.setHours(0, 0, 0, 0)
  const diffTime = delivery.getTime() - today.getTime()
  const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24))
  return diffDays > 0 ? diffDays : 0
}

// === LOGIKA PILIH SEMUA ===
watch(selectAll, (newVal) => {
  if (newVal) {
    selectedItems.value = [...cartItems.value]
  } else {
    selectedItems.value = []
  }
})

watch(selectedItems, (newVal) => {
  if (newVal.length === cartItems.value.length && cartItems.value.length > 0) {
    selectAll.value = true
  } else {
    selectAll.value = false
  }
})

// === COMPUTED ===
const totalSelectedItems = computed(() => {
  return selectedItems.value.reduce((sum, item) => sum + Number(item.quantity), 0)
})

const totalPriceSelected = computed(() => {
  return selectedItems.value.reduce((sum, item) => sum + Number(item.total), 0)
})

// Batas tanggal minimum = hari ini (format YYYY-MM-DD)
const minDate = computed(() => {
  const date = new Date()
  date.setHours(0, 0, 0, 0)
  return date.toISOString().split('T')[0]
})

// Batas tanggal maksimum = hari ini + 7 hari
const maxDate = computed(() => {
  const date = new Date()
  date.setHours(0, 0, 0, 0)
  date.setDate(date.getDate() + 7)
  return date.toISOString().split('T')[0]
})

// === NAVIGASI KE TRANSAKSI ===
function goToTransaksi() {
  if (cartItems.value.length === 0) {
    alert('Keranjang kosong!')
    return
  }
  saveCartToStorage()
  router.push('/kasir/transaksi')
}

// ✅ FUNGSI KONFIRMASI PEMBELIAN
async function confirmCheckout() {
  if (selectedItems.value.length === 0) {
    alert('Belum ada produk yang dipilih!')
    return
  }
  
  // Validasi tanggal untuk pre-order
  const preOrderItems = selectedItems.value.filter(item => item.ketersediaan === 'tidaktersedia')
  for (const item of preOrderItems) {
    if (!item.estimasiTanggal) {
      alert(`Pilih tanggal estimasi pengiriman untuk ${item.nama_produk}!`)
      // Find index and show input
      const index = cartItems.value.findIndex(i => i.id === item.id)
      if (index !== -1) {
        toggleDeliveryInput(index)
      }
      return
    }
    
    // Validasi: pastikan tanggal dalam rentang 0–7 hari
    const delivery = new Date(item.estimasiTanggal);
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    delivery.setHours(0, 0, 0, 0);
    const diffDays = Math.ceil((delivery - today) / (1000 * 60 * 60 * 24));

    if (diffDays < 0 || diffDays > 7) {
      alert(`Estimasi pengiriman untuk ${item.nama_produk} harus antara hari ini sampai 7 hari ke depan.`)
      return;
    }
  }

  // Cek stok lokal (hanya untuk produk tersedia)
  for (const item of selectedItems.value) {
    if (item.ketersediaan === 'tersedia' && item.quantity > item.stok) {
      alert(`Stok ${item.nama_produk} hanya tersedia ${item.stok}!`)
      return
    }
  }

  // Kurangi stok di server (hanya untuk produk tersedia)
  const success = await kurangiStokDiServer(selectedItems.value)
  if (!success) return

  // Simpan transaksi ke localStorage
  const transaction = {
    id: Date.now(),
    date: new Date().toLocaleString('id-ID'),
    cashier: userName.value,
    items: selectedItems.value.map(item => ({
      ...item,
      estimasiPreOrder: item.ketersediaan === 'tidaktersedia' ? `${getDaysFromToday(item.estimasiTanggal)} hari` : null
    })),
    grandTotal: Number(totalPriceSelected.value),
    cashPaid: Number(totalPriceSelected.value),
    change: 0,
    payment: 'Tunai',
    uang_dibayar: Number(totalPriceSelected.value),
    kembalian: 0,
    estimasiPreOrder: preOrderItems.length > 0 ? `${getDaysFromToday(preOrderItems[0].estimasiTanggal)} hari` : null
  }

  const history = JSON.parse(localStorage.getItem('transactions') || '[]')
  history.push(transaction)
  localStorage.setItem('transactions', JSON.stringify(history))

  // Kosongkan keranjang
  cartItems.value = []
  selectedItems.value = []
  selectAll.value = false
  localStorage.removeItem('cart')

  // Redirect ke transaksi
  router.push('/kasir/transaksi')
}

// ✅ FUNGSI SCAN BARCODE DI KERANJANG
function handleBarcodeInput(e) {
  if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA' || e.target.tagName === 'SELECT') return
  const key = e.key
  if (key === 'Enter' && barcodeBuffer) {
    const product = products.value.find(p => p.barcode === barcodeBuffer)
    if (product) {
      // Cek ketersediaan dan stok
      if (product.ketersediaan === 'tersedia' && product.stok <= 0) {
        alert('Produk ini sudah habis!')
      } else {
        let cart = JSON.parse(localStorage.getItem('cart') || '[]')
        const existing = cart.find(item => item.id === product.id)
        if (existing) {
          // Untuk pre-order, max 8
          if (product.ketersediaan === 'tidaktersedia') {
            if (existing.quantity < 8) {
              existing.quantity += 1
              existing.total = existing.quantity * Number(existing.harga_jual)
            } else {
              alert('Maksimal quantity untuk pre-order adalah 8!')
            }
          } else if (existing.quantity < product.stok) {
            existing.quantity += 1
            existing.total = existing.quantity * Number(existing.harga_jual)
          } else {
            alert('Stok maksimal tercapai!')
          }
        } else {
          cart.push({
            id: product.id,
            nama_produk: product.nama_produk,
            harga_jual: Number(product.harga_jual),
            modal: Number(product.modal) || 0,
            gambar: product.gambar,
            quantity: 1,
            total: Number(product.harga_jual),
            stok: Number(product.stok),
            ketersediaan: product.ketersediaan || 'tersedia',
            estimasi: product.estimasi || 'langsung_ambil',
            estimasiTanggal: '',
            showDeliveryInput: false
          })
        }
        localStorage.setItem('cart', JSON.stringify(cart))
        loadCartFromStorage()
      }
    } else {
      alert('Barcode tidak dikenali!')
    }
    barcodeBuffer = ''
    if (barcodeTimer) clearTimeout(barcodeTimer)
  } else if (key.length === 1) {
    barcodeBuffer += key
    if (barcodeTimer) clearTimeout(barcodeTimer)
    barcodeTimer = setTimeout(() => { barcodeBuffer = '' }, 100)
  }
}

// ✅ FUNGSI UNTUK MENGAMBIL DATA PRODUK
async function getProducts() {
  try {
    const res = await fetch('http://localhost:8000/api/produk')
    const data = await res.json()
    products.value = data.data || []
  } catch (err) {
    console.error('Gagal memuat produk:', err)
    alert('Gagal memuat produk. Pastikan server Laravel berjalan di port 8000.')
  }
}

// ✅ Fungsi untuk mengurangi stok di database (hanya produk tersedia)
async function kurangiStokDiServer(items) {
  // Hanya kurangi stok untuk produk dengan ketersediaan = tersedia
  const itemsYangDikurangi = items
    .filter(item => item.ketersediaan === 'tersedia')
    .map(item => ({
      id: item.id,
      quantity: Number(item.quantity)
    }))

  // Kalau semua item pre-order, skip hit server
  if (itemsYangDikurangi.length === 0) {
    return true
  }

  try {
    const response = await fetch('http://localhost:8000/api/produk/kurangi-stok', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify({ items: itemsYangDikurangi })
    })

    if (!response.ok) {
      const error = await response.json().catch(() => ({}))
      console.error('Gagal kurangi stok:', error)
      alert('Gagal memperbarui stok di server.')
      return false
    }

    return true
  } catch (err) {
    console.error('Error kirim ke server:', err)
    alert('Pastikan server Laravel berjalan di port 8000.')
    return false
  }
}

// ✅ Fungsi format rupiah
const formatRupiah = (angka) => {
  if (angka == null || angka === '') return 'Rp 0';
  const num = Number(angka);
  if (isNaN(num)) return 'Rp 0';
  return 'Rp ' + num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}
</script>

<style scoped>
.kasir-app {
  min-height: 100vh;
  background: #f5f7fa;
  display: flex;
  flex-direction: column;
}

.app-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 12px 24px;
  background: white;
  border-bottom: 1px solid #eee;
  position: sticky;
  top: 0;
  z-index: 100;
}

.header-left {
  display: flex;
  align-items: center;
  gap: 12px;
}

.logo-img {
  width: 40px;
  height: 40px;
  border-radius: 8px;
  object-fit: cover;
}

.header-text .line1 {
  font-weight: bold;
  font-size: 16px;
  color: #333;
  margin: 0;
}

.header-text .line2 {
  font-size: 16px;
  color: #333;
  margin: 0;
}

.header-right {
  display: flex;
  align-items: center;
  gap: 20px;
  position: relative;
}

.cart-icon {
  width: 36px;
  height: 36px;
  border-radius: 50%;
  background: #e6f7ff;
  display: flex;
  align-items: center;
  justify-content: center;
  text-decoration: none;
}

.user-info {
  display: flex;
  align-items: center;
  gap: 8px;
  cursor: pointer;
  position: relative;
}

.user-info span {
  font-size: 14px;
  font-weight: 500;
  color: #333;
}

.avatar {
  width: 32px;
  height: 32px;
  border-radius: 50%;
  object-fit: cover;
}

.dropdown-menu {
  position: absolute;
  top: 40px;
  right: 0;
  background: white;
  border: 1px solid #ddd;
  border-radius: 6px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
  min-width: 120px;
  z-index: 1000;
}

.dropdown-menu button {
  display: block;
  width: 100%;
  padding: 8px 12px;
  background: none;
  border: none;
  text-align: left;
  cursor: pointer;
  font-size: 14px;
  color: #333;
}

.dropdown-menu button:hover {
  background: #f0f8ff;
}

.app-layout {
  display: flex;
  flex: 1;
  height: calc(100vh - 60px);
}

/* Sidebar Styles - Disesuaikan dengan kategori.vue */
.sidebar {
  position: fixed;
  top: 60px;
  left: 0;
  width: 16rem;
  height: calc(100vh - 60px);
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

/* Tombol Logout di Sidebar */
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
  padding: 24px;
  background: white;
  overflow-y: auto;
  margin-left: 16rem;
}

.main-content h2 {
  margin-top: 0;
  font-size: 24px;
  color: #333;
}

.btn {
  padding: 6px 12px;
  font-size: 12px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  color: white;
  transition: background-color 0.2s;
}

.btn-primary {
  background: #1677ff;
  color: white;
  padding: 8px 16px;
  border-radius: 6px;
  font-weight: 500;
}

.btn-primary:hover {
  background: #096dd9;
}

.btn-secondary {
  background: #6c757d;
  color: white;
  padding: 8px 16px;
  border-radius: 6px;
  font-weight: 500;
}

.btn-secondary:hover {
  background: #5a6268;
}

/* Keranjang */
.cart-items {
  background: white;
  border: 1px solid #eee;
  border-radius: 8px;
  padding: 16px;
  margin-bottom: 20px;
}

.cart-item {
  display: flex;
  align-items: center;
  padding: 12px;
  border-bottom: 1px solid #eee;
  gap: 12px;
  transition: background 0.2s;
}

.cart-item:hover {
  background: #f9f9f9;
}

.item-checkbox {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 30px;
}

.item-image img {
  width: 60px;
  height: 60px;
  object-fit: cover;
  border-radius: 4px;
}

.item-details {
  flex: 1;
}

.item-stock {
  font-size: 0.875rem;
  color: #666;
  margin: 4px 0;
}

.item-name {
  font-weight: 500;
  margin: 0;
}

.item-price {
  color: #1677ff;
  margin: 4px 0;
}

/* Pre-order estimasi styling */
.preorder-estimasi {
  margin-top: 8px;
  display: flex;
  align-items: center;
  gap: 8px;
  flex-wrap: wrap;
}

.delivery-input-wrapper {
  display: flex;
  align-items: center;
  gap: 8px;
}

.delivery-placeholder {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 6px 10px;
  border: 1px solid #d1d5db;
  border-radius: 6px;
  background: #f9fafb;
  cursor: pointer;
  transition: all 0.2s;
  min-width: 150px;
}

.delivery-placeholder:hover {
  border-color: #1677ff;
  background: #e6f7ff;
}

.placeholder-text {
  color: #9ca3af;
  font-size: 13px;
}

.calendar-icon {
  color: #6b7280;
}

.delivery-input-container {
  display: flex;
  align-items: center;
  gap: 8px;
  position: relative;
}

.date-input {
  padding: 6px 10px;
  border: 1px solid #d1d5db;
  border-radius: 6px;
  font-size: 13px;
  outline: none;
  transition: all 0.2s;
}

.date-input:focus {
  border-color: #1677ff;
  box-shadow: 0 0 0 3px rgba(22, 119, 255, 0.1);
}

.item-quantity {
  display: flex;
  align-items: center;
  gap: 8px;
}

.qty-btn {
  width: 24px;
  height: 24px;
  background: #eee;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background 0.2s;
}

.qty-btn:hover {
  background: #ddd;
}

.qty-value {
  font-weight: 500;
}

.item-total {
  font-weight: 500;
  color: #1677ff;
}

.item-remove {
  background: none;
  border: none;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 28px;
  height: 28px;
  border-radius: 4px;
  transition: background 0.2s;
}

.item-remove:hover {
  background: #ffe6e6;
  color: #c82333;
}

.delete-icon {
  color: #dc3545;
  width: 16px;
  height: 16px;
}

/* Select All */
.select-all-row {
  padding: 8px 0;
}

.select-all-checkbox {
  display: flex;
  align-items: center;
  gap: 8px;
  font-weight: 500;
  color: #333;
  cursor: pointer;
}

.select-all-checkbox input[type="checkbox"] {
  width: 16px;
  height: 16px;
  cursor: pointer;
  accent-color: #1677ff;
}

/* Ringkasan */
.cart-summary {
  background: white;
  border: 1px solid #eee;
  border-radius: 8px;
  padding: 16px;
  margin-top: 20px;
}

.summary-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 8px 0;
  border-bottom: 1px solid #eee;
}

.summary-row:last-child {
  border-bottom: none;
}

/* ✅ TOMBOL KONFIRMASI */
.btn-confirm {
  background: #dc3545;
  color: white;
  padding: 8px 16px;
  font-weight: 500;
  transition: background 0.2s;
}

.btn-confirm:hover {
  background: #c82333;
}

.btn-confirm:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}
</style>

