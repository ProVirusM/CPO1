<template>
    <div class="flex flex-col pl-8 pr-8 pt-4 pb-8 gap-8 bg-[#F7F7F7] h-full overflow-auto">
        <div class="text-[42px] font-extrabold">Профиль</div>
        
        <div class="flex flex-wrap justify-between">
            <div class="flex flex-col gap-4">
                <div class="text-[32px] font-bold">Аккаунт</div>
                <div class="gap-1 flex flex-col">
                    <div class="text-sm font-bold">Как к вам обращаться</div>
                    <InputField color="primary" width-type="auto" placeholder="Ваше имя..."></InputField>
                </div>
            </div>

            <div class="flex flex-col gap-4">
                <div class="text-[32px] font-bold">Безопастность</div>
                <div class="flex flex-wrap gap-4">
                    <div class="flex flex-col gap-3">
                        <div class="gap-1 flex flex-col">
                            <div class="text-sm font-bold">Текущий пароль</div>
                            <InputField color="primary" width-type="auto" title="password" placeholder="Текущий пароль..."></InputField>
                        </div>
                        <div class="gap-1 flex flex-col">
                            <div class="text-sm font-bold">Новый пароль</div>
                            <InputField color="primary" width-type="auto" title="password" placeholder="Новый пароль..."></InputField>
                        </div>
                        <AuthButton title="Обновить пароль" width-type="auto"></AuthButton>
                    </div>
                    <div class="flex flex-col gap-3">
                        <div class="gap-1 flex flex-col">
                            <div class="text-sm font-bold">Активная почта</div>
                            <InputField color="primary" width-type="auto" v-model="currentMail" :disabled="true"></InputField>
                        </div>
                        <div class="gap-1 flex flex-col">
                            <div class="text-sm font-bold">Новая почта</div>
                            <InputField color="primary" width-type="auto" placeholder="Новая почта..."></InputField>
                        </div>
                        <AuthButton title="Обновить почту" width-type="auto"></AuthButton>
                    </div>
                </div>

            </div>
        </div>

        <div class="flex flex-col gap-4">
            <div class="flex flex-row justify-between">
                <div class="text-[32px] font-bold">Подписки</div>
                <div class="flex flex-row gap-2">
                    <InputField width-type="auto" color="primary" placeholder="Поиск..."></InputField>
                    <div class="p-2 border-solid border-[1px] border-[#D9D9D9] rounded-xl">
                        <Search color="black"/>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap justify-between gap-4">
                <SubscribeCard v-for="sub in subscribtions"
                    :name="sub.name"
                    :sport-types="sub.sportTypes"
                    :disciplines="sub.disciplines"
                    :age-groups="sub.ageGroups"
                    :take-places="sub.takePlaces"
                    :date-start="new Date(sub.dateStart)"
                    :date-end="new Date(sub.dateEnd)"
                    :amount-start="sub.amountStart"
                    :amount-end="sub.amountEnd"></SubscribeCard>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import InputField from './common/InputField.vue';
import AuthButton from './common/AuthButton.vue';
import SubscribeCard from './common/SubscribeCard.vue';
import { Database, Search } from 'lucide-vue-next';
const currentMail = ref('mail@mail.ru')

const subscribtions = ref([{
    name: 'Название подписки',
    sportTypes: ['Волейбол','Гандбол'],
    disciplines: ['Спортмастера россии и всего мира','Областные темки'],
    ageGroups: ['Мужики 45+','Женщины 20+'],
    takePlaces: ['Россия Липецк','США'],
    dateStart: '02.03.2025',
    dateEnd: '04.03.2025',
    amountStart: 228,
    amountEnd: 1337, 
},
{
    name: 'Название подписки',
    sportTypes: ['Волейбол','Гандбол'],
    disciplines: ['Спортмастера россии и всего мира','Областные темки'],
    ageGroups: ['Мужики 45+','Женщины 20+'],
    takePlaces: ['Россия Липецк','США'],
    dateStart: '02.03.2025',
    dateEnd: '04.03.2025',
    amountStart: 228,
    amountEnd: 1337, 
},{
    name: 'Название подписки',
    sportTypes: ['Волейбол','Гандбол'],
    disciplines: ['Спортмастера россии и всего мира','Областные темки'],
    ageGroups: ['Мужики 45+','Женщины 20+'],
    takePlaces: ['Россия Липецк','США'],
    dateStart: '02.03.2025',
    dateEnd: '04.03.2025',
    amountStart: 228,
    amountEnd: 1337, 
},{
    name: 'Название подписки',
    sportTypes: ['Волейбол','Гандбол'],
    disciplines: ['Спортмастера россии и всего мира','Областные темки'],
    ageGroups: ['Мужики 45+','Женщины 20+'],
    takePlaces: ['Россия Липецк','США'],
    dateStart: '02.03.2025',
    dateEnd: '04.03.2025',
    amountStart: 228,
    amountEnd: 1337, 
}])
</script>

<style lang="scss" scoped></style>
