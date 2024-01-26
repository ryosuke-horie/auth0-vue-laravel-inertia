<script setup lang="ts">
import { computed } from 'vue';
import type { DividerProps } from './type';

const props = withDefaults(defineProps<DividerProps>(), {
  height: 1,
});

const computedStyles = computed<{ height: string }>(() => {
  return {
    height: `${props.height}px`,
  };
});
</script>

<template>
  <hr class="c-divider" :style="computedStyles" />
</template>

<style lang="scss">
.c-divider {
  border: none;
  background-color: #dddddd;
}
</style>
