<script lang="ts" setup>
import { TipListProps } from './type';
import TipListItem from '@/Components/molecules/list/TipListItem/TipListItem.vue';
const props = defineProps<TipListProps>();
</script>

<template>
  <ul class="c-cheer-list">
    <TipListItem
      v-for="(item, index) of props.list"
      :key="item.name + index"
      :href="item.href"
      :src="item.src"
      :point="item.point"
      :name="item.name"
      :date="item.date"
      :is-read="item.isRead"
    />
  </ul>
</template>

<style lang="scss">
.c-cheer-list {
  list-style: none;
}
</style>
