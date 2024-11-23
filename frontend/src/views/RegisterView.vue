<template>
  <div class="flex flex-wrap gap-[32px] items-center justify-center h-screen max-[830px]:h-0">
    <img class="max-[830px]:ml-[80px]" src="/icons/logo_with_text.svg" />
    <div class="w-[1px] h-[450px] bg-[#1A1A1A] max-[830px]:invisible"></div>
    <div class="flex min-h-full flex-col justify-center items-center px-6 py-12 lg:px-8">
      <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <h2 class="text-end mr-[20px] font-golos font-bold text-[42px] cursor-default">
          Регистрация
        </h2>
      </div>

      <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
        <form @submit.prevent="handleRegister" class="space-y-6">
          <InputField v-model="email" label="почта" placeholder="Введите почту..." title="email" />
          <InputField v-model="name" label="имя" placeholder="Введите имя..." title="name" />
          <InputField
            v-model="password"
            label="пароль"
            placeholder="Введите пароль..."
            title="password"
          />
          <AuthButton title="Зарегистрироваться" />
        </form>

        <p
          @click="router.push('/')"
          class="mt-10 text-center ml-[50px] sm:mr-[2px] cursor-pointer font-golos font-medium text-[21px] text-[#191919]"
        >
          Войти
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
import InputField from '@/components/common/InputField.vue'
import AuthButton from '@/components/common/AuthButton.vue'
import { useRouter } from 'vue-router'
import { useToast } from 'vue-toastification'
import { useLoginStore } from '@/stores/loginStore'
import { ref } from 'vue'

const loginStore = useLoginStore()
const toast = useToast()

const email = ref('')
const name = ref('')
const password = ref('')

const router = useRouter()

const handleRegister = async () => {
  await loginStore.apiRegister(email.value, name.value, password.value)

  console.log('Данные', email.value, name.value)
  toast.success('Вы успешно зарегистрировались!')
  router.push('/')
  console.log('YES')
}
</script>

<style lang="scss" scoped></style>
