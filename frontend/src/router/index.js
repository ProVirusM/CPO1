import { createRouter, createWebHistory } from 'vue-router'

// Импорт компонентов
import MainLayout from '@/layouts/MainLayout.vue' // Макет с навигацией
import MainPage from '@/components/MainPage.vue'
import EventsPage from '@/components/EventsPage.vue'
import ProfilePage from '@/components/ProfilePage.vue'
// import HomeView from '@/views/HomeView.vue' // Домашняя страница
import AuthView from '@/views/AuthView.vue' // Авторизация
import RegisterView from '@/views/RegisterView.vue' // Регистрация
import ErrorPage from '@/views/ErrorPage.vue' // Страница ошибки

// Создаем маршруты
const routes = [
  // {
  //   path: '/',
  //   name: 'home',
  //   component: HomeView, // Домашняя страница
  // },
  {
    path: '/',
    name: 'auth',
    component: AuthView, // Авторизация
  },
  {
    path: '/register',
    name: 'register',
    component: RegisterView, // Регистрация
  },
  {
    path: '/app',
    component: MainLayout, // Общий макет с навигацией
    children: [
      {
        path: '', // Пустой путь для главной страницы
        name: 'mainPage',
        component: MainPage, // Главная страница
      },
      {
        path: 'events',
        name: 'events',
        component: EventsPage, // Мероприятия
      },
      {
        path: 'profile',
        name: 'profile',
        component: ProfilePage, // Профиль
      },
    ],
  },
  {
    path: '/:catchAll(.*)', // Обработка ошибок
    name: 'error',
    component: ErrorPage,
  },
]

// Создаем экземпляр роутера
const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
})

export default router
