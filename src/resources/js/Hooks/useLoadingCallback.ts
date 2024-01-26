import { ref } from 'vue';

export const useLoadingCallback = (fn: (...args: unknown[]) => void | Promise<void>) => {
  const isLoading = ref(false);

  const fetch = async (): Promise<void> => {
    if (isLoading.value) return;
    isLoading.value = true;
    await fn();
    isLoading.value = false;
  };

  return {
    isLoading,
    fetch,
  };
};
