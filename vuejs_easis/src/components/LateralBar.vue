<template>
  <div class="w-1/6 flex flex-col items-center bg-zinc-800 border-r-2 border-cyan-900">
    <div class="text-4xl text-cyan-200 font-semibold mt-4 drop-shadow drop-shadow-cyan-500/50">Easis</div>
    <div></div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "LateralBar",
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