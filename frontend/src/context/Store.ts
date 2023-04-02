import {defineStore} from "pinia";
import {createPinia} from "pinia";

const pinia = createPinia();
export default pinia;

interface AuthState {
  auth: boolean;
  token: string | null;
}

export const createStore = defineStore({
  id: "auth",
  state: () => ({auth: false, token: null}),
  getters: {
    getAuth(state: AuthState) {
      return {
        auth: state.auth,
        token: state.token,
      };
    },
  },
  actions: {
    setAuth({state}: {state: AuthState}, {auth, token}: {auth: boolean; token: string | null}) {
      state.auth = auth;
      state.token = token;

      localStorage.setItem(
        "auth",
        JSON.stringify({
          auth,
          token,
        })
      );
    },
  },
});

export const useAuth = createStore(pinia);
