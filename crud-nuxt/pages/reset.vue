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

        <!-- Right Side - Reset Password Form -->
        <div class="md:w-3/5 p-8 flex flex-col justify-center">
          <div class="max-w-md w-full mx-auto">
            <h2 class="text-2xl font-bold text-gray-800 mb-2 transition-all duration-300 hover:text-red-700">Reset Password</h2>
            <p class="text-gray-600 mb-6 transition-all duration-300 hover:text-gray-800">Buat password baru untuk akun Anda</p>

            <!-- Reset Password Form -->
            <form @submit.prevent="savePassword" class="space-y-5">
              
              <!-- Email Display (Read Only) -->
              <div v-if="email" class="group">
                <label class="block text-sm font-medium text-gray-700 mb-2 transition-all duration-300 group-hover:text-red-700">Email</label>
                <div class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 transition-all duration-300">
                  <p class="text-gray-700 font-medium">{{ email }}</p>
                </div>
              </div>

              <!-- No Telp Display (Read Only) -->
              <div v-else-if="noTelp" class="group">
                <label class="block text-sm font-medium text-gray-700 mb-2 transition-all duration-300 group-hover:text-red-700">Nomor WhatsApp</label>
                <div class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 transition-all duration-300">
                  <p class="text-gray-700 font-medium">{{ noTelp }}</p>
                </div>
              </div>

              <!-- New Password -->
              <div class="group">
                <label class="block text-sm font-medium text-gray-700 mb-2 transition-all duration-300 group-hover:text-red-700">
                  Password Baru <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                  <input
                    v-model="password"
                    :type="showPassword ? 'text' : 'password'"
                    placeholder="Minimal 5 karakter"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all duration-300 hover:border-red-400 hover:shadow-md pr-10"
                    required
                    minlength="5"
                  />
                  <button
                    type="button"
                    @click="showPassword = !showPassword"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
                  >
                    <svg v-if="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                  </button>
                </div>
              </div>

              <!-- Confirm Password -->
              <div class="group">
                <label class="block text-sm font-medium text-gray-700 mb-2 transition-all duration-300 group-hover:text-red-700">
                  Konfirmasi Password <span class="text-red-500">*</span>
                </label>
                <input
                  v-model="passwordConfirmation"
                  type="password"
                  placeholder="Ulangi password baru"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all duration-300 hover:border-red-400 hover:shadow-md"
                  :class="{'border-red-500': passwordConfirmation && password !== passwordConfirmation}"
                  required
                  minlength="5"
                />
                <p v-if="passwordConfirmation && password !== passwordConfirmation" class="text-xs text-red-500 mt-1">❌ Password tidak cocok</p>
                <p v-else-if="passwordConfirmation" class="text-xs text-green-500 mt-1">✅ Password cocok</p>
              </div>

              <button
                type="submit"
                :disabled="loading || !isFormValid"
                class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-3 px-4 rounded-lg transition-all duration-300 shadow-sm hover:shadow-lg hover:scale-[1.02] active:scale-[0.98] transform disabled:opacity-70 disabled:cursor-not-allowed disabled:hover:scale-100"
              >
                {{ loading ? 'Memproses...' : 'Simpan Password' }}
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
import { ref, computed } from 'vue'
import { useRouter, useRoute } from 'vue-router'

const router = useRouter()
const route = useRoute()

// ✅ Ambil email atau no_telp dari query string
const email = ref(route.query.email || '')
const noTelp = ref(route.query.no_telp || '')

const password = ref('')
const passwordConfirmation = ref('')
const showPassword = ref(false)
const loading = ref(false)

// ✅ Validasi form
const isFormValid = computed(() => {
  return password.value.length >= 5 && 
         password.value === passwordConfirmation.value
})

// ✅ Simpan password baru
const savePassword = async () => {
  // Validasi client-side
  if (!email.value && !noTelp.value) {
    alert('⚠️ Data akun tidak ditemukan. Silakan ulangi proses forgot password.')
    router.push('/forgot')
    return
  }
  
  if (password.value.length < 5) {
    alert('⚠️ Password minimal 5 karakter')
    return
  }
  
  if (password.value !== passwordConfirmation.value) {
    alert('⚠️ Konfirmasi password tidak cocok')
    return
  }

  try {
    loading.value = true

    // ✅ Payload sesuai backend: email/no_telp + password + password_confirmation
    const payload = {
      password: password.value,
      password_confirmation: passwordConfirmation.value
    }

    // Tambahkan identifier yang sesuai
    if (email.value) {
      payload.email = email.value
    }
    if (noTelp.value) {
      payload.no_telp = noTelp.value
    }

    const response = await $fetch("http://localhost:8000/api/reset-password", {
      method: "PUT",
      body: payload
    })

    if (response.success) {
      alert("✅ Password berhasil diubah! Silakan login dengan password baru.")
      router.push("/")
    }

  } catch (err) {
    console.error('Reset password error:', err)
    alert('❌ ' + (err?.data?.message || 'Gagal mengubah password. Coba lagi.'))
  } finally {
    loading.value = false
  }
}
</script>