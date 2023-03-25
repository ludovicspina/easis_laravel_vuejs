<template>
  <div class="flex flex-col justify-center items-center" v-if="userRole >= 80">
    <div class="grid grid-cols-4 w-1/3 bg-gradient-to-b from-neutral-700 to-neutral-800 rounded-t">
      <div class="flex justify-center">Pseudo</div>
      <div class="flex flex-col justify-center items-center">
        <div>Cartes</div>
        <div class="grid grid-cols-4 gap-4">
          <div>A</div>
          <div>B</div>
          <div>C</div>
          <div>D</div>
        </div>
      </div>
      <div class="flex justify-center">Nbr inst</div>
      <div class="flex justify-center">Ratio</div>
    </div>
    <div class="w-1/3 bg-neutral-800">
      <template v-for="joueur in joueursParticipationInstances">
        <div class="mb-1 grid grid-cols-4 hover:scale-125 cursor-pointer py-0.5 hover:bg-neutral-800 hover:shadow hover:rounded transition delay-50">
          <div class="flex justify-center">
            <div class="flex justify-center items-center gap-1">
              <img :src="joueur.choix_instance" :alt="joueur.choix_instance" class="h-4">
              {{ joueur.pseudo }}
            </div>
          </div>
          <div class="flex flex-col justify-center items-center">
            <div class="grid grid-cols-4 gap-4">
              <div v-bind:class="(joueur.carte_a > 0)?'text-neutral-100':'text-neutral-700'">{{ joueur.carte_a }}</div>
              <div v-bind:class="(joueur.carte_b > 0)?'text-neutral-100':'text-neutral-700'">{{ joueur.carte_b }}</div>
              <div v-bind:class="(joueur.carte_c > 0)?'text-neutral-100':'text-neutral-700'">{{ joueur.carte_c }}</div>
              <div v-bind:class="(joueur.carte_d > 0)?'text-neutral-100':'text-neutral-700'">{{ joueur.carte_d }}</div>
            </div>
          </div>
          <div v-bind:class="(joueur.nombre_instances > 0)?'text-neutral-100':'text-neutral-700'"
               class="flex justify-center">{{ joueur.nombre_instances }}
          </div>
          <div class="flex justify-center" v-bind:class="(calcRatio(joueur) > 0)?'text-neutral-100':'text-neutral-700'">
            {{ calcRatio(joueur) }}
          </div>
        </div>
      </template>
    </div>
  </div>
</template>
<script>


import axios from "axios";

export default {
  data() {
    return {
      axiosJoueurs: [],
      axiosParticipants: [],
      axiosRepartition: [],
      axiosObjets: [],
      joueursParticipationInstances: [],
    };
  },
  beforeMount() {
    this.getLoginStatus()
  },
  async created() {
    await this.getParticipantsData();
    await this.getJoueursData();
    await this.getRepartitionData();
    await this.getObjetsData();
    this.fusionJoueursParticipation();
    this.fusionObjetRepartition();
    this.fusionJoueursRepartition();
    this.fusionJoueurSelection();
  },
  methods: {
    getLoginStatus() {
      this.isLoggedIn = JSON.parse(localStorage.getItem('isLoggedIn'));
      this.userRole = JSON.parse(localStorage.getItem('userRole'));
    },
    async getParticipantsData() {
      const response = await axios.get("http://api.etheron.fr/api/instances/participants");
      this.axiosParticipants = Object.assign([], response.data);
    },
    async getJoueursData() {
      const response = await axios.get("http://api.etheron.fr/api/joueurs");
      this.axiosJoueurs = Object.assign([], response.data);
    },
    async getRepartitionData() {
      const response = await axios.get("http://api.etheron.fr/api/instance/repartition");
      this.axiosRepartition = Object.assign([], response.data);
    },
    async getObjetsData() {
      const response = await axios.get("http://api.etheron.fr/api/instances/objets");
      this.axiosObjets = Object.assign([], response.data);
    },
    fusionJoueursParticipation() {
      this.axiosJoueurs.forEach(joueur => {
        this.joueursParticipationInstances.push(joueur);
      })
      this.joueursParticipationInstances.forEach(joueur => {
        joueur.nombre_instances = 0;
        this.axiosParticipants.forEach(participant => {
          if (joueur.id === participant.id_joueur) {
            joueur.nombre_instances++;
          }
        })
      })
    },
    fusionObjetRepartition() {
      this.axiosRepartition.forEach(repartition => {
        this.axiosObjets.forEach(objet => {
          if (repartition.id_objet === objet.id) {
            repartition.icon = objet.icon;
            repartition.type = objet.type;
            repartition.categorie = objet.categorie;
          }
        })
      })
    },
    fusionJoueursRepartition() {
      this.joueursParticipationInstances.forEach(joueur => {
        joueur.carte_a = 0;
        joueur.carte_b = 0;
        joueur.carte_c = 0;
        joueur.carte_d = 0;
        this.axiosRepartition.forEach(repartition => {
          if (joueur.id === repartition.id_joueur) {
            if (repartition.categorie === "a") {
              joueur.carte_a++;
            } else if (repartition.categorie === "b") {
              joueur.carte_b++;
            } else if (repartition.categorie === "c") {
              joueur.carte_c++;
            } else if (repartition.categorie === "d") {
              joueur.carte_d++;
            }
          }
        })
      })
    },
    calcRatio(joueur) {
      return ((((joueur.carte_d * 5) + (joueur.carte_c * 10) + (joueur.carte_b * 20) + (joueur.carte_a * 50)) / joueur.nombre_instances) * 100).toFixed(2);
    },
    fusionJoueurSelection(joueur) {
      this.joueursParticipationInstances.forEach(joueur => {
        this.axiosObjets.forEach(objet => {
          if (joueur.choix_instance === objet.id) {
            joueur.choix_instance = objet.icon;
            joueur.libelle_objet = objet.libelle;
          }
        })
      })
    },
  },
}
</script>