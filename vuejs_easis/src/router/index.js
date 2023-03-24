import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import CdgView from "@/views/CdgView.vue";
import LoginView from "@/views/LoginView.vue";
import DonjonsView from "@/views/DonjonsView.vue";
import ObjetsDonjonsView from "@/views/ObjetsDonjonsView.vue";
import InstancesView from "@/views/InstancesView.vue";
import RatiosView from "@/views/RatiosView.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/cdg',
      name: 'cdg',
      component: CdgView
    },
    {
      path: '/donjons',
      name: 'donjons',
      component: DonjonsView
    },
    {
      path: '/addObjet',
      name: 'objet-donjons',
      component: ObjetsDonjonsView
    },
    {
      path: '/instances',
      name: 'instances',
      component: InstancesView
    },
    {
      path: '/instances/ratios',
      name: 'ratios',
      component: RatiosView
    },

  ]
})

export default router
