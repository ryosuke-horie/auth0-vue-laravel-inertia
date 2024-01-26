<script lang="ts" setup>
import MessageDate from '@/Components/atom/message/MessageDate/MessageDate.vue';
import IconImage from '@/Components/atom/image/IconImage/IconImage.vue';
import { StaffMessageListItemMessageSrcType, StaffMessageListItemProps } from './type';

const props = defineProps<StaffMessageListItemProps>();
</script>

<template>
  <li class="c-staff-message-list-item">
    <MessageDate class="c-staff-message-list-item__date" :date="props.date" />
    <div class="c-staff-message-list-item__wrap">
      <div class="c-staff-message-list-item__message">{{ props.message }}</div>
      <IconImage :src="props.src" :width="40" :height="40" />
    </div>
    <div v-if="props.messageSrc" class="c-staff-message-list-item__media">
      <img v-if="props.messageSrcType === StaffMessageListItemMessageSrcType.Image" :src="props.messageSrc" />
      <video controls v-else-if="props.messageSrcType === StaffMessageListItemMessageSrcType.Video">
        <source :src="props.messageSrc" />
      </video>
    </div>
  </li>
</template>

<style lang="scss">
.c-staff-message-list-item {
  display: flex;
  flex-direction: column;
  &__date {
    margin-bottom: 8px;
    margin-left: auto;
  }
  &__wrap {
    display: grid;
    grid-template-columns: 1fr 40px;
  }
  &__message {
    font-size: 14px;
    margin-right: 16px;
    padding: 16px;
    border-radius: 5px;
    background-color: #ffe4cc;
  }
  &__media {
    margin-top: 16px;
    width: 100%;
    img,
    video {
      width: 100%;
    }
  }
}
</style>
