<script lang="ts" setup>
import { computed } from 'vue';
import { type IconImageProps } from './type';

const props = withDefaults(defineProps<IconImageProps>(), {
  width: 50,
  height: 50,
});

const computedClasses = computed<string[]>(() => {
  const classes: string[] = [];

  return classes;
});

const computedStyles = computed<{ width: string; height: string }>(() => {
  return {
    width: `${props.width}px`,
    height: `${props.height}px`,
  };
});
</script>

<template>
  <div class="c-icon-image" :style="computedStyles" :class="computedClasses">
    <img :src="props.src" :alt="props.alt" />
  </div>
</template>

<style lang="scss">
.c-icon-image {
  overflow: hidden;
  border-radius: 50%;
  background-color: var(--white);
  img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
}
</style>
