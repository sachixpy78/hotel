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
            <h1 class="text-3xl font-bold mb-2 transition-all duration-300 hover:text-red-200">Flojachi</h1>
            <p class="text-white/90 text-lg transition-all duration-300 hover:text-white">Menyediakan Berbagai Macam Jasa Untuk Anda</p>
          </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="md:w-3/5 p-8 flex flex-col justify-center">
          <div class="max-w-md w-full mx-auto">
            <h2 class="text-2xl font-bold text-gray-800 mb-2 transition-all duration-300 hover:text-red-700">Masuk ke Akun</h2>
            <p class="text-gray-600 mb-6 transition-all duration-300 hover:text-gray-800">Silakan masuk untuk mengakses sistem</p>

            <!-- Role Selection -->
            <div class="mb-4">
              <select
                v-model="role"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all duration-300 hover:border-red-400 hover:shadow-md"
              >
                <option value="super_admin">Super Admin</option>
                <option value="kasir">Kasir</option>
              </select>
            </div>

            <!-- Login Form -->
            <form @submit.prevent="login" class="space-y-4">
              <div class="group">
                <input
                  v-model="form.email"
                  type="email"
                  placeholder="Email"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all duration-300 hover:border-red-400 hover:shadow-md group-hover:translate-x-1"
                  required
                />
              </div>

              <div class="group">
                <input
                  v-model="form.password"
                  type="password"
                  placeholder="Password"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all duration-300 hover:border-red-400 hover:shadow-md group-hover:translate-x-1"
                  required
                />
              </div>

              <div class="flex items-center justify-between">
                <label class="flex items-center group cursor-pointer">
                  <input type="checkbox" class="rounded border-gray-300 text-red-600 focus:ring-red-500 transition-all duration-300 hover:scale-110">
                  <span class="ml-2 text-sm text-gray-600 transition-all duration-300 group-hover:text-red-700">Ingat saya</span>
                </label>
           <NuxtLink 
  :to="role === 'super_admin' ? '/forgot' : '/forgot-kasir'" 
  class="text-sm text-red-600 hover:text-red-800 transition-all duration-300 hover:underline hover:font-medium"
>
  Lupa password?
</NuxtLink>
              </div>

              <button
                type="submit"
                class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-3 px-4 rounded-lg transition-all duration-300 shadow-sm hover:shadow-lg hover:scale-[1.02] active:scale-[0.98] transform"
              >
                Login
              </button>
            </form>

            <!-- Register Link -->
            <div v-if="role === 'kasir'" class="text-center mt-6 pt-6 border-t border-gray-200">
              <button
                @click="goToRegister"
                class="text-sm text-red-600 hover:text-red-800 font-medium transition-all duration-300 hover:underline hover:scale-105 transform"
              >
                Daftar akun kasir baru
              </button>
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
          <span class="text-gray-700 text-sm">Memproses login...</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue'
const router = useRouter()

const role = ref('super_admin')
const loading = ref(false)

const form = reactive({
  email: '',
  password: ''
})

const login = async () => {
  try {
    loading.value = true
    
    const res = await $fetch('http://localhost:8000/api/login', {
      method: 'POST',
      body: {
        email: form.email,
        password: form.password,
        level: role.value
      }
    })

    // SIMPAN DATA ADMIN KE LOCALSTORAGE
    localStorage.setItem('auth_token', res.token)
    localStorage.setItem('user_id', res.admin.id)
    localStorage.setItem('user_name', res.admin.username)
    localStorage.setItem('user_email', res.admin.email)
    localStorage.setItem('user_level', res.admin.level)
    localStorage.setItem('user_foto', res.admin.gambar)

    // REDIRECT SESUAI ROLE
    if (res.admin.level === 'super_admin') {
      router.push('/dashboard')
    } else {
      router.push('/kasir/kategori')
    }

  } catch (err) {
    alert(err?.data?.message || 'Login gagal!')
  } finally {
    loading.value = false
  }
}

const goToRegister = () => {
  router.push('/register')
}
</script>