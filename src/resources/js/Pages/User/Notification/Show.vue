<script lang="ts" setup>
import AuthLayout from '@/Layouts/AuthLayout/AuthLayout.vue';
import { type AuthLayoutProps } from '@/Layouts/AuthLayout/type';
import { RouteName, RouteRoleName } from '@/Utilities';

const authLayoutProps: AuthLayoutProps = {
  isAuthRoute: true,
  title: 'チアポイント',
  header: {
    role: RouteRoleName.Staff,
    text: 'チアポイント',
    href: RouteName.UserMypage,
  },
};
</script>

<template>
  <AuthLayout v-bind="authLayoutProps">
    <div class="p-notification-show">aaa</div>
  </AuthLayout>
</template>

<style lang="scss">
.p-notification-show {
}
</style>
