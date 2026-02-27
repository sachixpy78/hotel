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
            <p class="text-white/90 text-lg transition-all duration-300 hover:text-white">Menyediakan Berbagai Macam Jasa Untuk Anda</p>
          </div>
        </div>

        <!-- Right Side - Reset Password Form -->
        <div class="md:w-3/5 p-8 flex flex-col justify-center">
          <div class="max-w-md w-full mx-auto">
            <h2 class="text-2xl font-bold text-gray-800 mb-2 transition-all duration-300 hover:text-red-700">Reset Password</h2>
            <p class="text-gray-600 mb-6 transition-all duration-300 hover:text-gray-800">Buat password baru untuk akun Anda</p>

            <!-- Reset Password Form -->
            <form @submit.prevent="savePassword" class="space-y-5">
              <!-- Email Display -->
              <div v-if="email" class="group">
                <label class="block text-sm font-medium text-gray-700 mb-2 transition-all duration-300 group-hover:text-red-700">Email</label>
                <div class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 transition-all duration-300">
                  <p class="text-gray-700"><b>{{ email }}</b></p>
                </div>
              </div>

              <!-- Phone Display -->
              <div v-if="phone" class="group">
                <label class="block text-sm font-medium text-gray-700 mb-2 transition-all duration-300 group-hover:text-red-700">Nomor WhatsApp</label>
                <div class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 transition-all duration-300">
                  <p class="text-gray-700"><b>{{ phone }}</b></p>
                </div>
              </div>

              <!-- New Password -->
              <div class="group">
                <label class="block text-sm font-medium text-gray-700 mb-2 transition-all duration-300 group-hover:text-red-700">Password Baru</label>
                <input
                  v-model="password"
                  type="password"
                  placeholder="Masukkan password baru"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all duration-300 hover:border-red-400 hover:shadow-md group-hover:translate-x-1"
                  required
                />
              </div>

              <button
                type="submit"
                class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-3 px-4 rounded-lg transition-all duration-300 shadow-sm hover:shadow-lg hover:scale-[1.02] active:scale-[0.98] transform"
              >
                Simpan Password
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
  </div>
</template>

<script setup>
import { ref } from 'vue'

const router = useRouter()
const route = useRoute()

// Ambil email atau phone dari query string
const email = route.query.email
const phone = route.query.phone
const password = ref('')

const savePassword = async () => {
  try {
    // Kirim data sesuai yang ada
    const payload = {
      password: password.value
    }

    if (email) {
      payload.email = email
    }
    if (phone) {
      payload.phone = phone
    }

    await $fetch("http://localhost:8000/api/reset-password", {
      method: "PUT",
      body: payload
    })

    alert("Password berhasil diubah!")
    router.push("/")

  } catch (err) {
    alert(err?.data?.message || "Gagal mengubah password.")
  }
}
</script>