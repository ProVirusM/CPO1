<template>
    <div ref="window" class="relative w-fit">
        <div @click="dropDownVisible = !dropDownVisible" 
            class="cursor-pointer relative rounded-xl w-fit pl-2 pr-2 pt-1 pb-1 flex flex-row items-center justify-center gap-[10px] border-solid border-[1px] outline-solid"
            :class="stylesWithItems">
            <div @click="clearFilter" v-if="somethingSelected">
                <CircleX color="#2E2E2E" fill="#F7F7F7"/>
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
            <div class="text-[21px] font-bold">От</div>
            <div class="flex flex-row gap-4 items-center">
                <div @click="start--"><Minus/></div>
                <InputField type="number" placeholder="Начальное значение" v-model="start" width-type="auto" color="primary" />
                <div @click="start++"><Plus/></div>
            </div>
            <div class="text-[21px] font-bold">До</div>
            <div class="flex flex-row gap-4 items-center">
                <div @click="end--"><Minus/></div>
                <InputField type="number" placeholder="Конечное значение" v-model="end" width-type="auto" color="primary"/>
                <div @click="end++"><Plus/></div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { ref } from 'vue';
    import { Plus,Minus,ChevronDown} from 'lucide-vue-next';
    import { onClickOutside } from '@vueuse/core';
    import InputField from './InputField.vue';
    const dropDownVisible = ref(false)
    const props = defineProps({
        text: String
    })
    const window = ref(null)
    onClickOutside(window,event=>{dropDownVisible.value = false})

    const start = defineModel('start')
    start.value = Number(start.value)
    const end = defineModel('end')
    end.value = Number(end.value)
</script>

<style lang="scss" scoped>
    .shadow{
        box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px;
    }
    .z-index{
        z-index: 100;
    }
    .outline-solid{
        outline: solid;
        transition: 0.1s;
        outline-width: 0px;
        outline-color: #D9D9D9;
    }
    .outline-solid:hover{
        outline-width: 1px;
    }
</style>