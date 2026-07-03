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
              <!-- Email or No Telp Display -->
              <div class="group">
                <label class="block text-sm font-medium text-gray-700 mb-2 transition-all duration-300 group-hover:text-red-700">
                  {{ identifierType === 'email' ? 'Email' : 'Nomor WhatsApp' }}
                </label>
                <div class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 transition-all duration-300">
                  <p class="text-gray-700 font-medium">{{ identifier }}</p>
                </div>
              </div>

              <!-- OTP Input -->
              <div class="group">
                <label class="block text-sm font-medium text-gray-700 mb-2 transition-all duration-300 group-hover:text-red-700">
                  Kode OTP <span class="text-red-500">*</span>
                </label>
                <input
                  v-model="otp"
                  type="text"
                  inputmode="numeric"
                  maxlength="6"
                  placeholder="Masukkan 6 digit kode OTP"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all duration-300 hover:border-red-400 hover:shadow-md text-center text-lg tracking-widest font-mono"
                  required
                />
                <p class="text-xs text-gray-500 mt-1">Cek email atau WhatsApp Anda</p>
              </div>

              <button
                type="submit"
                :disabled="loading"
                class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-3 px-4 rounded-lg transition-all duration-300 shadow-sm hover:shadow-lg hover:scale-[1.02] active:scale-[0.98] transform disabled:opacity-70"
              >
                {{ loading ? 'Memverifikasi...' : 'Verifikasi OTP' }}
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
import { ref, computed, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'

const route = useRoute()
const router = useRouter()

// ✅ Ambil identifier (email atau no_telp) dari query string
const email = ref(route.query.email || '')
const noTelp = ref(route.query.no_telp || '')

// ✅ Computed untuk identifier yang ditampilkan
const identifier = computed(() => email.value || noTelp.value)
const identifierType = computed(() => email.value ? 'email' : 'no_telp')

const otp = ref('')
const loading = ref(false)

// Redirect ke /forgot jika tidak ada data
onMounted(() => {
  if (!email.value && !noTelp.value) {
    router.push('/forgot')
  }
})

// ✅ Verify OTP
const verifyOtp = async () => {
  // Validasi client-side
  if (!identifier.value) {
    alert('⚠️ Data akun tidak ditemukan. Silakan ulangi proses forgot password.')
    router.push('/forgot')
    return
  }
  
  if (otp.value.length !== 6) {
    alert('⚠️ Kode OTP harus 6 digit')
    return
  }

  try {
    loading.value = true

    // ✅ Payload sesuai backend: email/no_telp + otp
    const payload = {
      otp: otp.value
    }
    
    if (email.value) {
      payload.email = email.value
    }
    if (noTelp.value) {
      payload.no_telp = noTelp.value
    }

    const response = await $fetch("http://localhost:8000/api/verify-otp", {
      method: "POST",
      body: payload
    })

    if (response.success) {
      // ✅ Redirect ke reset-password dengan parameter
      const query = {
        ...(email.value && { email: email.value }),
        ...(noTelp.value && { no_telp: noTelp.value })
      }
      
      router.push({
        path: '/reset',
        query: query
      })
    }

  } catch (err) {
    console.error('Verify OTP error:', err)
    
    // Handle OTP invalid/expired
    if (err?.data?.message?.includes('OTP')) {
      alert('❌ ' + err.data.message + '\n\nSilakan minta kode OTP baru.')
    } else {
      alert('❌ ' + (err?.data?.message || 'Gagal memverifikasi OTP. Coba lagi.'))
    }
  } finally {
    loading.value = false
  }
}

// ✅ Resend OTP
const resendOtp = async () => {
  if (!identifier.value) {
    alert('⚠️ Data akun tidak ditemukan.')
    return
  }

  try {
    loading.value = true

    // ✅ Payload sama seperti forgot-password
    const payload = {
      metode: identifierType.value === 'email' ? 'email' : 'whatsapp'
    }
    
    if (email.value) {
      payload.email = email.value
    }
    if (noTelp.value) {
      payload.no_telp = noTelp.value
    }

    await $fetch("http://localhost:8000/api/forgot-password", {
      method: "POST",
      body: payload
    })

    alert("✅ OTP berhasil dikirim ulang! Cek email atau WhatsApp Anda.")

  } catch (err) {
    console.error('Resend OTP error:', err)
    alert('❌ ' + (err?.data?.message || 'Gagal mengirim ulang OTP!'))
  } finally {
    loading.value = false
  }
}
</script>