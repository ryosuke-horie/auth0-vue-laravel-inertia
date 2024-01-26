<script lang="ts" setup>
import { computed } from 'vue';
import { type ImageProps } from './type';

const props = withDefaults(defineProps<ImageProps>(), {
  width: 50,
  height: 50,
});

const computedClasses = computed<string[]>(() => {
  const classes: string[] = [];

  return classes;
});

const computedStyles = computed<{ width: string; height: string }>(() => {
  const width = typeof props.width === 'number' ? `${props.width}px` : props.width;
  const height = typeof props.height === 'number' ? `${props.height}px` : props.height;

  return {
    width,
    height,
  };
});
</script>

<template>
  <div class="c-image" :style="computedStyles" :class="computedClasses">
    <img :src="props.src" :alt="props.alt" />
  </div>
</template>

<style lang="scss">
.c-image {
}
</style>
