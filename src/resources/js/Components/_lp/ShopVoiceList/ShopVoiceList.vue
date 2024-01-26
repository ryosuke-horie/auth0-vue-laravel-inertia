<script lang="ts" setup>
import { ShopVoiceListProps } from './type';
const props = defineProps<ShopVoiceListProps>();
</script>

<template>
  <ul class="c-shop-voice-list">
    <li v-for="item of props.items" :key="item.name" class="c-shop-voice-list__item">
      <figure>
        <img :src="item.src" alt="" />
      </figure>
      <p class="c-shop-voice-list__name">{{ item.name }}</p>
      <p class="c-shop-voice-list__title">お客様の声</p>
      <p class="c-shop-voice-list__text">{{ item.text }}</p>
    </li>
  </ul>
</template>

<style lang="scss">
.c-shop-voice-list {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 24px;
  &__item {
    figure {
      overflow: hidden;
      max-width: 100%;
      margin: 0 auto 8px;
      img {
        width: 100%;
        height: 100%;
        border-radius: 5px;
        object-fit: cover;
        vertical-align: top;
      }
    }
  }
  &__name {
    font-size: 18px;
    font-weight: var(--bold);
  }
  &__title {
    margin-top: 8px;
    font-size: 14px;
    font-weight: var(--bold);
  }
  &__text {
    margin-top: 8px;
    font-size: 16px;
    line-height: 20px;
  }
}
</style>
