<template>
  <div class="flex flex-row h-svh">
    <!-- Навигационная панель -->
    <nav class="z-30">
      <ul class="flex flex-col gap-[12px] w-[300px] h-[100vh] bg-[#1A1A1A]">
        <img class="w-[268px] h-[213px] mt-[16px]" src="/icons/logo_with_black.svg" />

        <div class="flex flex-col ml-[16px] mt-[16px]">
          <li>
            <router-link to="/app">
              <ButtonMenu title="Главная" typeIcon="house" routeName="mainPage" />
            </router-link>
          </li>
          <li>
            <router-link to="/app/events">
              <ButtonMenu title="Мероприятия" typeIcon="calendar-search" routeName="events" />
            </router-link>
          </li>
          <li>
            <router-link to="/app/profile">
              <ButtonMenu title="Профиль" typeIcon="circle-user-round" routeName="profile" />
            </router-link>
          </li>
          <li>
            <router-link to="/">
              <ButtonMenu title="Выйти" typeIcon="LogOut" routeName="auth" />
            </router-link>
          </li>
        </div>
      </ul>
    </nav>

    <!-- Отображение текущей страницы -->
    <div class="max-h-full overflow-auto w-full z-50">
      <RouterView />
    </div>
  </div>
</template>

<script setup>
import { RouterView } from 'vue-router'
import ButtonMenu from '@/components/common/ButtonMenu.vue'
</script>

<style scoped></style>
