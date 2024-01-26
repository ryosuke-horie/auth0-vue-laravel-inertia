<script lang="ts" setup>
import { MypageAnkerButtonListItemProps } from './type';
import { Link } from '@inertiajs/vue3';

const props = defineProps<MypageAnkerButtonListItemProps>();
</script>

<template>
  <Link class="c-mypage-anker-button-list-item" :href="props.href">
    <i class="c-mypage-anker-button-list-item__icon" :class="props.icon" />
    <p class="c-mypage-anker-button-list-item__text">{{ props.text }}</p>
  </Link>
</template>

<style lang="scss">
.c-mypage-anker-button-list-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 80px;
  border-radius: 10px;
  box-shadow: 0 4px 4px 0 #00000005;
  color: var(--black);
  background-color: var(--white);
  &__icon {
    font-size: 22px;
    color: var(--yellow);
  }
  &__text {
    font-size: 16px;
    margin-top: 8px;
    font-weight: var(--bold);
  }
}
</style>
