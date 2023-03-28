<template>
  <div v-if="(userRole >= 80)" class="bg-neutral-800 flex justify-center gap-2 mx-4 py-4 h-48">
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
              class="inline-flex w-full justify-center rounded-md bg-green-600 flex px-3 py-1 text-sm font-semibold text-white shadow-sm hover:bg-green-500 sm:ml-3 sm:w-auto">
        Ajouter
      </button>
    </div>
  </div>

  <div class="gap-6 flex justify-center items-center bg-neutral-800">
    <div>{{ selectedObjet.libelle }}</div>
    <div>-></div>
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