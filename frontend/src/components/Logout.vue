<template lang="">
  <button @click="logout" @mouseover="showTooltip" @mouseout="hideTooltip">
    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#D9D9D9" viewBox="0 0 256 256">
      <path
        d="M112,216a8,8,0,0,1-8,8H48a16,16,0,0,1-16-16V48A16,16,0,0,1,48,32h56a8,8,0,0,1,0,16H48V208h56A8,8,0,0,1,112,216Zm109.66-93.66-40-40a8,8,0,0,0-11.32,11.32L196.69,120H104a8,8,0,0,0,0,16h92.69l-26.35,26.34a8,8,0,0,0,11.32,11.32l40-40A8,8,0,0,0,221.66,122.34Z"
      ></path>
    </svg>

    <div v-if="isTooltipVisible" class="tooltip"> Logout </div>
  </button>
</template>
<script lang="ts">
import router from "@/router";
import {useAuth} from "@/context/Store";

export default {
  name: "Logout",
  data() {
    return {
      isTooltipVisible: false,
    };
  },
  methods: {
    showTooltip() {
      this.isTooltipVisible = true;
    },
    hideTooltip() {
      this.isTooltipVisible = false;
    },
    async logout() {
      const {token} = useAuth;
      try {
        const response = await fetch(import.meta.env.VITE_BASE_URL_API + "/logout", {
          headers: {
            authorization: "Bearer " + token,
          },
        });

        localStorage.clear()
      } catch (error) {
        console.log(error)
      }
      router.push("/login");
    },
  },
};
</script>

<style lang="scss" scoped>
button {
  position: fixed;
  bottom: 20px;
  right: 20px;
}

svg {
  transition: 0.2s;

  &:hover {
    fill: var(--purple);
  }
}

.tooltip {
  position: absolute;
  top: 0px;
  left: -80px;
  background-color: #000;
  color: #fff;
  padding: 5px 10px;
  border-radius: 3px;
  z-index: 999;
  font-size: 14px;

  &:after {
    content: "";
    border-width: 8px;
    border-color: transparent transparent black;
    border-style: solid;
    border-image: initial;
    display: inline-block;
    position: absolute;
    rotate: 90deg;
    right: -15px;
    top: 6px;
  }
}
</style>
