<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import type { NotificationListItemProps } from './type';

const props = defineProps<NotificationListItemProps>();
</script>

<template>
  <Link class="c-notification-list-item" :href="props.url">
    <p class="c-notification-list-item__read" :class="{ active: !props.isRead }">●</p>
    <div class="c-notification-list-item__container">
      <p class="c-notification-list-item__title">{{ props.title }}</p>
      <p class="c-notification-list-item__date">{{ props.startAt }}</p>
    </div>
    <p class="c-notification-list-item__arrow">＞</p>
  </Link>
</template>

<style lang="scss">
.c-notification-list-item {
  display: flex;
  font-size: 14px;
  line-height: 18px;
  align-items: center;
  text-decoration: none;
  color: inherit;
  padding: 10px 16px;
  border-bottom: solid 1px #dddddd;
  &__read {
    font-size: 25px;
    padding-right: 20px;
    color: #ff0000;
    visibility: hidden;
  }
  &__read.active {
    visibility: visible;
  }

  &__container {
    width: 100%;
    font-size: 14px;
    font-weight: 700;
    line-height: 18px;
  }

  &__arrow {
    padding-left: 30px;
    font-size: 18px;
    font-weight: 700;
    line-height: 24px;
    color: #666666;
  }
}
</style>
