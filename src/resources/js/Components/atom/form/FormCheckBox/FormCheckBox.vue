<script setup lang="ts">
import { type FormCheckBoxProps } from './type';

const props = defineProps<FormCheckBoxProps>();
const emit = defineEmits(['update:checked']);

const toggleChecked = () => {
  emit('update:checked', !props.checked);
};
</script>

<template>
  <label class="c-form-checkbox">
    <input type="checkbox" :checked="props.checked" @change="toggleChecked" />
    {{ props.label }}
  </label>
</template>

<style lang="scss">
.c-form-checkbox {
  font-size: 13px;
  display: flex;
  align-items: center;
  gap: 8px;

  input[type='checkbox'] {
    accent-color: #007bff;
    cursor: pointer;
  }

  label {
    cursor: pointer;
  }
}
</style>
