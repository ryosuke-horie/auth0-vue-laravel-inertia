<script setup lang="ts">
import { type FormCountProps } from './type';

const props = withDefaults(defineProps<FormCountProps>(), {
  limit: 50,
  unit: '文字',
});
</script>

<template>
  <span class="c-form-count">{{ props.count }} / {{ props.limit }}{{ props.unit }}</span>
</template>

<style lang="scss">
.c-form-count {
  font-size: 13px;
}
</style>
