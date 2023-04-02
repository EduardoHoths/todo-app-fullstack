<template>
  <div class="spinner-7"> </div>
</template>

<style lang="scss">
.spinner-7 {
  width: 20px;
  aspect-ratio: 1;
  --_c: radial-gradient(farthest-side, #fff 92%, #0000);
  background: var(--_c) top, var(--_c) left, var(--_c) right, var(--_c) bottom;
  background-size: 5px 5px;
  background-repeat: no-repeat;
  animation: s7 1s infinite;
}
@keyframes s7 {
  to {
    transform: rotate(0.5turn);
  }
}
</style>
