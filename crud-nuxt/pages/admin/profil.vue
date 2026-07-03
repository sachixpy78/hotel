<template>
  <div class="min-h-screen bg-gray-50 p-6 flex justify-center">
    <div class="w-full max-w-3xl">
      
      <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold text-gray-900">Profil Saya</h1>
        <p class="text-sm text-gray-500">Kelola informasi akun Anda</p>
      </div>

      <div class="bg-white rounded-lg shadow-sm border border-gray-300 p-6">
        
        <!-- Profil Header -->
        <div class="flex items-center space-x-6 mb-8">
          <div class="relative">
            <img
              v-if="profile.gambar && profile.gambar !== 'logo.jpg'"
              :src="previewImage"
              alt="Foto Profil"
              class="w-20 h-20 rounded-full object-cover border-2 border-gray-300 transition-all duration-300 hover:border-red-500"
            />
            <div
              v-else
              class="w-20 h-20 rounded-full bg-red-100 flex items-center justify-center text-red-800 font-bold text-lg border-2 border-gray-300 transition-all duration-300 hover:border-red-500"
            >
              {{ profile.username?.charAt(0).toUpperCase() || 'A' }}
            </div>
          </div>

          <div>
            <h2 class="text-xl font-bold text-gray-900">{{ profile.username }}</h2>
            <p class="text-sm text-gray-600">{{ profile.email }}</p>
            <span class="inline-block mt-1 px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">
              {{ profile.level === 'admin' ? 'Administrator' : profile.level === 'resepsionis' ? 'Resepsionis' : 'Tamu' }}
            </span>
          </div>
        </div>

        <!-- FORM -->
        <form @submit.prevent="saveProfile" class="space-y-5">
          
          <!-- Upload Foto -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Foto Profil</label>
            <input
              type="file"
              accept="image/*"
              @change="handleImageUpload"
              class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 
                     file:rounded-lg file:border-0 file:text-sm file:font-medium 
                     file:bg-red-50 file:text-red-700 hover:file:bg-red-100 transition-all duration-300"
            />
            <p class="mt-1 text-xs text-gray-500">Maksimal 2MB. Format: JPG, PNG, GIF</p>
          </div>

          <!-- Email & Username -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
              <input
                v-model="form.email"
                type="email"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 
                       focus:ring-red-500 focus:border-red-500 outline-none transition-all duration-300"
                required
              />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Username <span class="text-red-500">*</span></label>
              <input
                v-model="form.username"
                type="text"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 
                       focus:ring-red-500 focus:border-red-500 outline-none transition-all duration-300"
                required
              />
            </div>
          </div>

          <!-- No. Telepon & Alamat -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
              <input
                v-model="form.no_telp"
                type="tel"
                placeholder="081234567890"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 
                       focus:ring-red-500 focus:border-red-500 outline-none transition-all duration-300"
              />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
              <input
                v-model="form.alamat"
                type="text"
                placeholder="Jl. Contoh No. 123"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 
                       focus:ring-red-500 focus:border-red-500 outline-none transition-all duration-300"
              />
            </div>
          </div>

          <!-- Password -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
            <input
              v-model="form.password"
              type="password"
              placeholder="Kosongkan jika tidak ingin mengubah"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 
                     focus:ring-red-500 focus:border-red-500 outline-none transition-all duration-300"
            />
            <p class="mt-1 text-xs text-gray-500">Minimal 5 karakter. Kosongkan jika tidak diubah.</p>
          </div>

          <!-- Buttons -->
          <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-3 pt-4">
            <button
              type="submit"
              :disabled="saving"
              class="px-5 py-2.5 bg-red-600 text-white font-medium rounded-lg 
                     hover:bg-red-700 hover:scale-105 transition-all duration-300 shadow-sm disabled:opacity-50 disabled:cursor-not-allowed"
            >
              {{ saving ? 'Menyimpan...' : 'Simpan Perubahan' }}
            </button>

            <button
              type="button"
              @click="goBack"
              class="px-5 py-2.5 bg-gray-100 text-gray-700 font-medium rounded-lg 
                     hover:bg-gray-200 hover:scale-105 transition-all duration-300"
            >
              Kembali
            </button>
          </div>
        </form>

      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

const profile = ref({})
const form = ref({
  email: '',
  username: '',
  no_telp: '',
  alamat: '',
  password: '',
})

const saving = ref(false)
const imageFile = ref(null)

// ✅ PREVIEW GAMBAR
const previewImage = computed(() => {
  if (!profile.value.gambar || profile.value.gambar === 'logo.jpg') return null
  
  // Jika sudah base64 (preview upload)
  if (profile.value.gambar.startsWith('data:')) {
    return profile.value.gambar
  }
  
  // Jika path dari server
  return `http://localhost:8000/storage/${profile.value.gambar}`
})

// ✅ GET DATA PROFIL
const fetchProfile = async () => {
  try {
    const userId = sessionStorage.getItem('user_id')
    const authToken = sessionStorage.getItem('auth_token')
    
    if (!userId || !authToken) {
      throw new Error('Session expired')
    }

    const response = await $fetch(`http://localhost:8000/api/admin/${userId}`, {
      method: 'GET',
      headers: {
        'Authorization': `Bearer ${authToken}`,
        'Accept': 'application/json'
      }
    })

    profile.value = response
    form.value = {
      email: response.email,
      username: response.username,
      no_telp: response.no_telp || '',
      alamat: response.alamat || '',
      password: '',
    }

  } catch (err) {
    console.error('Gagal memuat profil:', err)
    alert('Gagal memuat data profil. Silakan login ulang.')
    sessionStorage.removeItem('auth_token')
    router.push('/')
  }
}

// ✅ UPLOAD GAMBAR
const handleImageUpload = (e) => {
  const file = e.target.files[0]
  if (!file) return

  // Validasi ukuran
  if (file.size > 2 * 1024 * 1024) {
    alert('⚠️ Ukuran file maksimal 2MB')
    e.target.value = ''
    return
  }

  // Validasi tipe
  if (!['image/jpeg', 'image/png', 'image/gif'].includes(file.type)) {
    alert('⚠️ Format file harus JPG, PNG, atau GIF')
    e.target.value = ''
    return
  }

  imageFile.value = file

  // Preview
  const reader = new FileReader()
  reader.onload = (event) => {
    profile.value.gambar = event.target.result
  }
  reader.readAsDataURL(file)
}

// ✅ SIMPAN PROFIL
const saveProfile = async () => {
  // Validasi
  if (!form.value.email || !form.value.username) {
    alert('⚠️ Email dan Username wajib diisi')
    return
  }

  if (form.value.password && form.value.password.length < 5) {
    alert('⚠️ Password minimal 5 karakter')
    return
  }

  saving.value = true
  
  try {
    const userId = sessionStorage.getItem('user_id')
    const authToken = sessionStorage.getItem('auth_token')
    const userLevel = sessionStorage.getItem('user_role')
    
    if (!userId || !authToken) {
      throw new Error('Session expired')
    }

    const formData = new FormData()
    formData.append('_method', 'PUT') // Method spoofing untuk FormData
    formData.append('email', form.value.email)
    formData.append('username', form.value.username)
    formData.append('no_telp', form.value.no_telp || '')
    formData.append('alamat', form.value.alamat || '')
    formData.append('level', profile.value.level) // Level tidak bisa diubah via profil
    formData.append('status', profile.value.status) // Status tidak bisa diubah via profil
    
    if (form.value.password) {
      formData.append('password', form.value.password)
    }
    if (imageFile.value) {
      formData.append('gambar', imageFile.value)
    }

    const response = await $fetch(`http://localhost:8000/api/admin/${userId}`, {
      method: 'POST', // POST dengan _method=PUT
      body: formData,
      headers: {
        'Authorization': `Bearer ${authToken}`,
        'Accept': 'application/json',
        'X-User-ID': userId,
        'X-User-Level': userLevel
      }
    })

    if (response.success) {
      alert('✅ Profil berhasil diperbarui!')
      
      // Update localStorage dengan data terbaru
      sessionStorage.setItem('user_name', form.value.username)
      sessionStorage.setItem('user_email', form.value.email)
      
      // Update foto jika ada
      if (response.data?.gambar) {
        const fotoUrl = response.data.gambar !== 'logo.jpg' 
          ? `http://localhost:8000/storage/${response.data.gambar}`
          : '/logo.jpg'
        sessionStorage.setItem('user_foto', fotoUrl)
      }
      
      // Refresh profile data
      await fetchProfile()
    }

  } catch (err) {
    console.error('Error saving profile:', err)
    
    let message = 'Gagal menyimpan perubahan.'
    if (err.data?.message) {
      message = err.data.message
    } else if (err.response?.status === 401) {
      message = 'Session expired. Silakan login ulang.'
      sessionStorage.removeItem('auth_token')
      router.push('/')
    } else if (err.response?.status === 422) {
      message = 'Validasi gagal. Periksa data yang dimasukkan.'
    }
    
    alert('❌ ' + message)
  } finally {
    saving.value = false
  }
}

// ✅ KEMBALI KE HALAMAN SEBELUMNYA
const goBack = () => {
  // Cek role untuk redirect yang sesuai
  const role = sessionStorage.getItem('user_role')
  
  if (role === 'admin') {
    router.push('/admin/')
  } else if (role === 'resepsionis') {
    router.push('/resepsionis')
  } else if (role === 'tamu') {
    router.push('/tamu')
  } else {
    router.push('/')
  }
}

// ✅ CEK AUTH & LOAD DATA
onMounted(() => {
  const userId = sessionStorage.getItem('user_id')
  const authToken = sessionStorage.getItem('auth_token')
  
  if (!userId || !authToken) {
    alert('Silakan login terlebih dahulu.')
    router.push('/')
    return
  }
  
  fetchProfile()
})
</script>

<style scoped>
/* Smooth transitions */
* {
  transition: background-color 0.2s, border-color 0.2s, transform 0.2s;
}

/* Custom scrollbar untuk form */
form::-webkit-scrollbar {
  width: 6px;
}
form::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 3px;
}
form::-webkit-scrollbar-thumb {
  background: #cbd5e1;
  border-radius: 3px;
}
form::-webkit-scrollbar-thumb:hover {
  background: #94a3b8;
}
</style>