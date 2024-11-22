<template>
  <div>
    <button
      type="submit"
      class="shadow-md w-[450px] mt-[12px] h-[41px] rounded-[12px] active:shadow-md hover:bg-[#00C257] bg-[#00DB62] font-golos font-medium text-[21px] text-[#191919]"
    >
      {{ title }}
    </button>
  </div>
</template>

<script setup>
defineProps({
  title: String,
})
</script>

<style lang="scss" scoped></style>
