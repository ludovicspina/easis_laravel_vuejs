<template>

  <div class="flex justify-center gap-10 mt-6 mb-6" v-if="userRole >= 60">
    <button style="text-shadow: 1px 1px 2px white;" class="bg-gradient-to-b from-amber-200 via-amber-400 transition delay-50 to-amber-200 hover:from-amber-100 hover:via-amber-300 hover:to-amber-100 rounded-xl text-neutral-800 font-medium px-3 border-double border-[7px] border-neutral-800" v-bind:class="(apocalypse)?'scale-125':''" @click="(apocalypse = true) && (blue = false)">Sets Apocalypse</button>
    <button style="text-shadow: 1px 1px 2px white;" class="bg-gradient-to-b from-amber-200 via-amber-400 transition delay-50 to-amber-200 hover:from-amber-100 hover:via-amber-300 hover:to-amber-100 rounded-xl text-neutral-800 font-medium px-3 border-double border-[7px] border-neutral-800" v-bind:class="(blue)?'scale-125':''" @click="(blue = true) && (apocalypse = false)">Sets 135</button>
  </div>

  <div class="flex flex-col" v-if="userRole >= 60">
    <div>
      <div class="mx-2">
        <div class="flex flex-col">
          <div class="grid lg:grid-cols-8 md:grid-cols-4 sm:grid-cols-2 gap-x-2">
            <div v-if="apocalypse" v-for="i in cdgs_apocalypse" class="mt-2">
              <div class="border-2 border-amber-300 hover:bg-neutral-700 transition delay-50 p-2 text-sm rounded-xl"
                   v-bind:class="(i.quantite > 0)?'bg-black opacity-90':'bg-black bg-opacity-50'">
                <div>
                  <div class="flex gap-2 justify-center text-amber-300">
                    <img v-bind:src="i.photos" class="w-5 h-5 mt-0.5">
                    {{ i.classe }}
                    <img v-bind:src="i.photos" class="w-5 h-5 mt-0.5">
                  </div>
                  <div class="flex justify-center text-amber-400">{{ i.libelle }} {{ i.genre }}</div>
                  <div class="flex justify-center gap-3">
                    <button class="hover:scale-125 transition delay-50" @click="removeOneItem(i.id)">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                           stroke="currentColor" class="stroke-amber-200 w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                      </svg>
                    </button>
                    <div class="flex justify-center text-amber-200">{{ i.quantite }} en stock</div>
                    <button class="hover:scale-125 transition delay-50" @click="addOneItem(i.id)">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                           stroke="currentColor" class="stroke-amber-200 w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                      </svg>
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <div v-if="blue" v-for="i in cdgs_blue" class="mt-2">
              <div class="border-2 border-amber-300 hover:bg-neutral-700 transition delay-50 p-2 text-sm rounded-xl"
                   v-bind:class="(i.quantite > 0)?'bg-black bg-opacity-90':'bg-black bg-opacity-50'">
                <div>
                  <div class="flex gap-2 justify-center text-amber-300">
                    <img v-bind:src="i.photos" class="w-5 h-5 mt-0.5">
                    {{ i.classe }}
                    <img v-bind:src="i.photos" class="w-5 h-5 mt-0.5">
                  </div>
                  <div class="flex justify-center text-amber-400">{{ i.libelle }} {{ i.genre }}</div>
                  <div class="flex justify-center gap-3">
                    <button class="hover:scale-125 transition delay-50" @click="removeOneItem(i.id)">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                           stroke="currentColor" class="stroke-amber-200 w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                      </svg>
                    </button>
                    <div class="flex justify-center text-amber-200">{{ i.quantite }} en stock</div>
                    <button class="hover:scale-125 transition delay-50" @click="addOneItem(i.id)">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                           stroke="currentColor" class="stroke-amber-200 w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                      </svg>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
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
      cdgs_apocalypse: [],
      cdgs_blue: [],
      apocalypse: false,
      blue: false,
    }
  },
  beforeMount() {
    this.getLoginStatus()
  },
  mounted() {
    axios.get("http://api.etheron.fr/api/cdg")
        .then((response) => {
          const tempCdg = Object.assign([], response.data);
          tempCdg.forEach(elem => {
            if (elem.type_stuff === 'APOCALYPSE')
              this.cdgs_apocalypse.push(elem);
            else if (elem.type_stuff === '135')
              this.cdgs_blue.push(elem);
          })
        })
  },
  methods: {

    getLoginStatus() {
      this.isLoggedIn = JSON.parse(localStorage.getItem('isLoggedIn'));
      this.userRole = JSON.parse(localStorage.getItem('userRole'));
    },
    addOneItem(id) {
      axios.put('http://api.etheron.fr/api/cdg/add-one-item/' + id);
      this.cdgs_apocalypse.forEach(elem => {
        if (elem.id === id) {
          elem.quantite++;
        }
      }
      );
      this.cdgs_blue.forEach(elem => {
            if (elem.id === id) {
              elem.quantite++;
            }
          }
      );

    },
    removeOneItem(id) {
      axios.put('http://api.etheron.fr/api/cdg/remove-one-item/' + id);
      this.cdgs_apocalypse.forEach(elem => {
            if (elem.id === id) {
              elem.quantite--;
            }
          }
      );
      this.cdgs_blue.forEach(elem => {
            if (elem.id === id) {
              elem.quantite--;
            }
          }
      );
    }
  }
}
</script>

<style scoped>

</style>