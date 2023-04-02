import {createRouter, createWebHistory} from "vue-router";
import Todo from "../views/Todo.vue";
import Login from "../views/Login.vue";
import Register from "../views/Register.vue";
import ForgetPassword from "../views/ForgetPassword.vue";
import ResetPassword from "../views/ResetPassword.vue";

import {useAuth} from "@/context/Store";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "Todo",
      component: Todo,
      meta: {
        title: "Todo",
      },
      beforeEnter: async (to, from, next) => {
        const store = useAuth;

        const auth = localStorage.getItem("auth");

        if (!auth) {
          next("/login");
          return;
        }

        const authParsed = JSON.parse(auth);

        const response = await fetch(import.meta.env.VITE_BASE_URL_API + "/me", {
          method: "GET",
          headers: {
            authorization: "Bearer " + authParsed.token,
          },
        });

        if (response.status !== 200) {
          localStorage.clear();
          store.setAuth(
            {
              state: store.$state,
            },
            {
              auth: false,
              token: null,
            }
          );
          next("/login");
          return;
        } else {
          store.setAuth(
            {
              state: store.$state,
            },
            {
              auth: authParsed.auth,
              token: authParsed.token,
            }
          );
          next();
          return;
        }
      },
    },
    {
      path: "/login",
      name: "Login",
      component: Login,
      meta: {
        title: "Todo - Login",
      },
      beforeEnter: async (to, from, next) => {
        const store = useAuth;

        const auth = localStorage.getItem("auth");

        if (!auth) {
          next();
          return;
        }

        const authParsed = JSON.parse(auth);

        const response = await fetch(import.meta.env.VITE_BASE_URL_API + "/me", {
          method: "GET",
          headers: {
            authorization: "Bearer " + authParsed.token,
          },
        });

        if (response.status !== 200) {
          localStorage.clear();
          next();
          return;
        } else {
          store.setAuth(
            {
              state: store.$state,
            },
            {
              auth: authParsed.auth,
              token: authParsed.token,
            }
          );
          next("/");
          return;
        }
      },
    },
    {
      path: "/register",
      name: "Register",
      component: Register,
      meta: {
        title: "Todo - Register",
      },
      beforeEnter: async (to, from, next) => {
        const store = useAuth;

        const auth = localStorage.getItem("auth");

        if (!auth) {
          next();
          return;
        }

        const authParsed = JSON.parse(auth);

        const response = await fetch(import.meta.env.VITE_BASE_URL_API + "/me", {
          method: "GET",
          headers: {
            authorization: "Bearer " + authParsed.token,
          },
        });

        if (response.status !== 200) {
          localStorage.clear();
          store.setAuth(
            {
              state: store.$state,
            },
            {
              auth: false,
              token: null,
            }
          );
          next("/login");
          return;
        } else {
          store.setAuth(
            {
              state: store.$state,
            },
            {
              auth: authParsed.auth,
              token: authParsed.token,
            }
          );
          next('/');
          return;
        }
      },
    },
    {
      path: "/forget-password",
      name: "Forget Password",
      component: ForgetPassword,
      meta: {
        title: "Todo - Forget Password",
      },
    },
    {
      path: "/reset-password",
      name: "Reset Password",
      component: ResetPassword,
      meta: {
        title: "Todo - Reset Password",
      },
    },
  ],
});

router.beforeEach((to, from, next) => {
  if (typeof to.meta.title === "string") {
    document.title = to.meta.title;
  }
  next();
});

export default router;
