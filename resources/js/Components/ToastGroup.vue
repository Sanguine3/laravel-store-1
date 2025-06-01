<template>
  <div class="fixed top-4 right-4 z-50 flex flex-col space-y-2">
    <transition-group name="toast" tag="div">
      <div
        v-for="msg in flashStore.messages"
        :key="msg.id"
        :class="['px-4 py-2 rounded shadow-lg', toastClasses[msg.type]]"
        @mouseenter="clearTimeout(timerMap[msg.id])"
        @mouseleave="startTimer(msg.id)"
      >
        {{ msg.message }}
      </div>
    </transition-group>
  </div>
</template>

<script setup lang="ts">
import { reactive, watch } from 'vue';
import { useFlashStore } from '@/stores/flash';

const flashStore = useFlashStore();
const timerMap = reactive<Record<string, number>>({});

const toastClasses: Record<string, string> = {
  success: 'bg-green-500 text-white',
  error: 'bg-red-500 text-white',
  warning: 'bg-yellow-500 text-white',
  info: 'bg-blue-500 text-white',
};

function startTimer(id: string) {
  clearTimeout(timerMap[id]);
  timerMap[id] = window.setTimeout(() => {
    flashStore.remove(id);
    delete timerMap[id];
  }, 5000);
}

watch(
  () => flashStore.messages,
  (msgs) => {
    msgs.forEach((msg) => {
      if (!timerMap[msg.id]) {
        startTimer(msg.id);
      }
    });
  },
  { deep: true, immediate: true }
);
</script>

<style scoped>
.toast-enter-active,
.toast-leave-active {
  transition: all 0.3s ease;
}
.toast-enter-from,
.toast-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}
.toast-enter-to,
.toast-leave-from {
  opacity: 1;
  transform: translateY(0);
}
</style> 