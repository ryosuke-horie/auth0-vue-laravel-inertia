<script setup lang="ts">
import type { DefinitionListItemProps } from './type';

const props = defineProps<DefinitionListItemProps>();
</script>

<template>
  <div class="c-definition-item-list">
    <p class="c-definition-item-list__label">{{ props.label }}</p>
    <p class="c-definition-item-list__content">{{ props.content }}</p>
  </div>
</template>

<style lang="scss">
.c-definition-item-list {
  width: 100%;
  background-color: #ffffff;
  &__content {
    padding: 5px 0px 5px 20px;
  }
}
</style>
