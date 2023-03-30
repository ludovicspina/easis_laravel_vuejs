<template>
  <div v-if="(userRole >= 80)" class="bg-black flex justify-center gap-2 mx-4 py-4 h-48">
    <select multiple>
      <template v-for="objet in packedRepartition">
        <option @click="setObjet(objet)" v-if="objet.nombre > 0">({{ objet.nombre }}){{ objet.libelle }}</option>
      </template>
    </select>
    <select multiple>
      <template v-for="joueur in axiosJoueurs">
        <option @click="setJoueur(joueur)">{{ joueur.pseudo }}</option>
      </template>
    </select>
    <div class="flex justify-center items-center">
      <button type="button" @click="addRepartition"
              style="text-shadow: 1px 1px 2px white;" class="bg-gradient-to-b from-amber-200 via-amber-400 to-amber-200 hover:from-amber-100 hover:via-amber-300 hover:to-amber-100 rounded-xl text-neutral-800 font-medium px-3 border-double border-[7px] border-neutral-800">
        Ajouter
      </button>
    </div>
  </div>

  <div class="gap-6 flex justify-center items-center bg-black text-amber-200">
    <div>{{ selectedObjet.libelle }}</div>
    <div class="border border-amber-300 rounded">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="fill-amber-300 stroke-amber-300 w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
      </svg>

    </div>
    <div>{{ selectedJoueur.pseudo }}</div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "Repartition",
  data() {
    return {
      axiosObjets: [],
      axiosRepartition: [],
      axiosJoueurs: [],
      axiosRepartis: [],

      packedRepartition: [],

      selectedJoueur: [],
      selectedObjet: [],

      Navbar: 0,
      "user":
          {
            "email": "",
            "password": ""
          },
      isLoggedIn: false,
      userRole: 0,
    }
  },
  beforeMount() {
    this.getLoginStatus()
  },
  async created() {
    await this.getJoueursData();
    await this.getObjetsData();
    await this.getRepartitionData();
    await this.getRepartis();
    await this.packRepartition();
  },
  methods: {
    getLoginStatus() {
      if (this.isLoggedIn != null) {
        this.isLoggedIn = JSON.parse(localStorage.getItem('isLoggedIn'));
        this.userRole = JSON.parse(localStorage.getItem('userRole'));
      }
    },
    async getJoueursData() {
      const response = await axios.get("http://api.etheron.fr/api/joueurs");
      this.axiosJoueurs = Object.assign([], response.data);
    },
    async getObjetsData() {
      const response = await axios.get("http://api.etheron.fr/api/objets");
      this.axiosObjets = Object.assign([], response.data);
    },
    async getRepartitionData() {
      const response = await axios.get("http://api.etheron.fr/api/instances/objets");
      this.axiosRepartition = Object.assign([], response.data);
    },
    async getRepartis() {
      const response = await axios.get("http://api.etheron.fr/api/instance/repartition");
      this.axiosRepartis = Object.assign([], response.data);
    },
    packRepartition() {
      this.axiosRepartition.forEach(elem => {
        if (!this.packedRepartition.some(obj => obj.id === elem.id)) {
          elem.nombre = 1;
          this.packedRepartition.push(elem);
        } else {
          this.packedRepartition.forEach(obj => {
            if (obj.id === elem.id)
              obj.nombre++;
          })
        }
      })
      this.axiosRepartis.forEach(repartition => {
        this.packedRepartition.forEach(obj => {
          if (obj.id === repartition.id_objet)
            obj.nombre--;
        })
      })
    },
    addRepartition() {
      axios.post("http://api.etheron.fr/api/instance/add-repartition", {
        repartitionObjet: this.selectedObjet.id,
        repartitionJoueur: this.selectedJoueur.id,
      })

      this.packedRepartition.forEach(obj => {
        if (obj.id === this.selectedObjet.id)
          obj.nombre--;
      })

      this.selectedObjet = [];
      this.selectedJoueur = [];
    },
    setJoueur(joueur) {
      this.selectedJoueur = joueur;
    },
    setObjet(objet) {
      this.selectedObjet = objet;
    },
  }
}
</script>

<style scoped>

</style>