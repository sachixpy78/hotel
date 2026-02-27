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

      <!-- Konten -->
      <main class="main-content">
        <div class="content-header">
          <h1 class="page-title">Invoice Penjualan</h1>
          <p class="page-subtitle">Detail transaksi terakhir</p>
        </div>

        <div v-if="!transaction" class="empty-invoice">
          <p class="text-gray-500 text-center py-8">Belum ada transaksi untuk ditampilkan.</p>
          <div class="text-center">
            <button @click="goToKeranjang" class="btn btn-secondary">Kembali ke Keranjang</button>
          </div>
        </div>

        <div v-else class="invoice-container">
          <div class="invoice-header">
            <div class="invoice-logo">
              <img src="/logo.jpg" alt="Logo SMK" class="logo-img" />
            </div>
            <div class="invoice-title">
              <h3>Invoice Penjualan</h3>
            </div>
            <div class="invoice-actions">
              <div class="user-info">
                <span>{{ userName }}</span>
              </div>
            </div>
          </div>

          <div class="invoice-details">
            <div class="detail-row">
              <label>Tanggal</label>
              <span>: {{ transaction.date }}</span>
            </div>
            <div class="detail-row">
              <label>Kasir</label>
              <span>: {{ transaction.cashier }}</span>
            </div>
            <div class="detail-row">
              <label>Pembayaran</label>
              <span>: <strong>{{ transaction.payment }}</strong></span>
            </div>
          </div>

          <!-- Tabel Produk -->
          <div class="invoice-table">
            <table>
              <thead>
                <tr>
                  <th>No</th>
                  <th>Produk</th>
                  <th>Qty</th>
                  <th>Harga</th>
                  <th>Subtotal</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item, index) in transaction.items" :key="index">
                  <td>{{ index + 1 }}</td>
                  <td>
                    <div class="product-name">{{ item.nama_produk }}</div>
                    <div class="product-type" v-if="item.ketersediaan === 'tidaktersedia'">(Pre-order)</div>
                    <div class="product-type" v-else-if="item.ketersediaan === 'tersedia'">(Ambil Langsung)</div>
                  </td>
                  <td>{{ item.quantity }}</td>
                  <td>{{ formatRupiah(item.harga_jual) }}</td>
                  <td>{{ formatRupiah(item.total) }}</td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- Ringkasan Total -->
          <div class="invoice-summary">
            <div class="summary-row">
              <span>Grand Total:</span>
              <span>{{ formatRupiah(transaction.grandTotal) }}</span>
            </div>
            <div class="summary-row">
              <span>Total Keuntungan:</span>
              <span class="positive">{{ formatRupiah(totalKeuntungan) }}</span>
            </div>
            <div class="summary-row">
              <span>Tunai:</span>
              <input
                v-model.number="cashPayment"
                type="number"
                min="0"
                class="cash-input"
                placeholder="Masukkan jumlah tunai"
              />
            </div>
            <div v-if="isPreOrder" class="summary-row">
              <span>Pre-order:</span>
              <span>{{ preOrderDays }}</span>
            </div>

            <div v-if="cashPayment > 0" class="summary-row">
              <span>Kembali:</span>
              <span :class="{ positive: changeAmount > 0 }">{{ formatRupiah(changeAmount) }}</span>
            </div>
          </div>

          <!-- TOMBOL KONFIRMASI -->
          <div class="invoice-actions mt-6">
            <button
              @click="printInvoice"
              :disabled="!canPrint"
              class="btn btn-primary w-full md:w-auto"
            >
              Konfirmasi
            </button>
          </div>
        </div>
      </main>
    </div>

    <!-- Modal Cetak Struk Profesional -->
    <div v-if="showPrintModal" class="modal-overlay" @click.self="closePrintModal">
      <div class="modal-receipt">
        <div class="receipt-container" id="printable-receipt">
          <!-- Header -->
          <div class="receipt-header">
            <h2 class="store-name">KASIR SMK NEGERI 71</h2>
            <p class="store-address">Jl. Dr. KRT Radjiman Widyodiningrat</p>
            <p class="store-address">Jatinegara, Kec. Cakung</p>
            <p class="store-address">Kota Jakarta Timur</p>
          </div>
          
          <div class="receipt-divider-dashed"></div>
          
          <!-- Info Transaksi -->
          <div class="receipt-info">
            <div class="info-row">
              <span>Tanggal</span>
              <span>: {{ formatDate(transaction?.date) }}</span>
            </div>
            <div class="info-row">
              <span>Kasir</span>
              <span>: {{ transaction?.cashier }}</span>
            </div>
          </div>
          
          <div class="receipt-divider-dashed"></div>
          
          <!-- Items -->
          <div class="receipt-items">
            <div v-for="(item, index) in transaction?.items" :key="index" class="item-block">
              <div class="item-header">
                <span class="item-name">{{ item.nama_produk }}</span>
              </div>
              <div class="item-type" v-if="item.ketersediaan === 'tidaktersedia'">Pre-order</div>
              <div class="item-type" v-else-if="item.ketersediaan === 'tersedia'">Ambil Langsung</div>
              <div class="item-details">
                <span>{{ item.quantity }} x {{ formatRupiah(item.harga_jual) }}</span>
              </div>
              <div class="item-subtotal">{{ formatRupiah(item.total) }}</div>
            </div>
          </div>
          
          <div class="receipt-divider-dashed"></div>
          
          <!-- Total -->
          <div class="receipt-totals">
            <div class="total-row">
              <span>Grand Total</span>
              <span class="total-value">{{ formatRupiah(transaction?.grandTotal) }}</span>
            </div>
            <div class="total-row">
              <span>Tunai</span>
              <span class="total-value">{{ formatRupiah(cashPayment) }}</span>
            </div>
            <div v-if="isPreOrder" class="total-row">
              <span>Pre-order</span>
              <span class="total-value">{{ preOrderDays }}</span>
            </div>
            <div class="total-row change">
              <span>Kembali</span>
              <span class="total-value">{{ formatRupiah(changeAmount) }}</span>
            </div>
          </div>
          
          <div class="receipt-divider-dashed"></div>
          
          <!-- Footer -->
          <div class="receipt-footer">
            <p class="thank-you">TERIMA KASIH</p>
            <p class="store-name-small">SMK NEGERI 71</p>
          </div>
        </div>
        
        <!-- Buttons -->
        <div class="receipt-actions">
          <button @click="printReceipt" class="btn-print">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="margin-right: 6px;">
              <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
              <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v2a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-2h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM3 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H3V3zm1 6.5A1.5 1.5 0 1 1 5.5 11 1.5 1.5 0 0 1 4 9.5zm6 0A1.5 1.5 0 1 1 12.5 11 1.5 1.5 0 0 1 11 9.5z"/>
              <path d="M1 7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V7zm12-1a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1h-1z"/>
            </svg>
            Cetak Struk
          </button>
          <button @click="closePrintModal" class="btn-close">Tutup</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'

const router = useRouter()
const route = useRoute()

const transaction = ref(null)
const cashPayment = ref(0)
const showPrintModal = ref(false)

const userName = ref('Kasir')
const userAvatar = ref('/logo.jpg')

const userDropdown = ref(null)
const showDropdown = ref(false)

onMounted(() => {
  loadUserProfile()
  loadLastTransaction()
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

function goToKeranjang() {
  router.push('/kasir/keranjang')
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

function loadLastTransaction() {
  const history = JSON.parse(localStorage.getItem('transactions') || '[]')
  if (history.length > 0) {
    transaction.value = history[history.length - 1]
  }
}

function calculateTotalProfit(items) {
  if (!items || items.length === 0) return 0
  return items.reduce((total, item) => {
    const profitPerItem = (item.harga_jual - (item.modal || 0)) * item.quantity
    return total + profitPerItem
  }, 0)
}

const totalKeuntungan = computed(() => {
  return calculateTotalProfit(transaction.value?.items || [])
})

async function sendToDatabase() {
  if (!transaction.value) return

  const today = new Date().toISOString().split('T')[0]
  const userId = localStorage.getItem('user_id') || null

  if (!userId) {
    alert('User ID tidak ditemukan. Silakan login ulang.')
    return
  }

  const payload = {
    tanggal_pembelian: today,
    total_harga: transaction.value.grandTotal,
    total_keuntungan: totalKeuntungan.value,
    fid_admin: parseInt(userId),
    fid_produk: transaction.value.items.length > 0 ? transaction.value.items[0].id : null,
    detail: JSON.stringify(transaction.value.items),
    tunai: cashPayment.value,
    kembalian: changeAmount.value
  }
  
  try {
    const response = await fetch('http://localhost:8000/api/transaksi', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify(payload)
    })

    const data = await response.json()
    if (!data.success) {
      alert('Gagal simpan ke database: ' + (data.message || 'Unknown error'))
    } else {
      alert('✅ Data berhasil disimpan ke database!')
    }
  } catch (err) {
    console.error('Error kirim ke database:', err)
    alert('❌ Pastikan Laravel berjalan di port 8000.')
  }
}

function printInvoice() {
  if (!transaction.value) {
    alert('Tidak ada transaksi untuk dicetak.')
    return
  }

  if (cashPayment.value <= 0) {
    alert('Silakan masukkan jumlah tunai yang valid.')
    return
  }

  if (cashPayment.value < transaction.value.grandTotal) {
    alert('Jumlah tunai tidak mencukupi untuk membayar total belanja.')
    return
  }

  sendToDatabase()
  showPrintModal.value = true
}

function formatDate(dateStr) {
  if (!dateStr) return '-'
  
  try {
    // Jika format sudah "DD/MM/YYYY, HH:mm:ss", ambil bagian tanggal saja
    if (dateStr.includes(',')) {
      return dateStr.split(',')[0].trim()
    }
    
    // Jika format ISO atau lainnya, parse dan format ulang
    const date = new Date(dateStr)
    
    if (isNaN(date.getTime())) {
      return dateStr
    }
    
    const day = String(date.getDate()).padStart(2, '0')
    const month = String(date.getMonth() + 1).padStart(2, '0')
    const year = date.getFullYear()
    
    return `${day}/${month}/${year}`
  } catch (error) {
    return dateStr
  }
}


function printReceipt() {
  localStorage.setItem('lastTransaction', JSON.stringify(transaction.value))
  localStorage.setItem('lastCashPayment', cashPayment.value)
  
  const printWindow = window.open('', '_blank')
  
  const itemsHtml = transaction.value.items.map(item => {
    const typeLabel = item.ketersediaan === 'tidaktersedia' 
      ? '<div class="item-type">Pre-order</div>' 
      : (item.ketersediaan === 'tersedia' ? '<div class="item-type">Ambil Langsung</div>' : '')
    
    return `
      <div class="item-block">
        <div class="item-header">
          <span class="item-name">${item.nama_produk}</span>
        </div>
        ${typeLabel}
        <div class="item-details">
          <span>${item.quantity} x ${formatRupiah(item.harga_jual)}</span>
        </div>
        <div class="item-subtotal">${formatRupiah(item.total)}</div>
      </div>
    `
  }).join('')

  const preOrderHtml = transaction.value.estimasiPreOrder 
    ? `<div class="total-row"><span>Pre-order</span><span class="total-value">${transaction.value.estimasiPreOrder}</span></div>` 
    : ''

  printWindow.document.write(`
    <!DOCTYPE html>
    <html>
      <head>
        <title>Cetak Struk</title>
        <style>
          @media print {
            @page { size: 80mm auto; margin: 0; }
            body { margin: 0; padding: 0; }
          }
          body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 11px;
            line-height: 1.5;
            color: #1a1a1a;
            margin: 0;
            padding: 5mm;
            width: 80mm;
          }
          .receipt-container { width: 100%; }
          .receipt-header { text-align: center; margin-bottom: 12px; }
          .store-name { font-size: 16px; font-weight: 800; color: #1677ff; margin: 0 0 8px 0; letter-spacing: 1px; }
          .store-address { font-size: 9px; color: #666; margin: 2px 0; line-height: 1.3; }
          .receipt-divider-dashed { border-bottom: 2px dashed #ddd; margin: 12px 0; }
          .receipt-info { margin-bottom: 12px; }
          .info-row { display: flex; justify-content: space-between; font-size: 10px; margin-bottom: 4px; }
          .info-row span:first-child { color: #666; }
          .info-row span:last-child { color: #1a1a1a; font-weight: 600; }
          .receipt-items { margin-bottom: 12px; }
          .item-block { margin-bottom: 16px; padding-bottom: 12px; border-bottom: 1px dotted #e0e0e0; }
          .item-block:last-child { border-bottom: none; }
          .item-header { margin-bottom: 2px; }
          .item-name { font-size: 12px; font-weight: 700; color: #1a1a1a; }
          .item-type { font-size: 9px; color: #1677ff; font-weight: 600; margin-bottom: 4px; font-style: italic; }
          .item-details { font-size: 10px; color: #666; margin-bottom: 2px; }
          .item-subtotal { font-size: 12px; font-weight: 700; color: #1677ff; text-align: right; }
          .receipt-totals { margin-bottom: 12px; }
          .total-row { display: flex; justify-content: space-between; padding: 6px 0; font-size: 11px; }
          .total-row span:first-child { color: #666; font-weight: 600; }
          .total-value { color: #1677ff; font-weight: 700; font-size: 12px; }
          .total-row.change { border-top: 2px solid #1677ff; margin-top: 8px; padding-top: 10px; font-size: 12px; }
          .total-row.change .total-value { font-size: 13px; color: #10b981; }
          .receipt-footer { text-align: center; margin-top: 16px; padding-top: 12px; border-top: 2px dashed #ddd; }
          .thank-you { font-size: 12px; font-weight: 700; color: #1a1a1a; margin: 0 0 4px 0; letter-spacing: 2px; }
          .store-name-small { font-size: 10px; color: #666; margin: 0; }
        </style>
      </head>
      <body>
        <div class="receipt-container">
          <div class="receipt-header">
            <h2 class="store-name">KASIR SMK NEGERI 71</h2>
            <p class="store-address">Jl. Dr. KRT Radjiman Widyodiningrat</p>
            <p class="store-address">Jatinegara, Kec. Cakung</p>
            <p class="store-address">Kota Jakarta Timur</p>
          </div>
          <div class="receipt-divider-dashed"></div>
          <div class="receipt-info">
            <div class="info-row"><span>Tanggal</span><span>: ${formatDate(transaction.value.date)}</span></div>
            <div class="info-row"><span>Kasir</span><span>: ${transaction.value.cashier}</span></div>
          </div>
          <div class="receipt-divider-dashed"></div>
          <div class="receipt-items">
            ${itemsHtml}
          </div>
          <div class="receipt-divider-dashed"></div>
          <div class="receipt-totals">
            <div class="total-row"><span>Grand Total</span><span class="total-value">${formatRupiah(transaction.value.grandTotal)}</span></div>
            <div class="total-row"><span>Tunai</span><span class="total-value">${formatRupiah(cashPayment.value)}</span></div>
            ${preOrderHtml}
            <div class="total-row change"><span>Kembali</span><span class="total-value">${formatRupiah(changeAmount.value)}</span></div>
          </div>
          <div class="receipt-divider-dashed"></div>
          <div class="receipt-footer">
            <p class="thank-you">TERIMA KASIH</p>
            <p class="store-name-small">SMK NEGERI 71</p>
          </div>
        </div>
      </body>
    </html>
  `)
  
  printWindow.document.close()
  
  setTimeout(() => {
    printWindow.print()
    printWindow.close()
    setTimeout(() => {
      router.push('/kasir/laporantu')
    }, 500)
  }, 100)
}

function closePrintModal() {
  showPrintModal.value = false
}

const canPrint = computed(() => !!transaction.value)

const changeAmount = computed(() => {
  return Math.max(0, cashPayment.value - (transaction.value?.grandTotal || 0))
})

const preOrderDays = computed(() => transaction.value?.estimasiPreOrder || '')

const isPreOrder = computed(() => {
  return transaction.value?.items?.some(item => item.ketersediaan === 'tidaktersedia')
})

const formatRupiah = (angka) => {
  const num = Number(angka) || 0
  return 'Rp ' + num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.')
}
</script>

<style scoped>
.kasir-app {
  min-height: 100vh;
  background: #f8fafc;
  display: flex;
  flex-direction: column;
}

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

.invoice-container {
  background: white;
  border-radius: 12px;
  padding: 28px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
  margin-bottom: 24px;
}

.invoice-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 28px;
}

.invoice-logo img {
  width: 44px;
  height: 44px;
  border-radius: 8px;
}

.invoice-title h3 {
  font-size: 22px;
  font-weight: 700;
  color: #1f2937;
}

.invoice-details {
  background: #f9fbff;
  border-radius: 10px;
  padding: 20px;
  margin-bottom: 28px;
  border: 1px solid #edf2ff;
}

.detail-row {
  display: flex;
  margin-bottom: 12px;
  font-size: 15px;
}

.detail-row label {
  width: 110px;
  font-weight: 600;
  color: #374151;
}

.detail-row span {
  flex: 1;
  color: #4b5563;
}

.invoice-table {
  border-radius: 10px;
  overflow: hidden;
  margin-bottom: 28px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.invoice-table table {
  width: 100%;
  border-collapse: collapse;
}

.invoice-table th,
.invoice-table td {
  padding: 14px 16px;
  text-align: left;
  font-size: 14px;
}

.invoice-table th {
  background: #f8fafc;
  font-weight: 600;
  color: #374151;
  border-bottom: 1px solid #e2e8f0;
}

.invoice-table td {
  border-bottom: 1px solid #f1f5f9;
  color: #4b5563;
}

.invoice-table tr:last-child td {
  border-bottom: none;
}

.invoice-summary {
  background: #f8fafc;
  border-radius: 10px;
  padding: 20px;
  border: 1px solid #e2e8f0;
}

.summary-row {
  display: flex;
  justify-content: space-between;
  padding: 10px 0;
  font-size: 15px;
}

.summary-row span:first-child {
  font-weight: 600;
  color: #374151;
}

.summary-row span:last-child {
  font-weight: 600;
  color: #1677ff;
}

.cash-input {
  width: 100%;
  max-width: 120px;
  padding: 10px 14px;
  border: 1px solid #d1d5db;
  border-radius: 8px;
  font-size: 15px;
  background: white;
  transition: border-color 0.2s;
}

.cash-input:focus {
  outline: none;
  border-color: #1677ff;
  box-shadow: 0 0 0 3px rgba(22, 119, 255, 0.15);
}

.positive {
  color: #1677ff;
  font-weight: 600;
}

.product-name {
  font-weight: 500;
  margin-bottom: 4px;
}

.product-type {
  display: inline-block;
  font-size: 0.8em;
  color: #666;
  background-color: #f8fafc;
  padding: 2px 6px;
  border-radius: 10px;
  margin-top: 2px;
}

.btn-primary {
  padding: 0.75rem 1.5rem;
  background: #800000;
  color: white;
  border: none;
  border-radius: 0.5rem;
  font-size: 0.875rem;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.3s ease;
  width: 100%;
}

.btn-primary:hover:not(:disabled) {
  background: #990000;
  transform: scale(1.02);
}

.btn-primary:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.btn-secondary {
  padding: 0.75rem 1.5rem;
  background: #6c757d;
  color: white;
  border: none;
  border-radius: 0.5rem;
  font-size: 0.875rem;
  font-weight: 500;
  cursor: pointer;
}

.btn-secondary:hover {
  background: #5a6268;
}

/* Modal Overlay */
.modal-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.7);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 2000;
  padding: 20px;
}

.modal-receipt {
  background: #f5f5f5;
  padding: 20px;
  border-radius: 12px;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
  max-height: 90vh;
  overflow-y: auto;
}

/* Receipt Container - Thermal Paper Style */
.receipt-container {
  background: white;
  width: 320px;
  padding: 20px 16px;
  font-family: 'Courier New', Courier, monospace;
  font-size: 11px;
  line-height: 1.5;
  color: #1a1a1a;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  margin: 0 auto;
}

.receipt-header {
  text-align: center;
  margin-bottom: 12px;
}

.store-name {
  font-size: 16px;
  font-weight: 800;
  color: #1677ff;
  margin: 0 0 8px 0;
  letter-spacing: 1px;
}

.store-address {
  font-size: 9px;
  color: #666;
  margin: 2px 0;
  line-height: 1.3;
}

.receipt-divider-dashed {
  border-bottom: 2px dashed #ddd;
  margin: 12px 0;
}

.receipt-info {
  margin-bottom: 12px;
}

.info-row {
  display: flex;
  justify-content: space-between;
  font-size: 10px;
  margin-bottom: 4px;
}

.info-row span:first-child {
  color: #666;
}

.info-row span:last-child {
  color: #1a1a1a;
  font-weight: 600;
}

.receipt-items {
  margin-bottom: 12px;
}

.item-block {
  margin-bottom: 16px;
  padding-bottom: 12px;
  border-bottom: 1px dotted #e0e0e0;
}

.item-block:last-child {
  border-bottom: none;
}

.item-header {
  margin-bottom: 2px;
}

.item-name {
  font-size: 12px;
  font-weight: 700;
  color: #1a1a1a;
}

.item-type {
  font-size: 9px;
  color: #1677ff;
  font-weight: 600;
  margin-bottom: 4px;
  font-style: italic;
}

.item-details {
  font-size: 10px;
  color: #666;
  margin-bottom: 2px;
}

.item-subtotal {
  font-size: 12px;
  font-weight: 700;
  color: #1677ff;
  text-align: right;
}

.receipt-totals {
  margin-bottom: 12px;
}

.total-row {
  display: flex;
  justify-content: space-between;
  padding: 6px 0;
  font-size: 11px;
}

.total-row span:first-child {
  color: #666;
  font-weight: 600;
}

.total-value {
  color: #1677ff;
  font-weight: 700;
  font-size: 12px;
}

.total-row.change {
  border-top: 2px solid #1677ff;
  margin-top: 8px;
  padding-top: 10px;
  font-size: 12px;
}

.total-row.change .total-value {
  font-size: 13px;
  color: #10b981;
}

.receipt-footer {
  text-align: center;
  margin-top: 16px;
  padding-top: 12px;
  border-top: 2px dashed #ddd;
}

.thank-you {
  font-size: 12px;
  font-weight: 700;
  color: #1a1a1a;
  margin: 0 0 4px 0;
  letter-spacing: 2px;
}

.store-name-small {
  font-size: 10px;
  color: #666;
  margin: 0;
}

.receipt-actions {
  display: flex;
  gap: 12px;
  margin-top: 20px;
  justify-content: center;
}

.btn-print,
.btn-close {
  padding: 10px 20px;
  border: none;
  border-radius: 6px;
  font-size: 13px;
  font-weight: 600;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s;
}

.btn-print {
  background: #1677ff;
  color: white;
}

.btn-print:hover {
  background: #096dd9;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(22, 119, 255, 0.4);
}

.btn-close {
  background: #6c757d;
  color: white;
}

.btn-close:hover {
  background: #5a6268;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(108, 117, 125, 0.4);
}

@media print {
  @page {
    size: 80mm auto;
    margin: 0;
  }
  body * {
    visibility: hidden;
  }
  .receipt-container,
  .receipt-container * {
    visibility: visible;
  }
  .receipt-container {
    position: absolute;
    left: 0;
    top: 0;
    width: 80mm;
    padding: 5mm;
    box-shadow: none;
  }
  .modal-receipt,
  .receipt-actions {
    display: none !important;
  }
}

.modal-receipt::-webkit-scrollbar {
  width: 6px;
}

.modal-receipt::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 3px;
}

.modal-receipt::-webkit-scrollbar-thumb {
  background: #888;
  border-radius: 3px;
}

.modal-receipt::-webkit-scrollbar-thumb:hover {
  background: #555;
}

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
  .invoice-header,
  .detail-row,
  .summary-row,
  .item-row {
    flex-direction: column;
    align-items: flex-start;
  }
  .detail-row label,
  .summary-row span:first-child {
    margin-bottom: 4px;
  }
  .btn-primary {
    width: 100%;
  }
}

.empty-invoice {
  background: white;
  border-radius: 12px;
  padding: 32px;
  text-align: center;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
}

.mt-6 {
  margin-top: 1.5rem;
}
</style>