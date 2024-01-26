<script setup lang="ts">
import { computed } from 'vue';
import { ParagraphVariantProp, type ParagraphProps } from './type';

const props = withDefaults(defineProps<ParagraphProps>(), {
  variant: ParagraphVariantProp.Black,
});

const computedClasses = computed<string[]>(() => {
  const classes: string[] = [];

  classes.push(props.variant);

  return classes;
});
</script>

<template>
  <p class="c-paragraph" :class="computedClasses">
    <slot />
  </p>
</template>

<style lang="scss">
.c-paragraph {
  &.black {
    color: var(--black);
  }
  &.white {
    color: var(--white);
  }
  &.gray {
    color: var(--gray);
  }
  &.red {
    color: var(--red);
  }
}
</style>
