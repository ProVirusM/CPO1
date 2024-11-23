<template>
  <div class="w-auto p-5 flex flex-col gap-4">
    <div class="flex flex-wrap gap-2 pl-20 pr-20">
      <SelectWithSearch text="Вид спорта"></SelectWithSearch>
      <SelectWithSearch :items="['Физра','Бег трусцой','Абоба', 'Климсаныч']" v-model="model" text="Дисциплина"></SelectWithSearch>
      <SelectWithSearch :items="['Физра','Бег трусцой','Абоба', 'Климсаныч']" v-model="model2" text="Программа"></SelectWithSearch>
      <SelectWithSearch text="Место проведения"></SelectWithSearch>
      <SelectWithSearch text="Количество участников"></SelectWithSearch>
      <SelectWithSearch text="Пол, возрастная группа"></SelectWithSearch>
      <SelectWithSearch text="Сроки проведения"></SelectWithSearch>
      <SelectWithSearch text="Тип"></SelectWithSearch>
      <button @click="modalSubscribeVisible = true" class="bg-[#312E5C] p-2 rounded-xl text-xl text-[#F7F7F7] font-bold flex gap-2 items-center active:bg-[#292650]">
        <Bell></Bell>
        Подписаться
      </button>
      <ModalSubscribe v-model="modalSubscribeVisible"/>
    </div>
    
    <CalendarPage></CalendarPage>
  </div>
</template>

<script setup>
  import CalendarPage from './CalendarPage.vue';
  import SelectWithSearch from './common/SelectWithSearch.vue';
  import ModalSubscribe from './common/ModalSubscribe.vue';
  import { Bell } from 'lucide-vue-next';
  import { ref } from 'vue';
  
  const model = ref([])
  const model2 = ref([])
  const modalSubscribeVisible = ref(false)
</script>

<style lang="scss" scoped></style>
