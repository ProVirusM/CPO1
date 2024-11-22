<template>
  <div>
    <label :for="label" class="block font-golos font-medium text-[14px] text-black">{{
      label
    }}</label>
    <div class="">
      <input
        v-model="model"
        :placeholder="placeholder"
        :id="title"
        :name="title"
        :type="title"
        required
        class="block w-[450px] h-[41px] rounded-[12px] focus:bg-[#F7F7F7] bg-[#EBEBEB] pl-[16px] pt-[8px] pb-[8px] font-golos font-regular text-[21px] text-[#191919] outline-[#00C257] shadow-md"
        :class="[widthStyle,colorStyle]"
        />
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
const props = defineProps({
  title: String,
  placeholder: String,
  label: String,
  widthType: {
    type: String,
    validator: value => ['auto','default'].includes(value),
    default: 'default'
  },
  color: {
    type: String,
    validator: value => ['primary','secondary'].includes(value),
    default: 'secondary'
  }
})
const model = defineModel()
const widthStyle = ref('')
const colorStyle = ref('')

if(props.widthType === 'auto'){
  widthStyle.value = 'w-auto'
}
if(props.color === 'primary'){
  colorStyle.value = 'bg-[#F7F7F7]'
}
</script>

<style lang="scss" scoped>

</style>
