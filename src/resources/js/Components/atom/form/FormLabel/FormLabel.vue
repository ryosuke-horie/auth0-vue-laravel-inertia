<script setup lang="ts">
import type { FormLabelProps } from './type';

const props = withDefaults(defineProps<FormLabelProps>(), {});
</script>

<template>
  <label class="c-form-label" :for="props.htmlFor">{{ props.label }}</label>
</template>

<style lang="scss">
.c-form-label {
  cursor: pointer;
  font-size: 16px;
  font-weight: bold;
}
</style>
