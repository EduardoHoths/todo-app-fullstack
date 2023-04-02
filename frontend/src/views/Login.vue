<template>
  <div class="container-form">
    <div class="auth">
      <router-link to="/register">Signup --></router-link>
    </div>

    <div class="wrapper">
      <div class="title">
        <h1>Welcome back</h1>
        <span>Let's get started!</span>
      </div>

      <Form @submit.prevent="handleLogin">
        <InputComponent
          id="email"
          label="Email"
          placeholder="example@example.com"
          type="email"
          v-model="email"
          :class="errors?.errors.email ? 'error' : ''"
        />
        <InputComponent
          id="password"
          label="Password"
          type="password"
          placeholder="********"
          v-model="password"
          :class="errors?.errors.password ? 'error' : ''"
        />

        <button v-if="loading" disabled class="disabled"> <LoadingSpinner /> Please wait</button>
        <button v-else> Login</button>

        <div class="errors">
          <p v-if="errors && errors.errors.email">{{ errors?.errors.email![0] }}</p>
          <p v-if="errors && errors.errors.password" v-for="error in errors?.errors.password">
            <span>{{ error }}</span>
          </p>
        </div>

        <router-link to="/forget-password">Forget your password?</router-link>
      </Form>
    </div>
  </div>
</template>

<script lang="ts">
import router from "@/router";
import {useAuth} from "@/context/Store";
import Form from "@/components/Form/Form.vue";
import InputComponent from "@/components/Form/InputComponent.vue";
import LoadingSpinner from "@/components/Icons/LoadingSpinner.vue";

const store = useAuth;

interface Data {
  email: string;
  password: string;
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
  name: "Login",
  components: {
    Form,
    InputComponent,
    LoadingSpinner,
  },
  data(): Data {
    return {
      email: "",
      password: "",
      errors: null,
      loading: false,
    };
  },

  methods: {
    async handleLogin() {
      try {
        this.loading = true;

        const response = await fetch(import.meta.env.VITE_BASE_URL_API + "/login", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
          },
          body: JSON.stringify({
            email: this.email,
            password: this.password,
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
