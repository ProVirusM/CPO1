import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'
import { useLoginStore } from './loginStore'
import { useToast } from 'vue-toastification'

export const useFilterStore = defineStore('filter', () => {
  const sport = ref([])
  const division = ref([])
  const placeCity = ref([])
  const tag = ref([])
  const regionPlace = ref([])

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

  async function getDivisions() {
    return axios
      .get(import.meta.env.VITE_BASE_URL + '/api/divisions', { headers: loginStore.headers })
      .then((response) => {
        console.log(response.data)
        division.value = response.data.data
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

  async function getPlaceCity() {
    return axios
      .get(import.meta.env.VITE_BASE_URL + '/api/places', { headers: loginStore.headers })
      .then((response) => {
        console.log(response.data)
        placeCity.value = response.data.data.filter(
          (item, index, array) => array.indexOf(item) === array.lastIndexOf(item),
        )
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
  async function getTag() {
    return axios
      .get(import.meta.env.VITE_BASE_URL + '/api/tags', { headers: loginStore.headers })
      .then((response) => {
        console.log(response.data)
        tag.value = response.data.data.filter(
          (item, index, array) => array.indexOf(item) === array.lastIndexOf(item),
        )
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

  async function getRegionPlace() {
    return axios
      .get(import.meta.env.VITE_BASE_URL + '/api/regions', { headers: loginStore.headers })
      .then((response) => {
        console.log(response.data)
        regionPlace.value = response.data.data.filter(
          (item, index, array) => array.indexOf(item) === array.lastIndexOf(item),
        )
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
    placeCity,
    division,
    tag,
    regionPlace,
    getRegionPlace,
    getSports,
    getDivisions,
    getPlaceCity,
    getTag,
  }
})
