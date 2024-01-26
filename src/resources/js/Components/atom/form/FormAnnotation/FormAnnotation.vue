<script setup lang="ts">
import { type FormAnnotationProps } from './type';

const props = defineProps<FormAnnotationProps>();
</script>

<template>
  <span class="c-form-annotation">{{ props.text }}</span>
</template>

<style lang="scss">
.c-form-annotation {
  font-size: 12px;
  color: #666666;
}
</style>
