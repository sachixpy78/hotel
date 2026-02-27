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

        <!-- Right Side - Verify OTP Form -->
        <div class="md:w-3/5 p-8 flex flex-col justify-center">
          <div class="max-w-md w-full mx-auto">
            <h2 class="text-2xl font-bold text-gray-800 mb-2 transition-all duration-300 hover:text-red-700">Verifikasi OTP</h2>
            <p class="text-gray-600 mb-6 transition-all duration-300 hover:text-gray-800">Masukkan kode OTP yang telah dikirim ke email atau WhatsApp Anda</p>

            <!-- Verify OTP Form -->
            <form @submit.prevent="verifyOtp" class="space-y-5">
              <!-- Email or Phone Display -->
              <div class="group">
                <label class="block text-sm font-medium text-gray-700 mb-2 transition-all duration-300 group-hover:text-red-700">
                  {{ email ? 'Email' : 'Nomor WhatsApp' }}
                </label>
                <div class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 transition-all duration-300">
                  <p class="text-gray-700"><b>{{ email || phone }}</b></p>
                </div>
              </div>

              <!-- OTP Input -->
              <div class="group">
                <label class="block text-sm font-medium text-gray-700 mb-2 transition-all duration-300 group-hover:text-red-700">Kode OTP</label>
                <input
                  v-model="otp"
                  type="text"
                  inputmode="numeric"
                  maxlength="6"
                  placeholder="Masukkan kode OTP dari email/WhatsApp"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all duration-300 hover:border-red-400 hover:shadow-md"
                  required
                />
              </div>

              <button
                type="submit"
                :disabled="loading"
                class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-3 px-4 rounded-lg transition-all duration-300 shadow-sm hover:shadow-lg hover:scale-[1.02] active:scale-[0.98] transform disabled:opacity-70"
              >
                Verifikasi OTP
              </button>

              <!-- Resend OTP Button -->
              <button
                type="button"
                @click="resendOtp"
                :disabled="loading"
                class="w-full text-red-600 hover:text-red-800 font-medium py-2 px-4 rounded-lg transition-all duration-300 hover:underline disabled:opacity-50"
              >
                Kirim Ulang OTP
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
          <span class="text-gray-700 text-sm">Memverifikasi OTP...</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'

const route = useRoute()
const router = useRouter()

const email = ref(route.query.email || '')
const phone = ref(route.query.phone || '')
const otp = ref('')
const loading = ref(false)

// Redirect ke /forgot jika tidak ada data
onMounted(() => {
  if (!email.value && !phone.value) {
    router.push('/forgot')
  }
})

const verifyOtp = async () => {
  try {
    loading.value = true

    await $fetch("http://localhost:8000/api/verify-otp", {
      method: "POST",
      body: {
        email: email.value,
        phone: phone.value,
        otp: otp.value
      }
    })

    // Redirect ke reset dengan parameter
    let query = {}
    if (email.value) {
      query.email = email.value
    } else if (phone.value) {
      query.phone = phone.value
    }

    router.push(`/reset?${new URLSearchParams(query).toString()}`)

  } catch (err) {
    alert(err?.data?.message || "OTP tidak valid atau sudah kadaluarsa.")
  } finally {
    loading.value = false
  }
}

const resendOtp = async () => {
  try {
    loading.value = true

    await $fetch("http://localhost:8000/api/forgot-password", {
      method: "POST",
      body: {
        email: email.value,
        phone: phone.value
      }
    })

    alert("OTP berhasil dikirim ulang!")

  } catch (err) {
    alert(err?.data?.message || "Gagal mengirim ulang OTP!")
  } finally {
    loading.value = false
  }
}
</script>