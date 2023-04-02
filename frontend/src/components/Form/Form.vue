<template>
  <form class="form"> <slot /> </form>
</template>
<script lang="ts">
export default {
  name: "Form",
};
</script>
<style lang="scss">
.form {
  display: flex;
  flex-direction: column;
  gap: 16px;

  width: 400px;

  > div {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  

  input:-webkit-autofill {
    -webkit-box-shadow: 0 0 0 30px var(--gray-400) inset !important;
    -webkit-text-fill-color: #fff !important;
    background-color: transparent !important;
    border: 1px solid var(--gray-300);
  }

  .error input {
    border: 1px solid var(--danger);
  }

  input {
    background-color: var(--gray-400);
    padding: 10px 20px;
    border-radius: 6px;

    &:focus {
      border: 1px solid var(--purple);
    }
  }

  button {
    margin-top: 20px;
    background-color: var(--purple);
    padding: 10px;
    border-radius: 6px;
    font-size: 18px;
    font-weight: bold;

    display: flex;
    align-items: center;
    justify-content: center;
    gap: 20px;

    &:hover {
      background-color: var(--purple-dark);
    }
  }

  a {
    text-align: center;
    color: var(--gray-300);

    &:hover {
      color: var(--gray-100);
    }
  }
}

@media (max-width: 420px) {
  .form{
    width: 320px;
  }
}

@media (max-width: 320px) {
  .form{
    width: 280px;
  }
}
</style>
