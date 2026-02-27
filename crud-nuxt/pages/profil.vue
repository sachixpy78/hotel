<template>
  <div class="min-h-screen bg-gray-50 p-6 flex justify-center">
    <div class="w-full max-w-3xl">
      
      <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold text-gray-900">Profil Saya</h1>
        <p class="text-sm text-gray-500">Kelola informasi akun Anda</p>
      </div>

      <div class="bg-white rounded-lg shadow-sm border border-gray-300 p-6">
        
        <!-- Profil -->
        <div class="flex items-center space-x-6 mb-8">
          <div class="relative">
            <img
              v-if="profile.gambar"
              :src="previewImage"
              alt="Foto Profil"
              class="w-20 h-20 rounded-full object-cover border-2 border-gray-300 transition-all duration-300 hover:border-maroon"
            />

            <div
              v-else
              class="w-20 h-20 rounded-full bg-red-100 flex items-center justify-center text-red-800 font-bold text-lg border-2 border-gray-300 transition-all duration-300 hover:border-maroon"
            >
              {{ profile.username?.charAt(0).toUpperCase() || 'A' }}
            </div>
          </div>

          <div>
            <h2 class="text-xl font-bold text-gray-900">{{ profile.username }}</h2>
            <p class="text-sm text-gray-600">{{ profile.email }}</p>
            <span class="inline-block mt-1 px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">
              {{ profile.level }}
            </span>
          </div>
        </div>

        <!-- FORM -->
        <form @submit.prevent="saveProfile" class="space-y-5">
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
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
              <input
                v-model="form.email"
                type="email"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 
                       focus:ring-red-500 focus:border-red-500 outline-none transition-all duration-300"
                required
              />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
              <input
                v-model="form.username"
                type="text"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 
                       focus:ring-red-500 focus:border-red-500 outline-none transition-all duration-300"
                required
              />
            </div>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
            <input
              v-model="form.password"
              type="password"
              placeholder="Kosongkan jika tidak ingin mengubah"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 
                     focus:ring-red-500 focus:border-red-500 outline-none transition-all duration-300"
            />
            <p class="mt-1 text-xs text-gray-500">Password minimal 8 karakter.</p>
          </div>

          <div class="flex space-x-3 pt-4">
            <button
              type="submit"
              class="px-5 py-2.5 bg-maroon text-white font-medium rounded-lg 
                     hover:bg-red-800 hover:scale-105 transition-all duration-300 shadow-sm"
            >
              Simpan Perubahan
            </button>

            <NuxtLink
              to="/dashboard"
              class="px-5 py-2.5 bg-gray-100 text-gray-700 font-medium rounded-lg 
                     hover:bg-gray-200 hover:scale-105 transition-all duration-300"
            >
              Kembali ke Beranda
            </NuxtLink>
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
  password: '',
  gambar: null,
})

let imageFile = null

// PREVIEW GAMBAR
const previewImage = computed(() => {
  if (!profile.value.gambar) return null

  if (profile.value.gambar.startsWith('data:')) {
    return profile.value.gambar
  }

  return `http://localhost:8000/storage/${profile.value.gambar}`
})

// GET DATA PROFIL
const fetchProfile = async () => {
  try {
    const userId = localStorage.getItem('user_id')

    const response = await fetch(`http://localhost:8000/api/admin/${userId}`)
    const data = await response.json()

    profile.value = data
    form.value.email = data.email
    form.value.username = data.username
    form.value.password = ''
    form.value.gambar = data.gambar

  } catch (err) {
    console.error('Gagal memuat profil:', err)
    alert('Gagal memuat data profil. Silakan login ulang.')
    router.push('/')
  }
}

// UPLOAD GAMBAR
const handleImageUpload = (e) => {
  const file = e.target.files[0]
  if (!file) return

  imageFile = file

  const reader = new FileReader()
  reader.onload = (event) => {
    profile.value.gambar = event.target.result
  }
  reader.readAsDataURL(file)
}

// SIMPAN PROFIL
const saveProfile = async () => {
  try {
    const userId = localStorage.getItem('user_id')
    const formData = new FormData()
    
    formData.append('id', userId) // ← Wajib untuk updateProfile
    formData.append('email', form.value.email)
    formData.append('username', form.value.username)
    if (form.value.password) {
      formData.append('password', form.value.password)
    }
    if (imageFile) {
      formData.append('gambar', imageFile)
    }

    // ✅ GUNAKAN ROUTE /update-profile
    const response = await $fetch('http://localhost:8000/api/update-profile', {
      method: 'POST',
      body: formData
    })

    alert('Profil berhasil diperbarui!')
    fetchProfile()

    // ✅ UPDATE LOCALSTORAGE SETELAH SUKSES
    if (process.client) {
      localStorage.setItem('user_name', form.value.username)
      const newFotoUrl = profile.value.gambar 
        ? `http://localhost:8000/storage/${profile.value.gambar}` 
        : "/logo.jpg"
      localStorage.setItem('user_foto', newFotoUrl)
    }

  } catch (err) {
    console.error('Error:', err)
    alert(err?.data?.message || 'Email sudah terdaftar silahkan gunakan email lain.')
  }
}

// CEK ROLE
onMounted(() => {
  const userId = localStorage.getItem('user_id')
  const role = localStorage.getItem('user_level')

  if (!userId || role !== 'super_admin') {
    alert('Silakan login ulang.')
    router.push('/')
    return
  }

  fetchProfile()
})
</script>

<style scoped>
.bg-maroon {
  background-color: #800000;
}

.text-maroon {
  color: #800000;
}

.border-maroon {
  border-color: #800000;
}
</style>