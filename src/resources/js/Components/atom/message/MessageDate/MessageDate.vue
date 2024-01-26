<script lang="ts" setup>
import { MessageDateProps } from './type';

const props = defineProps<MessageDateProps>();
</script>

<template>
  <div class="c-message-date">{{ props.date }}</div>
</template>

<style lang="scss">
.c-message-date {
  font-size: 12px;
}
</style>
