<template>

  <div class="mx-8 bg-black flex justify-center gap-10 border-x-2 border-t-2 border-amber-300">
    <div>Nombre d'instance : {{ nombreInstances }}</div>
    <div>Nombre joueurs : {{ nombreJoueurs }}</div>
    <div>Nombre objets : {{ nombreObjets }}</div>
  </div>
  <div class="grid grid-cols-8 mx-8 border-x-2 border-b-2 border-amber-300">
    <div class="flex flex-col gap-1 bg-neutral-900 h-[45em] overflow-y-auto">
      <template v-if="userRole >= 50">
        <div class="bg-neutral-900 p-2 hover:bg-neutral-800 transition delay-[5ms] cursor-pointer"
             @click="instanceCheck ='add'"> Ajouter une instance
        </div>
      </template>
      <template v-for="instance in instances">
        <div class="bg-neutral-900 p-2 hover:bg-neutral-800 transition delay-[5ms] cursor-pointer"
             @click="instanceCheck = instance.id"> {{ instance.date }} {{ instance.heure }} - {{ instance.id }}
        </div>
      </template>

    </div>
    <div class="col-span-7 bg-neutral-900 bg-opacity-90">
      <template v-if="instanceCheck !== 0">
        <template v-for="instance in instances">
          <template v-if="instance.id === instanceCheck">
            <div class="text-center underline text-2xl mt-2">Instance du {{ instance.date }} à {{ instance.heure }}
            </div>
            <div class="text-center text-lg">Identifiant {{ instance.id }}</div>
            <div class="flex justify-evenly">
              <div>
                <div>
                  <div class="text-xl ml-2">Participants</div>
                  <div class="flex ml-6 gap-2">
                    <template v-for="participant in instancesParticipants">
                      <div v-if="participant.id_instance === instance.id">{{ participant.pseudo }}</div>
                    </template>
                  </div>
                </div>

                <div>
                  <div class="text-xl ml-2 mt-2">Objets obtenus</div>
                  <div class="flex ml-6 gap-2">
                    <template v-for="objet in instancesObjets">
                      <img v-if="objet.id_instance === instance.id"
                           class="h-5 w-5"
                           :src="objet.icon" alt="{{ objet.icon }}">
                      <div v-if="objet.id_instance === instance.id">{{ objet.libelle }}</div>
                    </template>
                  </div>
                </div>
              </div>
              <div class="flex ml-6 gap-2">
                <template v-if="instance.type_instance === 1">
                  <img src="/leren.png" class="border-2 rounded border-amber-300">
                </template>
                <template v-if="instance.type_instance === 2">
                  <img src="/rhisi.png" class="border-2 rounded border-amber-300">
                </template>
                <template v-if="instance.type_instance === 3">
                  <img src="/envy.png" class="border-2 rounded border-amber-300">
                </template>
                <template v-if="instance.type_instance === 4">
                  <img src="/guardiane.png" class="border-2 rounded border-amber-300">
                </template>
                <template v-if="instance.type_instance === 5">
                  <img src="/storm.png" class="border-2 rounded border-amber-300">
                </template>
                <template v-if="instance.type_instance === 0">
                  <div>Pas d'instance définie</div>
                </template>
              </div>
            </div>

          </template>
        </template>
      </template>
      <template v-if="instanceCheck === 'add'">
        <template v-if="userRole >= 50">
          <form @submit.prevent="addInstance" v-if="userRole >= 50" class="mt-16">
            <div class="flex justify-evenly">

              <div class="flex flex-col gap-2 justify-center items-center">
                <div>
                  <div style="text-shadow: 1px 1px 2px white;"
                       class="hover:cursor-pointer bg-gradient-to-b from-amber-200 via-amber-400 to-amber-200 hover:from-amber-100 hover:via-amber-300 hover:to-amber-100 rounded-xl text-neutral-800 font-medium border-double border-[7px] border-neutral-800">
                    <select v-model="type_instance" required class="px-1 hover:cursor-pointer bg-transparent border-none">
                      <option value="1">Leren Chasm</option>
                      <option value="2">Rhisis Catacomb</option>
                      <option value="3">Envy Depths</option>
                      <option value="4">Guardiane Sanctuary</option>
                      <option value="5">Storm Peak</option>
                    </select>
                  </div>
                </div>
                <div class="flex flex-col">
                  <input v-model="date" type="date" style="text-shadow: 1px 1px 2px white;"
                         class="bg-gradient-to-b from-amber-200 via-amber-400 to-amber-200 hover:from-amber-100 hover:via-amber-300 hover:to-amber-100 rounded-xl text-neutral-800 font-medium px-3 border-double border-[7px] border-neutral-800"
                         required>
                </div>
                <div class="flex flex-col">
                  <input v-model="heure" type="time" style="text-shadow: 1px 1px 2px white;"
                         class="bg-gradient-to-b from-amber-200 via-amber-400 to-amber-200 hover:from-amber-100 hover:via-amber-300 hover:to-amber-100 rounded-xl text-neutral-800 font-medium px-3 border-double border-[7px] border-neutral-800"
                         required>
                </div>
                <div class="flex justify-center">
                  <button type="submit" style="text-shadow: 1px 1px 2px white;"
                          class="bg-gradient-to-b from-amber-200 via-amber-400 to-amber-200 hover:from-amber-100 hover:via-amber-300 hover:to-amber-100 rounded-xl text-neutral-800 font-medium px-3 border-double border-[7px] border-neutral-800">
                    Valider
                  </button>
                </div>
              </div>

              <div
                  class="col-span-3 flex justify-center text-xs grid grid-cols-4 gap-2 bg-black bg-opacity-90 p-3 rounded-xl border-2 border-amber-300">
                <a class="cursor-pointer hover:scale-110 transition delay-50 flex justify-center items-center"
                   v-for="objet in dungeonItems"
                   @click="addObjetListing(objet)">
                  <img class="text-center h-6 w-6 flex justify-center items-center" :src="objet.icon"
                       alt="{{ objet.icon }}">
                  <div class="col-span-2 text-center flex justify-center items-center">{{ objet.libelle }}</div>
                </a>
              </div>

              <div
                  class="col-span-2 flex justify-center text-black bg-black bg-opacity-90 rounded-xl border-2 border-amber-300">
                <select multiple class="w-80 bg-transparent border-none text-neutral-200">
                  <option v-for="joueur in joueurs" :value="joueur"
                          @click="addJoueurListing(joueur)">
                    {{ joueur.pseudo }}
                  </option>
                </select>
              </div>
            </div>
          </form>


          <div class="flex justify-center mt-6 mb-6">
            <div class="border-2 border-amber-300 p-2 bg-black bg-opacity-90 rounded-xl">
              <div class="text-xl underline font-bold text-amber-200">Instance du {{ date }} à {{ heure }}</div>
              <div class="flex gap-2">
                <div class="font-semibold text-amber-300">Réalisée par :</div>
                <div v-for="(participant, index) in participantsShow" class="flex gap-2">
                  <div class="text-white">{{ participant.pseudo }}</div>
                  <button @click="removeJoueurListing(index)" class="hover:scale-125 transition delay-50">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="stroke-red-600 w-4 h-4">
                      <path stroke-linecap="round" stroke-linejoin="round"
                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                    </svg>
                  </button>
                  ,
                </div>
              </div>
              <div class="flex gap-2">
                <div class="font-semibold text-amber-300">Loots obtenus :</div>
                <div v-for="(objet, index) in objetsShow" class="flex gap-2">
                  <img class="text-center h-6 w-6 flex justify-center items-center" :src="objet.icon"
                       alt="{{ objet.icon }}">
                  <div class="text-white">{{ objet.libelle }}</div>
                  <button @click="removeObjetListing(objet)" class="hover:scale-125 transition delay-50">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="stroke-red-600 w-4 h-4">
                      <path stroke-linecap="round" stroke-linejoin="round"
                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                    </svg>
                  </button>

                </div>
              </div>
            </div>
          </div>
        </template>
      </template>
    </div>
  </div>
</template>


<script>
import axios from "axios";
import NavBar from "@/App.vue";

export default {
  components: {NavBar},
  data() {
    return {
      joueurs: [],
      joueursInstance: [],
      dungeonItems: [],

      date: '',
      heure: '',

      participants: [],
      participantsShow: [],
      participantsFilter: '',
      objets: [],
      objetsShow: [],
      objetsFilter: '',

      instances: [],
      instancesObjets: [],
      instancesObjetsGroup: [],
      instancesParticipants: [],
      menu: 0,

      axiosRepartition: [],
      axiosRepartitionGroup: [],

      type_instance: [],

      repartitionJoueur: 0,
      repartitionObjet: 0,

      instanceCheck: "0",

      nombreInstances: 0,
      nombreJoueurs: 0,
      nombreObjets: 0,
    };
  },

  beforeMount() {
    this.getLoginStatus()
  },

  mounted() {
    axios.get("http://api.etheron.fr/api/joueurs")
        .then((response) => {
          const tempJoueurs = Object.assign([], response.data);
          tempJoueurs.forEach(elem => {
            this.joueurs.push(elem);
            this.joueursInstance.push(elem);
          })
          this.nombreJoueurs = this.joueurs.length;
        })
    axios.get("http://api.etheron.fr/api/instance/items")
        .then((response) => {
          const tempDungeon = Object.assign([], response.data);
          tempDungeon.forEach(elem => {
            this.dungeonItems.push(elem);
          })
        })
    axios.get("http://api.etheron.fr/api/instances")
        .then((response) => {
          const tempsInstances = Object.assign([], response.data);
          tempsInstances.forEach(elem => {
            this.instances.push(elem);
          })

          this.nombreInstances = this.instances.length;
        })
    axios.get("http://api.etheron.fr/api/instances/objets")
        .then((response) => {
          const tempsInstances = Object.assign([], response.data);
          tempsInstances.forEach(elem => {
            this.instancesObjets.push(elem);
          })
          this.instancesObjets.forEach(elem => {
            // si l'objet n'est pas dans le tableau instanceObjetsGroup
            if (!this.instancesObjetsGroup.some(obj => obj.id === elem.id)) {
              // on ajoute nombre à l'objet
              elem.nombre = 1;
              // et on l'ajoute
              this.instancesObjetsGroup.push(elem);
            } else {
              // sinon on incrémente le nombre
              this.instancesObjetsGroup.forEach(obj => {
                if (obj.id === elem.id)
                  obj.nombre++;
              })
            }

            this.nombreObjets = this.instancesObjets.length;
          })
          axios.get("http://api.etheron.fr/api/instance/repartition")
              .then((response) => {
                const tempsInstances = Object.assign([], response.data);
                tempsInstances.forEach(elem => {
                  this.axiosRepartition.push(elem);
                })
                this.axiosRepartition.forEach(repartition => {
                  this.instancesObjetsGroup.forEach(obj => {
                    if (obj.id === repartition.id_objet)
                      obj.nombre--;
                  })
                })
                this.axiosRepartition.forEach(elem => {
                  // si l'objet n'est pas dans le tableau instanceObjetsGroup
                  if (!this.axiosRepartitionGroup.some(obj => obj.id === elem.id)) {
                    // on ajoute nombre à l'objet
                    elem.nombre = 1;
                    // et on l'ajoute
                    this.axiosRepartitionGroup.push(elem);
                  } else {
                    // sinon on incrémente le nombre
                    this.axiosRepartitionGroup.forEach(obj => {
                      if (obj.id === elem.id)
                        obj.nombre++;
                    })
                  }
                })
                this.axiosRepartitionGroup.forEach(elem => {
                  this.joueurs.forEach(joueur => {
                    if (joueur.id === elem.id_joueur)
                      elem.pseudo = joueur.pseudo;
                  })
                })
                var temp = [];
                // ajouter le nom des objet déjà obtenus par le joueur
                this.axiosRepartitionGroup.forEach(elem => {
                  this.instancesObjets.forEach(obj => {
                    if (obj.id === elem.id_objet)
                      temp.push(obj.libelle);
                    console.log(temp);
                  })
                  elem
                })

              })
        })
    axios.get("http://api.etheron.fr/api/instances/participants")
        .then((response) => {
          const tempsInstances = Object.assign([], response.data);
          tempsInstances.forEach(elem => {
            this.instancesParticipants.push(elem);
          })
        })
    axios.get("http://api.etheron.fr/api/instances/nombre")
        .then((response) => {
              const tempsInstances = Object.assign([], response.data);
              this.joueursInstance.forEach(joueur => {
                joueur.nombre_donjons = 0;
              })
              tempsInstances.forEach(elem => {
                this.joueursInstance.forEach(joueur => {
                  if (joueur.id === elem.id_joueur)
                    joueur.nombre_donjons++;
                })
              })

            }
        )
  },

  methods: {
    calculateRatio(joueur) {
      return (((joueur.carte_d * 5) + (joueur.carte_c * 10) + (joueur.carte_b * 20) + (joueur.carte_a * 50)) / joueur.nombre_donjons) * 100;
    }
    ,

    getLoginStatus() {
      this.isLoggedIn = JSON.parse(localStorage.getItem('isLoggedIn'));
      this.userRole = JSON.parse(localStorage.getItem('userRole'));
    }
    ,
    filterJoueurs() {
      if (this.participantsFilter.includes('pamp')) {
        return true;
      } else {
        return false;
      }
    }
    ,

    addObjetListing(objet) {
      this.objets.push(objet.id);
      this.objetsShow.push(objet);
    }
    ,
    removeObjetListing(id) {
      this.objets.splice(id, 1);
      this.objetsShow.splice(id, 1);
    }
    ,

    addJoueurListing(joueur) {
      this.participants.push(joueur.id);
      this.participantsShow.push(joueur);
    }
    ,
    removeJoueurListing(id) {
      this.participants.splice(id, 1);
      this.participantsShow.splice(id, 1);
    }
    ,
    addJoueurRepartition(id) {
      this.repartitionJoueur = id;
    }
    ,
    addObjetRepartition(id) {
      this.repartitionObjet = id;
    }
    ,
    // ajout d'instance
    addInstance() {
      axios.post("http://api.etheron.fr/api/instance/add", {
        date: this.date,
        heure: this.heure,
        participants: this.participants,
        objets: this.objets,
        type_instance: this.type_instance,
      })
          .then((response) => {
            console.log(response);
          })
          .catch((error) => {
            console.log(error);
          });

      // vider les variables et le formulaire
      this.date = '';
      this.heure = '';
      this.participants = [];
      this.objets = [];
      this.participantsShow = [];
      this.objetsShow = [];
      this.type_instance = [];
    }
    ,
    // ajout de répartition à un joueur
    addRepartition() {
      axios.post("http://api.etheron.fr/api/instance/add-repartition", {
        repartitionObjet: this.repartitionObjet,
        repartitionJoueur: this.repartitionJoueur,
      })
          .then((response) => {
            console.log(response);
          })
          .catch((error) => {
            console.log(error);
          });
      this.instancesObjetsGroup.forEach(obj => {
        if (obj.id === this.repartitionObjet)
          obj.nombre--;
      })

      // vider les variables et le formulaire
      this.repartitionJoueur = [];
      this.repartitionObjet = [];
    }
  }
  ,

}
;
</script>


<style scoped>

</style>