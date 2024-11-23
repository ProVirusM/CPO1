import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'

export const useFilterStore = defineStore('filter', () => {
  const sport = ref([])

  const router = useRouter()

  return {
    sport,
  }
})
