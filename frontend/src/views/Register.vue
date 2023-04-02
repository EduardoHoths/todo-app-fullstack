<template>
  <div class="container-form">
    <div class="auth">
      <router-link to="/login">Login --></router-link>
    </div>

    <div class="wrapper">
      <div class="title">
        <h1>Let's join us :)</h1>
        <span>Take control of your tasks and achieve your goals.</span>
      </div>

      <Form @submit.prevent="handleRegister">
        <InputComponent
          label="Email"
          type="email"
          id="email"
          placeholder="example@example.com"
          v-model="email"
          :class="errors?.errors.email ? 'error' : ''"
        />

        <InputComponent
          label="Password"
          type="password"
          id="password"
          placeholder="********"
          v-model="password"
          :class="errors?.errors.password ? 'error' : ''"
        />

        <InputComponent
          label="Confirm Password"
          type="password"
          id="confirm_password"
          placeholder="********"
          v-model="confirmPassword"
          :class="errors?.errors.password ? 'error' : ''"
        />

        <div class="errors">
          <p v-if="errors && errors.errors.email">{{ errors?.errors.email![0] }}</p>
          <p v-if="errors && errors.errors.password" v-for="error in errors?.errors.password">
            <span>{{ error }}</span>
          </p>
        </div>

        <button v-if="loading" disabled class="disabled"> <LoadingSpinner /> Please wait</button>
        <button v-else> Register </button>
      </Form>
    </div>
  </div>
</template>

<script lang="ts">
import {useAuth} from "@/context/Store";
import router from "@/router";
import Form from "@/components/Form/Form.vue";
import InputComponent from "@/components/Form/InputComponent.vue";
import LoadingSpinner from "@/components/Icons/LoadingSpinner.vue";

const store = useAuth;

interface Data {
  email: string;
  password: string;
  confirmPassword: string;
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
  name: "Register",
  data(): Data {
    return {
      email: "",
      password: "",
      confirmPassword: "",
      errors: null,
      loading: false,
    };
  },
  components: {Form, InputComponent, LoadingSpinner},
  methods: {
    async handleRegister() {
      this.loading = true;

      try {
        const response = await fetch(import.meta.env.VITE_BASE_URL_API + "/register", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
          },
          body: JSON.stringify({
            email: this.email,
            password: this.password,
            password_confirmation: this.confirmPassword,
          }),
        });

        const data = await response.json();

        if (response.status === 200) {
          store.setAuth(
            {
              state: store.$state,
            },
            {
              auth: true,
              token: data.token,
            }
          );

          router.push("/");
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
