<script setup lang="ts">
import { computed } from 'vue';
import { type FormInputProps, FormInputTypeProp } from './type';

const props = withDefaults(defineProps<FormInputProps>(), {
  type: FormInputTypeProp.Text,
});

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
  <input
    :id="props.id"
    :class="computedClasses"
    class="c-form-input"
    :type="type"
    :minlength="props.minlength"
    :maxlength="props.maxlength"
    :placeholder="props.placeholder"
    :value="props.modelValue"
    @input="onInput"
  />
</template>

<style lang="scss">
.c-form-input {
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
  &:focus {
  }
}
</style>
