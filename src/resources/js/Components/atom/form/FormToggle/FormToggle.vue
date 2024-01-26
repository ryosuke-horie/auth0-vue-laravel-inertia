<script setup lang="ts">
import { computed } from 'vue';
import type { FormToggleProps } from './type';

const props = withDefaults(defineProps<FormToggleProps>(), {});

const computedClasses = computed<string[]>(() => {
  const classes: string[] = [];
  return classes;
});

const emit = defineEmits(['update:modelValue']);

const onChange = (e: Event): void => {
  const value = (e.target as HTMLInputElement).checked;
  emit('update:modelValue', value);
};
</script>

<template>
  <div class="c-toggle">
    <input
      :id="props.id"
      type="checkbox"
      class="c-toggle__checkbox"
      :class="computedClasses"
      :checked="props.modelValue"
      @change="onChange"
    />
    <label :for="props.id" class="c-toggle__label" />
  </div>
</template>

<style lang="scss">
.c-toggle {
  &__checkbox {
    display: none;
    &:checked + .c-toggle__label {
      background-color: #36df98;
      &::after {
        left: unset;
        right: 1px;
      }
    }
  }
  &__label {
    cursor: pointer;
    display: inline-block;
    position: relative;
    border: none;
    border-radius: 50px;
    width: 64px;
    height: 40px;
    box-sizing: border-box;
    border: solid 2px #bbbbbb;
    background-color: #cccccc;
    &::after {
      content: '';
      position: absolute;
      width: 36px;
      height: 36px;
      border-radius: 50%;
      left: 1px;
      top: 0px;
      border: 1px solid #dddddd;
      transition: all 0.1s ease 0s;
      background: var(--white);
    }
  }
}
</style>
