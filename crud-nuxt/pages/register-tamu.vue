<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-gray-100 flex items-center justify-center p-4 py-8">
    <!-- Background Pattern -->
    <div class="absolute inset-0 bg-grid-pattern opacity-30"></div>
    
    <div class="relative w-full max-w-5xl bg-white/95 backdrop-blur-sm rounded-2xl shadow-2xl overflow-hidden flex flex-col lg:flex-row">
      
      <!-- BAGIAN KIRI: FORM -->
      <div class="w-full lg:w-1/2 p-6 md:p-10">
        <!-- Header -->
        <div class="mb-8">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
              </svg>
            </div>
            <div>
              <h2 class="text-2xl font-bold text-gray-800">Daftar sebagai Tamu</h2>
              <p class="text-xs text-green-600 font-medium">✨ Akun langsung aktif</p>
            </div>
          </div>
          <p class="text-gray-500 text-sm">Lengkapi data berikut untuk membuat akun tamu</p>
        </div>

        <form @submit.prevent="register" class="space-y-5">
          
          <!-- Upload Foto Profil -->
          <div class="flex justify-center mb-6">
            <div class="relative group">
              <div class="w-32 h-32 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center overflow-hidden border-4 border-white shadow-lg ring-4 ring-green-100 group-hover:ring-green-300 transition-all duration-300">
                <img
                  v-if="form.profileImage"
                  :src="form.profileImage"
                  alt="Foto Profil"
                  class="w-full h-full object-cover"
                />
                <span v-else class="text-gray-400 text-5xl">👤</span>
              </div>
              <label
                for="profile-upload"
                class="absolute bottom-0 right-0 w-10 h-10 bg-green-600 hover:bg-green-700 rounded-full flex items-center justify-center cursor-pointer shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-110"
                title="Ubah foto profil"
              >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
              </label>
              <input
                id="profile-upload"
                type="file"
                accept="image/*"
                class="hidden"
                @change="handleImageUpload"
              />
            </div>
          </div>

          <!-- Username & Email -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-1.5">Username <span class="text-red-500">*</span></label>
              <div class="relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                  </svg>
                </span>
                <input
                  v-model="form.username"
                  type="text"
                  required
                  placeholder="johndoe"
                  class="w-full pl-11 pr-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-green-100 focus:border-green-500 outline-none transition-all duration-200 hover:border-gray-300"
                />
              </div>
            </div>
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email <span class="text-red-500">*</span></label>
              <div class="relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                  </svg>
                </span>
                <input
                  v-model="form.email"
                  type="email"
                  required
                  placeholder="email@contoh.com"
                  class="w-full pl-11 pr-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-green-100 focus:border-green-500 outline-none transition-all duration-200 hover:border-gray-300"
                />
              </div>
            </div>
          </div>

          <!-- No Telepon -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">No. Telepon <span class="text-gray-400 font-normal">(Opsional)</span></label>
            <div class="relative">
              <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
              </span>
              <input
                v-model="form.no_telp"
                type="tel"
                placeholder="0812 3456 7890"
                maxlength="13"
                class="w-full pl-11 pr-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-green-100 focus:border-green-500 outline-none transition-all duration-200 hover:border-gray-300"
              />
            </div>
          </div>

          <!-- Alamat -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Alamat <span class="text-red-500">*</span></label>
            <div class="relative">
              <span class="absolute left-4 top-4 text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
              </span>
              <textarea
                v-model="form.alamat"
                rows="3"
                required
                placeholder="Jl. Contoh No. 123, Kota, Provinsi"
                class="w-full pl-11 pr-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-green-100 focus:border-green-500 outline-none transition-all duration-200 hover:border-gray-300 resize-none"
              ></textarea>
            </div>
          </div>

          <!-- Password & Konfirmasi -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password <span class="text-red-500">*</span></label>
              <div class="relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                  </svg>
                </span>
                <input
                  v-model="form.password"
                  :type="showPassword ? 'text' : 'password'"
                  required
                  minlength="5"
                  placeholder="••••••••"
                  class="w-full pl-11 pr-10 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-green-100 focus:border-green-500 outline-none transition-all duration-200 hover:border-gray-300"
                />
                <button type="button" @click="showPassword = !showPassword" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                  <svg v-if="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                  </svg>
                  <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                  </svg>
                </button>
              </div>
              <p class="text-xs text-gray-400 mt-1">Minimal 5 karakter</p>
            </div>
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-1.5">Konfirmasi <span class="text-red-500">*</span></label>
              <div class="relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                  </svg>
                </span>
                <input
                  v-model="form.confirmPassword"
                  :type="showConfirmPassword ? 'text' : 'password'"
                  required
                  minlength="5"
                  placeholder="••••••••"
                  class="w-full pl-11 pr-10 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-green-100 focus:border-green-500 outline-none transition-all duration-200 hover:border-gray-300"
                  :class="{'border-red-400 focus:border-red-500 focus:ring-red-100': form.confirmPassword && form.password !== form.confirmPassword}"
                />
                <button type="button" @click="showConfirmPassword = !showConfirmPassword" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                  <svg v-if="!showConfirmPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                  </svg>
                  <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                  </svg>
                </button>
              </div>
              <p v-if="form.confirmPassword && form.password !== form.confirmPassword" class="text-xs text-red-500 mt-1">❌ Password tidak cocok</p>
              <p v-else-if="form.confirmPassword" class="text-xs text-green-500 mt-1">✅ Password cocok</p>
            </div>
          </div>

          <!-- TOMBOL DAFTAR -->
          <div class="pt-6">
            <button
              type="submit"
              :disabled="loading"
              class="w-full bg-gradient-to-r from-green-600 via-green-700 to-emerald-700 hover:from-green-700 hover:via-green-800 hover:to-emerald-800 disabled:from-gray-300 disabled:via-gray-400 disabled:to-gray-500 text-white font-bold py-4 px-6 rounded-xl transition-all duration-300 transform hover:scale-[1.02] hover:shadow-xl disabled:scale-100 disabled:shadow-none disabled:cursor-not-allowed flex items-center justify-center gap-2"
            >
              <span v-if="loading">
                <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
              </span>
              <span v-else>✨</span>
              {{ loading ? 'Memproses...' : 'Daftar sebagai Tamu' }}
            </button>
          </div>

          <!-- Link Login -->
          <div class="text-center pt-4 pb-2">
            <p class="text-sm text-gray-500">
              Sudah punya akun? 
              <button type="button" @click="goToLogin" class="text-green-600 font-semibold hover:text-green-800 hover:underline transition-colors">
                Login di sini →
              </button>
            </p>
          </div>
        </form>
      </div>

      <!-- BAGIAN KANAN: ILLUSTRASI -->
      <div class="hidden lg:flex w-1/2 bg-gradient-to-br from-green-600 to-emerald-700 p-10 items-center justify-center relative overflow-hidden">
        <div class="absolute top-10 left-10 w-20 h-20 bg-white/10 rounded-full blur-xl"></div>
        <div class="absolute bottom-20 right-10 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
        <div class="absolute top-1/2 left-1/4 w-16 h-16 bg-white/5 rounded-full blur-lg animate-pulse"></div>
        
        <div class="relative z-10 text-center text-white max-w-sm">
          <div class="mb-8">
            <div class="w-24 h-24 mx-auto bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center mb-6 shadow-lg">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 11c0 3.517-1.009 6.799-2.753 9.14.144-.02.289-.03.435-.03 3.317 0 6.01-2.693 6.01-6s-2.693-6-6.01-6c-.146 0-.291.01-.435.03C10.991 17.799 12 14.517 12 11z" />
              </svg>
            </div>
          </div>
          <h3 class="text-2xl font-bold mb-4">Akun Tamu 🎉</h3>
          <p class="text-green-100 text-sm leading-relaxed mb-6">
            Daftar sebagai tamu untuk akses dasar. Akun langsung aktif tanpa verifikasi!
          </p>
          
          <div class="space-y-3 text-left">
            <div class="flex items-center gap-3">
              <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
              </div>
              <span class="text-sm text-green-100">Aktif langsung setelah daftar</span>
            </div>
            <div class="flex items-center gap-3">
              <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
              </div>
              <span class="text-sm text-green-100">Akses fitur dasar</span>
            </div>
            <div class="flex items-center gap-3">
              <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
              </div>
              <span class="text-sm text-green-100">Bisa upgrade ke resepsionis nanti</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- MODAL SUKSES -->
  <Transition name="modal">
    <div v-if="showPopup" class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4 z-50" @click.self="closePopup">
      <div class="bg-white rounded-3xl shadow-2xl p-8 max-w-md w-full text-center transform transition-all scale-100 hover:scale-[1.01]">
        <div class="relative w-24 h-24 mx-auto mb-6">
          <div class="absolute inset-0 bg-green-100 rounded-full animate-ping opacity-75"></div>
          <div class="relative w-full h-full bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
            </svg>
          </div>
        </div>
        
        <h3 class="text-2xl font-bold text-gray-800 mb-3">🎉 Pendaftaran Berhasil!</h3>
        <p class="text-gray-600 mb-8 leading-relaxed">
          Akun tamu Anda sudah aktif! Silakan login untuk mulai menjelajahi.
        </p>
        
        <button @click="closePopup" class="w-full bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold py-3.5 px-8 rounded-xl transition-all duration-200 transform hover:scale-[1.02] shadow-lg hover:shadow-xl">
          ✓ Lanjut ke Login
        </button>
        
        <p class="text-xs text-gray-400 mt-4">Redirect otomatis dalam 5 detik...</p>
      </div>
    </div>
  </Transition>
</template>

<script setup>
import { reactive, ref } from "vue"
import { useRouter } from "vue-router"

const router = useRouter()
const loading = ref(false)
const showPassword = ref(false)
const showConfirmPassword = ref(false)
const showPopup = ref(false)

const form = reactive({
  username: "",
  email: "",
  no_telp: "",
  alamat: "",
  password: "",
  confirmPassword: "",
  level: "tamu", // ✅ HARDCODE: Tamu
  profileImage: null,
  imageFile: null
})

const handleImageUpload = (event) => {
  const file = event.target.files[0]
  if (file) {
    if (file.size > 2 * 1024 * 1024) {
      alert('⚠️ Ukuran file terlalu besar. Maksimal 2MB')
      return
    }
    if (!file.type.startsWith('image/')) {
      alert('⚠️ File harus berupa gambar (JPG, PNG, GIF)')
      return
    }
    form.profileImage = URL.createObjectURL(file)
    form.imageFile = file
  }
}

const register = async () => {
  if (!form.username || !form.email || !form.password || !form.alamat) {
    alert('⚠️ Mohon lengkapi semua field yang wajib diisi')
    return
  }

  if (form.password !== form.confirmPassword) {
    alert('⚠️ Password dan konfirmasi password tidak cocok!')
    return
  }

  if (form.password.length < 5) {
    alert('⚠️ Password minimal 5 karakter')
    return
  }

  loading.value = true

  try {
    const formData = new FormData()
    formData.append('username', form.username)
    formData.append('email', form.email)
    formData.append('no_telp', form.no_telp || '')
    formData.append('alamat', form.alamat)
    formData.append('password', form.password)
    formData.append('password_confirmation', form.confirmPassword)
    formData.append('level', form.level) // ✅ Level sudah hardcoded: 'tamu'
    
    if (form.imageFile) {
      formData.append('gambar', form.imageFile)
    }

    const response = await $fetch('http://localhost:8000/api/register', {
      method: 'POST',
      headers: { 'Accept': 'application/json' },
      body: formData
    })

    if (response.success) {
      showPopup.value = true
      setTimeout(() => closePopup(), 5000)
      // Reset form
      Object.assign(form, {
        username: "", email: "", no_telp: "", alamat: "",
        password: "", confirmPassword: "", profileImage: null, imageFile: null
      })
    } else {
      alert('❌ ' + (response.message || 'Gagal mendaftar'))
    }

  } catch (err) {
    console.error('Error:', err)
    if (err.response?._data?.errors) {
      const errors = err.response._data.errors
      const firstError = Object.values(errors)[0]
      alert('❌ ' + (Array.isArray(firstError) ? firstError[0] : firstError))
    } else {
      alert('❌ ' + (err?.data?.message || err?.response?._data?.message || 'Gagal koneksi ke server'))
    }
  } finally {
    loading.value = false
  }
}

const closePopup = () => {
  showPopup.value = false
  router.push("/")
}

const goToLogin = () => {
  router.push("/")
}
</script>

<style scoped>
.bg-grid-pattern {
  background-image: url("image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}
.modal-enter-active, .modal-leave-active { transition: all 0.3s ease; }
.modal-enter-from, .modal-leave-to { opacity: 0; }
.modal-enter-from .bg-white, .modal-leave-to .bg-white { transform: scale(0.95) translateY(20px); }
textarea::-webkit-scrollbar { width: 6px; }
textarea::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 3px; }
textarea::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
textarea::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
input:focus, textarea:focus, select:focus { box-shadow: 0 0 0 4px rgba(34, 197, 94, 0.15); }
button[type="button"] { transition: transform 0.2s ease; }
button[type="button"]:hover { transform: scale(1.1); }
</style>