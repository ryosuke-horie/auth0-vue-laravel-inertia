<script lang="ts" setup>
import NotificationListItem from '@/Components/molecules/list/NotificationListItem/NotificationListItem.vue';
import type { NotificationListProps } from './type';

const props = defineProps<NotificationListProps>();
</script>

<template>
  <div class="c-notification-list">
    <NotificationListItem
      v-for="(item, index) in props.list"
      :key="index"
      :is-read="item.isRead"
      :title="item.title"
      :start-at="item.startAt"
      :url="item.url"
      class="c-notification-list__item"
    />
  </div>
</template>

<style lang="scss">
.c-notification-list {
  &__item {
    border-bottom: 1px solid #dddddd;
    padding-top: 10px;
    padding-bottom: 10px;
  }
}
</style>
