import { defineStore } from "pinia";

export const useAuthStore = defineStore("username", {
  state: () => ({
    username: ""
  })
});
