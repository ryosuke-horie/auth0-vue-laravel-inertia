<script lang="ts" setup>
import { computed } from 'vue';
import { type ColorSectionProps, ColorSectionVariantProp } from './type';

const props = withDefaults(defineProps<ColorSectionProps>(), {
  variant: ColorSectionVariantProp.Gray,
});

const computedClasses = computed<string[]>(() => {
  const classes: string[] = [];

  classes.push(props.variant);

  if (props.isRounded) {
    classes.push('is-rounded');
  }

  return classes;
});
</script>

<template>
  <div class="c-color-section" :class="computedClasses"><slot /></div>
</template>

<style lang="scss">
.c-color-section {
  padding: 16px;
  &.gray {
    background-color: #eeeeee;
  }
  &.white {
    background-color: var(--white);
  }
  &.is-rounded {
    border-radius: 10px;
  }
}
</style>
