<script lang="ts" setup>
import { FeatureListProps } from './type';
const props = defineProps<FeatureListProps>();
</script>

<template>
  <ul class="c-feature-list">
    <li v-for="item of props.items" :key="item.title" class="c-feature-list__item">
      <figure>
        <img :src="item.src" alt="" />
      </figure>
      <div class="c-feature-list__content">
        <h3 class="c-feature-list__title">{{ item.title }}</h3>
        <p class="c-feature-list__text">{{ item.text }}</p>
      </div>
    </li>
  </ul>
</template>

<style lang="scss">
.c-feature-list {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 24px;
  &__item {
    figure {
      overflow: hidden;
      width: 120px;
      height: 120px;
      border-radius: 50%;
      margin: 0 auto 16px;
      img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        vertical-align: top;
      }
    }
  }
  &__title {
    font-size: 18px;
    font-weight: var(--bold);
  }
  &__text {
    margin-top: 8px;
    font-size: 16px;
    line-height: 20px;
  }
}
</style>
