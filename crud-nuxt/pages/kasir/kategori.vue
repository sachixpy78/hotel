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
          <h1 class="page-title">Kategori Produk</h1>
          <p class="page-subtitle">Kelola kategori produk toko</p>
        </div>

        <div class="category-grid">
          <div v-for="kat in kategoriList" :key="kat.id" class="category-card group">
            <div class="card-image-container">
              <img
                :src="kat.gambar ? `http://localhost:8000/storage/profile/${kat.gambar}` : '/placeholder.png'"
                :alt="kat.kategori"
                class="category-image"
                @error="handleImageError"
              />
              <div class="card-overlay">
                <div class="action-buttons">
                  <button @click.stop="editKategori(kat.id)" class="action-btn edit-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                  </button>
                  <button @click="hapusKategori(kat.id)" class="action-btn delete-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                  </button>
                </div>
              </div>
            </div>
            <h3 class="category-name">{{ kat.kategori }}</h3>
          </div>

          <router-link to="/kasir/tambahkat" class="category-card add-new-card group">
            <div class="add-icon-container">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
              </svg>
            </div>
            <span class="add-text">Tambah Kategori</span>
          </router-link>
        </div>
      </main>
    </div>

    <!-- Modal Edit Kategori -->
    <div v-if="showEditModal" class="modal-overlay">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title">Edit Kategori</h3>
          <button @click="closeEditModal" class="modal-close-btn">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>

        <div class="modal-body">
          <!-- Preview Gambar -->
          <div v-if="imagePreview || editingCategory.gambar" class="image-preview-container">
            <div class="relative inline-block">
              <img
                :src="imagePreview || `http://localhost:8000/storage/profile/${editingCategory.gambar}`"
                alt="Preview"
                class="preview-image"
              />
              <button
                @click="removePhoto"
                class="remove-image-btn"
              >
                &times;
              </button>
            </div>
          </div>

          <!-- Input Nama -->
          <div class="form-group">
            <label class="form-label">Nama Kategori</label>
            <input
              v-model="editingCategory.kategori"
              type="text"
              class="form-input"
              placeholder="Masukkan nama kategori"
            />
          </div>

          <!-- Input Gambar -->
          <div class="form-group">
            <label class="form-label">Ganti Gambar (opsional)</label>
            <input
              type="file"
              accept="image/*"
              @change="handleFileUpload"
              class="file-input"
            />
          </div>
        </div>

        <div class="modal-footer">
          <button @click="closeEditModal" class="btn-secondary">
            Batal
          </button>
          <button @click="submitEdit" class="btn-primary">
            Simpan Perubahan
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'DashboardKasir',
  data() {
    return {
      kategoriList: [],
      produkList: [],
      showDropdown: false,
      userName: 'Kasir',
      userAvatar: '/logo.jpg',
      showEditModal: false,
      editingCategory: {
        id: null,
        kategori: '',
        gambar: null
      },
      imagePreview: null,
      selectedFile: null
    }
  },
  mounted() {
    this.loadUserProfile();
    this.getKategori();
    this.getProduk();
    document.addEventListener('click', this.clickOutside);
  },
  beforeUnmount() {
    document.removeEventListener('click', this.clickOutside);
  },
  methods: {
    clickOutside(e) {
      if (this.showDropdown && !this.$refs.userDropdown.contains(e.target)) {
        this.showDropdown = false;
      }
    },
    toggleDropdown() {
      this.showDropdown = !this.showDropdown;
    },
    goToProfile() {
      this.showDropdown = false;
      this.$router.push('/kasir/profile');
    },
    logout() {
      if (confirm('Yakin mau logout?')) {
        if (typeof window !== 'undefined') {
          localStorage.clear()
        }
        this.$router.push('/')
      }
    },
    loadUserProfile() {
      const name = localStorage.getItem('user_name') || 'Kasir';
      const avatarPath = localStorage.getItem('user_foto');

      this.userName = name;
      this.userAvatar = avatarPath
        ? `http://localhost:8000/storage/profile/${avatarPath}`
        : '/login.png';
    },
    fallbackAvatar() {
      this.userAvatar = '/logo.jpg';
    },
    async getKategori() {
      try {
        const res = await fetch("http://localhost:8000/api/kategori");
        const data = await res.json();
        this.kategoriList = data.data || [];
      } catch (err) {
        console.error("Error:", err);
        alert('Gagal memuat kategori.');
      }
    },
    async getProduk() {
      try {
        const res = await fetch("http://localhost:8000/api/produk");
        const data = await res.json();
        this.produkList = data.data || [];
      } catch (err) {
        console.error("Gagal memuat produk:", err);
      }
    },
    getProdukByKategori(katId) {
      return this.produkList.some(produk => produk.fid_kategori == katId);
    },
    editKategori(id) {
      const kat = this.kategoriList.find(k => k.id === id);
      if (kat) {
        this.editingCategory = { ...kat };
        this.imagePreview = kat.gambar ? `http://localhost:8000/storage/profile/${kat.gambar}` : null;
        this.selectedFile = null;
        this.showEditModal = true;
      }
    },
    async hapusKategori(id) {
      if (!confirm('Yakin hapus kategori ini?')) return;
      const hasProduk = this.getProdukByKategori(id);
      if (hasProduk) {
        alert('Tidak bisa dihapus! Kategori ini masih digunakan oleh produk.');
        return;
      }

      try {
        const res = await fetch(`http://localhost:8000/api/kategori/${id}`, { method: 'DELETE' });
        if (res.ok) {
          this.kategoriList = this.kategoriList.filter(k => k.id !== id);
          alert('Kategori berhasil dihapus!');
        } else {
          alert('Gagal menghapus kategori.');
        }
      } catch (err) {
        console.error('Error hapus:', err);
        alert('Gagal menghapus kategori.');
      }
    },
    handleFileUpload(event) {
      const file = event.target.files[0];
      if (file) {
        this.selectedFile = file;
        const reader = new FileReader();
        reader.onload = (e) => {
          this.imagePreview = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    },
    removePhoto() {
      this.selectedFile = null;
      this.imagePreview = null;
    },
    async submitEdit() {
      const isDuplicate = this.kategoriList.some(kat => 
        kat.id !== this.editingCategory.id && 
        kat.kategori.toLowerCase() === this.editingCategory.kategori.toLowerCase()
      );
      if (isDuplicate) {
        alert('Nama kategori sudah ada!');
        return;
      }

      const formData = new FormData();
      formData.append('kategori', this.editingCategory.kategori);
      if (this.selectedFile) {
        formData.append('gambar', this.selectedFile);
      }
      formData.append('_method', 'PUT');

      try {
        const response = await fetch(`http://localhost:8000/api/kategori/${this.editingCategory.id}`, {
          method: 'POST',
          body: formData
        });

        if (response.ok) {
          alert('Kategori berhasil diperbarui!');
          this.getKategori();
          this.closeEditModal();
        } else {
          const errorData = await response.json().catch(() => ({}));
          alert(errorData.message || 'Gagal memperbarui kategori.');
        }
      } catch (err) {
        console.error('Error:', err);
        alert('Terjadi kesalahan.');
      }
    },
    closeEditModal() {
      this.showEditModal = false;
      this.selectedFile = null;
      this.imagePreview = null;
    },
    handleImageError(e) {
      e.target.src = '/placeholder.png';
    }
  }
}
</script>

<style scoped>
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
  transition: background-color 0.3s ease;
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
  overflow: hidden; /* 🔥 Penting! */
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
  overflow-y: auto; /* ✅ Hanya konten yang scroll */
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

/* Category Grid Styles */
.category-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
  gap: 1.5rem;
}

.category-card {
  background: white;
  border-radius: 0.75rem;
  padding: 1.25rem;
  text-align: center;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  border: 1px solid #e2e8f0;
  transition: all 0.3s ease;
  cursor: pointer;
}

.category-card:hover {
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

.category-image {
  width: 100%;
  height: 100px;
  object-fit: cover;
  border-radius: 0.5rem;
  transition: transform 0.3s ease;
}

.category-card:hover .category-image {
  transform: scale(1.05);
}

.card-overlay {
  position: absolute;
  inset: 0;
  background: rgba(0, 0, 0, 0.7);
  display: flex;
  align-items: center;
  justify-content: center;
  opacity: 0;
  transition: opacity 0.3s ease;
}

.category-card:hover .card-overlay {
  opacity: 1;
}

.action-buttons {
  display: flex;
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

.category-name {
  font-size: 0.875rem;
  font-weight: 600;
  color: #1a202c;
  margin: 0;
  line-height: 1.4;
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