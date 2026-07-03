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

        <!-- Right Side - Forgot Password Form -->
        <div class="md:w-3/5 p-8 flex flex-col justify-center">
          <div class="max-w-md w-full mx-auto">
            <h2 class="text-2xl font-bold text-gray-800 mb-2 transition-all duration-300 hover:text-red-700">Lupa Password</h2>
            <p class="text-gray-600 mb-6 transition-all duration-300 hover:text-gray-800">Masukkan email atau nomor WhatsApp untuk mereset password</p>

            <!-- Forgot Password Form -->
            <form @submit.prevent="submitRequest" class="space-y-5">
              <!-- Email Input (default) -->
              <div v-if="!showPhoneInput" class="group">
                <label class="block text-sm font-medium text-gray-700 mb-2 transition-all duration-300 group-hover:text-red-700">
                  Email <span class="text-red-500">*</span>
                </label>
                <input
                  v-model="formData.email"
                  type="email"
                  placeholder="Masukkan email Anda"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all duration-300 hover:border-red-400 hover:shadow-md"
                  required
                />
              </div>

              <!-- Phone Input (sembunyi, muncul saat diklik link) -->
              <div v-if="showPhoneInput" class="group">
                <label class="block text-sm font-medium text-gray-700 mb-2 transition-all duration-300 group-hover:text-red-700">
                  Nomor WhatsApp <span class="text-red-500">*</span>
                </label>
                <input
                  v-model="formData.no_telp"
                  type="tel"
                  placeholder="Contoh: 081234567890"
                  maxlength="15"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all duration-300 hover:border-red-400 hover:shadow-md"
                  required
                />
                <p class="text-xs text-gray-500 mt-1">Gunakan format: 0812xxxx atau 62812xxxx</p>
              </div>

              <button
                type="submit"
                :disabled="loading"
                class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-3 px-4 rounded-lg transition-all duration-300 shadow-sm hover:shadow-lg hover:scale-[1.02] active:scale-[0.98] transform disabled:opacity-70"
              >
                {{ loading ? 'Mengirim...' : 'Kirim Kode OTP' }}
              </button>

              <!-- Link "Lupa email? Gunakan nomor WhatsApp" -->
              <div class="text-center mt-4">
                <button
                  type="button"
                  @click="togglePhoneInput"
                  class="text-red-600 hover:text-red-800 font-medium text-sm underline"
                >
                  {{ showPhoneInput ? 'Gunakan email saja' : 'Lupa email? Gunakan nomor WhatsApp.' }}
                </button>
              </div>
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
          <span class="text-gray-700 text-sm">Mengirim kode OTP...</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

const showPhoneInput = ref(false)
const loading = ref(false)

// ✅ Reactive form data sesuai database admin
const formData = reactive({
  email: '',
  no_telp: ''  // ✅ Sesuai field di database: no_telp (bukan phone)
})

// ✅ Toggle antara email dan no_telp
const togglePhoneInput = () => {
  showPhoneInput.value = !showPhoneInput.value
  // Reset input saat beralih
  if (showPhoneInput.value) {
    formData.email = ''
  } else {
    formData.no_telp = ''
  }
}

// ✅ Submit request forgot password
const submitRequest = async () => {
  // Validasi sederhana
  if (!showPhoneInput.value && !formData.email) {
    alert('⚠️ Mohon masukkan email Anda')
    return
  }
  if (showPhoneInput.value && !formData.no_telp) {
    alert('⚠️ Mohon masukkan nomor WhatsApp Anda')
    return
  }

  try {
    loading.value = true

    // ✅ TENTUKAN METODE berdasarkan input yang diisi
    const metode = showPhoneInput.value ? 'whatsapp' : 'email'
    
    // ✅ Payload WAJIB kirim field 'metode' + email/no_telp
    const payload = {
      metode: metode  // ✅ INI PENTING! Backend validasi ini
    }
    
    if (metode === 'whatsapp') {
      // Format nomor: hapus karakter non-digit, pastikan mulai dengan 62 atau 0
      let phone = formData.no_telp.replace(/\D/g, '')
      if (phone.startsWith('0')) {
        phone = '62' + phone.slice(1)
      }
      payload.no_telp = phone
    } else {
      payload.email = formData.email
    }

    console.log('Sending payload:', payload) // Debug log

    const response = await $fetch("http://localhost:8000/api/forgot-password", {
      method: "POST",
      body: payload
    })

    if (response.success) {
      // ✅ Redirect ke verify-otp dengan parameter yang sesuai
      const query = {
        ...(payload.email && { email: payload.email }),
        ...(payload.no_telp && { no_telp: payload.no_telp }),
        metode: payload.metode
      }
      
      router.push({
        path: '/verify-otp',
        query: query
      })
    }

  } catch (err) {
    console.error('Forgot password error:', err)
    alert('❌ ' + (err?.data?.message || 'Gagal mengirim kode OTP. Periksa koneksi atau coba lagi.'))
  } finally {
    loading.value = false
  }
}
</script>