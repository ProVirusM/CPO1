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

    const items = ref(props.items)
    const selectedItems = defineModel()
    selectedItems.value = []

    watch(()=>selectedItems.value.length, ()=>{
        console.log({...selectedItems.value})
        if(selectedItems.value.length > 0){
            somethingSelected.value = true
            stylesWithItems.value = ["text-[#F7F7F7]","bg-[#2E2E2E]"]
        }else{
            somethingSelected.value = false
            stylesWithItems.value = ref([])
        }
    })
    const stylesWithItems = ref([])
    const somethingSelected = ref(false)
    const dropDownVisible = ref(false)
    const window = ref()

    function itemChecked(item,isChecked){
        console.log(isChecked)
        console.log(item)
        selectedItems.value.push(item)
        items.value = items.value.filter((filtered1)=>{return filtered1 !== item})
        
    }

    function itemUnchecked(item,isChecked){
        items.value.push(item)
        selectedItems.value = selectedItems.value.filter((filtered1)=>{return filtered1 !== item})
    }

    const checkbox = ref(null)
    function clearFilter(){
        selectedItems.value = []
        items.value = props.items
    }
    const trueref = ref(true)
    const falseref = ref(false)
    onClickOutside(window,event=>{dropDownVisible.value = false})

    const inputModel = ref('')
    function filterBySearch(searchValue){
        const set = new Set(selectedItems.value)
        items.value = props.items.filter(elem=>!set.has(elem))
        items.value = items.value.filter((filtered)=>{return filtered.toLowerCase().includes(searchValue.toLowerCase())})
    }
</script>

<template>
    <div ref="window" class="relative w-fit">
        <div @click="dropDownVisible = !dropDownVisible" 
        class="cursor-pointer relative rounded-xl w-fit p-2 flex flex-row items-center justify-center gap-[10px]"
        :class="stylesWithItems">
            <div @click="clearFilter" v-if="somethingSelected">
                <CircleX />
            </div>
            
            <div class="text-[21px] font-bold">
                {{ props.text }}
            </div>
            <div>
                <ChevronDown />
            </div>
            
        </div>
        <div v-show="dropDownVisible" class="shadow absolute top-full bg-[#EBEBEB] p-4 min-w-[350px] flex flex-col gap-4 z-index rounded-xl right-2/4 translate-x-1/2">
            <div class="text-[21px] font-medium">{{ props.text }}</div>
            <div class="flex items-center gap-2 "> 
                <InputField @changed="filterBySearch(inputModel)" v-model="inputModel" color="primary" width-type="auto" placeholder="Поиск..."></InputField>
                <div class="p-2 bg-[#1A1A1A] rounded-xl">
                    <Search color="#F7F7F7"/>
                </div>
            </div>
            <div class="h-[200px] overflow-auto flex flex-col gap-4">
                <CheckBox behavior="manual" :checked="true" @changed="(isChecked)=>itemUnchecked(item,isChecked)" v-for="item in selectedItems" :title="item"/>
                <CheckBox behavior="manual" :checked="false" @changed="(isChecked)=>itemChecked(item,isChecked)" v-for="item in items" :title="item"></CheckBox>
            </div>
            
        </div>
    </div>
</template>


<style lang="scss" scoped>
    .shadow{
        box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px;
    }
    .z-index{
        z-index: 100;
    }
</style>