<template>
  <div class="flex flex-wrap h-screen items-center justify-center gap-[32px]">
    <div class="w-[192px] h-[192px] bg-[url('/icons/404.svg')]"></div>
    <div class="flex flex-col items-center">
      <h1 class="font-golos font-bold text-[42px] mb-4 cursor-default">404</h1>
      <p class="mt-[16px] font-golos font-regular text-[21px] fill-black cursor-default">
        Страница не найдена
      </p>

      <router-link to="/">
        <button
          class="font-golos font-medium text-[21px] mt-[32px] fill-[#191919] w-[234px] h-[41px] stroke-[#1A1A1A] border-[1px] active:shadow-;g hover:shadow-md rounded-[12px]"
        >
          Вернуться обратно
        </button></router-link
      >
    </div>
  </div>
</template>

<script setup></script>

<style scoped></style>
