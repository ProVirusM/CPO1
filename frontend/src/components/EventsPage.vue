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
    </div>
    
    <CalendarPage></CalendarPage>
  </div>
</template>

<script setup>
  import CalendarPage from './CalendarPage.vue';
  import SelectWithSearch from './common/SelectWithSearch.vue';
  import { ref } from 'vue';
  
  const model = ref([])
  const model2 = ref([])
</script>

<style lang="scss" scoped></style>
