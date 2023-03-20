<template>

  <div class="grid grid-cols-4 gap-2 mx-2 mb-10" v-if="userRole >= 100">
    <div v-for="joueur in joueurs" class="flex flex-col border p-2 justify-center items-center">
      <div class="text-xl underline text-neutral100">{{ joueur.pseudo }}</div>
      <div class="flex justify-center items-center gap-1">
        <button class="hover:scale-125 transition delay-50" @click="removeOneItem(joueur.id)">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
               stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
        </button>
        {{ joueur.nombre_donjons }}
        donjons
        <button class="hover:scale-125 transition delay-50" @click="addOneItem(joueur.id)">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
               stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
        </button>
      </div>
      <div>{{ joueur.nombre_donjons }} objets</div>
      <div>
        <form class="grid grid-cols-6 gap-4">
          <div></div>
          <input placeholder="Objet*" class="col-span-2 bg-neutral-800 border border-neutral-700 rounded text-center">
          <input placeholder="Contribution"
                 class="col-span-2 bg-neutral-800 border border-neutral-700 rounded text-center">
          <div class="flex justify-center items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="w-5 h-5 hover:scale-125 transition delay-50">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
            </svg>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "CdgView",
  data() {
    return {
      joueurs: [],
    }
  },
  mounted() {
    axios.get("http://localhost:8000/api/joueurs")
        .then((response) => {

          const tempJoueurs = Object.assign([], response.data);
          tempJoueurs.forEach(elem => {
            this.joueurs.push(elem);
          })
        })
  },
  methods: {
    addOneItem(id) {
      axios.put('http://localhost:8000/api/joueurs/add-one-item/' + id);
      this.joueurs.forEach(elem => {
            if (elem.id === id) {
              elem.nombre_donjons++;
            }
          }
      );

    },
    removeOneItem(id) {
      axios.put('http://localhost:8000/api/joueurs/remove-one-item/' + id);
      this.joueurs.forEach(elem => {
            if (elem.id === id) {
              elem.nombre_donjons--;
            }
          }
      );
    }
  }
}
</script>

<style scoped>

</style>