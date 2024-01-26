<script lang="ts" setup>
import AuthLayout from '@/Layouts/AuthLayout/AuthLayout.vue';
import { type AuthLayoutProps } from '@/Layouts/AuthLayout/type';
import { RouteName, RouteRoleName } from '@/Utilities';
import NotificationListItem from '@/Components/molecules/list/NotificationListItem/NotificationListItem.vue';
import AnkerButton from '@/Components/atom/button/AnkerButton/AnkerButton.vue';
import { ButtonVariantProp } from '@/Components/atom/button/Button/type';
import Divider from '@/Components/atom/divider/Divider.vue';

const authLayoutProps: AuthLayoutProps = {
  isAuthRoute: true,
  title: 'お知らせ',
  header: {
    role: RouteRoleName.User,
    text: 'お知らせ',
    href: RouteName.UserMypage,
  },
};

const props = defineProps<{
  notifications: {
    title: string;
    startAt: string;
    isRead: boolean;
  }[];
}>();
</script>

<template>
  <AuthLayout v-bind="authLayoutProps">
    <div class="p-notification-index-index">
      <Heading2 text="運営からのお知らせ" />
      <Divider />
      <ul class="p-notification-index__notification-content">
        <NotificationListItem
          class="p-notification-index__notification-item"
          v-for="(item, index) of props.notifications"
          :key="item.title + index"
          :is-read="item.isRead"
          :title="item.title"
          :start-at="item.startAt"
          :url="route(RouteName.UserNotificationShow, { id: 1, type: 2 })"
        />
      </ul>
      <div class="p-notification-index__notification-button">
        <AnkerButton :variant="ButtonVariantProp.Derk" :href="route(RouteName.UserNotification)" text="お知らせ一覧" />
      </div>
    </div>
  </AuthLayout>
</template>

<style lang="scss">
.p-notification-index-index {
}
</style>
