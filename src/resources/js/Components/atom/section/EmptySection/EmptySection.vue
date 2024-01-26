<script lang="ts" setup>
import { EmptySectionProps } from './type';

const props = defineProps<EmptySectionProps>();
</script>

<template>
  <div class="c-empty-section">{{ props.text }}</div>
</template>

<style lang="scss">
.c-empty-section {
  padding: 16px;
  text-align: center;
}
</style>
