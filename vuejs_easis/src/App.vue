<script setup>
import {RouterLink, RouterView} from 'vue-router'
import NavBar from "@/components/NavBar.vue";
import LateralBar from "@/components/LateralBar.vue";
</script>

<template>

  <div style="font-family: 'Maven Pro', sans-serif;">
      <div class="bg-gradient-to-b from-neutral-800 to-neutral-900">
        <NavBar></NavBar>
        <div class="h-6"></div>
      </div>
      <RouterView/>
  </div>
</template>

<style scoped>
</style>
