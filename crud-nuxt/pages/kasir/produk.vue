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
          <h1 class="page-title">Produk</h1>
          <p class="page-subtitle">Kelola produk toko</p>
        </div>

        <!-- Filter & Search -->
        <div class="flex flex-col sm:flex-row gap-4 mb-6">
          <div class="flex-1">
            <label class="block text-sm font-medium mb-1">Kategori</label>
            <select
              v-model="selectedCategory"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
            >
              <option value="">Semua Kategori</option>
              <option v-for="kat in categories" :key="kat.id" :value="kat.id">{{ kat.kategori }}</option>
            </select>
          </div>

          <div class="flex-1">
            <label class="block text-sm font-medium mb-1">Cari Produk</label>
            <input
              v-model="searchQuery"
              type="text"
              placeholder="Cari nama produk..."
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
            />
          </div>
        </div>

        <!-- Grid Produk -->
   <!-- Grid Produk -->
<div class="product-grid">
  <div v-for="prod in paginatedProducts" :key="prod.id" class="product-card group">
    <!-- TAG STATUS DI ATAS CARD -->
<div class="status-tag status-habis" v-if="prod.stok === 0">Produk habis</div>
<div class="status-tag" v-else-if="prod.ketersediaan === 'tersedia'">Produk tersedia</div>
<div class="status-tag status-preorder" v-else-if="prod.ketersediaan === 'tidaktersedia'">Pre-order</div>

    <div class="card-image-container">
      <img
        :src="prod.gambar ? `http://localhost:8000/storage/${prod.gambar}` : 'https://via.placeholder.com/150'"
        :alt="prod.nama_produk"
        class="product-image"
        @error="handleImageError"
      />
    </div>

    <div class="product-info">
      <h3 class="product-name">{{ prod.nama_produk }}</h3>
<p class="product-stock">
  Stok:
{{ prod.stok }}
</p>
      <p class="product-price">Rp{{ prod.harga_jual }}</p>
    </div>

    <div class="product-actions">
      <button @click.stop="editProduct(prod.id)" class="action-btn edit-btn">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
        </svg>
      </button>
      <button @click="confirmDelete(prod)" class="action-btn delete-btn">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
        </svg>
      </button>
      <button @click="viewProductDetail(prod)" class="action-btn detail-btn">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        </svg>
      </button>
      <button @click="addToCartManual(prod)" class="action-btn cart-btn">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
      </button>
    </div>
  </div>

  <router-link to="/kasir/tambahduk" class="product-card add-new-card group">
    <div class="add-icon-container">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
      </svg>
    </div>
    <span class="add-text">Tambah Produk</span>
  </router-link>
</div>
        <!-- Pagination -->
        <div class="pagination mt-6">
          <button
            @click="prevPage"
            :disabled="currentPage === 1"
            class="px-3 py-1 border border-gray-300 rounded-l-md bg-white disabled:opacity-50"
          >
            ←
          </button>
          <button
            v-for="page in totalPages"
            :key="page"
            @click="currentPage = page"
            :class="['px-3 py-1 border border-gray-300 bg-white', currentPage === page ? 'bg-blue-100 border-blue-500' : '']"
          >
            {{ page }}
          </button>
          <button
            @click="nextPage"
            :disabled="currentPage === totalPages"
            class="px-3 py-1 border border-gray-300 rounded-r-md bg-white disabled:opacity-50"
          >
            →
          </button>
        </div>
      </main>
      <input
  ref="scannerInput"
  type="text"
  class="hidden"
  @input="handleScannerInput"
  @keydown.enter="processBarcodeFromScanner"
  tabindex="-1"
/>
    </div>

    <!-- ✅ MODAL DETAIL PRODUK -->
    <div v-if="showDetailModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[1000] p-4">
      <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6 overflow-y-auto max-h-[80vh]">
        <h3 class="text-lg font-bold mb-4 text-center">Detail Produk</h3>

        <!-- Preview Gambar -->
        <div class="flex justify-center mb-4">
          <img
            :src="selectedProduct.gambar ? `http://localhost:8000/storage/${selectedProduct.gambar}` : 'https://via.placeholder.com/150'"
            alt="Preview"
            class="w-24 h-24 object-cover rounded-lg border"
            @error="handleImageError"
          />
        </div>

        <!-- Detail Produk -->
        <div class="space-y-3">

          <!-- Nama Produk -->
          <div>
            <label class="block text-sm font-medium mb-1">Nama Produk</label>
            <input
              :value="selectedProduct.nama_produk"
              type="text"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100"
              readonly
            />
          </div>

          <!-- Kategori -->
          <div>
            <label class="block text-sm font-medium mb-1">Kategori</label>
            <input
              :value="selectedProduct.kategori?.kategori || 'Tidak Ada'"
              type="text"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100"
              readonly
            />
          </div>

          <!-- Barcode (Gambar) -->
          <div>
            <label class="block text-sm font-medium mb-1">Barcode</label>
            <div class="border border-gray-300 rounded-lg p-4 bg-white">
              <canvas
                ref="barcodeCanvasDetail"
                class="w-full h-16"
                v-if="selectedProduct.barcode"
              ></canvas>
              <div v-else class="text-gray-500">Belum ada barcode</div>
              <!-- Tampilkan teks barcode di bawah canvas -->
              <div v-if="selectedProduct.barcode" class="text-center mt-2 text-sm text-gray-600">
                {{ selectedProduct.barcode }}
              </div>
            </div>
          </div>

          <!-- Ketersediaan -->
          <div>
            <label class="block text-sm font-medium mb-1">Ketersediaan</label>
            <input
              :value="selectedProduct.ketersediaan"
              type="text"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100"
              readonly
            />
          </div>

          <!-- Modal -->
          <div>
            <label class="block text-sm font-medium mb-1">Modal</label>
            <input
              :value="selectedProduct.modal"
              type="text"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100"
              readonly
            />
          </div>

<!-- Stok -->
<div>
  <label class="block text-sm font-medium mb-1">Stok</label>
  <input
    :value="selectedProduct.stok"
    type="text"
    class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100"
    readonly
  />
</div>
          <!-- Harga Jual -->
          <div>
            <label class="block text-sm font-medium mb-1">Harga Jual</label>
            <input
              :value="selectedProduct.harga_jual"
              type="text"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100"
              readonly
            />
          </div>

          <!-- Estimasi -->
          <div>
            <label class="block text-sm font-medium mb-1">Estimasi</label>
            <input
              :value="selectedProduct.estimasi"
              type="text"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100"
              readonly
            />
          </div>

          <!-- Deskripsi -->
          <div>
            <label class="block text-sm font-medium mb-1">Deskripsi</label>
            <textarea
              :value="selectedProduct.deskripsi"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100"
              rows="3"
              readonly
            ></textarea>
          </div>

          <!-- Keuntungan -->
          <div>
            <label class="block text-sm font-medium mb-1">Keuntungan</label>
            <input
              :value="keuntunganDetail"
              type="text"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100"
              readonly
            />
          </div>

        </div>

        <!-- Tombol Tutup -->
        <div class="flex justify-end pt-4">
          <button @click="closeDetailModal" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
            Tutup
          </button>
        </div>
      </div>
    </div>

    <!-- ✅ MODAL EDIT PRODUK -->
    <div v-if="showEditModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[1000] p-4">
      <div class="bg-white rounded-xl shadow-lg w-full max-w-lg p-6 overflow-y-auto max-h-[80vh]">
        <h3 class="text-lg font-bold mb-4 text-center">Edit Produk</h3>

        <!-- Preview Gambar -->
        <div class="flex justify-center mb-4">
          <div class="relative">
            <img
              :src="imagePreview || (editingProduct.gambar ? `http://localhost:8000/storage/${editingProduct.gambar}` : 'https://via.placeholder.com/150')"
              alt="Preview"
              class="w-24 h-24 object-cover rounded-lg border"
              @error="handleImageError"
            />
            <!-- Button hapus gambar -->
            <button
              v-if="imagePreview || editingProduct.gambar"
              @click="removeImage"
              class="absolute top-0 right-0 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs"
            >
              ×
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
            class="w-full px-3 py-2 border border-gray-300 rounded-lg"
          />
        </div>

        <!-- Form Edit -->
        <div class="space-y-3">

          <!-- Nama Produk -->
          <div>
            <label class="block text-sm font-medium mb-1">Nama Produk</label>
            <input
              v-model="editingProduct.nama_produk"
              type="text"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg"
              placeholder="Nama produk"
            />
          </div>

          <!-- Kategori -->
          <div>
            <label class="block text-sm font-medium mb-1">Kategori</label>
            <select
              v-model="editingProduct.fid_kategori"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg"
            >
              <option value="">Pilih Kategori</option>
              <option v-for="kat in categories" :key="kat.id" :value="kat.id">{{ kat.kategori }}</option>
            </select>
          </div>

          <!-- Barcode (Gambar) -->
          <div>
            <label class="block text-sm font-medium mb-1">Barcode</label>
            <div class="border border-gray-300 rounded-lg p-4 bg-white">
              <canvas
                ref="barcodeCanvasEdit"
                class="w-full h-16"
                v-if="editingProduct.barcode"
              ></canvas>
              <div v-else class="text-gray-500">Belum ada barcode</div>
              <!-- Tampilkan teks barcode di bawah canvas -->
              <div v-if="editingProduct.barcode" class="text-center mt-2 text-sm text-gray-600">
                {{ editingProduct.barcode }}
              </div>
            </div>
          </div>

          <!-- Ketersediaan -->
          <div>
            <label class="block text-sm font-medium mb-1">Ketersediaan</label>
            <select
              v-model="editingProduct.ketersediaan"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg"
            >
              <option value="tersedia">Tersedia</option>
              <option value="tidaktersedia">pre-order</option>
            </select>
          </div>

          <!-- Modal -->
          <div>
            <label class="block text-sm font-medium mb-1">Modal</label>
            <input
              v-model.number="editingProduct.modal"
              type="number"
              min="0"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg"
              placeholder="Harga modal"
            />
          </div>

          <!-- Stok -->
<!-- Stok -->
<div>
  <label class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
  <input
    v-model.number="editingProduct.stok"
    type="number"
    min="0"
    class="w-full px-3 py-2 border rounded-md border-gray-300"
    placeholder="Stok"
  />
  <p class="text-xs text-gray-500 mt-1" v-if="editingProduct.ketersediaan === 'tidaktersedia'">
    * Produk pre-order - stok tetap bisa diisi
  </p>
</div>

          <!-- Harga Jual -->
          <div>
            <label class="block text-sm font-medium mb-1">Harga Jual</label>
            <input
              v-model.number="editingProduct.harga_jual"
              type="number"
              min="0"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg"
              placeholder="Harga jual"
            />
          </div>

          <!-- Estimasi -->
          <div>
            <label class="block text-sm font-medium mb-1">Estimasi</label>
            <select
              v-model="editingProduct.estimasi"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg"
            >
              <option value="langsung_ambil">Ambil di Tempat</option>
              <option value="7_hari_kerja">7 hari kerja</option>
            </select>
          </div>

          <!-- Deskripsi -->
          <div>
            <label class="block text-sm font-medium mb-1">Deskripsi</label>
            <textarea
              v-model="editingProduct.deskripsi"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg"
              rows="3"
              placeholder="Deskripsi produk"
            ></textarea>
          </div>

          <!-- Keuntungan -->
          <div>
            <label class="block text-sm font-medium mb-1">Keuntungan</label>
            <input
              :value="keuntunganEdit"
              type="text"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100"
              readonly
            />
          </div>

        </div>

        <!-- Tombol Simpan & Kembali -->
        <div class="flex justify-end space-x-2 pt-4">
          <button @click="closeEditModal" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded">
            Kembali
          </button>
          <button @click="submitEdit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Simpan
          </button>
        </div>
      </div>
    </div>

    <!-- ✅ MODAL KONFIRMASI HAPUS -->
    <div v-if="showConfirmModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[1000] p-4">
      <div class="bg-white rounded-xl shadow-lg w-full max-w-sm p-6 text-center">
        <div class="text-yellow-500 mb-4">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M12 17h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
        <h3 class="text-lg font-semibold mb-2">Yakin hapus data?</h3>
        <p class="text-gray-600 mb-6">Tindakan ini tidak dapat dibatalkan.</p>
        <div class="flex gap-3 justify-center">
          <button
            @click="closeConfirmModal"
            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition"
          >
            Batal
          </button>
          <button
            @click="deleteProduct"
            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition"
          >
            Ya
          </button>
        </div>
      </div>
    </div>

    <!-- ✅ MODAL STOK MASIH ADA -->
    <div v-if="showStockWarning" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[1000] p-4">
      <div class="bg-white rounded-xl shadow-lg w-full max-w-sm p-6 text-center">
        <div class="text-yellow-500 mb-4">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M12 17h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
        <h3 class="text-lg font-semibold mb-2">Stok Masih Tersedia</h3>
        <p class="text-gray-600 mb-6">Tunggu hingga stok habis sebelum menghapus produk.</p>
        <div class="flex justify-center">
          <button
            @click="closeStockWarning"
            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition"
          >
            Tutup
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed, nextTick } from 'vue'
import { useRouter } from 'vue-router'
import JsBarcode from 'jsbarcode'

const router = useRouter()
const scannerInput = ref(null)
// Data
const products = ref([])
let barcodeBuffer = ''
let barcodeTimer = null
const categories = ref([])
const selectedCategory = ref('')
const searchQuery = ref('')
const showEditModal = ref(false)
const showConfirmModal = ref(false)
const showStockWarning = ref(false)
const showDetailModal = ref(false)

let deleteId = null
let productToDelete = null

// Pagination
const currentPage = ref(1)
const itemsPerPage = 5

// === MODAL DETAIL ===
const selectedProduct = ref({
  id: null,
  nama_produk: '',
  fid_kategori: '',
  stok: 0,
  harga_jual: 0,
  gambar: null,
  modal: 0,
  ketersediaan: '',
  estimasi: '',
  deskripsi: '',
  barcode: null,
  kategori: null
})

// === MODAL EDIT ===
const editingProduct = ref({
  id: null,
  nama_produk: '',
  fid_kategori: '',
  stok: 0,
  harga_jual: 0,
  gambar: null,
  modal: 0,
  ketersediaan: 'tersedia',
  estimasi: 'langsung_ambil',
  deskripsi: '',
  barcode: null
})

// === STATE UNTUK GAMBAR ===
const imagePreview = ref(null)
const selectedFile = ref(null)

// === REF UNTUK CANVAS BARCODE ===
const barcodeCanvasEdit = ref(null)
const barcodeCanvasDetail = ref(null)

// User Info
const userName = ref('Kasir')
const userAvatar = ref('/logo.jpg')

// Ref untuk dropdown
const userDropdown = ref(null)
const showDropdown = ref(false)

// Load Data
onMounted(() => {
  loadUserProfile()
  getCategories()
  getProducts()
  document.addEventListener('click', clickOutside)
  document.addEventListener('keypress', handleBarcodeInput)
  nextTick(() => {
  if (scannerInput.value) {
    scannerInput.value.focus()
  }
})
setInterval(() => {
  if (scannerInput.value && document.activeElement !== scannerInput.value) {
    scannerInput.value.focus()
  }
}, 1000)
})

onUnmounted(() => {
  document.removeEventListener('click', clickOutside)
  document.removeEventListener('keypress', handleBarcodeInput)
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
    const res = await fetch('http://localhost:8000/api/produk')
    const data = await res.json()
    products.value = data.data || []
  } catch (err) {
    console.error('Gagal memuat produk:', err)
    alert('Gagal memuat produk.')
  }
}

// Filter Produk
const filteredProducts = computed(() => {
  let filtered = products.value

  if (selectedCategory.value) {
    filtered = filtered.filter(p => p.fid_kategori == selectedCategory.value)
  }

  if (searchQuery.value.trim()) {
    const query = searchQuery.value.toLowerCase()
    filtered = filtered.filter(p =>
      p.nama_produk.toLowerCase().includes(query)
    )
  }

  return filtered
})

// Pagination
const totalPages = computed(() => {
  return Math.ceil(filteredProducts.value.length / itemsPerPage)
})

const paginatedProducts = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage
  const end = start + itemsPerPage
  return filteredProducts.value.slice(start, end)
})

function prevPage() {
  if (currentPage.value > 1) currentPage.value--
}

function nextPage() {
  if (currentPage.value < totalPages.value) currentPage.value++
}

// Computed Keuntungan
const keuntunganEdit = computed(() => {
  const modal = Number(editingProduct.value.modal) || 0
  const hargaJual = Number(editingProduct.value.harga_jual) || 0
  return Math.max(0, hargaJual - modal)
})

const keuntunganDetail = computed(() => {
  const modal = Number(selectedProduct.value.modal) || 0
  const hargaJual = Number(selectedProduct.value.harga_jual) || 0
  return Math.max(0, hargaJual - modal)
})

// === RENDER BARCODE ===
function renderBarcode(canvasRef, barcodeText) {
  if (!canvasRef.value || !barcodeText) return

  try {
    JsBarcode(canvasRef.value, barcodeText, {
      format: "CODE39",
      lineColor: "#000",
      width: 2,
      height: 50,
      displayValue: true,
      fontSize: 12,
      textMargin: 5,
      margin: 10,
      background: "#fff"
    })
  } catch (err) {
    console.error('Gagal render barcode:', err)
    const ctx = canvasRef.value.getContext('2d')
    ctx.fillStyle = '#000'
    ctx.font = '12px Arial'
    ctx.fillText('Barcode Error', 10, 20)
  }
}

// === DETAIL PRODUK ===
function viewProductDetail(product) {
  selectedProduct.value = { ...product }
  showDetailModal.value = true

  nextTick(() => {
    renderBarcode(barcodeCanvasDetail, selectedProduct.value.barcode)
  })
}

function closeDetailModal() {
  showDetailModal.value = false
}

// === EDIT PRODUK ===
function editProduct(id) {
  const prod = products.value.find(p => p.id === id)
  if (prod) {
    editingProduct.value = { ...prod }
    imagePreview.value = null
    selectedFile.value = null
    showEditModal.value = true

    nextTick(() => {
      renderBarcode(barcodeCanvasEdit, editingProduct.value.barcode)
    })
  }
}

// ✅ SAMA PERSIS DENGAN KATEGORI
function handleFileUpload(event) {
  const file = event.target.files[0]
  if (file) {
    selectedFile.value = file
    const reader = new FileReader()
    reader.onload = (e) => {
      imagePreview.value = e.target.result
    }
    reader.readAsDataURL(file)
  }
}

function removeImage() {
  selectedFile.value = null
  imagePreview.value = null
}

async function submitEdit() {
   // ✅ Cek duplikat nama produk (kecuali untuk produk ini sendiri)
  const isDuplicate = products.value.some(prod => 
    prod.id !== editingProduct.value.id && 
    prod.nama_produk.toLowerCase() === editingProduct.value.nama_produk.toLowerCase()
  );

  if (isDuplicate) {
    alert('Nama produk sudah ada!');
    return;
  }
  const formData = new FormData()
  formData.append('nama_produk', editingProduct.value.nama_produk)
  formData.append('fid_kategori', editingProduct.value.fid_kategori)
  formData.append('stok', editingProduct.value.stok)
  formData.append('harga_jual', editingProduct.value.harga_jual)
  formData.append('modal', editingProduct.value.modal)
  formData.append('ketersediaan', editingProduct.value.ketersediaan)
  formData.append('estimasi', editingProduct.value.estimasi)
  formData.append('deskripsi', editingProduct.value.deskripsi)
  formData.append('barcode', editingProduct.value.barcode)

  if (selectedFile.value) {
    formData.append('gambar', selectedFile.value)
  }

  formData.append('_method', 'PUT')

  try {
    const response = await fetch(`http://localhost:8000/api/produk/${editingProduct.value.id}`, {
      method: 'POST',
      body: formData
    })

    if (response.ok) {
      alert('Produk berhasil diperbarui!')
      getProducts()
      closeEditModal()
    } else {
      const errorData = await response.json().catch(() => ({}))
      alert(errorData.message || 'Gagal memperbarui produk.')
    }
  } catch (err) {
    console.error('Error saat update produk:', err)
    alert('Terjadi kesalahan: pastikan server Laravel berjalan di port 8000.')
  }
}

function closeEditModal() {
  showEditModal.value = false
  selectedFile.value = null
  imagePreview.value = null
}

// === HAPUS PRODUK ===
function confirmDelete(product) {
  productToDelete = product
  // Hanya blokir jika produk tersedia DAN stok > 0
  if (product.ketersediaan === 'tersedia' && product.stok > 0) {
    showStockWarning.value = true
  } else {
    deleteId = product.id
    showConfirmModal.value = true
  }
}

function closeStockWarning() {
  showStockWarning.value = false
  productToDelete = null
}

function closeConfirmModal() {
  showConfirmModal.value = false
  deleteId = null
}

async function deleteProduct() {
  try {
    const res = await fetch(`http://localhost:8000/api/produk/${deleteId}`, {
      method: 'DELETE'
    })

    if (res.ok) {
      alert('Produk berhasil dihapus!')
      products.value = products.value.filter(p => p.id !== deleteId)
    } else {
      alert('Gagal menghapus produk.')
    }
  } catch (err) {
    alert('Gagal menghapus produk.')
  }

  closeConfirmModal()
}

function handleImageError(e) {
  e.target.src = 'https://via.placeholder.com/150'
}


function addToCartManual(product) {
  // Hanya blokir jika stok == 0 (habis), tapi izinkan stok == -1 (tak terhingga)
  if (product.stok === 0) {
    alert('Produk ini sudah habis!')
    return
  }
  
  let cart = JSON.parse(localStorage.getItem('cart') || '[]')
  const existing = cart.find(item => item.id === product.id)
  
if (existing) {
  if (product.stok !== -1 && existing.quantity >= product.stok) {
    alert('Stok produk ini sudah maksimal!')
    return
  }
  existing.quantity += 1
  existing.total = existing.quantity * existing.harga_jual
} else {
cart.push({
  id: product.id,
  nama_produk: product.nama_produk,
  harga_jual: product.harga_jual,
  modal: product.modal,
  gambar: product.gambar,
  quantity: 1,
  total: product.harga_jual,
  stok: product.stok,
  ketersediaan: product.ketersediaan || 'tersedia',  // ✅ TAMBAHKAN INI
  estimasi: product.estimasi || 'langsung_ambil'      // ✅ TAMBAHKAN INI
})
}

  
  localStorage.setItem('cart', JSON.stringify(cart))
  alert('Produk berhasil ditambahkan ke keranjang!')
}

// ✅ BARCODE SCANNER AUTO-ADD TO CART (dengan cek stok)
function handleBarcodeInput(e) {
  if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA' || e.target.tagName === 'SELECT') return

  const key = e.key
  if (key === 'Enter' && barcodeBuffer) {
    const product = products.value.find(p => p.barcode === barcodeBuffer)
    if (product) {
      // Cek stok
if (product.stok === 0) {
  alert('Produk ini sudah habis!')
  barcodeBuffer = ''
  if (barcodeTimer) clearTimeout(barcodeTimer)
  return
}

      let cart = JSON.parse(localStorage.getItem('cart') || '[]')
      const existing = cart.find(item => item.id === product.id)

    if (existing) {
  // Cek apakah penambahan melebihi stok (hanya untuk produk dengan stok terbatas)
  if (product.stok !== -1 && existing.quantity >= product.stok) {
    alert('Stok produk ini sudah maksimal!')
    barcodeBuffer = ''
    if (barcodeTimer) clearTimeout(barcodeTimer)
    return
  }
        existing.quantity += 1
        existing.total = existing.quantity * existing.harga_jual
      } 
      else {
     cart.push({
  id: product.id,
  nama_produk: product.nama_produk,
  harga_jual: product.harga_jual,
  modal: product.modal,
  gambar: product.gambar,
  quantity: 1,
  total: product.harga_jual,
  stok: product.stok,
  ketersediaan: product.ketersediaan || 'tersedia',  // ✅ TAMBAHKAN INI
  estimasi: product.estimasi || 'langsung_ambil'      // ✅ TAMBAHKAN INI
})
      }

      localStorage.setItem('cart', JSON.stringify(cart))
      router.push('/kasir/keranjang')
    }
    barcodeBuffer = ''
    if (barcodeTimer) clearTimeout(barcodeTimer)
  } else if (key.length === 1) {
    barcodeBuffer += key
    if (barcodeTimer) clearTimeout(barcodeTimer)
    barcodeTimer = setTimeout(() => { barcodeBuffer = '' }, 100)
  }
}

// Fungsi untuk handle input dari scanner
function handleScannerInput(e) {
  const value = e.target.value.trim()
  if (value && value.length > 0) {
    // Simpan sementara nilai barcode
    barcodeBuffer = value
    // Kosongkan input agar siap untuk scan berikutnya
    e.target.value = ''
  }
}

// Fungsi untuk proses barcode saat enter ditekan
function processBarcodeFromScanner() {
    console.log('🔍 Scan diterima:', barcodeBuffer)
  console.log('🛒 Jumlah pemanggilan fungsi:', (window.scanCount = (window.scanCount || 0) + 1))
  if (!barcodeBuffer) return

  const product = products.value.find(p => p.barcode === barcodeBuffer)
  if (product) {
    // Cek stok
if (product.stok === 0) {
  alert('Produk ini sudah habis!')
  barcodeBuffer = ''
  return
}

    let cart = JSON.parse(localStorage.getItem('cart') || '[]')
    const existing = cart.find(item => item.id === product.id)
    if (existing) {
      if (existing.quantity >= product.stok) {
        alert('Stok produk ini sudah maksimal!')
        barcodeBuffer = ''
        return
      }
      existing.quantity += 1
      existing.total = existing.quantity * existing.harga_jual
    } else {
  cart.push({
  id: product.id,
  nama_produk: product.nama_produk,
  harga_jual: product.harga_jual,
  modal: product.modal,
  gambar: product.gambar,
  quantity: 1,
  total: product.harga_jual,
  stok: product.stok,
  ketersediaan: product.ketersediaan || 'tersedia',  // ✅ TAMBAHKAN INI
  estimasi: product.estimasi || 'langsung_ambil'      // ✅ TAMBAHKAN INI
})
    }
    localStorage.setItem('cart', JSON.stringify(cart))
    router.push('/kasir/keranjang')
  } else {
    alert('Barcode tidak dikenali!')
  }

  // Reset buffer
  barcodeBuffer = ''
}
</script>

<style scoped>


/* Tag status umum */
.status-tag {
  position: absolute;
  top: 8px;
  right: 8px;
  padding: 4px 8px;
  border-radius: 4px;
  font-size: 0.75rem;
  font-weight: 600;
  text-transform: uppercase;
  z-index: 2;
}

/* ✅ Produk tersedia → hijau */
.status-tag {
  background: #015e21;
  color: #011801;
}

/* ✅ Produk habis → merah */
.status-habis {
  background: #fee2e2;
  color: #dc2626;
}

/* ✅ Pre-order → kuning */
.status-preorder {
  background: #fef9c3;
  color: #ca8a04;
}

.kasir-app {
  min-height: 100vh;
  background: #f8fafc;
  display: flex;
  flex-direction: column;
}

/* Header Styles */

.hidden {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  white-space: nowrap;
  border: 0;
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
  border-radius: 0.5rem;
  transition: background-color 0.3s ease;
}

.user-info:hover {
  background: #f8fafc;
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

/* Layout Styles */
.app-layout {
  display: flex;
  flex: 1;
  height: calc(100vh - 80px);
  overflow: hidden; /* 🔥 Penting! Biar main-content yang scroll */
}

/* Sidebar Styles */
.sidebar {
  position: fixed;
  top: 80px; /* Sesuaikan dengan tinggi header */
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

/* Main Content Styles */
.main-content {
  flex: 1;
  padding: 2rem;
  background: #f8fafc;
  overflow-y: auto; /* ✅ Ini yang bikin konten scroll, bukan seluruh halaman */
  margin-left: 16rem; /* ⚠️ Geser ke kanan agar tidak tertutup sidebar */
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

/* Product Grid Styles */
.product-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
  gap: 1.5rem;
}

.product-card {
  background: white;
  border-radius: 0.75rem;
  padding: 1.25rem;
  text-align: center;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  border: 1px solid #e2e8f0;
  transition: all 0.3s ease;
  cursor: pointer;
}

.product-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.1);
  border-color: #800000;
}

.card-image-container {
  position: relative;
  margin-bottom: 1rem;
  border-radius: 0.5rem;
  overflow: hidden;
}

.product-image {
  width: 100%;
  height: 100px;
  object-fit: cover;
  border-radius: 0.5rem;
  transition: transform 0.3s ease;
}

.product-card:hover .product-image {
  transform: scale(1.05);
}

.product-info {
  margin-bottom: 1rem;
}

.product-name {
  font-size: 0.875rem;
  font-weight: 600;
  color: #1a202c;
  margin: 0;
  line-height: 1.4;
}

.product-stock,
.product-price {
  font-size: 0.875rem;
  color: #555;
  margin: 4px 0;
}

.product-actions {
  display: flex;
  justify-content: center;
  gap: 0.5rem;
}

.action-btn {
  width: 2rem;
  height: 2rem;
  border: none;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.3s ease;
  color: white;
}

.edit-btn {
  background: #800000;
}

.edit-btn:hover {
  background: #990000;
  transform: scale(1.1);
}

.delete-btn {
  background: #dc2626;
}

.delete-btn:hover {
  background: #b91c1c;
  transform: scale(1.1);
}

.detail-btn {
  background: #6c757d;
}

.detail-btn:hover {
  background: #5a6268;
}

.cart-btn {
  background: #28a745;
}

.cart-btn:hover {
  background: #218838;
}

/* Add New Card */
.add-new-card {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  text-decoration: none;
  color: #64748b;
  border: 2px dashed #cbd5e1;
  border-radius: 0.75rem;
  min-height: 180px;
  transition: all 0.3s ease;
}

.add-new-card:hover {
  background: #fef2f2;
  border-color: #800000;
  color: #800000;
  transform: translateY(-4px);
}

.add-icon-container {
  width: 3rem;
  height: 3rem;
  border-radius: 50%;
  background: #fef2f2;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 0.75rem;
  transition: all 0.3s ease;
}

.add-new-card:hover .add-icon-container {
  background: #800000;
  color: white;
  transform: scale(1.1);
}

.add-text {
  font-size: 0.875rem;
  font-weight: 500;
}

/* Pagination */
.pagination {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 0.5rem;
}

.pagination button {
  font-size: 0.875rem;
  padding: 0.5rem 0.75rem;
  border: 1px solid #d1d5db;
  border-radius: 0.25rem;
  background: white;
  cursor: pointer;
  transition: all 0.2s;
}

.pagination button:hover:not(:disabled) {
  background: #f1f5f9;
}

.pagination button:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.pagination button.bg-blue-100 {
  background: #dbeafe;
  border-color: #3b82f6;
  color: #2563eb;
}

/* Modal Styles */
.modal-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
  padding: 1rem;
}

.modal-content {
  background: white;
  border-radius: 1rem;
  box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
  width: 100%;
  max-width: 28rem;
  max-height: 90vh;
  overflow-y: auto;
}

.modal-header {
  display: flex;
  justify-content: between;
  align-items: center;
  padding: 1.5rem 1.5rem 0;
}

.modal-title {
  font-size: 1.25rem;
  font-weight: 600;
  color: #1a202c;
  margin: 0;
}

.modal-close-btn {
  background: none;
  border: none;
  color: #64748b;
  cursor: pointer;
  padding: 0.5rem;
  border-radius: 0.375rem;
  transition: all 0.3s ease;
}

.modal-close-btn:hover {
  background: #f1f5f9;
  color: #374151;
}

.modal-body {
  padding: 1.5rem;
}

.image-preview-container {
  display: flex;
  justify-content: center;
  margin-bottom: 1.5rem;
}

.preview-image {
  width: 6rem;
  height: 6rem;
  object-fit: cover;
  border-radius: 0.5rem;
  border: 2px solid #e5e7eb;
}

.remove-image-btn {
  position: absolute;
  top: -0.5rem;
  right: -0.5rem;
  background: #dc2626;
  color: white;
  border: none;
  border-radius: 50%;
  width: 1.5rem;
  height: 1.5rem;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  font-size: 1rem;
  line-height: 1;
}

.form-group {
  margin-bottom: 1.5rem;
}

.form-label {
  display: block;
  font-size: 0.875rem;
  font-weight: 500;
  color: #374151;
  margin-bottom: 0.5rem;
}

.form-input {
  width: 100%;
  padding: 0.75rem;
  border: 1px solid #d1d5db;
  border-radius: 0.5rem;
  font-size: 0.875rem;
  transition: all 0.3s ease;
}

.form-input:focus {
  outline: none;
  border-color: #800000;
  box-shadow: 0 0 0 3px rgba(128, 0, 0, 0.1);
}

.file-input {
  width: 100%;
  font-size: 0.875rem;
}

.modal-footer {
  display: flex;
  justify-content: flex-end;
  gap: 0.75rem;
  padding: 0 1.5rem 1.5rem;
}

.btn-secondary {
  padding: 0.75rem 1.5rem;
  background: #f8fafc;
  color: #374151;
  border: 1px solid #d1d5db;
  border-radius: 0.5rem;
  font-size: 0.875rem;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.3s ease;
}

.btn-secondary:hover {
  background: #f1f5f9;
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
}

.btn-primary:hover {
  background: #990000;
  transform: scale(1.05);
}
</style>