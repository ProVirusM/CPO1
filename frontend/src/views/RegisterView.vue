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
        <form class="space-y-6" action="#" method="POST">
          <InputField label="почта" placeholder="Введите почту..." title="email" />
          <InputField label="имя" placeholder="Введите имя..." title="name" />
          <InputField label="пароль" placeholder="Введите пароль..." title="password" />
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

const router = useRouter()
</script>

<style lang="scss" scoped></style>
