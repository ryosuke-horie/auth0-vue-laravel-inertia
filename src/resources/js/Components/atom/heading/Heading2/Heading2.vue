<script setup lang="ts">
import type { Heading2Props } from './type';

const props = withDefaults(defineProps<Heading2Props>(), {});
</script>

<template>
  <h2 class="c-heading2">{{ props.text }}</h2>
</template>

<style lang="scss">
.c-heading2 {
  width: 100%;
  height: 40px;
  font-size: 16px;
  padding: 0 16px;
  font-weight: 700;
  line-height: 40px;
  letter-spacing: -0.015em;
  color: #000000;
  background-color: #ffffff;
}
</style>
