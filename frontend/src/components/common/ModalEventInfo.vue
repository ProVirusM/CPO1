<template>
    <div>
        <Modal class="w-max-4/5" title="О соревновании" v-model="model">
            <div class="flex flex-col p-5 gap-8">
                <div class="flex flex-col gap-4">
                    <div class="font-bold text-3xl">{{ props.sportType }}</div>
                    <div class="text-sm flex items-center gap-1 font-semibold">
                        <div>
                            <Sparkle size="24"/>
                        </div>
                        {{ props.sportSubType }}
                    </div>
                </div>
                <div class="gap-4 flex-col flex">
                    <div class="font-semibold text-xl">
                        {{ props.title }}
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

                    <div class="font-medium flex flex-col gap-2">
                        <div class="flex flex-row gap-2 text-sm items-center">
                            <Tags/>
                            Тэги
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <div class="bg-[#F7F7F7] rounded-xl p-2 w-fit" v-for="tag in props.tags">
                                {{ tag }}
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-row gap-10">
                        <div class="flex flex-col gap-2">
                            <div class="flex flex-row gap-2 font-medium text-sm items-center">
                                <div>
                                    <LandPlot></LandPlot>
                                </div>
                                <div>
                                    Страна
                                </div>
                            </div>
                            <div class="text-xl font-medium"> 
                                {{ props.country }}
                            </div>
                        </div>
                        <div class="flex flex-col gap-2">
                            <div class="flex flex-row gap-2 font-medium text-sm items-center">
                                <div>
                                    <MapPinned></MapPinned>
                                </div>
                                <div>
                                    Регион, Область
                                </div>
                            </div>
                            <div class="text-xl font-medium"> 
                                {{ props.region }}
                            </div>
                        </div>
                        <div class="flex flex-col gap-2">
                            <div class="flex flex-row gap-2 font-medium text-sm items-center">
                                <div>
                                    <Building2></Building2>
                                </div>
                                <div>
                                    Город
                                </div>
                            </div>
                            <div class="text-xl font-medium"> 
                                {{ props.city }}
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
                            {{ props.participantsAmount }}
                        </div>
                        <div class="flex items-center justify-center">
                            <AuthButton title="Добавить в личный календарь"></AuthButton>
                        </div>
                    </div>
                </div>
            </div>
        </Modal>
    </div>
</template>

<script setup>
    import Modal from './Modal.vue';
    import AuthButton from './AuthButton.vue';
    import {Sparkle,CalendarArrowUp,CalendarArrowDown,Tags,LandPlot,MapPinned,Building2, PersonStanding} from 'lucide-vue-next'
    
    const props = defineProps({
        sportType: String,
        sportSubType: String,
        title: String,
        dateStart: Date,
        dateEnd: Date,
        tags: Array,
        country: String,
        region: String,
        city: String,
        participantsAmount: Number
    })
    const model = defineModel()
</script>

<style lang="scss" scoped>

</style>