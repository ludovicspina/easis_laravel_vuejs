<template>
    <form @submit.prevent="addInstance">
      <div class="grid grid-cols-5">
        <div class="flex flex-col cols-span-1">
          <div class="grid grid-cols-2">
            <label>Date</label>
            <input v-model="date" type="date" class=" text-black" required>
          </div>
          <div class="grid grid-cols-2">
            <label>Heure</label>
            <input v-model="heure" type="time" class=" text-black" required>
          </div>
        </div>

        <div class="col-span-2 flex justify-center  text-black">
          <select multiple class="h-64 w-80">
            <option v-for="objet in dungeonItems" @click="addObjetListing(objet)">
              {{ objet.libelle }}
            </option>
          </select>
        </div>

        <div class="col-span-2 flex justify-center text-black">
          <select multiple class="h-64 w-80">
            <option v-for="joueur in joueurs" :value="joueur"
                    @click="addJoueurListing(joueur)">
              {{ joueur.pseudo }}
            </option>
          </select>
        </div>
      </div>
      <div class="flex justify-center mt-2">
        <button type="submit" class="border rounded px-1 py-0.5 text-2xl hover:scale-125">Valider</button>
      </div>
    </form>


  <div class="flex justify-center mt-2">
    <div class="border p-2 bg-neutral-800 rounded">
      <div class="text-xl underline font-bold">Instance du {{ date }} à {{ heure }}</div>
      <div class="flex gap-2">
        <div class="font-semibold">Réalisée par :</div>
        <div v-for="(participant, index) in participantsShow" class="flex gap-2">
          <div>{{ participant.pseudo }}</div>
          <button @click="removeJoueurListing(index)" class="hover:scale-125">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="w-4 h-4">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
            </svg>
          </button>
          ,
        </div>
      </div>
      <div class="flex gap-2">
        <div class="font-semibold">Loots obtenus :</div>
        <div v-for="(objet, index) in objetsShow" class="flex gap-2">
          <div>{{ objet.libelle }}</div>
          <button @click="removeObjetListing(objet)" class="hover:scale-125">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="w-4 h-4">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
            </svg>
          </button>
          ,
        </div>
      </div>
    </div>
  </div>

  <div class="flex justify-center m-2" v-for="instance in instances">
    <div class="border p-2 bg-neutral-800 bg-opacity-25 border-neutral-700 rounded w-screen">
      <div class="text-xl underline font-bold">Instance du {{ instance.date }} à {{ instance.heure }}</div>
      <div class="flex gap-2">
        <div class="font-semibold">Réalisée par :</div>
        <template v-for="participant in instancesParticipants" class="flex gap-2">
          <div v-if="participant.id_instance === instance.id">{{ participant.pseudo }} ,</div>
        </template>
      </div>
      <div class="flex gap-2">
        <div class="font-semibold">Loots obtenus :</div>
        <template v-for="objet in instancesObjets" class="flex gap-2">
          <div v-if="objet.id_instance === instance.id">{{ objet.libelle }} ,</div>
        </template>
      </div>
    </div>
  </div>

  <div class="mb-4">
    <div class="text-xl underline text-center mb-4">Loots totaux:</div>
    <div class="grid grid-cols-8 gap-2">
      <template v-for="objet in instancesObjets">
        <div>
          {{ objet.libelle }}
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
      joueurs: [],
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
      instancesParticipants: [],

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
          })
        }),
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
        })
    axios.get("http://api.etheron.fr/api/instances/objets")
        .then((response) => {
          const tempsInstances = Object.assign([], response.data);
          tempsInstances.forEach(elem => {
            this.instancesObjets.push(elem);
          })
        })
    axios.get("http://api.etheron.fr/api/instances/participants")
        .then((response) => {
          const tempsInstances = Object.assign([], response.data);
          tempsInstances.forEach(elem => {
            this.instancesParticipants.push(elem);
          })
        })
  },

  methods: {

    getLoginStatus() {
      this.isLoggedIn = JSON.parse(localStorage.getItem('isLoggedIn'));
      this.userRole = JSON.parse(localStorage.getItem('userRole'));
    },
    filterJoueurs() {
      if (this.participantsFilter.includes('pamp')) {
        return true;
      } else {
        return false;
      }
    },

    addObjetListing(objet) {
      this.objets.push(objet.id);
      this.objetsShow.push(objet);
    },
    removeObjetListing(id) {
      this.objets.splice(id, 1);
      this.objetsShow.splice(id, 1);
    },

    addJoueurListing(joueur) {
      this.participants.push(joueur.id);
      this.participantsShow.push(joueur);
    },
    removeJoueurListing(id) {
      this.participants.splice(id, 1);
      this.participantsShow.splice(id, 1);
    },
    //user login function and api call
    addInstance() {
      axios.post("http://api.etheron.fr/api/instance/add", {
        date: this.date,
        heure: this.heure,
        participants: this.participants,
        objets: this.objets,
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
    }
  }
  ,

}
;
</script>


<style scoped>

</style>