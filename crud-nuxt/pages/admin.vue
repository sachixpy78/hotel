<template>
  <div class="min-h-screen bg-gray-50 p-6">
    <!-- HEADER -->
    <header class="bg-white shadow-sm border-b border-gray-300 px-6 py-4 flex items-center justify-between">
      <div class="flex items-center space-x-3">
        <NuxtLink to="/dashboard" class="px-3 py-1 bg-maroon text-white rounded-md text-sm hover:bg-red-800 transition-colors duration-300">Back</NuxtLink>
        <h1 class="text-xl font-bold text-gray-800">Admin</h1>
      </div>
      <div class="flex items-center space-x-2">
        <span class="text-sm font-medium">{{ user.name }}</span>
        <img :src="user.foto_profil" alt="Profile" class="h-8 w-8 rounded-full border border-gray-300" />
      </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="container mx-auto px-6 py-6">
      <h2 class="text-2xl font-bold text-gray-800 mb-6">Persetujuan Akun</h2>

      <!-- Loading -->
      <div v-if="loading" class="text-center py-10">
        <p class="text-gray-500">Memuat data admin...</p>
      </div>

      <!-- Table -->
      <div v-else class="bg-white rounded-lg shadow-sm border border-gray-300 overflow-hidden">
        <div class="overflow-x-auto">
          <table class="w-full">
            <thead class="bg-gray-100">
              <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto Diri</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Password</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Persetujuan</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-300">
              <tr v-for="admin in admins" :key="admin.id" class="hover:bg-red-50 transition-colors duration-300">
                <td class="px-4 py-4 whitespace-nowrap">
                  <img :src="getFotoUrl(admin.gambar)" alt="Foto" class="h-10 w-10 rounded-full object-cover border border-gray-300" />
                </td>
                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">{{ admin.email }}</td>
                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">{{ admin.username }}</td>
                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">{{ admin.password }}</td>
                <td class="px-4 py-4 whitespace-nowrap">
                  <button 
                    v-if="admin.status === 'off'"
                    @click="showApprovalModal(admin)"
                    class="px-3 py-1 bg-red-100 text-red-700 rounded-md text-xs font-medium hover:bg-red-200 hover:scale-105 transition-all duration-300"
                  >
                    Menunggu Persetujuan
                  </button>
                  <span 
                    v-else-if="admin.status === 'on'"
                    class="px-3 py-1 bg-green-100 text-green-700 rounded-md text-xs font-medium"
                  >
                    Sudah Disetujui
                  </span>
                  <span 
                    v-else-if="admin.status === 'blokir'"
                    class="px-3 py-1 bg-red-200 text-red-800 rounded-md text-xs font-medium"
                  >
                    Diblokir
                  </span>
                </td>
                <td class="px-4 py-4 whitespace-nowrap">
                  <button 
                    v-if="admin.status === 'on'"
                    @click="toggleStatus(admin, 'off')"
                    class="px-2 py-1 bg-green-100 text-green-700 rounded-md text-xs font-medium hover:bg-green-200 hover:scale-110 transition-all duration-300"
                  >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 6a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                  </button>
                  <button 
                    v-else-if="admin.status === 'off'"
                    @click="toggleStatus(admin, 'on')"
                    class="px-2 py-1 bg-red-100 text-red-700 rounded-md text-xs font-medium hover:bg-red-200 hover:scale-110 transition-all duration-300"
                  >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 0012 12m6 6L12 12m6 6H9m6 6v-6m6 6h-6" />
                    </svg>
                  </button>
                  <button 
                    v-else-if="admin.status === 'blokir'"
                    @click="toggleStatus(admin, 'on')"
                    class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-md text-xs font-medium hover:bg-yellow-200 hover:scale-110 transition-all duration-300"
                  >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v6h8z" />
                    </svg>
                  </button>
                </td>
                <td class="px-4 py-4 whitespace-nowrap">
                  <button 
                    v-if="admin.status !== 'blokir'"
                    @click="showEditModal(admin)"
                    class="px-2 py-1 bg-red-100 text-red-700 rounded-md text-xs font-medium hover:bg-red-200 hover:scale-110 transition-all duration-300"
                  >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                  </button>
                  <button 
                    v-else
                    @click="showUnblockModal(admin)"
                    class="px-2 py-1 bg-orange-100 text-orange-700 rounded-md text-xs font-medium hover:bg-orange-200 hover:scale-110 transition-all duration-300"
                  >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v6h8z" />
                    </svg>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-300 flex items-center justify-between">
          <div class="text-sm text-gray-700">
            Showing {{ admins.length }} of {{ total }} entries
          </div>
          <div class="flex space-x-2">
            <button class="px-3 py-1 bg-gray-100 text-gray-700 rounded-md text-sm hover:bg-gray-200 hover:scale-105 transition-all duration-300">«</button>
            <button class="px-3 py-1 bg-maroon text-white rounded-md text-sm hover:bg-red-800 transition-colors duration-300">1</button>
            <button class="px-3 py-1 bg-gray-100 text-gray-700 rounded-md text-sm hover:bg-gray-200 hover:scale-105 transition-all duration-300">2</button>
            <button class="px-3 py-1 bg-gray-100 text-gray-700 rounded-md text-sm hover:bg-gray-200 hover:scale-105 transition-all duration-300">3</button>
            <button class="px-3 py-1 bg-gray-100 text-gray-700 rounded-md text-sm hover:bg-gray-200 hover:scale-105 transition-all duration-300">»</button>
          </div>
        </div>
      </div>
    </main>

    <!-- Approval Modal -->
    <Teleport to="body">
      <div v-if="showApproval" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 max-w-md w-full border border-gray-300">
          <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">Konfirmasi Persetujuan Akun</h3>
            <button @click="showApproval = false" class="text-gray-400 hover:text-gray-600 hover:scale-110 transition-all duration-300">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
          <div class="text-center mb-6">
            <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14a4 4 0 014-4h4M12 14a4 4 0 01-4-4h-4M12 14a4 4 0 01-4-4h-4m8 8v6m4-6v6m4-6v6" />
              </svg>
            </div>
            <p class="text-sm text-gray-600 mb-4">Apakah Anda yakin ingin menyetujui akun ini?</p>
            <div class="text-left text-sm mb-4">
              <p><strong>Email:</strong> {{ selectedAdmin?.email }}</p>
              <p><strong>Username:</strong> {{ selectedAdmin?.username }}</p>
              <p><strong>Level:</strong> {{ selectedAdmin?.level }}</p>
            </div>
          </div>
          <div class="flex space-x-3">
            <button @click="showApproval = false" class="flex-1 px-4 py-2 bg-gray-100 text-gray-700 rounded-md text-sm font-medium hover:bg-gray-200 hover:scale-105 transition-all duration-300">
              Batal
            </button>
            <button @click="approveAdmin(selectedAdmin)" class="flex-1 px-4 py-2 bg-maroon text-white rounded-md text-sm font-medium hover:bg-red-800 hover:scale-105 transition-all duration-300">
              Setujui
            </button>
          </div>
        </div>
      </div>
    </Teleport>

    <!-- Edit Modal -->
    <Teleport to="body">
      <div v-if="showEdit" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 max-w-md w-full border border-gray-300">
          <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">Edit</h3>
            <button @click="showEdit = false" class="text-gray-400 hover:text-gray-600 hover:scale-110 transition-all duration-300">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Ganti Foto Profil (optional)</label>
            <input type="file" accept="image/*" @change="handleImageUpload" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-red-50 file:text-red-700 hover:file:bg-red-100 transition-colors duration-300" />
          </div>
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Ganti email login (optional)</label>
            <input v-model="editForm.email" type="email" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all duration-300" />
          </div>
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Ganti username</label>
            <input v-model="editForm.username" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all duration-300" />
          </div>
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Reset / ubah password</label>
            <input v-model="editForm.password" type="password" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all duration-300" />
          </div>
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <div class="flex items-center space-x-4">
              <label class="inline-flex items-center">
                <input v-model="editForm.status" type="radio" value="on" class="form-radio h-4 w-4 text-red-600" />
                <span class="ml-2 text-sm text-gray-700">On</span>
              </label>
              <label class="inline-flex items-center">
                <input v-model="editForm.status" type="radio" value="off" class="form-radio h-4 w-4 text-red-600" />
                <span class="ml-2 text-sm text-gray-700">Off</span>
              </label>
            </div>
          </div>
          <div class="flex space-x-3">
            <button @click="showEdit = false" class="flex-1 px-4 py-2 bg-gray-100 text-gray-700 rounded-md text-sm font-medium hover:bg-gray-200 hover:scale-105 transition-all duration-300">
              Batal
            </button>
            <button @click="saveEdit" class="flex-1 px-4 py-2 bg-maroon text-white rounded-md text-sm font-medium hover:bg-red-800 hover:scale-105 transition-all duration-300">
              Setujui
            </button>
          </div>
        </div>
      </div>
    </Teleport>

    <!-- Unblock Modal -->
    <Teleport to="body">
      <div v-if="showUnblock" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 max-w-md w-full border border-gray-300">
          <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">Buka Blokir Akun</h3>
            <button @click="showUnblock = false" class="text-gray-400 hover:text-gray-600 hover:scale-110 transition-all duration-300">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
          <div class="text-center mb-6">
            <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14a4 4 0 014-4h4M12 14a4 4 0 01-4-4h-4M12 14a4 4 0 01-4-4h-4m8 8v6m4-6v6m4-6v6" />
              </svg>
            </div>
            <p class="text-sm text-gray-600 mb-4">Apakah Anda yakin ingin membuka blokir akun ini?</p>
            <div class="text-left text-sm mb-4">
              <p><strong>Email:</strong> {{ selectedAdmin?.email }}</p>
              <p><strong>Username:</strong> {{ selectedAdmin?.username }}</p>
              <p><strong>Status:</strong> Diblokir</p>
            </div>
            <p class="text-xs text-gray-500">Setelah dibuka, akun ini bisa login kembali. Pastikan perubahan ini memang diizinkan.</p>
          </div>
          <div class="flex space-x-3">
            <button @click="showUnblock = false" class="flex-1 px-4 py-2 bg-gray-100 text-gray-700 rounded-md text-sm font-medium hover:bg-gray-200 hover:scale-105 transition-all duration-300">
              Batal
            </button>
            <button @click="unblockAdmin(selectedAdmin)" class="flex-1 px-4 py-2 bg-maroon text-white rounded-md text-sm font-medium hover:bg-red-800 hover:scale-105 transition-all duration-300">
              Buka Blokir
            </button>
          </div>
        </div>
      </div>
    </Teleport>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useStorage } from '@vueuse/core'

const router = useRouter()

const showDropdown = ref(false)
const loading = ref(true)
const admins = ref([])
const total = ref(0)
const user = ref({
  name: useStorage('user_name', 'Admin').value,
  foto_profil: useStorage('user_foto', '/logo.jpg').value
})

const showApproval = ref(false)
const showEdit = ref(false)
const showUnblock = ref(false)
const selectedAdmin = ref(null)
let imageFile = null

// GET DATA ADMIN (tampilkan semua yang levelnya kasir)
const fetchAdmins = async () => {
  try {
    const response = await $fetch('http://localhost:8000/api/admin')
    // ✅ Tampilkan semua yang levelnya 'kasir' (tidak peduli statusnya)
    admins.value = response.filter(admin => admin.level === 'kasir')
    total.value = admins.value.length
  } catch (err) {
    console.error('Error:', err)
    alert('Gagal memuat data admin.')
  } finally {
    loading.value = false
  }
}

// GET FOTO URL
const getFotoUrl = (gambar) => {
  if (!gambar) return '/logo.jpg'
  if (gambar.startsWith('data:')) return gambar
  // ✅ Gunakan path yang benar
  return `http://localhost:8000/storage/${gambar}`
}

// SHOW APPROVAL MODAL
const showApprovalModal = (admin) => {
  selectedAdmin.value = admin
  showApproval.value = true
}

// APPROVE ADMIN
const approveAdmin = async (admin) => {
  try {
    const response = await $fetch(`http://localhost:8000/api/admin/${admin.id}/activate`, {
      method: 'PUT'
    })
    alert('Akun berhasil disetujui!')
    showApproval.value = false
    fetchAdmins() // Refresh data
  } catch (err) {
    console.error('Error:', err)
    alert('Gagal menyetujui akun.')
  }
}

// TOGGLE STATUS
const toggleStatus = (admin, status) => {
  if (status === 'blokir') {
    showUnblock.value = false
    selectedAdmin.value = admin
    showUnblock.value = true
  } else {
    updateStatus(admin, status)
  }
}

// UPDATE STATUS
const updateStatus = async (admin, status) => {
  try {
    const response = await $fetch(`http://localhost:8000/api/admin/${admin.id}/${status === 'on' ? 'activate' : 'deactivate'}`, {
      method: 'PUT'
    })

    // ✅ NOTIFIKASI SESUAI STATUS
    if (status === 'on') {
      alert('Data sudah ON')
    } else if (status === 'off') {
      alert('Data sudah OFF')

      // ✅ HAPUS OTOMATIS DARI DATABASE SETELAH 5 DETIK
      setTimeout(async () => {
        try {
          const deleteResponse = await $fetch(`http://localhost:8000/api/admin/${admin.id}`, {
            method: 'DELETE'
          })
          // ✅ HAPUS JUGA DARI FRONTEND
          admins.value = admins.value.filter(item => item.id !== admin.id)
          alert('Akun berhasil dihapus karena tidak disetujui dalam 5 detik.')
        } catch (err) {
          console.error('Error:', err)
          alert('Gagal menghapus akun dari database.')
        }
      }, 5000)

    }

    fetchAdmins() // Refresh data
  } catch (err) {
    console.error('Error:', err)
    alert('Gagal mengubah status akun.')
  }
}

// UNBLOCK ADMIN
const unblockAdmin = async (admin) => {
  try {
    const response = await $fetch(`http://localhost:8000/api/admin/${admin.id}/activate`, {
      method: 'PUT'
    })
    alert('Akun berhasil dibuka dari blokir!')
    showUnblock.value = false
    fetchAdmins() // Refresh data
  } catch (err) {
    console.error('Error:', err)
    alert('Gagal membuka blokir akun.')
  }
}

// SHOW EDIT MODAL
const showEditModal = (admin) => {
  selectedAdmin.value = admin
  editForm.value = {
    email: admin.email,
    username: admin.username,
    password: '',
    status: admin.status
  }
  showEdit.value = true
}

// SHOW UNBLOCK MODAL
const showUnblockModal = (admin) => {
  selectedAdmin.value = admin
  showUnblock.value = true
}

// HANDLE IMAGE UPLOAD
const handleImageUpload = (e) => {
  const file = e.target.files[0]
  if (!file) return
  imageFile = file
}

// SAVE EDIT
const saveEdit = async () => {
  try {
    const formData = new FormData()
    formData.append('id', selectedAdmin.value.id) // ✅ Tambahkan ID
    formData.append('email', editForm.value.email)
    formData.append('username', editForm.value.username)
    if (editForm.value.password) {
      formData.append('password', editForm.value.password)
    }
    formData.append('status', editForm.value.status) // ✅ Tambahkan status
    if (imageFile) {
      formData.append('gambar', imageFile)
    }

    // ✅ GANTI KE ROUTE YANG BISA UPLOAD FILE
    const response = await $fetch(`http://localhost:8000/api/update-profile`, {
      method: 'POST',
      body: formData
    })

    alert('Perubahan berhasil disimpan!')
    showEdit.value = false
    fetchAdmins() // Refresh data
  } catch (err) {
    console.error('Error:', err)
    alert(err?.data?.message || 'Gagal menyimpan perubahan.')
  }
}

// EDIT FORM
const editForm = ref({
  email: '',
  username: '',
  password: '',
  status: 'on'
})

onMounted(() => {
  const auth_token = useStorage('auth_token').value
  if (!auth_token) {
    router.push('/')
  } else {
    fetchAdmins()
  }
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