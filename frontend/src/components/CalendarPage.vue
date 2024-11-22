<script setup>
  import FullCalendar from '@fullcalendar/vue3'
  import dayGridPlugin from '@fullcalendar/daygrid'
  import timeGridPlugin from '@fullcalendar/timegrid'
  import interactionPlugin from '@fullcalendar/interaction'
  import listPlugin from '@fullcalendar/list'
  import multiMonthPlugin from '@fullcalendar/multimonth'
  import AuthButton from './common/AuthButton.vue'
  import Modal from './common/Modal.vue'
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
    <Modal title="Подробнее о мероприятии 2132398123921" v-model="eventModalVisible">
        <div class="flex flex-col p-5 gap-2">
            <div>
                <div class="font-bold">Идентификатор</div>
                <div class="ml-5">2391239232392</div>
            </div>
            <div>
                <div class="font-bold">Вид спорта</div>
                <div class="ml-5">Футбольчик</div>
            </div>
            
            <div>
                <div class="font-bold">Название мероприятия</div>
                <div class="ml-5">Футбольчик с пацанами на улице (без правил)</div>
            </div>
            <div>
                <div class="font-bold">Тэги</div>
                <div class="ml-5">Боль, ссадины, хорошее настроение</div>
            </div>
            
            <div>
                <div class="font-bold">Сроки проведения</div>
                <div class="ml-5">02.03.2025 - 04.03.2025</div>
            </div>
            
            <div>
                <div class="font-bold">Количество участников (чел.)</div>
                <div class="ml-5">255</div>
            </div>
            <div class="text-xl font-bold">Место проведения</div>
            <div>
                <div class="font-bold">Страна</div>
                <div class="ml-5">Россия</div>
                </div>
            
          
            <div>
                <div class="font-bold">Регион</div>
                <div class="ml-5">Липецкая область</div>
            </div>
            <div>
                <div class="font-bold">Город</div>
                <div class="ml-5">Липецк</div>
            </div>
            <AuthButton title="Добавить в личный календарь"></AuthButton>
        </div>
    </Modal>
  </div>
</template>


<style scoped>

</style>
