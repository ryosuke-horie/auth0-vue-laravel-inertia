<script lang="ts" setup>
import { SlideProps } from './type';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Navigation, Pagination } from 'swiper/modules';
import Heading3 from '@/Components/_lp/Heading3/Heading3.vue';
const props = defineProps<SlideProps>();

const swiperNavigation = {
  prevEl: `.${props.id}-prev`,
  nextEl: `.${props.id}-next`,
};
</script>

<template>
  <div class="c-slide">
    <Heading3 class="c-slide__title" variant="green">{{ props.title }}</Heading3>
    <Swiper
      :id="props.id"
      class="c-slide__content"
      :modules="[Navigation, Pagination]"
      pagination
      :loop="true"
      :navigation="swiperNavigation"
      :slides-per-view="1"
      :space-between="60"
    >
      <SwiperSlide class="c-slide__item" v-for="item of props.items" :key="item.text">
        <figure>
          <img :src="item.src" alt="" />
        </figure>
        <div class="c-slide__text">
          <p>{{ item.text }}</p>
        </div>
      </SwiperSlide>
    </Swiper>
    <span class="swiper-button swiper-button-prev" :class="`${props.id}-prev`"></span>
    <span class="swiper-button swiper-button-next" :class="`${props.id}-next`"></span>
  </div>
</template>

<style lang="scss">
.c-slide {
  position: relative;
  max-width: 600px;
  width: 100%;
  color: var(--white);
  background-color: var(--black);
  padding: 24px 40px 32px;
  @media screen and (min-width: 1025px) {
    padding: 24px 66px 32px;
  }
  &__title {
    margin-bottom: 16px;
  }
  &__text {
    margin-top: 16px;
  }
  .swiper-button {
    cursor: pointer;
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 30px;
    height: 30px;
    &:before {
      position: absolute;
      content: '';
      width: 15px;
      height: 15px;
      border-left: solid 3px;
      border-bottom: solid 3px;
    }
    &-prev {
      left: 15px;
      &:before {
        left: 0px;
        transform: rotate(45deg);
        @media screen and (min-width: 1025px) {
          left: 7.5px;
        }
      }
    }
    &-next {
      right: 15px;
      &:before {
        right: 0;
        transform: rotate(-135deg);
        @media screen and (min-width: 1025px) {
          left: 7.5px;
        }
      }
    }
  }
}
</style>
