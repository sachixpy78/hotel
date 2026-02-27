<!-- src/App.vue -->
<template>
  <router-view />
</template>

<script setup>
import { onMounted, onUnmounted } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
let barcodeBuffer = ''
let barcodeTimer = null

function handleGlobalScan(event) {
  // Abaikan input dari form (tapi biarkan scanner tetap jalan)
  if (event.target.tagName === 'INPUT' || event.target.tagName === 'TEXTAREA' || event.target.tagName === 'SELECT') {
    return
  }

  const key = event.key

  // Jika Enter ditekan dan ada buffer
  if (key === 'Enter' && barcodeBuffer) {
    if (window.isProcessingBarcode) return
    window.isProcessingBarcode = true
    setTimeout(() => {
      window.isProcessingBarcode = false
    }, 500)

    // Ambil data produk
    fetch('http://localhost:8000/api/produk')
      .then(res => res.json())
      .then(data => {
        const products = data.data || []
        const product = products.find(p => p.barcode === barcodeBuffer)

        if (product) {
          if (product.stok <= 0) {
            alert('Produk ini sudah habis!')
          } else {
            let cart = JSON.parse(localStorage.getItem('cart') || '[]')
            const existing = cart.find(item => item.id === product.id)

            if (existing) {
              if (existing.quantity < product.stok) {
                existing.quantity += 1
                existing.total = existing.quantity * existing.harga_jual
              } else {
                alert('Stok maksimal tercapai!')
                return
              }
            } else {
              cart.push({
                id: product.id,
                nama_produk: product.nama_produk,
                harga_jual: product.harga_jual,
                modal: product.modal,
                gambar: product.gambar,
                quantity: 1,
                total: product.harga_jual,
                stok: product.stok
              })
            }

            localStorage.setItem('cart', JSON.stringify(cart))
            router.push('/kasir/keranjang')
          }
        } else {
          alert('Barcode tidak dikenali!')
        }
      })
      .catch(err => {
        console.error('Error fetch produk:', err)
        alert('Gagal mengambil data produk. Pastikan server Laravel aktif di port 8000.')
      })
      .finally(() => {
        barcodeBuffer = ''
        if (barcodeTimer) clearTimeout(barcodeTimer)
      })

    event.preventDefault()
    return
  }

  // Abaikan tombol khusus (Shift, Ctrl, dll)
  if (key.length > 1 || event.ctrlKey || event.altKey || event.metaKey) {
    return
  }

  // Tambahkan karakter ke buffer
  barcodeBuffer += key
  if (barcodeTimer) clearTimeout(barcodeTimer)
  barcodeTimer = setTimeout(() => {
    barcodeBuffer = ''
  }, 200) // Timeout 200ms
}

onMounted(() => {
  window.addEventListener('keydown', handleGlobalScan)
})

onUnmounted(() => {
  window.removeEventListener('keydown', handleGlobalScan)
})
</script>