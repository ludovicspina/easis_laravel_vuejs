<template>
  <form @submit.prevent="add_item">
    <label>Objet</label>
    <input v-model="libelle" type="text" required>
    <label>contrib</label>
    <input v-model="contribution" type="text" required>
    <label>participants</label>
    <div>
      <label>{{ joueur.pseudo }}</label>
      <input v-for="joueur in joueurs" type="checkbox" v-model="participants" :value="joueur.id">
    </div>
    <button type="submit">ok</button>
  </form>
</template>


<script>
import axios from "axios";

export default {
  data() {
    return {
      joueurs: [],
      libelle: '',
      contribution: '',
      participants: [],
    };
  },

  computed: {
    isLoggedIn() {
      return localStorage.getItem('isLoggedIn');
    }
  },
  mounted() {
    axios.get("http://api.etheron.fr/api/joueurs")
        .then((response) => {
          const tempJoueurs = Object.assign([], response.data);
          tempJoueurs.forEach(elem => {
            this.joueurs.push(elem);
          })
        })
  },

  methods: {
    //user login function and api call
    add_item() {
      axios.post("http://api.etheron.fr/api/donjons/createItem", {
        libelle: this.libelle,
        contribution: this.contribution,
        participants: this.participants,
      })
          .then((response) => {
            console.log(response);
          })
          .catch((error) => {
            console.log(error);
          });
    }
  },

};
</script>


<style scoped>

</style>