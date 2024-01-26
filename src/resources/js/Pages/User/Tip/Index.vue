<script lang="ts" setup>
import AuthLayout from '@/Layouts/AuthLayout/AuthLayout.vue';
import { type AuthLayoutProps } from '@/Layouts/AuthLayout/type';
import { RouteName, RouteRoleName } from '@/Utilities';
import Divider from '@/Components/atom/divider/Divider.vue';
import TipListItem from '@/Components/molecules/list/TipListItem/TipListItem.vue';
import { computed } from 'vue';

const authLayoutProps: AuthLayoutProps = {
  isAuthRoute: true,
  title: '応援履歴一覧',
  header: {
    role: RouteRoleName.User,
    text: '応援履歴',
    href: RouteName.UserMypage,
  },
};

const props = defineProps<{
  userTips: {
    tipId: number;
    image?: string | null;
    staffName: string;
    points: number;
    createdAt: string;
    isRead: boolean;
  }[];
}>();

const hasUnRead = computed(() => {
  return props.userTips.some((tip) => !tip.isRead);
});
</script>

<template>
  <AuthLayout v-bind="authLayoutProps">
    <div class="p-point-history">
      <div v-if="hasUnRead" class="p-point-history__unread">未読メッセージがあります</div>
      <Divider />
      <ul>
        <TipListItem
          v-for="(item, index) of props.userTips"
          type="user"
          :key="item.staffName + index"
          :href="route(RouteName.UserTipsShow, { tipId: item.tipId })"
          :src="item.image || ''"
          :point="item.points"
          :name="item.staffName"
          :date="item.createdAt"
          :is-read="item.isRead"
        />
      </ul>
      <Divider />
    </div>
  </AuthLayout>
</template>

<style lang="scss">
.p-point-history {
  &__unread {
    padding: 8px 16px;
    font-size: 16px;
    font-weight: var(--bold);
  }
}
</style>
