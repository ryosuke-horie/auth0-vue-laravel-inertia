<script setup lang="ts">
import { type FormValidationProps } from './type';

const props = defineProps<FormValidationProps>();
</script>

<template>
  <div class="c-form-validation">{{ props.text }}</div>
</template>

<style lang="scss">
.c-form-validation {
  font-size: 13px;
  color: #ff0000;
}
</style>
