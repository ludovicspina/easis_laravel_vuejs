<template>

</template>
<script>


export default {
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