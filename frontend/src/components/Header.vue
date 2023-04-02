<template>
  <header>
    <img :src="img" alt="Logo todo" />
  </header>
</template>

<script lang="ts">
export default {
  name: "Header",

  data() {
    return {
      img: "/Logo.svg",
    };
  },
};
</script>

<style lang="scss" scoped>
header {
  background-color: var(--gray-700);
  height: 200px;
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>
