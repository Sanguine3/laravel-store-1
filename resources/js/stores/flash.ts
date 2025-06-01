import { defineStore } from 'pinia';
import { nanoid } from 'nanoid';

export type FlashMessage = {
  id: string;
  type: 'success' | 'error' | 'warning' | 'info';
  message: string;
};

export const useFlashStore = defineStore('flash', {
  state: () => ({
    messages: [] as FlashMessage[],
  }),
  actions: {
    add(message: Omit<FlashMessage, 'id'>) {
      const id = nanoid();
      this.messages.push({ id, ...message });
    },
    remove(id: string) {
      this.messages = this.messages.filter((msg) => msg.id !== id);
    },
    clear() {
      this.messages = [];
    },
  },
}); 