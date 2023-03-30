<template>
  <div class="flex justify-center items-center flex-col">
    <div class="text-4xl mb-10 bg-black bg-opacity-90 text-amber-300 p-4 rounded-xl border-2 border-amber-300">Site de la guilde Easis</div>
  </div>
</template>
<script>


import RatiosView from "@/views/RatiosView.vue";

export default {
  components: {RatiosView},
  beforeMount() {
    this.getLoginStatus()
  },
  methods: {
    getLoginStatus() {
      this.isLoggedIn = localStorage.getItem('isLoggedIn');
    },
  }
}
</script>