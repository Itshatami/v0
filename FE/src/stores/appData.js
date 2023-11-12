import { defineStore } from 'pinia'

export const useAppDataStore = defineStore('appData', {
  state: () => ({
    username: null
  }),
})
