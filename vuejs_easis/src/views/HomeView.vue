<template>
  <div class="flex justify-center items-center">
    <div class="text-4xl">Site de la guilde Easis</div>
    <div>

    </div>
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