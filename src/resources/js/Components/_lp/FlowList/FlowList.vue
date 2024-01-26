<script lang="ts" setup>
import { FlowListProps } from './type';
const props = defineProps<FlowListProps>();
</script>

<template>
  <ul class="c-flow-list">
    <li v-for="(item, index) of props.items" :key="item.title + index" class="c-flow-list__item">
      <div class="c-flow-list__title">
        <span class="c-flow-list__title-number">{{ index + 1 }}</span>
        <span class="c-flow-list__title-text">{{ item.title }}</span>
      </div>
      <div class="c-flow-list__text">{{ item.text }}</div>
    </li>
  </ul>
</template>

<style lang="scss">
.c-flow-list {
  box-sizing: border-box;
  border: solid 1px silver;
  &__item {
    padding: 16px;
    & + .c-flow-list__item {
      border-top: solid 1px silver;
    }
  }
  &__title {
    display: flex;
    align-items: center;
    margin-bottom: 16px;
    &-number {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 30px;
      height: 30px;
      border-radius: 5px;
      margin-right: 8px;
      background-color: #ff7733;
      color: var(--white);
      font-weight: var(--bold);
    }
    &-text {
      font-size: 18px;
      font-weight: var(--bold);
    }
  }
  &__text {
    font-size: 14px;
  }
}
</style>
