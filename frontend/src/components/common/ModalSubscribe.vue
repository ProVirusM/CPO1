<script setup>
    import Modal from './Modal.vue';    
    import InputField from './InputField.vue';
    import AuthButton from './AuthButton.vue';
    const model = defineModel()
    
    
</script>

<template>
    <div>
        <Modal title="Подписаться на фильтр" v-model="model">
            <div class="p-4 flex flex-col gap-4 max-w-[416px]">
                <div class="flex flex-col gap-2">
                    <div class="font-medium text-xl">Введите почту и нажмите «Подписаться», для получения уведомлений об изменениях в соревнованиях по настроенному фильтру:</div>
                    <InputField color="primary" width-type="auto" placeholder="Введите почту..."></InputField>
                </div>
                <div class="flex flex-col gap-2"> 
                    <div class="font-medium text-xl">Для удобства вы можете дать подписке название:</div>
                    <InputField color="primary" width-type="auto" placeholder="Введите название подписки..."></InputField>
                </div>
                
                <AuthButton width-type="auto" title="Подписаться"></AuthButton>
            </div>
            
        </Modal>
    </div>
</template>


<style lang="scss" scoped>

</style>