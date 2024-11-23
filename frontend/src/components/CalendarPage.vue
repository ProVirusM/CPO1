<script setup>
  import FullCalendar from '@fullcalendar/vue3'
  import dayGridPlugin from '@fullcalendar/daygrid'
  import timeGridPlugin from '@fullcalendar/timegrid'
  import interactionPlugin from '@fullcalendar/interaction'
  import listPlugin from '@fullcalendar/list'
  import multiMonthPlugin from '@fullcalendar/multimonth'
  import AuthButton from './common/AuthButton.vue'
  import Modal from './common/Modal.vue'
  import { watch } from 'vue'
  import ModalEventInfo from './common/ModalEventInfo.vue'
  import SelectWithSearch from './common/SelectWithSearch.vue'

  import { ref } from 'vue'

  async function eventClick(info){
    console.log(info.event.extendedProps.data)
    pickedEvent.value = {...info.event.extendedProps.data}
    info.el.style.borderColor = 'red';
    eventModalVisible.value = true
  } 
  const eventsModel = defineModel()
  const pickedEvent = ref(null)
  const events = ref([])
  watch(()=>eventsModel.value,()=>{
    events.value = eventsModel.value.map((event)=>({id: event.ekp_id,title:event.sport +' '+ event.title,start: event.from_date,end: event.to_date,data: event}))
    options.value.events = events.value
  })

  const eventModalVisible = ref(false)

  const options = ref({
      initialView: 'dayGridMonth',
      eventClick: eventClick,
      events: events.value,
      headerToolbar: {
        start: 'title',
        center:'timeGridDay,timeGridWeek,dayGridMonth,multiMonthYear listWeek,listMonth',
        end:'today prev,next'
      },
      buttonText:{
        timeGridDay: 'День',
        listWeek: 'Список за неделю',
        timeGridWeek: 'Неделя',
        dayGridMonth: 'Месяц',
        multiMonthYear: 'Год',
        listMonth: 'Список за месяц',
        today: 'Перейти на сегодня'
      },
      locale: 'ru',
      plugins:[dayGridPlugin,timeGridPlugin,interactionPlugin,listPlugin,multiMonthPlugin]
    })
</script>

<template>
  <div>
    <FullCalendar :options="options">
        <template v-slot:eventContent='arg'>
          <b>{{ arg.event.title }}</b>
        </template>
    </FullCalendar>
    <ModalEventInfo v-if="pickedEvent" v-model="eventModalVisible" 
        :id="pickedEvent.ekp_id"
        :city="pickedEvent.place"
        :country="pickedEvent.country"
        :dateStart="new Date(pickedEvent.from_date)"
        :dateEnd="new Date(pickedEvent.to_date)"
        :participantsAmount="pickedEvent.amount"
        :region="pickedEvent.region"
        :sportType="pickedEvent.sport"
        :sportSubType="pickedEvent.division"
        :tags="pickedEvent.tags"
        />
  </div>
</template>


<style scoped>

</style>
