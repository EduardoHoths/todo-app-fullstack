<template>
  <div class="container-form">
    <div class="auth">
      <router-link to="/login">Login --></router-link>
    </div>

    <div class="wrapper">
      <div class="title">
        <h1>Reset your password</h1>
        <span>Get back to your account in no time!</span>
      </div>

      <Form @submit.prevent="handleSubmit">
        <InputComponent
          id="email"
          label="Email"
          placeholder="Email"
          v-model="email"
          type="email"
          :class="errors?.errors.email ? 'error' : ''"
        />
        <InputComponent
          id="code"
          label="Code"
          placeholder="Code"
          v-model="verification_code"
          type="number"
          :class="errors?.errors.verification_code ? 'error' : ''"
        />
        <InputComponent
          id="password"
          label="Password"
          placeholder="Password"
          v-model="password"
          type="password"
          :class="errors?.errors.password ? 'error' : ''"
        />
        <InputComponent
          id="confirm-password"
          label="Confirm Password"
          placeholder="Confirm Password"
          v-model="password_confirmation"
          type="password"
          :class="errors?.errors.password ? 'error' : ''"
        />

        <div class="errors">
          <p v-if="errors && errors.errors.email">{{ errors?.errors.email![0] }}</p>
          <p v-if="errors && errors.errors.verification_code">{{ errors?.errors.verification_code![0] }}</p>
          <p v-if="errors && errors.errors.password" v-for="error in errors?.errors.password">
            <span>{{ error }}</span>
          </p>
        </div>

        <button v-if="loading" disabled class="disabled"> <LoadingSpinner /> Please wait</button>
        <button v-else> Reset your password</button>
      </Form>
    </div>
  </div>
</template>

<script lang="ts">
import InputComponent from "@/components/Form/InputComponent.vue";
import Form from "@/components/Form/Form.vue";
import {useToast} from "vue-toastification";
import LoadingSpinner from "@/components/Icons/LoadingSpinner.vue";
import router from "@/router";

interface Data {
  email: string;
  password: string;
  password_confirmation: string;
  verification_code: string;
  errors: {
    message: string;
    errors: {
      email?: string[];
      password?: string[];
      verification_code?: string[];
    };
  } | null;
  loading: boolean;
}

export default {
  name: "ForgetPassword",
  data(): Data {
    return {
      email: "",
      password: "",
      password_confirmation: "",
      verification_code: "",
      errors: null,
      loading: false,
    };
  },

  setup() {
    const toast = useToast();

    return {toast};
  },
  components: {
    InputComponent,
    Form,
    LoadingSpinner,
  },
  methods: {
    async handleSubmit() {
      this.errors = null;
      this.loading = true;

      try {
        const response = await fetch(import.meta.env.VITE_BASE_URL_API + "/resetPassword", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
          },
          body: JSON.stringify({
            email: this.email,
            password: this.password,
            password_confirmation: this.password_confirmation,
            verification_code: this.verification_code,
          }),
        });

        const data = await response.json();

        if (response.status === 200) {
          this.toast.success(data.message);
          router.push("/login");
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
