<script lang="ts" setup>
import Button from '@/Components/atom/button/Button/Button.vue';
import UserMessageListItem from '@/Components/molecules/list/MessageListItem/UserMessageListItem/UserMessageListItem.vue';
import StaffMessageListItem from '@/Components/molecules/list/MessageListItem/StaffMessageListItem/StaffMessageListItem.vue';

type Props = {
  userTip: {
    points: number;
    createdAt: string;
    image?: string;
    message: string;
  };
  staffTipReply: {
    createdAt: string;
    image?: string;
    message: string;
    messageSrc?: string;
    messageSrcType?: 'image' | 'video';
  } | null;
};

const props = defineProps<Props>();

const emit = defineEmits(['deleteReply']);

const onDelete = () => {
  emit('deleteReply');
};
</script>

<template>
  <ul class="p-cheer-history-chat">
    <UserMessageListItem
      :point="props.userTip.points"
      :date="props.userTip.createdAt"
      :src="props.userTip.image || 'https://www.mamiya-its.co.jp/public/images/4_service/webservice.jpg'"
      :message="props.userTip.message"
    />
    <template v-if="props.staffTipReply">
      <StaffMessageListItem
        class="p-cheer-history-chat__staff"
        :date="props.staffTipReply.createdAt"
        :src="props.staffTipReply.image || 'https://www.mamiya-its.co.jp/public/images/4_service/webservice.jpg'"
        :message="props.staffTipReply.message"
        :message-src="props.staffTipReply.messageSrc"
        :message-src-type="props.staffTipReply.messageSrcType"
      />
      <Button @click="onDelete" text="メッセージ削除" />
    </template>
  </ul>
</template>

<style lang="scss">
.p-cheer-history-chat {
  padding: 24px 16px;
  &__staff {
    margin-top: 16px;
  }
}
</style>
