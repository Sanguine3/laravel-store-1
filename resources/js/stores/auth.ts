import { defineStore } from 'pinia';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null as null | Record<string, any>,
  }),
  getters: {
    isAdmin: (state) => state.user?.role === 'admin',
    isCustomer: (state) => state.user?.role === 'customer',
  },
  actions: {
    setUser(user: Record<string, any> | null) {
      this.user = user;
    },
    clearUser() {
      this.user = null;
    },
  },
}); 