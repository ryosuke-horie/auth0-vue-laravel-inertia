<script lang="ts" setup>
import { SlideRecommendShopProps } from './type';
import { Swiper, SwiperSlide } from 'swiper/vue';
const props = defineProps<SlideRecommendShopProps>();
</script>

<template>
  <div class="c-slide-recommend-shop">
    <Swiper :id="props.id" class="c-slide-recommend-shop__content" :slides-per-view="2.5" :space-between="8">
      <SwiperSlide class="c-slide-recommend-shop__item" v-for="item of props.items" :key="item.text">
        <figure>
          <img :src="item.src" alt="" />
        </figure>
        <div class="c-slide-recommend-shop__content">
          <p class="c-slide-recommend-shop__name">{{ item.name }}</p>
          <p class="c-slide-recommend-shop__text">{{ item.text }}</p>
        </div>
      </SwiperSlide>
    </Swiper>
  </div>
</template>

<style lang="scss">
.c-slide-recommend-shop {
  position: relative;
  max-width: 600px;
  width: 100%;
  figure {
    margin-bottom: 8px;
    height: 150px;
    @media screen and (min-width: 1025px) {
      height: 200px;
    }
    img {
      height: 100%;
      object-fit: cover;
      vertical-align: top;
    }
  }
  &__content {
  }
  &__name {
    font-size: 18px;
    font-weight: var(--bold);
  }
  &__text {
    font-size: 14px;
  }
}
</style>
