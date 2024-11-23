import { ref, computed } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios'
import { useLoginStore } from './loginStore'

export const useEventStore = defineStore('events', () => {
    const loginStore = useLoginStore()
    const events = ref([])
    async function getEvents() {
        return axios
        .get(import.meta.env.VITE_BASE_URL + '/api/events',
            {headers: loginStore.headers}
        )
        .then((response) => {
            console.log(response.data)
            return response.data
        })
    }

    async function saveEvent(eventId) {
        return axios
        .post(import.meta.env.VITE_BASE_URL + '/api/user-event/add',
            {
                user_id: loginStore.id,
                event_id: eventId,
            },
            {headers: loginStore.headers}
        )
        .then((response) => {
            console.log(response.data)
            return response.data
        })
    }

    async function getPersonalEvents() {
        return axios
        .post(import.meta.env.VITE_BASE_URL + '/api/user-event/get',
            {
                user_id: loginStore.id
            },
            {headers: loginStore.headers}
        )
        .then((response) => {
            console.log(response.data)
            return response.data
        })
    }

    return { events,getEvents,saveEvent,getPersonalEvents }
})
