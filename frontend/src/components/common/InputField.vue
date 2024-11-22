<template>
  <div>
    <label :for="label" class="block font-golos font-medium text-[14px] text-black">{{
      label
    }}</label>
    <div class="">
      <input
        :placeholder="placeholder"
        :id="title"
        :name="title"
        :type="title"
        required
        class="block w-[450px] h-[41px] rounded-[12px] focus:bg-[#F7F7F7] bg-[#EBEBEB] pl-[16px] pt-[8px] pb-[8px] font-golos font-regular text-[21px] text-[#191919] outline-[#00C257] shadow-md"
      />
    </div>
  </div>
</template>

<script setup>
defineProps({
  title: String,
  placeholder: String,
  label: String,
})
</script>

<style lang="scss" scoped></style>
