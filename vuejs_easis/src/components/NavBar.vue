<template>
  <div
      class="grid grid-cols-3 justify-evenly gap-5 py-4 border-opacity-50 bg-opacity-10">
    <div></div>
    <a class="flex justify-center gap-5">
      <a href="../" class="hover:scale-125 transition delay-50 text-neutral-200">Accueil</a>
      <a href="../instances" class="hover:scale-125 transition delay-50 text-neutral-200">Instances</a>
      <a href="../instances/ratios"
         class="hover:scale-125 transition delay-50 text-neutral-200">Ratios</a>
    </a>
    <div v-if="(isLoggedIn === false) || (isLoggedIn === null)" class="scale-50 md:scale-100">
      <form @submit.prevent="login_user" class="flex justify-center items-center">
        <div class="flex gap-1">
          <div class="flex">
            <input v-model="user.email" type="email" placeholder="Email" required
                   class="h-5 w-32 text-xs rounded-xl bg-black bg-opacity-40 border border-neutral-800 focus:outline-none ring-0">
          </div>
          <div class="flex">
            <input v-model="user.password" type="password" placeholder="Password" required
                   class="h-5 w-32 text-xs rounded-xl bg-black bg-opacity-40 border border-neutral-800 focus:outline-none ring-0">
          </div>
        </div>
        <div class="flex ml-2">
          <button type="submit">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="w-5 h-5 hover:scale-125 transition delay-50">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
            </svg>

          </button>
        </div>
      </form>
    </div>
    <div v-if="isLoggedIn === true" class="flex justify-center items-center text-xs gap-2">
      <div>Vous êtes connecté</div>
      <div>-</div>
      <a href="" @click="logout()" class="underline hover:text-white text-xs">Se déconnecter</a>
    </div>
  </div>

</template>

<script>
import axios from "axios";

export default {
  name: "NavBar",
  data() {
    return {
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
  methods: {
    getLoginStatus() {
      if (this.isLoggedIn != null) {
        this.isLoggedIn = JSON.parse(localStorage.getItem('isLoggedIn'));
        this.userRole = JSON.parse(localStorage.getItem('userRole'));
      }
    },
    getUserRole(email) {
      axios.get("http://api.etheron.fr/api/users")
          .then((response) => {
            const tempRole = Object.assign([], response.data);
            tempRole.forEach(elem => {
              if (elem.email === email)
                localStorage.setItem('userRole', elem.role);
            })
            this.getLoginStatus()
          })
          .catch(error => {
            console.log(error);
          });
    },
    //user login function and api call
    login_user() {
      axios
          .post('http://api.etheron.fr/api/login', this.user)
          .then((resp) => {
            this.getUserRole(this.user.email);
            this.user.email = '';
            this.user.password = '';
            if (resp["data"]["status"] === "error") {
              localStorage.setItem('isLoggedIn', false);
            } else {
              localStorage.setItem('isLoggedIn', true);
              this.getLoginStatus()
            }
          })
          .catch(error => {
            console.log(error);
          });
    },
    logout() {
      localStorage.setItem('isLoggedIn', false);
      localStorage.setItem('userRole', 0);
      this.getLoginStatus()
    }
  },
}
</script>

<style scoped>

</style>