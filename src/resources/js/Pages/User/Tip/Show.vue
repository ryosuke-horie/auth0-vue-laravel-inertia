<script lang="ts" setup>
import AuthLayout from '@/Layouts/AuthLayout/AuthLayout.vue';
import { type AuthLayoutProps } from '@/Layouts/AuthLayout/type';
import { RouteName, RouteRoleName } from '@/Utilities';
import UserMessageListItem from '@/Components/molecules/list/MessageListItem/UserMessageListItem/UserMessageListItem.vue';
import StaffMessageListItem from '@/Components/molecules/list/MessageListItem/StaffMessageListItem/StaffMessageListItem.vue';

const props = defineProps<{
  staffName: string;
  userTip: {
    tipId: number;
    image?: string | null;
    userName: string;
    points: number;
    message: string;
    createdAt: string;
    isRead: boolean;
    isResponse: boolean;
  };
  staffTipReply: {
    replyId: number;
    image?: string | null;
    staffName: string;
    createdAt: string;
    message: string;
    messageSrc: string | null;
    messageSrcType?: 'image' | 'video';
  };
}>();

const authLayoutProps: AuthLayoutProps = {
  isAuthRoute: true,
  title: 'ユーザー名',
  header: {
    role: RouteRoleName.User,
    text: props.staffName + 'さん',
    href: RouteName.UserTips,
  },
};
</script>

<template>
  <AuthLayout v-bind="authLayoutProps">
    <div class="p-cheer-history-detail">
      <UserMessageListItem
        :point="props.userTip.points"
        :date="props.userTip.createdAt"
        :src="props.userTip.image || 'https://www.mamiya-its.co.jp/public/images/4_service/webservice.jpg'"
        :message="props.userTip.message"
      />
      <template v-if="props.staffTipReply">
        <StaffMessageListItem
          class="p-cheer-history-detail__staff"
          :date="props.staffTipReply.createdAt"
          :src="props.staffTipReply.image || 'https://www.mamiya-its.co.jp/public/images/4_service/webservice.jpg'"
          :message="props.staffTipReply.message"
          :message-src="
            props.staffTipReply.messageSrc || 'https://www.mamiya-its.co.jp/public/images/4_service/webservice.jpg'
          "
          :message-src-type="props.staffTipReply.messageSrcType"
        />
      </template>
    </div>
  </AuthLayout>
</template>

<style lang="scss">
.p-cheer-history-detail {
  padding: 24px 16px;
  &__staff {
    margin-top: 16px;
  }
}
</style>
