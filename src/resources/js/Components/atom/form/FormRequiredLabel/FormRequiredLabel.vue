<script setup lang="ts">
import { computed } from 'vue';
import { type FormRequiredLabelProps, FormRequiredLabelTypeProp } from './type';

const props = defineProps<FormRequiredLabelProps>();

const labelName = computed<string>(() => {
  switch (props.type) {
    case FormRequiredLabelTypeProp.Required:
      return '必須';
    case FormRequiredLabelTypeProp.Any:
      return '任意';
    default:
      return '';
  }
});
</script>

<template>
  <span class="c-form-required-label" :class="`c-form-required-label--${props.type}`">
    {{ labelName }}
  </span>
</template>

<style lang="scss">
.c-form-required-label {
  display: inline-block;
  font-size: 14px;
  padding: 0 8px;
  font-weight: bold;
  &--required {
    color: white;
    background-color: #ff0000;
  }
  &--any {
    color: white;
    background-color: #36df98;
  }
}
</style>
