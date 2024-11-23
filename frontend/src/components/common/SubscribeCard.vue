<template>
    <div class="flex flex-col p-5 gap-8 border-solid border-[1px] border-[#D9D9D9] rounded-xl">
                <div class="flex flex-col gap-4">
                    <div class="font-bold text-3xl flex flex-row justify-between gap-4">
                        {{ props.name }}
                        <div class="bg-[#DB1200] rounded-xl p-2">
                            <MailX color="#F7F7F7"></MailX>
                        </div>
                    </div>
                </div>
                
                <div class="gap-4 flex-col flex">
                    <div class="font-medium flex flex-col gap-2">
                        <div class="flex flex-row gap-2 text-sm items-center">
                            <Bike/>
                            Виды спорта
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <div class="bg-[#F7F7F7] border-solid border-[1px] border-[#D9D9D9] rounded-xl p-2 w-fit" v-for="tag in props.sportTypes">
                                {{ tag }}
                            </div>
                        </div>
                    </div>
                    <div class="font-medium flex flex-col gap-2">
                        <div class="flex flex-row gap-2 text-sm items-center">
                            <Sparkle/>
                            Дисциплины, команды
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <div class="bg-[#F7F7F7] border-solid border-[1px] border-[#D9D9D9] rounded-xl p-2 w-fit" v-for="tag in props.disciplines">
                                {{ tag }}
                            </div>
                        </div>
                    </div>
                    <div class="font-medium flex flex-col gap-2">
                        <div class="flex flex-row gap-2 text-sm items-center">
                            <Tags/>
                            Пол, возрастные группы
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <div class="bg-[#F7F7F7] border-solid border-[1px] border-[#D9D9D9] rounded-xl p-2 w-fit" v-for="tag in props.ageGroups">
                                {{ tag }}
                            </div>
                        </div>
                    </div>
                    <div class="font-medium flex flex-col gap-2">
                        <div class="flex flex-row gap-2 text-sm items-center">
                            <MapPinned/>
                            Места проведения
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <div class="bg-[#F7F7F7] border-solid border-[1px] border-[#D9D9D9] rounded-xl p-2 w-fit" v-for="tag in props.takePlaces">
                                {{ tag }}
                            </div>
                        </div>
                    </div>
                    <div class="flex  gap-8 font-medium">
                        <div class="flex flex-col">
                            <div class="flex flex-col gap-2">
                                <div class="flex gap-2">
                                    <CalendarArrowUp/>
                                    Дата начала    
                                </div>
                                {{ props.dateStart.toLocaleDateString('ru') }}
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <div class="flex gap-2 flex-col">
                                <div class="flex gap-2">
                                    <CalendarArrowDown/>
                                    Дата конца
                                </div>
                                {{ props.dateEnd.toLocaleDateString('ru') }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex flex-col gap-2">
                        <div class="flex flex-row gap-2">
                            <PersonStanding></PersonStanding>
                            <div class="text-sm font-medium">
                                Кол-во участников
                            </div>
                        </div>
                        <div class="text-xl font-medium">
                            От <b>{{ props.amountStart }}</b> до <b>{{ props.amountEnd }}</b>
                        </div>
                    </div>
                </div>
            </div>
</template>

<script setup>
    import { MailX } from 'lucide-vue-next';
    import {Sparkle,CalendarArrowUp,CalendarArrowDown,Tags,LandPlot,MapPinned,Building2, PersonStanding, Bike} from 'lucide-vue-next'
    
    const props = defineProps({
        name: String,
        sportTypes: Array,
        disciplines: Array,
        ageGroups: Array,
        takePlaces: Array,
        dateStart: Date,
        dateEnd: Date,
        amountStart: Number,
        amountEnd: Number,
    })
</script>

<style lang="scss" scoped>

</style>