<template>
  <div>
    <button
      type="submit"
      class="shadow-md w-[450px] mt-[12px] h-[41px] rounded-[12px] active:shadow-md hover:bg-[#00C257] bg-[#00DB62] font-golos font-medium text-[21px] text-[#191919]"
      :class="widthStyle"
      >
      {{ props.title }}
    </button>
  </div>
</template>

<script setup>
import { ref } from 'vue';
const props = defineProps({
  title: String,
  widthType: {
    type: String,
    validator: value => ['auto','default'].includes(value),
    default: 'default'
  },
})
const widthStyle = ref('')
if(props.widthType === 'auto'){
  widthStyle.value = 'w-full'
}
</script>

<style lang="scss" scoped></style>
