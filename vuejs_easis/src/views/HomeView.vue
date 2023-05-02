<template>
  <div class="flex justify-center items-center flex-col">
    <div class="text-4xl mb-10 bg-black bg-opacity-75 text-amber-300 p-4 rounded-xl border-2 border-amber-300">Site de la guilde Easis</div>
  </div>

  <div>Nombre d'instance réalisées : {{ nombreInstances }}</div>
</template>
<script>


import axios from "axios";

export default {
  data() {
    return {
      instances: [],
      nombreInstances: 0,
    };
  },
  beforeMount() {
    this.getLoginStatus()
  },
  methods: {
    getLoginStatus() {
      this.isLoggedIn = localStorage.getItem('isLoggedIn');
    },
    mounted() {
      axios.get("http://api.etheron.fr/api/instances")
          .then((response) => {
            const tempsInstances = Object.assign([], response.data);
            tempsInstances.forEach(elem => {
              this.instances.push(elem);
            })
            this.nombreInstances = response.data.length;
          })
    }
  }
}
</script>