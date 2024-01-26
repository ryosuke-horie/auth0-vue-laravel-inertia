<script lang="ts" setup>
import { TotalCountSectionProps } from './type';

const props = defineProps<TotalCountSectionProps>();
</script>
<template>
  <div class="c-total-count-section">
    <div class="c-total-count-section__label">{{ props.label }}</div>
    <div class="c-total-count-section__count">{{ props.count.toLocaleString() }}</div>
    <div class="c-total-count-section__unit">{{ props.unit }}</div>
  </div>
</template>

<style lang="scss">
.c-total-count-section {
  display: flex;
  align-items: center;
  height: 80px;
  padding: 0 16px;
  font-weight: var(--bold);
  &__label {
    font-size: 17px;
  }
  &__count {
    margin-left: auto;
    font-size: 34px;
    line-height: 38px;
  }
  &__unit {
    font-size: 17px;
    margin-top: 10px;
    margin-left: 5px;
  }
}
</style>
