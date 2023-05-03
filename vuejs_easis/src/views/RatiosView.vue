<template>
  <div>
    <div class="absolute left-32 top-32 bg-black bg-opacity-90 p-4 rounded-xl border-2 border-amber-300">
      <div class="flex justify-center mb-4 flex flex-col justify-center items-center">
        <p class="font-semibold mb-2 underline text-amber-300">Filtrer les objets</p>
        <div class="flex justify-center items-center gap-3">
          <div>
            <input style="text-shadow: 1px 1px 2px white;"
                   class="bg-gradient-to-b from-amber-200 via-amber-400 to-amber-200 hover:from-amber-100 hover:via-amber-300 hover:to-amber-100 hover:cursor-pointer rounded text-neutral-800 p-1.5 font-medium border-double border-[7px] border-neutral-800"
                   type="checkbox" role="switch" id="flexSwitchCheckDefault"
                   @click="switchCardStatus = !switchCardStatus"/>
            <label class="inline-block pl-[0.15rem] hover:cursor-pointer" for="flexSwitchCheckDefault"></label>
          </div>
          <div style="text-shadow: 1px 1px 2px white;"
               class="hover:cursor-pointer bg-gradient-to-b from-amber-200 via-amber-400 to-amber-200 hover:from-amber-100 hover:via-amber-300 hover:to-amber-100 rounded-xl text-neutral-800 font-medium border-double border-[7px] border-neutral-800">
            <select v-model="switchCardType" class="px-1 hover:cursor-pointer bg-transparent border-none">
              <option v-for="objet in switchCardTypeList" v-bind:value="objet">
                {{ objet.toUpperCase() }}
              </option>
            </select>
          </div>
        </div>
        <div class="flex justify-center items-center gap-3">
          <div>
            <input style="text-shadow: 1px 1px 2px white;"
                   class="bg-gradient-to-b from-amber-200 via-amber-400 to-amber-200 hover:from-amber-100 hover:via-amber-300 hover:to-amber-100 hover:cursor-pointer rounded text-neutral-800 p-1.5 font-medium border-double border-[7px] border-neutral-800"
                   type="checkbox" role="switch" id="flexSwitchFamCheckDefault"
                   @click="switchFamStatus = !switchFamStatus"/>
            <label class="inline-block pl-[0.15rem] hover:cursor-pointer" for="flexSwitchFamCheckDefault"></label>
          </div>
          <div style="text-shadow: 1px 1px 2px white;"
               class="hover:cursor-pointer bg-gradient-to-b from-amber-200 via-amber-400 to-amber-200 hover:from-amber-100 hover:via-amber-300 hover:to-amber-100 rounded-xl text-neutral-800 font-medium border-double border-[7px] border-neutral-800">
            <select v-model="switchFamType" class="px-1 hover:cursor-pointer bg-transparent border-none">
              <option v-for="objet in switchFamTypeList" v-bind:value="objet">
                {{ objet.toUpperCase() }}
              </option>
            </select>
          </div>
        </div>
      </div>
      <div class="flex flex-col justify-center items-center" v-if="(userRole >= 80)">
        <button @click="repartitionModal = !repartitionModal" style="text-shadow: 1px 1px 2px white;"
                class="bg-gradient-to-b from-amber-200 via-amber-400 to-amber-200 hover:from-amber-100 hover:via-amber-300 hover:to-amber-100 rounded-xl text-neutral-800 font-medium px-3 border-double border-[7px] border-neutral-800">
          Attribuer un objet
        </button>
      </div>
    </div>
    <template v-if="repartitionModal">
      <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-black bg-opacity-75 transition-opacity"></div>

        <div class="fixed inset-0 z-10 overflow-y-auto">
          <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div
                class="relative transform rounded-xl bg-black bg-opacity-75 rounded border border-amber-300 text-left transition-all sm:my-8 sm:w-full sm:max-w-lg">
              <div class="bg-black bg-opacity-75 px-4 pb-4 sm:p-6 sm:pb-4 rounded-t text-xl text-amber-200 ">
                Répartition des objets
              </div>
              <Repartition></Repartition>
              <div class="bg-black bg-opacity-75 rounded-b py-3 sm:flex sm:flex-row-reverse sm:px-6">
                <button type="button" @click="repartitionModal = !repartitionModal"
                        style="text-shadow: 1px 1px 2px white;"
                        class="bg-gradient-to-b from-amber-200 via-amber-400 to-amber-200 hover:from-amber-100 hover:via-amber-300 hover:to-amber-100 rounded-xl text-neutral-800 font-medium px-3 border-double border-[7px] border-neutral-800">
                  Annuler
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </template>
    <div class="flex flex-col justify-center items-center text-yellow-100">
      <div
          class="grid grid-cols-5 md:w-2/4 w-screen text-xs border-t-2 border-x-2 border-amber-300 md:text-base bg-black bg-opacity-95 rounded-t-xl">
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
      <div class="md:w-2/4 w-screen text-xs md:text-base bg-black bg-opacity-90 border-x-2 border-b-2 border-amber-300">
        <template v-for="joueur in joueursParticipationInstances">
          <div
              v-if="(((joueur.sub_type_text === switchCardType) && (switchCardStatus === true)) || ((joueur.familier === switchFamType) && (switchFamStatus === true)) || (switchCardStatus === false && switchFamStatus === false))"
              class="mb-1 grid grid-cols-5 hover:scale-125 cursor-pointer py-0.5 hover:bg-black hover:border hover:rounded hover:border-amber-300 hover:shadow hover:rounded transition delay-50">
            <div class="flex justify-center">
              <div class="flex justify-center items-center gap-1 overflow-x-hidden">
                <div class="flex gap-1" v-if="joueur.min_carte !== null">{{ joueur.min_carte.toUpperCase() }}
                  <img :src="joueur.icon" :alt="joueur.icon" class="h-6"></div>
                <div v-else><img :src="joueur.icon" :alt="joueur.icon" class="h-6"></div>
                <template v-if="joueur.familier === 's'">
                  <img src="../../public/peteggs.png" class="h-6">
                </template>
                <template v-if="joueur.familier === 'a'">
                  <img src="../../public/petegga.png" class="h-6">
                </template>
                <template v-if="joueur.familier === 'b'">
                  <img src="../../public/peteggb.png" class="h-6">
                </template>
                <template v-if="joueur.familier === 'c'">
                  <img src="../../public/peteggc.png" class="h-6">
                </template>
                <template v-if="joueur.familier === 'd'">
                  <img src="../../public/peteggd.png" class="h-6">
                </template>
                <template v-if="joueur.familier === 'e'">
                  <img src="../../public/petegge.png" class="h-6">
                </template>
                <template v-if="joueur.familier === 'f'">
                  <img src="../../public/peteggf.png" class="h-6">
                </template>
                {{ joueur.pseudo }}

              </div>

            </div>
            <div class="flex flex-col justify-center items-center">
              <div class="grid grid-cols-4 gap-2">
                <div v-bind:class="(joueur.carte_a > 0)?'text-amber-300':'text-amber-300 text-opacity-10'">
                  {{ joueur.carte_a }}
                </div>
                <div v-bind:class="(joueur.carte_b > 0)?'text-amber-300':'text-amber-300 text-opacity-10'">
                  {{ joueur.carte_b }}
                </div>
                <div v-bind:class="(joueur.carte_c > 0)?'text-amber-300':'text-amber-300 text-opacity-10'">
                  {{ joueur.carte_c }}
                </div>
                <div v-bind:class="(joueur.carte_d > 0)?'text-amber-300':'text-amber-300 text-opacity-10'">
                  {{ joueur.carte_d }}
                </div>
              </div>
            </div>
            <div class="flex flex-col justify-center items-center">
              <div class="grid grid-cols-7 gap-2">
                <div v-bind:class="(joueur.familier_s > 0)?'text-amber-300':'text-amber-300 text-opacity-10'">{{
                    joueur.familier_s
                  }}
                </div>
                <div v-bind:class="(joueur.familier_a > 0)?'text-amber-300':'text-amber-300 text-opacity-10'">{{
                    joueur.familier_a
                  }}
                </div>
                <div v-bind:class="(joueur.familier_b > 0)?'text-amber-300':'text-amber-300 text-opacity-10'">{{
                    joueur.familier_b
                  }}
                </div>
                <div v-bind:class="(joueur.familier_c > 0)?'text-amber-300':'text-amber-300 text-opacity-10'">{{
                    joueur.familier_c
                  }}
                </div>
                <div v-bind:class="(joueur.familier_d > 0)?'text-amber-300':'text-amber-300 text-opacity-10'">{{
                    joueur.familier_d
                  }}
                </div>
                <div v-bind:class="(joueur.familier_e > 0)?'text-amber-300':'text-amber-300 text-opacity-10'">{{
                    joueur.familier_e
                  }}
                </div>
                <div v-bind:class="(joueur.familier_f > 0)?'text-amber-300':'text-amber-300 text-opacity-10'">{{
                    joueur.familier_f
                  }}
                </div>
              </div>
            </div>
            <div v-bind:class="(joueur.nombre_instances > 0)?'text-amber-300':'text-amber-300 text-opacity-10'"
                 class="flex justify-center">{{ joueur.nombre_instances }}
            </div>
            <div class="flex justify-center"
                 v-bind:class="(calcRatio(joueur) >= 0)?'text-amber-300':'text-amber-300 text-opacity-10'">
              {{ calcRatio(joueur) }}
            </div>
          </div>
        </template>
      </div>
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
        'thorn', 'electric', 'fire', 'land', 'lava', 'wind', 'volt', 'water'
      ],
      switchFamStatus: false,
      switchFamType: null,
      switchFamTypeList: [
        'f', 'e', 'd', 'c', 'b', 'a', 's'
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
    addFamType(id) {
      this.switchFamType = id;
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
      return ((((joueur.carte_c * 8) + (joueur.carte_b * 20) + (joueur.carte_a * 50) + (joueur.familier_f * 1) + (joueur.familier_e * 2) + (joueur.familier_d * 3) + (joueur.familier_c * 8) + (joueur.familier_b * 12) + (joueur.familier_a * 15) + (joueur.familier_s * 18)) / joueur.nombre_instances) * 100).toFixed(2);
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

<style>
body {
  background-image: url("/Colosseum_2.jpg");
  background-size: cover;
  background-position: center;
  background-attachment: fixed;
}

*::-webkit-scrollbar {
  width: 0.4em;
  background-color: transparent;
  border-radius: 10em;
  border-color: #fbbf24;
}

*::-webkit-scrollbar-thumb {
  background-color: #fbbf24;
  border-radius: 1em;
}

</style>