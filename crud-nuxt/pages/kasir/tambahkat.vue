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
        <router-link to="/kasir/transaksi/keranjang" class="cart-icon">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#007bff" stroke-width="2">
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
      <!-- Sidebar -->
      <aside class="sidebar">
        <nav>
          <router-link to="/kasir/kategori" exact class="menu-item">
            <span class="icon">📁</span> <span>Kategori</span>
          </router-link>
          <router-link to="/kasir/produk" class="menu-item">
            <span class="icon">🛍</span> <span>Produk</span>
          </router-link>
          <router-link to="/kasir/transaksi/" class="menu-item">
            <span class="icon">💰</span> <span>Transaksi</span>
          </router-link>
          <router-link to="/kasir/laporantu" class="menu-item">
            <span class="icon">📊</span> <span>Laporan</span>
          </router-link>
        </nav>
      </aside>

      <!-- Konten -->
      <main class="main-content">
        <h2>Tambah Kategori</h2>
        <div class="add-category-form">
          <div class="form-group">
            <label>Nama Kategori</label>
            <input
              v-model="newCategory.kategori"
              type="text"
              placeholder="Contoh: Poster, Banner, Logo"
              class="form-input"
            />
          </div>

          <div class="form-group">
            <label>Foto Kategori</label>
            <div class="image-preview-container">
              <div v-if="imagePreview" class="image-preview">
                <img :src="imagePreview" alt="Preview" class="preview-image" />
                <button @click="removePhoto" class="remove-btn">×</button>
              </div>
              <input
                type="file"
                accept="image/*"
                @change="handleFileUpload"
                class="file-input"
              />
            </div>
          </div>

          <div class="form-actions">
            <button @click="goBack" class="btn btn-secondary">Batal</button>
            <button @click="submitCategory" class="btn btn-primary">Simpan</button>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

// Data
const newCategory = ref({
  kategori: '',
  gambar: null
})
const imagePreview = ref(null)
const selectedFile = ref(null)
const kategoriList = ref([]) // ✅ Tambahkan ini

// User Info
const userName = ref('Kasir')
const userAvatar = ref('/logo.jpg')

// Ref untuk dropdown
const userDropdown = ref(null)
const showDropdown = ref(false)

// Load User Profile
function loadUserProfile() {
  const name = localStorage.getItem('user_name') || 'Kasir'
  const avatarPath = localStorage.getItem('user_foto')

  userName.value = name
  userAvatar.value = avatarPath
    ? `http://localhost:8000/storage/profile/${avatarPath}`
    : '/login.png'
}

// ✅ Ambil semua kategori saat load
async function getKategori() {
  try {
    const res = await fetch("http://localhost:8000/api/kategori");
    const data = await res.json();
    kategoriList.value = data.data || [];
  } catch (err) {
    console.error("Gagal memuat kategori:", err);
  }
}

// Handle File Upload
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

function removePhoto() {
  selectedFile.value = null
  imagePreview.value = null
}

function goBack() {
  router.push('/kasir/kategori')
}

async function submitCategory() {
  const kategoriInput = newCategory.value.kategori.trim()
  if (!kategoriInput) {
    alert('Nama kategori wajib diisi!')
    return
  }

  // ✅ CEK DUPLIKAT
  const isDuplicate = kategoriList.value.some(kat => 
    kat.kategori.toLowerCase() === kategoriInput.toLowerCase()
  )

  if (isDuplicate) {
    alert('Nama kategori sudah ada!')
    return
  }

  const formData = new FormData()
  formData.append('kategori', kategoriInput)

  if (selectedFile.value) {
    formData.append('gambar', selectedFile.value)
  }

  try {
    const res = await fetch('http://localhost:8000/api/kategori', {
      method: 'POST',
      body: formData
    })

    if (res.ok) {
      alert('Kategori berhasil ditambahkan!')
      router.push('/kasir/kategori')
    } else {
      const errorData = await res.json().catch(() => ({}))
      alert(errorData.message || 'Gagal menambah kategori. Cek nama & gambar.')
    }
  } catch (err) {
    console.error('Error saat tambah kategori:', err)
    alert('Terjadi kesalahan: pastikan server Laravel berjalan di port 8000.')
  }
}

// Dropdown Functions
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

function fallbackAvatar() {
  userAvatar.value = '/logo.jpg'
}

// On Mounted
onMounted(() => {
  loadUserProfile()
  getKategori() // ✅ Tambahkan ini
})
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

.sidebar {
  width: 200px;
  background: white;
  border-right: 1px solid #eee;
  padding: 20px 0;
  height: 100%;
  overflow-y: auto;
}

.sidebar .menu-item {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 12px 20px;
  color: #555;
  text-decoration: none;
  font-weight: 500;
}

.sidebar .menu-item:hover,
.sidebar .menu-item.router-link-active {
  background: #e6f7ff;
  color: #007bff;
}

.main-content {
  flex: 1;
  padding: 24px;
  background: white;
  overflow-y: auto;
}

.main-content h2 {
  margin-top: 0;
  font-size: 24px;
  color: #333;
}

.add-category-form {
  max-width: 500px;
  margin: 0 auto;
  padding: 20px;
  background: white;
  border-radius: 12px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.05);
}

.form-group {
  margin-bottom: 20px;
}

.form-group label {
  display: block;
  font-size: 14px;
  font-weight: 500;
  color: #333;
  margin-bottom: 8px;
}

.form-input {
  width: 100%;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 6px;
  font-size: 14px;
  outline: none;
  transition: border-color 0.2s;
}

.form-input:focus {
  border-color: #007bff;
}

.image-preview-container {
  position: relative;
  border: 1px dashed #ccc;
  border-radius: 6px;
  padding: 10px;
  text-align: center;
  cursor: pointer;
  transition: border-color 0.2s;
}

.image-preview-container:hover {
  border-color: #007bff;
}

.image-preview {
  position: relative;
  width: 100%;
  height: 150px;
  overflow: hidden;
  border-radius: 6px;
  margin-bottom: 10px;
  background: #f0f0f0;
}

.preview-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.remove-btn {
  position: absolute;
  top: 4px;
  right: 4px;
  background: red;
  color: white;
  border: none;
  border-radius: 50%;
  width: 24px;
  height: 24px;
  font-size: 14px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
}

.file-input {
  width: 100%;
  padding: 8px;
  border: none;
  background: transparent;
  font-size: 14px;
  color: #555;
  cursor: pointer;
}

.file-input::file-selector-button {
  display: none;
}

.form-actions {
  display: flex;
  justify-content: flex-end;
  gap: 10px;
  margin-top: 20px;
}

.btn {
  padding: 10px 20px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-size: 14px;
  font-weight: 500;
  transition: background-color 0.2s;
}

.btn-secondary {
  background: #e0e0e0;
  color: #333;
}

.btn-secondary:hover {
  background: #d0d0d0;
}

.btn-primary {
  background: #007bff;
  color: white;
}

.btn-primary:hover {
  background: #0056b3;
}
</style>