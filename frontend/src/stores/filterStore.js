import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'
import { useLoginStore } from './loginStore'
import { useToast } from 'vue-toastification'

export const useFilterStore = defineStore('filter', () => {
  const sport = ref([])

  const toast = useToast()

  const loginStore = useLoginStore()

  console.log(loginStore.headers)

  const router = useRouter()

  async function getSports() {
    return axios
      .get(import.meta.env.VITE_BASE_URL + '/api/sports', { headers: loginStore.headers })
      .then((response) => {
        console.log(response.data)
        sport.value = response.data.data
        return response.data
      })
      .catch((error) => {
        if (error.status === 401) {
          router.push({ name: 'auth' })
          toast.error('Пользователь не авторизован!')
        }
        return false
      })
  }

  return {
    sport,
    getSports,
  }
})
