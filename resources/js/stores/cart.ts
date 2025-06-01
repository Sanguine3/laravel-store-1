import { defineStore } from 'pinia';

export const useCartStore = defineStore('cart', {
  state: () => ({
    items: [] as any[],
    count: 0,
  }),
  actions: {
    setItems(items: any[]) {
      this.items = items;
      this.count = items.length;
    },
    setCount(count: number) {
      this.count = count;
    },
    clearCart() {
      this.items = [];
      this.count = 0;
    },
  },
}); 