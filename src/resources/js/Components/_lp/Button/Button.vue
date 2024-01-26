<script setup lang="ts">
import { computed } from 'vue';
import { ButtonVariantProp, type ButtonProps } from './type';
import { Link } from '@inertiajs/vue3';

const props = withDefaults(defineProps<ButtonProps>(), {
  variant: ButtonVariantProp.Blue,
});

const computedClasses = computed<string[]>(() => {
  const classes: string[] = [];

  classes.push(props.variant);

  return classes;
});
</script>

<template>
  <Link class="c-button" :href="props.href" :class="computedClasses">
    <span v-if="props.icon" class="c-button__icon">
      <i :class="props.icon"></i>
    </span>
    {{ props.text }}
  </Link>
</template>

<style lang="scss" scoped>
.c-button {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  box-sizing: border-box;
  min-height: 60px;
  padding: 16px;
  border-radius: 4px;
  border: none;
  border: solid 1px;
  min-width: 120px;
  font-weight: bold;
  text-align: center;
  text-decoration: none;
  color: var(--white);
  &__icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    position: absolute;
    top: 50%;
    left: 16px;
    transform: translateY(-50%);
    i {
      font-size: 20px;
    }
  }
  &.blue {
    background-color: #55aaee;
  }
  &.green {
    background-color: #60c0bd;
  }
  &.orange {
    background-color: #ff7733;
  }
  &.black {
    background-color: #333;
  }
  &.red {
    background-color: #dd0000;
  }
}
</style>
