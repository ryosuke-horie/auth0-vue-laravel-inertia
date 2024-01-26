<script lang="ts" setup>
import IconNameListItem from '@/Components/molecules/list/IconNameListItem/IconNameListItem.vue';
import { IconNameListProps } from './type';

const props = defineProps<IconNameListProps>();
</script>

<template>
  <div class="c-icon-name-list">
    <IconNameListItem v-for="(item, index) of props.list" :key="item.name + index" :src="item.src" :name="item.name" />
  </div>
</template>

<style lang="scss">
.c-icon-name-list {
  display: grid;
  grid-row-gap: 10px;
}
</style>
