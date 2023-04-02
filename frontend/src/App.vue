<template lang="">
  <div>
    <Header />
    <router-view></router-view>
  </div>
</template>

<script lang="ts">
import Header from "./components/Header.vue";
import {useAuth} from "./context/Store";
import router from "./router";

async function getUser() {
  
}

getUser()

interface AuthState {
  auth: boolean;
  token: string | null;
}

export default {
  name: "App",
  components: {
    Header,
  },
};
</script>
