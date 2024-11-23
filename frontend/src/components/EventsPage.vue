<template>
  <div class="w-auto p-5 flex flex-col gap-4">
    <div class="flex flex-wrap gap-2 pl-20 pr-20">
      <SelectWithSearch
        :items="filterStore.sport"
        v-model="model3"
        text="Вид спорта"
        @open="loadSports"
      ></SelectWithSearch>
      <SelectWithSearch
        :items="filterStore.division"
        v-model="model"
        text="Дивизион"
        @open="loadDivisions"
      ></SelectWithSearch>
      <SelectWithSearch
        :items="filterStore.placeCity"
        v-model="model2"
        text="Место проведения"
        @open="loadPlaceCity"
      ></SelectWithSearch>
      <!-- <SelectWithSearch text="Пол, возрастная группа"></SelectWithSearch> -->
      <SelectWithSearch
        :items="filterStore.regionPlace"
        v-model="model5"
        text="Регион проведения"
        @open="loadRegionPlace"
      ></SelectWithSearch>
      <SelectWithSearch
        :items="filterStore.tag"
        v-model="model4"
        text="Тип"
        @open="loadTags"
      ></SelectWithSearch>
      <ParticipantsPicker
        v-model:start="amountStart"
        v-model:end="amountEnd"
        text="Количество участников"
      ></ParticipantsPicker>
      <div class="w-128 flex items-center">
        <VueDatePicker
          placeholder="Выберите интервал дат"
          width="200px"
          ref="dp"
          v-model="dateRange"
          locale="ru"
          :range="true"
          :enable-time-picker="false"
        >
          <template #action-buttons>
            <p class="bg-[#00DB62] p-2 rounded-xl font-bold" @click="selectDate">
              Выбрать интервал
            </p>
          </template>
        </VueDatePicker>
      </div>
      <button
        @click="modalSubscribeVisible = true"
        class="bg-[#312E5C] p-2 pt-1 pb-1 rounded-xl text-xl text-[#F7F7F7] font-bold flex gap-2 items-center active:bg-[#292650]"
      >
        <Bell></Bell>
        Подписаться
      </button>
      <ModalSubscribe v-model="modalSubscribeVisible" />
    </div>

    <CalendarPage></CalendarPage>
  </div>
</template>

<script setup>
import CalendarPage from './CalendarPage.vue'
import SelectWithSearch from './common/SelectWithSearch.vue'
import ModalSubscribe from './common/ModalSubscribe.vue'
import VueDatePicker from '@vuepic/vue-datepicker'
import { Bell } from 'lucide-vue-next'
import { ref } from 'vue'
import ParticipantsPicker from './common/ParticipantsPicker.vue'
import { useFilterStore } from '@/stores/filterStore'
import { useLoginStore } from '@/stores/loginStore'

const model = ref([])
const model2 = ref([])
const model3 = ref([])
const model4 = ref([])
const model5 = ref([])
const dateRange = ref([])
const modalSubscribeVisible = ref(false)
const amountStart = ref(0)
const amountEnd = ref(10000)

const filterStore = useFilterStore()

// Функции для загрузки данных
const loadSports = async () => {
  if (!filterStore.sport.length) {
    await filterStore.getSports()
  }
}

const loadDivisions = async () => {
  if (!filterStore.division.length) {
    await filterStore.getDivisions()
  }
}

const loadPlaceCity = async () => {
  if (!filterStore.placeCity.length) {
    await filterStore.getPlaceCity()
  }
}

const loadTags = async () => {
  if (!filterStore.tag.length) {
    await filterStore.getTag()
  }
}

const loadRegionPlace = async () => {
  if (!filterStore.regionPlace.length) {
    await filterStore.getRegionPlace()
  }
}

// Выбор интервала дат
const dp = ref()
const selectDate = () => {
  dp.value.selectDate()
}
</script>
