<template>
  <div>
    <h1>Login</h1>
    {{ isLoggedIn }}
    <form @submit.prevent="login_user">
      <label>Email:</label>
      <input v-model="user.email" type="email" required>
      <br><br>
      <label>Password:</label>
      <input v-model="user.password" type="password" required>
      <br><br>
      <button type="submit">Login</button>
    </form>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      "user":
          {
            "email": "user@example.com",
            "password": "password"
          },
    };
  },

  computed: {
    isLoggedIn() {
      return localStorage.getItem('isLoggedIn');
    }
  },

  methods: {
    //user login function and api call
    login_user() {
      axios
          .post('http://api.etheron.fr/api/login', this.user)
          .then((resp) => {
            console.log(resp["data"]["status"]);

            this.user.email = '';
            this.user.password = '';
            console.log(this.isLoggedIn)
            if (resp["data"]["status"] === "error") {
              localStorage.setItem('isLoggedIn', false);
            } else {
              localStorage.setItem('isLoggedIn', true);
            }
          })
    }
  },

};
</script>
