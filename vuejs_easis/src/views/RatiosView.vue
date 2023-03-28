<template>
  <div class="absolute left-32 top-32">
    <div class="flex flex-col justify-center items-center">
      <p class="font-semibold mb-2 underline">Attribuer un objet</p>
      <svg @click="repartitionModal = !repartitionModal" xmlns="http://www.w3.org/2000/svg" fill="none"
           viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
           class="w-8 h-8 hover:scale-125 transition delay-50">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
      </svg>
    </div>
    <div class="flex justify-center mb-4 mt-10 flex flex-col justify-center items-center">
      <p class="font-semibold mb-2 underline">Filtrer les objets</p>
      <div class="flex">
        <div>
          <input
              class="mt-[0.3rem] mr-2 h-3.5 w-8 appearance-none rounded-[0.4375rem] bg-neutral-300 before:pointer-events-none before:absolute before:h-3.5 before:w-3.5 before:rounded-full before:bg-transparent before:content-[''] after:absolute after:z-[2] after:-mt-[0.1875rem] after:h-5 after:w-5 after:rounded-full after:border-none after:bg-neutral-100 after:shadow-[0_0px_3px_0_rgb(0_0_0_/_7%),_0_2px_2px_0_rgb(0_0_0_/_4%)] after:transition-[background-color_0.2s,transform_0.2s] after:content-[''] checked:bg-primary checked:after:absolute checked:after:z-[2] checked:after:-mt-[3px] checked:after:ml-[1.0625rem] checked:after:h-5 checked:after:w-5 checked:after:rounded-full checked:after:border-none checked:after:bg-primary checked:after:shadow-[0_3px_1px_-2px_rgba(0,0,0,0.2),_0_2px_2px_0_rgba(0,0,0,0.14),_0_1px_5px_0_rgba(0,0,0,0.12)] checked:after:transition-[background-color_0.2s,transform_0.2s] checked:after:content-[''] hover:cursor-pointer focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[3px_-1px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-5 focus:after:w-5 focus:after:rounded-full focus:after:content-[''] checked:focus:border-primary checked:focus:bg-primary checked:focus:before:ml-[1.0625rem] checked:focus:before:scale-100 checked:focus:before:shadow-[3px_-1px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s]"
              type="checkbox" role="switch" id="flexSwitchCheckDefault" @click="switchCardStatus = !switchCardStatus"/>
          <label class="inline-block pl-[0.15rem] hover:cursor-pointer" for="flexSwitchCheckDefault"></label>
        </div>
        <div>
          <select v-model="switchCardType">
            <option v-for="objet in switchCardTypeList" v-bind:value="objet">
              {{ objet.toUpperCase() }}
            </option>
          </select>
        </div>
      </div>
    </div>
  </div>
  <template v-if="repartitionModal">
    <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
      <div class="fixed inset-0 bg-black bg-opacity-75 transition-opacity"></div>

      <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
          <div
              class="relative transform overflow-hidden rounded-lg bg-neutral-800 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
            <div class="bg-neutral-900 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
              Répartition des objets
            </div>
            <Repartition></Repartition>
            <div class="bg-neutral-800 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
              <button type="button" @click="repartitionModal = !repartitionModal"
                      class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-1 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">
                Annuler
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  <div class="flex flex-col justify-center items-center">
    <div
        class="grid grid-cols-5 md:w-2/4 w-screen text-xs md:text-base bg-gradient-to-b from-neutral-700 to-neutral-800 rounded-t">
      <div class="flex justify-center">Pseudo</div>
      <div class="flex flex-col justify-center items-center">
        <div>Cartes</div>
        <div class="grid grid-cols-4 gap-2">
          <div>A</div>
          <div>B</div>
          <div>C</div>
          <div>D</div>
        </div>
      </div>
      <div class="flex flex-col justify-center items-center">
        <div>Familier</div>
        <div class="grid grid-cols-7 gap-2">
          <div>S</div>
          <div>A</div>
          <div>B</div>
          <div>C</div>
          <div>D</div>
          <div>E</div>
          <div>F</div>
        </div>
      </div>
      <div class="flex justify-center">Nbr inst</div>
      <div class="flex justify-center">Ratio</div>
    </div>
    <div class="md:w-2/4 w-screen text-xs md:text-base bg-neutral-800">
      <template v-for="joueur in joueursParticipationInstances">
        <div
            v-if="((joueur.sub_type_text === switchCardType) && (switchCardStatus === true)) || switchCardStatus === false"
            class="mb-1 grid grid-cols-5 hover:scale-125 cursor-pointer py-0.5 hover:bg-neutral-800 hover:shadow hover:rounded transition delay-50">
          <div class="flex justify-center">
            <div class="flex justify-center items-center gap-1 overflow-x-hidden">
              <img :src="joueur.icon" :alt="joueur.icon" class="h-4">
              {{ joueur.pseudo }}
            </div>
          </div>
          <div class="flex flex-col justify-center items-center">
            <div class="grid grid-cols-4 gap-2">
              <div v-bind:class="(joueur.carte_a > 0)?'text-neutral-100':'text-neutral-700'">{{ joueur.carte_a }}</div>
              <div v-bind:class="(joueur.carte_b > 0)?'text-neutral-100':'text-neutral-700'">{{ joueur.carte_b }}</div>
              <div v-bind:class="(joueur.carte_c > 0)?'text-neutral-100':'text-neutral-700'">{{ joueur.carte_c }}</div>
              <div v-bind:class="(joueur.carte_d > 0)?'text-neutral-100':'text-neutral-700'">{{ joueur.carte_d }}</div>
            </div>
          </div>
          <div class="flex flex-col justify-center items-center">
            <div class="grid grid-cols-7 gap-2">
              <div v-bind:class="(joueur.familier_s > 0)?'text-neutral-100':'text-neutral-700'">{{
                  joueur.familier_s
                }}
              </div>
              <div v-bind:class="(joueur.familier_a > 0)?'text-neutral-100':'text-neutral-700'">{{
                  joueur.familier_a
                }}
              </div>
              <div v-bind:class="(joueur.familier_b > 0)?'text-neutral-100':'text-neutral-700'">{{
                  joueur.familier_b
                }}
              </div>
              <div v-bind:class="(joueur.familier_c > 0)?'text-neutral-100':'text-neutral-700'">{{
                  joueur.familier_c
                }}
              </div>
              <div v-bind:class="(joueur.familier_d > 0)?'text-neutral-100':'text-neutral-700'">{{
                  joueur.familier_d
                }}
              </div>
              <div v-bind:class="(joueur.familier_e > 0)?'text-neutral-100':'text-neutral-700'">{{
                  joueur.familier_e
                }}
              </div>
              <div v-bind:class="(joueur.familier_f > 0)?'text-neutral-100':'text-neutral-700'">{{
                  joueur.familier_f
                }}
              </div>
            </div>
          </div>
          <div v-bind:class="(joueur.nombre_instances > 0)?'text-neutral-100':'text-neutral-700'"
               class="flex justify-center">{{ joueur.nombre_instances }}
          </div>
          <div class="flex justify-center"
               v-bind:class="(calcRatio(joueur) >= 0)?'text-neutral-100':'text-neutral-700'">
            {{ calcRatio(joueur) }}
          </div>
        </div>
      </template>
    </div>
  </div>
</template>
<script>


import axios from "axios";
import Repartition from "@/components/Repartition.vue";

export default {
  components: {Repartition},
  data() {
    return {
      axiosJoueurs: [],
      axiosParticipants: [],
      axiosRepartition: [],
      axiosObjets: [],
      joueursParticipationInstances: [],
      objetSubtype: [],
      // modal
      repartitionModal: false,
      // filter
      switchCardStatus: false,
      switchCardType: null,
      switchCardTypeList: [
        'thorn', 'electric', 'fire', 'land', 'lava', 'wind', 'volt', 'water', 'familier'
      ]
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
    await this.fusionJoueursParticipation();
    await this.fusionObjetRepartition();
    await this.fusionJoueursRepartition();
    await this.fusionJoueurSelection();
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
    addCardType(id) {
      this.switchCardType = id;
    },
    fusionJoueursParticipation() {
      this.axiosJoueurs.forEach(joueur => {
        this.joueursParticipationInstances.push(joueur);
      })

      this.joueursParticipationInstances.forEach(joueur => {
        joueur.nombre_instances = 0;
        joueur.sub_type_text = null;

        this.axiosParticipants.forEach(participant => {
          if (joueur.id === participant.id_joueur) {
            joueur.nombre_instances++;
          }
        })

        this.axiosObjets.forEach(objet => {
          if (objet.id === joueur.sub_type) {
            joueur.sub_type_text = objet.sub_type;
            joueur.icon = objet.icon;
          }
        })


      })
    },
    fusionObjetRepartition() {
      this.axiosRepartition.forEach(repartition => {
        this.axiosObjets.forEach(objet => {
          if (repartition.id_objet === objet.id) {
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
        joueur.familier_f = 0;
        joueur.familier_e = 0;
        joueur.familier_d = 0;
        joueur.familier_c = 0;
        joueur.familier_b = 0;
        joueur.familier_a = 0;
        joueur.familier_s = 0;
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
            } else if (repartition.categorie === "ff") {
              joueur.familier_f++;
            } else if (repartition.categorie === "fe") {
              joueur.familier_e++;
            } else if (repartition.categorie === "fd") {
              joueur.familier_d++;
            } else if (repartition.categorie === "fc") {
              joueur.familier_c++;
            } else if (repartition.categorie === "fb") {
              joueur.familier_b++;
            } else if (repartition.categorie === "fa") {
              joueur.familier_a++;
            } else if (repartition.categorie === "fs") {
              joueur.familier_s++;
            }
          }
        })
      })
    },
    calcRatio(joueur) {
      return ((((joueur.carte_d * 5) + (joueur.carte_c * 10) + (joueur.carte_b * 20) + (joueur.carte_a * 50) + (joueur.familier_f * 2) + (joueur.familier_e * 2) + (joueur.familier_d * 4) + (joueur.familier_c * 8) + (joueur.familier_b * 12) + (joueur.familier_a * 16) + (joueur.familier_s * 20)) / joueur.nombre_instances) * 100).toFixed(2);
    },
    fusionJoueurSelection() {
      this.axiosJoueurs.forEach(joueur => {
        this.axiosObjets.forEach(objet => {
          if (joueur.sub_type === objet.id) {
            joueur.sub_type_test = objet.sub_type;
          }
        })
      })
    },
  },
}
</script>