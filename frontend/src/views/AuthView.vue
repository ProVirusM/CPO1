<template>
  <div class="flex flex-wrap gap-[32px] items-center justify-center h-screen max-[830px]:h-0">
    <img class="max-[830px]:ml-[80px]" src="/icons/logo_with_text.svg" />
    <div class="w-[1px] h-[450px] bg-[#1A1A1A] max-[830px]:invisible"></div>
    <div class="flex min-h-full flex-col justify-center items-center px-6 py-12 lg:px-8">
      <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <h2 class="text-end font-golos font-bold text-[42px] cursor-default">Вход в систему</h2>
      </div>

      <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
        <form @submit.prevent="handleLogin" class="space-y-6">
          <InputField v-model="email" label="почта" placeholder="Введите почту..." title="email" />
          <InputField
            v-model="password"
            label="пароль"
            placeholder="Введите пароль..."
            title="password"
            type="password"
          />
          <AuthButton title="Войти" />
        </form>

        <p
          @click="router.push('/register')"
          class="mt-10 text-center ml-[64px] sm:mr-[2px] cursor-pointer font-golos font-medium text-[21px] text-[#191919]"
        >
          Зарегестрироваться
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
import InputField from '@/components/common/InputField.vue'
import AuthButton from '@/components/common/AuthButton.vue'
import { useRouter } from 'vue-router'
import { ref } from 'vue'
import { useLoginStore } from '@/stores/loginStore'

const router = useRouter()
const loginStore = useLoginStore()

console.log()

// Локальные переменные для email и password
const email = ref('')
const password = ref('')
const loginStatus = ref('')

// Обработчик для выполнения checkLogin
const handleLogin = async () => {
  const success = await loginStore.checkLogin(email.value, password.value)
  loginStatus.value = success ? 'login successful' : 'login failed'

  loginStore.logged ? router.push('/app') : alert('Неправильная почта или пароль')
}
</script>

<style lang="scss" scoped></style>
