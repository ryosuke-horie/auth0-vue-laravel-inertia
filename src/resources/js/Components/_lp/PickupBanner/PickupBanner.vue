<script lang="ts" setup>
import { PickupBannerProps } from './type';
const props = defineProps<PickupBannerProps>();
</script>

<template>
  <div class="c-pickup-banner" :class="props.variant">
    <div class="c-pickup-banner__title">
      {{ props.titleBefore }}
      <span>{{ props.titleCount }}</span>
      {{ props.titleAfter }}
    </div>
    <div class="c-pickup-banner__button">{{ props.buttonText }}</div>
  </div>
</template>

<style lang="scss">
.c-pickup-banner {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  background-color: #ff7733;
  padding: 20px;
  border-radius: 5px;
  margin-bottom: 16px;
  &.green {
    background-color: #66ccbb;
    .c-pickup-banner__button {
      color: #449988;
    }
  }
  &__title {
    font-size: 16px;
    margin-bottom: 16px;
    color: var(--white);
    @media screen and (min-width: 1025px) {
      font-size: 18px;
    }
    span {
      font-size: 24px;
      font-weight: var(--bold);
      @media screen and (min-width: 1025px) {
        font-size: 30px;
      }
    }
  }
  &__button {
    text-align: center;
    border-radius: 50px;
    padding: 12px 24px;
    color: #aa3300;
    font-weight: var(--bold);
    background-color: var(--white);
    @media screen and (min-width: 1025px) {
      display: block;
      padding: 12px 64px;
    }
  }
}
</style>
