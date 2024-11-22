<script setup>
    import { ref } from 'vue';
    import { watch } from 'vue';
    import {CircleX,ChevronDown, Search} from 'lucide-vue-next'
    import { onClickOutside } from '@vueuse/core';
    import CheckBox from './CheckBox.vue';
    
    import InputField from './InputField.vue';

    const props = defineProps({
        text: String,
        items: Array,
    })

    const selectedItems = defineModel()

    watch(()=>selectedItems, ()=>{
        if(selectedItems.value){
            somethingSelected.value = true
        }else{
            somethingSelected.value = false
        }
    })
    const somethingSelected = ref(false)
    const dropDownVisible = ref(false)
    const window = ref()
    onClickOutside(window,event=>{dropDownVisible.value = false})
</script>

<template>
    <div ref="window" class="relative w-fit">
        <div @click="dropDownVisible = !dropDownVisible" class="cursor-pointer bg-[#2E2E2E] relative rounded-xl w-fit p-2 text-[#F7F7F7] flex flex-row items-center justify-center gap-[10px]">
            <CircleX />
            <div class="text-[21px] font-bold">
                {{ props.text }}
            </div>
            <div>
                <ChevronDown />
            </div>
            
        </div>
        <div  v-if="dropDownVisible" class="absolute top-full bg-[#EBEBEB] p-4 w-fit flex flex-col gap-4 z-50 rounded-xl ">
            <div class="text-[21px] font-medium">{{ props.text }}</div>
            <div class="flex items-center gap-2 "> 
                <InputField color="primary" width-type="auto" placeholder="Поиск..."></InputField>
                <div class="p-2 bg-[#1A1A1A] rounded-xl">
                    <Search color="#F7F7F7"/>
                </div>
            </div>
            <div class="h-[200px] overflow-auto flex flex-col gap-4">
                <CheckBox v-for="i in 20" title="Мальчики, 33-45 лет"/>
            </div>
            
        </div>
    </div>
</template>


<style lang="scss" scoped>

</style>