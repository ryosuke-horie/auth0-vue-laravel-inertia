<script lang="ts" setup>
import { PointListProps } from './type';
import PointListItem from '@/Components/molecules/list/PointListItem/PointListItem.vue';
const props = defineProps<PointListProps>();
</script>

<template>
  <ul class="c-point-list">
    <PointListItem
      v-for="(item, index) of props.list"
      :key="item.category + index"
      :category="item.category"
      :count="item.count"
      :date="item.date"
    />
  </ul>
</template>

<style lang="scss">
.c-point-list {
  list-style: none;
}
</style>
