<script lang="ts" setup>
import { NotificationProps } from './type';

const props = defineProps<NotificationProps>();
</script>

<template>
  <div class="c-notification">
    <h2 class="c-notification__title">{{ props.title }}</h2>
    <time class="c-notification__date">{{ props.startAt }}</time>
    <figure class="c-notification__image">
      <img v-if="props.src" :src="props.src" />
    </figure>
    <p class="c-notification__content">{{ props.content }}</p>
  </div>
</template>

<style lang="scss">
.c-notification {
  &__title {
    font-size: 18px;
    margin-bottom: 10px;
    padding-bottom: 5px;
    border-bottom: solid 2px #ddd;
  }
  &__date {
    display: block;
    text-align: right;
    width: 100%;
    margin-bottom: 10px;
  }
  &__image {
    width: 100%;
    margin: 0;
    margin-bottom: 10px;
    img {
      width: 100%;
    }
  }
  &__content {
    white-space: break-spaces;
  }
}
</style>
