<template>
  <div
    @click="handleClick"
    class="flex flex-wrap gap-[10px] w-[268px] items-center h-[48px] align-middle"
    :class="{
      'bg-[#2E2E2E] rounded-[12px]': isActive,
      'text-black': isActive,
      'text-[#F7F7F7]': !isActive,
    }"
  >
    <House
      v-if="typeIcon === 'house'"
      class="mt-[1.5px] ml-[10px]"
      width="24px"
      height="24px"
      :color="isActive ? '#F7F7F7' : '#F7F7F7'"
    />
    <CalendarSearch
      v-if="typeIcon === 'calendar-search'"
      class="mt-[1.5px] ml-[10px]"
      width="24px"
      height="24px"
      :color="isActive ? '#F7F7F7' : '#F7F7F7'"
    />
    <CircleUserRound
      v-if="typeIcon === 'circle-user-round'"
      class="mt-[1.5px] ml-[10px]"
      width="24px"
      height="24px"
      :color="isActive ? '#F7F7F7' : '#F7F7F7'"
    />
    <LogOut
      v-if="typeIcon === 'LogOut'"
      class="mt-[1.5px] ml-[10px]"
      width="24px"
      height="24px"
      :color="isActive ? '#F7F7F7' : '#F7F7F7'"
    />
    <p class="font-golos font-medium text-[21px] text-[#F7F7F7] pb-[0.5px]">
      {{ title }}
    </p>
  </div>
</template>

<script setup>
import { House, CalendarSearch, CircleUserRound, LogOut } from 'lucide-vue-next'
import { computed } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()

// Получение props
const props = defineProps({
  title: String,
  typeIcon: String,
  routeName: String,
})

const isActive = computed(() => route.name === props.routeName)

const handleClick = () => {
  console.log(`Clicked: ${props.routeName}, Current Route: ${route.name}`)
}
</script>
