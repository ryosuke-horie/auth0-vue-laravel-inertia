<script lang="ts" setup>
import MypageAnkerButtonListItem from '@/Components/molecules/list/MypageAnkerButtonListItem/MypageAnkerButtonListItem.vue';
import type { MypageAnkerButtonListProps } from './type';

const props = defineProps<MypageAnkerButtonListProps>();
</script>

<template>
  <div class="c-mypage-anker-button-list">
    <MypageAnkerButtonListItem
      v-for="(item, index) in props.list"
      :key="index"
      :icon="item.icon"
      :text="item.text"
      :href="item.href"
      class="c-mypage-anker-button-list__item"
    />
  </div>
</template>

<style lang="scss">
.c-mypage-anker-button-list {
  display: grid;
  grid-template-columns: 1fr 1fr;
  grid-template-rows: auto;
  gap: 16px;
}
</style>
