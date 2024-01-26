<script lang="ts" setup>
import { AlertProps } from './type';

const props = defineProps<AlertProps>();
</script>

<template>
  <div class="c-alert">{{ props.text }}</div>
</template>

<style lang="scss">
.c-alert {
  padding: 16px;
  border-radius: 5px;
  color: var(--white);
  background-color: var(--red);
}
</style>
