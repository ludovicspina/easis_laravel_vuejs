<script setup>
import {RouterLink, RouterView} from 'vue-router'
import NavBar from "@/components/NavBar.vue";
import LateralBar from "@/components/LateralBar.vue";
</script>

<template>

  <div style="font-family: 'Maven Pro', sans-serif;">
      <div class="bg-black bg-opacity-90 mb-10 border-b-2 border-amber-300">
        <NavBar></NavBar>
      </div>
      <RouterView/>
  </div>
</template>

<style scoped>

</style>
