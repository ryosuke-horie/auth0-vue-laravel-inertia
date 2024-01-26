<script lang="ts" setup>
import MessageDate from '@/Components/atom/message/MessageDate/MessageDate.vue';
import IconImage from '@/Components/atom/image/IconImage/IconImage.vue';
import { UserMessageListItemProps } from './type';

const props = defineProps<UserMessageListItemProps>();
</script>

<template>
  <li class="c-user-message-list-item">
    <MessageDate class="c-user-message-list-item__date" :date="props.date" />
    <div class="c-user-message-list-item__wrap">
      <IconImage :src="props.src" :width="40" :height="40" />
      <div class="c-user-message-list-item__message">
        <div class="c-user-message-list-item__message-point">
          <span>{{ `${props.point.toLocaleString()}CP` }}</span>
          を贈りました。
        </div>
        <div class="c-user-message-list-item__message-text">
          {{ props.message }}
        </div>
      </div>
    </div>
  </li>
</template>

<style lang="scss">
.c-user-message-list-item {
  &__date {
    margin-bottom: 8px;
  }
  &__wrap {
    display: grid;
    grid-template-columns: 40px 1fr;
  }
  &__message {
    margin-left: 16px;
    padding: 16px;
    border-radius: 5px;
    font-size: 14px;
    background-color: #eeeeee;
    &-point {
      margin-bottom: 8px;
      font-weight: var(--bold);
      span {
        color: #ff5693;
      }
    }
    &-text {
    }
  }
}
</style>
