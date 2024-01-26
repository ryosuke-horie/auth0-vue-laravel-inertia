<script setup lang="ts">
import { type FormDescriptionProps } from './type';

const props = defineProps<FormDescriptionProps>();
</script>

<template>
  <span class="c-form-description">{{ props.text }}</span>
</template>

<style lang="scss">
.c-form-description {
  font-size: 13px;
}
</style>
