<template>
  <div class="min-h-screen bg-gradient-to-br from-red-50 to-red-100 flex items-center justify-center p-4">
    <div class="w-full max-w-4xl bg-white rounded-2xl shadow-lg overflow-hidden transition-all duration-500 hover:shadow-2xl hover:scale-[1.02]">
      <div class="flex flex-col md:flex-row">
        <!-- Left Side - Brand Section dengan Video Background -->
        <div class="md:w-2/5 relative h-64 md:h-auto group overflow-hidden">
          <video 
            class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" 
            autoplay 
            muted 
            loop
            playsinline
          >
            <source src="/ko.mp4" type="video/mp4">
            Your browser does not support the video tag.
          </video>
          <!-- Overlay untuk membuat teks lebih terbaca -->
          <div class="absolute inset-0 bg-black bg-opacity-40 transition-all duration-500 group-hover:bg-opacity-30"></div>
          <div class="relative z-10 p-8 flex flex-col justify-center h-full text-white">
            <div class="w-16 h-16 bg-white/20 rounded-xl flex items-center justify-center mb-6 transition-all duration-300 hover:bg-white/30 hover:scale-110 hover:rotate-12">
              <span class="text-white font-bold text-2xl transition-transform duration-300 hover:scale-110">F</span>
            </div>
            <h1 class="text-3xl font-bold mb-2 transition-all duration-300 hover:text-red-200">Kasir Flojachi</h1>
            <p class="text-white/90 text-lg transition-all duration-300 hover:text-white">Bergabung menjadi bagian kami</p>
          </div>
        </div>

        <!-- Right Side - Register Form -->
        <div class="md:w-3/5 p-6 flex flex-col justify-center">
          <div class="max-w-md w-full mx-auto">
            <h2 class="text-2xl font-bold text-gray-800 mb-4 transition-all duration-300 hover:text-red-700">Daftar Akun Baru</h2>

            <!-- Register Form -->
            <form class="space-y-4">
              <!-- Upload Foto Profil -->
              <div class="flex flex-col items-center group">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-2 transition-all duration-300 hover:bg-gray-200 hover:scale-110 border-2 border-dashed border-gray-300 hover:border-red-400 cursor-pointer" @click="$refs.profileUpload.click()">
                  <img v-if="profileImage" :src="profileImage" alt="Foto Profil" class="w-full h-full object-cover rounded-full" />
                  <span v-else class="text-gray-400 text-xl transition-all duration-300 group-hover:text-red-500">👤</span>
                </div>
                <label for="profile-upload" class="text-sm text-red-600 hover:text-red-800 cursor-pointer transition-all duration-300 hover:underline">
                  Unggah Foto Profil
                </label>
                <input
                  id="profile-upload"
                  ref="profileUpload"
                  type="file"
                  accept="image/*"
                  @change="handleImageUpload"
                  class="hidden"
                />
              </div>

              <!-- Email -->
              <div class="group">
                <label class="block text-sm font-medium text-gray-700 mb-2 transition-all duration-300 group-hover:text-red-700">Email</label>
                <input
                  v-model="form.email"
                  type="email"
                  placeholder="contoh@email.com"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all duration-300 hover:border-red-400 hover:shadow-md group-hover:translate-x-1"
                  required
                />
              </div>

              <!-- Username -->
              <div class="group">
                <label class="block text-sm font-medium text-gray-700 mb-2 transition-all duration-300 group-hover:text-red-700">Username</label>
                <input
                  v-model="form.username"
                  type="text"
                  placeholder="Masukkan username"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all duration-300 hover:border-red-400 hover:shadow-md group-hover:translate-x-1"
                  required
                />
              </div>

              <!-- Password -->
              <div class="group">
                <label class="block text-sm font-medium text-gray-700 mb-2 transition-all duration-300 group-hover:text-red-700">Password</label>
                <input
                  v-model="form.password"
                  type="password"
                  placeholder="Minimal 8 karakter"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all duration-300 hover:border-red-400 hover:shadow-md group-hover:translate-x-1"
                  minlength="8"
                  required
                />
              </div>

              <!-- Status (Kasir) -->
              <div class="group">
                <label class="block text-sm font-medium text-gray-700 mb-2 transition-all duration-300 group-hover:text-red-700">Status</label>
                <select
                  v-model="form.status"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all duration-300 hover:border-red-400 hover:shadow-md bg-gray-50"
                  disabled
                >
                  <option value="kasir">Kasir</option>
                </select>
                <p class="text-xs text-gray-500 mt-1 transition-all duration-300 group-hover:text-gray-700">*Hanya bisa daftar sebagai Kasir</p>
              </div>

              <button
                @click="register"
                type="button"
                class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-3 px-4 rounded-lg transition-all duration-300 shadow-sm hover:shadow-lg hover:scale-[1.02] active:scale-[0.98] transform"
              >
                Daftar Sekarang
              </button>
            </form>

            <!-- Back to Login Link -->
            <div class="text-center mt-6 pt-6 border-t border-gray-200">
              <NuxtLink 
                to="/" 
                class="text-sm text-red-600 hover:text-red-800 font-medium transition-all duration-300 hover:underline hover:scale-105 transform inline-flex items-center gap-1"
              >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Login
              </NuxtLink>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Loading Overlay -->
    <div v-if="loading" class="fixed inset-0 bg-black/40 flex items-center justify-center z-50 backdrop-blur-sm">
      <div class="bg-white rounded-lg p-6 shadow-2xl border border-gray-200 transition-all duration-300 hover:scale-105">
        <div class="flex items-center gap-3">
          <div class="w-5 h-5 border-2 border-red-600 border-t-transparent rounded-full animate-spin"></div>
          <span class="text-gray-700 text-sm">Mendaftarkan akun...</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue'
import { useRouter } from 'vue-router'

const form = reactive({
  email: '',
  username: '',
  password: '',
  status: 'kasir'
})

const router = useRouter()
const profileImage = ref(null)
const loading = ref(false)
let imageFile = null

// HANDLE IMAGE UPLOAD
const handleImageUpload = (event) => {
  const file = event.target.files[0]
  if (file) {
    profileImage.value = URL.createObjectURL(file)
    imageFile = file
  }
}

// REGISTER
const register = async () => {
  try {
    loading.value = true
    
    const formData = new FormData()
    formData.append('email', form.email)
    formData.append('username', form.username)
    formData.append('password', form.password)
    formData.append('level', 'kasir')
    formData.append('status', 'off')
    if (imageFile) {
      formData.append('gambar', imageFile)
    }

    const response = await $fetch('http://localhost:8000/api/register', {
      method: 'POST',
      body: formData
    })

    alert('Berhasil Mendaftar! Silakan hubungi operator untuk diverifikasi.')
    router.push('/')

  } catch (err) {
    console.error('Error:', err)
    alert(err?.data?.message || 'Gagal mendaftar. Silakan coba lagi.')
  } finally {
    loading.value = false
  }
}
</script>