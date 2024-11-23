<script setup>
  import FullCalendar from '@fullcalendar/vue3'
  import dayGridPlugin from '@fullcalendar/daygrid'
  import timeGridPlugin from '@fullcalendar/timegrid'
  import interactionPlugin from '@fullcalendar/interaction'
  import listPlugin from '@fullcalendar/list'
  import multiMonthPlugin from '@fullcalendar/multimonth'
  import AuthButton from './common/AuthButton.vue'
  import Modal from './common/Modal.vue'
  import ModalEventInfo from './common/ModalEventInfo.vue'
  import SelectWithSearch from './common/SelectWithSearch.vue'

  import { ref } from 'vue'

  async function eventClick(info){
    console.log(info.event.id)
    info.el.style.borderColor = 'red';
    eventModalVisible.value = true
  } 

  const eventModalVisible = ref(false)

  const options = ref({
      initialView: 'dayGridMonth',
      eventClick: eventClick,
      events: [
          { title: 'event 1',id: 1, start: '2024-11-22T10:00',end: '2024-11-23T13:00' },
          { title: 'event 2', date: '2024-11-23' },
          { title: 'event 3', date: '2024-11-23' },
          { title: 'event 4', date: '2024-11-23' },
          { title: 'event 5', date: '2024-11-23' },
          { title: 'event 6', date: '2024-11-23' },
        ],
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
    <ModalEventInfo v-model="eventModalVisible" 
        city="Липецк"
        country="Россия"
        :dateStart="new Date('02.03.2025')"
        :dateEnd="new Date('02.03.2025')"
        participantsAmount="228"
        region="Липецкая область"
        sportType="Бадминтон"
        sportSubType="Основной состав"
        :tags="['Мужики','Еще кто-то']"
        />
  </div>
</template>


<style scoped>

</style>
