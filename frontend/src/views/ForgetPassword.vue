<template>
  <div class="container-form">
    <div class="auth">
      <router-link to="/login">Login --></router-link>
    </div>

    <div class="wrapper">
      <div class="title">
        <h1>Revitalize Your Productivity</h1>
        <span>Recover Your Lost Password and Get Back on Track</span>
      </div>

      <Form @submit.prevent="handleSubmit">
        <InputComponent
          label="Email"
          type="email"
          id="email"
          placeholder="example@example.com"
          v-model="email"
          :class="errors?.errors.email ? 'error' : ''"
        />

        <div class="errors">
          <p v-if="errors && errors.errors.email">{{ errors?.errors.email![0] }}</p>
          <p v-if="errors && errors.errors.password" v-for="error in errors?.errors.password">
            <span>{{ error }}</span>
          </p>
        </div>

        <button v-if="loading" disabled class="disabled"> <LoadingSpinner /> Please wait</button>
        <button v-else> Send code </button>
      </Form>
    </div>
  </div>
</template>
<script lang="ts">
import Form from "@/components/Form/Form.vue";
import InputComponent from "@/components/Form/InputComponent.vue";
import router from "@/router";
import LoadingSpinner from "@/components/Icons/LoadingSpinner.vue";

import {useToast} from "vue-toastification";

interface Data {
  email: string;
  errors: {
    message: string;
    errors: {
      email?: string[];
      password?: string[];
    };
  } | null;
  loading: boolean;
}
export default {
  data(): Data {
    return {
      email: "",
      errors: null,
      loading: false,
    };
  },
  setup() {
    const toast = useToast();

    return {toast};
  },
  components: {InputComponent, Form, LoadingSpinner},
  methods: {
    async handleSubmit() {
      this.loading = true;

      try {
        const response = await fetch(import.meta.env.VITE_BASE_URL_API + "/resetPasswordRequest", {
          method: "POST",
          headers: {
            "Content-type": "application/json",
            Accept: "application/json",
          },
          body: JSON.stringify({
            email: this.email,
          }),
        });
        const data = await response.json();

        if (response.status === 200) {
          this.toast.success(data.message);
          router.push("/reset-password");
        } else {
          this.errors = data;
        }
      } catch (error) {
        console.log(error);
      } finally {
        this.loading = false;
      }
    },
  },
};
</script>
