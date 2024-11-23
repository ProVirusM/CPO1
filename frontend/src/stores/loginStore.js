import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'
// import { getUrl } from '@/util/config'
// import { connect } from '@/util/ws'

export const useLoginStore = defineStore('login', () => {
  const apiClient = axios.create({
    baseURL: import.meta.env.VITE_BASE_URL,
  })
  let logged = ref(false)
  let name = ref('Вы не вошли')
  let id = ref('')
  let token = ref('')
  let role = ref('')
  let image = ref('')
  let username = ref('')
  let email = ref('')
  let email2 = ref('')
  const router = useRouter()
  let headers = computed(() => {
    return {
      'Content-Type': 'application/json',
      Authorization: 'Bearer ' + token.value,
    }
  })

  // Авторизация
  async function checkLogin(email, password) {
    return axios
      .post(import.meta.env.VITE_BASE_URL + '/api/login_check', {
        email: email,
        password: password,
      })
      .then((response) => {
        console.log(response.data)
        email2.value = response.data.email
        logged.value = true
        username.value = response.data.name
        token.value = response.data.token

        console.log(logged.value)

        return true
      })
      .catch((error) => {
        return false
      })
  }

  // Регистрация
  async function apiRegister(email, name, password) {
    return axios
      .post(import.meta.env.VITE_BASE_URL + '/api/register', {
        email: email,
        name: name,
        password: password,
      })
      .then((response) => {
        console.log(response.data)
      })
  }

  const logout = () => {
    logged.value = false
    token.value = ''
  }

  //   async function login(username, password) {
  //     return axios
  //       .post(getUrl() + '/auth/signin', {
  //         username: username,
  //         password: password,
  //       })
  //       .then((response) => {
  //         token.value = response.data
  //         console.log(response.data)
  //         logged.value = true
  //         connect(headers.value)
  //         return true
  //       })
  //       .catch((error) => {
  //         return false
  //       })
  //   }

  //   async function register(username, password, forename, email, isOrganizer) {
  //     return axios
  //       .post(getUrl() + '/auth/signup', {
  //         username: username,
  //         password: password,
  //         forename: forename,
  //         email: email,
  //         isOrganizer: isOrganizer,
  //       })
  //       .then((response) => {
  //         console.log(response.data)
  //         return true
  //       })
  //       .catch((error) => {
  //         return false
  //       })
  //   }

  //   function logout() {
  //     logged.value = false
  //     token.value = ''
  //     router.push('/login')
  //   }

  //   async function getUserInfo() {
  //     console.log(headers.value)
  //     return axios
  //       .get(getUrl() + '/secured/user', { headers: headers.value })
  //       .then((response) => {
  //         name.value = response.data.forename
  //         role.value = response.data.role
  //         id.value = response.data.id
  //         image.value = response.data.imagePath
  //         username.value = response.data.username
  //         console.log(response.data)
  //         return response.data
  //       })
  //       .catch((error) => {
  //         return false
  //       })
  //   }

  return {
    logout,
    apiRegister,
    email,
    checkLogin,
    token,
    email2,
    // getUserInfo,
    logged,
    username,
    headers,
    // login,
    // register,
    id,
    image,
    // logout,
    role,
    name,
  }
})
