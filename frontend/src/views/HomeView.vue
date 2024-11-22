<script setup>
  import FullCalendar from '@fullcalendar/vue3'
  import dayGridPlugin from '@fullcalendar/daygrid'
  import timeGridPlugin from '@fullcalendar/timegrid'
  import interactionPlugin from '@fullcalendar/interaction'
  import listPlugin from '@fullcalendar/list'
  import multiMonthPlugin from '@fullcalendar/multimonth'

  import { ref } from 'vue'

  async function eventClick(info){
    console.log(info.event.id)
    alert(info.event.id)
    info.el.style.borderColor = 'red';
  } 

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
        center:'timeGridDay timeGridWeek dayGridMonth multiMonthYear',
        end:'today prev,next'
      },
      buttonText:{
        timeGridDay: 'День',
        timeGridWeek: 'Неделя',
        dayGridMonth: 'Месяц',
        multiMonthYear: 'Год',
        today: 'Перейти на сегодня'
      },
      locale: 'ru',
      plugins:[dayGridPlugin,timeGridPlugin,interactionPlugin,listPlugin,multiMonthPlugin]
    })
</script>

<template>
  <div class="p-5">
    <h1 class="text-3xl text-red-400">Home</h1>
    <FullCalendar :options="options">
        <template v-slot:eventContent='arg'>
          <b>{{ arg.event.title }}</b>
        </template>
    </FullCalendar>
  </div>
</template>


<style lang="scss" scoped></style>
