<template>
  <div>
    <label :for="label" class="block font-golos font-medium text-[14px] text-black">{{
      label
    }}</label>
    <div class="">
      <input
        v-model="model"
        @input="$emit('changed')"
        @change="onChange($event)"
        @keypress="onChange($event)"
        :placeholder="props.placeholder"
        :id="props.title"
        :name="props.title"
        :type="props.title"
        :disabled="props.disabled"
        required
        class="block w-[450px] h-[41px] rounded-[12px] focus:bg-[#F7F7F7] border-[1px] bg-[#EBEBEB] pl-[16px] pt-[8px] pb-[8px] font-golos border-solid border-[#D9D9D9] font-regular text-[21px] text-[#191919] outline-[#00C257]"
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
  },
  disabled: {
    type: Boolean,
    validator: value => [true,false].includes(value),
    default: false
  },
  type: String
})

const emits = defineEmits('changed')
const model = defineModel()
const widthStyle = ref('')
const colorStyle = ref('')

if(props.widthType === 'auto'){
  widthStyle.value = 'w-full'
}
if(props.color === 'primary'){
  colorStyle.value = 'bg-[#F7F7F7]'
}

const lastInput = ref('')
function onPress(event){
    if(props.type == 'number'){
        const keysAllowed = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '.'];
        const keyPressed = event.key;
        
        if (!keysAllowed.includes(keyPressed)) {
            event.preventDefault()
        }
    }
}

function onChange(event){
    if(props.type != 'number') return
    onPress(event)
    if(props.type == 'number'){
        if(model.value <= 0){
            model.value = 1
        }
    }
  }

</script>

<style lang="scss" scoped>

</style>
