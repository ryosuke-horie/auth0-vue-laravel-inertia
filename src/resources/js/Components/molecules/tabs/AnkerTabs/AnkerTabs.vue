<script lang="ts" setup>
import { AnkerTabsProps } from './type';
import { Link } from '@inertiajs/vue3';

const props = defineProps<AnkerTabsProps>();
</script>

<template>
  <div class="c-anker-tabs">
    <Link
      v-for="(item, index) of props.tabs"
      :key="index"
      class="c-anker-tabs__item"
      :class="{ 'is-active': item.isActive }"
      :href="item.href"
    >
      {{ item.text }}
    </Link>
  </div>
</template>

<style lang="scss">
.c-anker-tabs {
  display: flex;
  border-bottom: solid 1px #ddd;
  &__item {
    text-align: center;
    flex: 1;
    padding: 16px;
    color: var(--black);
    &.is-active {
      border-bottom: solid 2px pink;
    }
  }
}
</style>
