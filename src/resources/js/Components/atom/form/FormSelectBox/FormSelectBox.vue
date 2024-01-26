<script setup lang="ts">
import { computed } from 'vue';
import type { FormSelectBoxProps } from './type';

const props = withDefaults(defineProps<FormSelectBoxProps>(), {});

const computedClasses = computed<string[]>(() => {
  const classes: string[] = [];

  if (props.isError) {
    classes.push('is-error');
  }

  return classes;
});

const emit = defineEmits(['update:modelValue']);

const onInput = (e: Event): void => {
  const value = (e.target as HTMLInputElement).value;
  emit('update:modelValue', value);
};
</script>

<template>
  <select
    :id="props.id"
    :class="computedClasses"
    class="c-form-select"
    :disabled="props.disabled"
    :name="props.name"
    :placeholder="props.placeholder"
    :value="props.modelValue"
    @input="onInput"
  >
    <option
      v-for="(item, index) of props.options"
      :key="`${item.value} + ${index}`"
      :value="item.value"
      :hidden="item.hidden"
    >
      {{ item.label }}
    </option>
  </select>
</template>

<style lang="scss">
.c-form-select {
  height: 50px;
  border: solid 1px;
  border-color: #dddddd;
  border-radius: 4px;
  padding: 0 16px;
  max-width: 100%;
  color: #000000;
  background-color: #eeeeee;
  &.is-error {
    border-color: red;
    background-color: #ffe3e3;
  }
  // &:focus{

  // }
}
</style>
