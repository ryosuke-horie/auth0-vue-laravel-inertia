<script setup lang="ts">
import type { HeaderSubTextProps } from './type';
const props = defineProps<HeaderSubTextProps>();
</script>

<template>
  <div class="c-header-sub-text">
    <p class="c-header-sub-text__text">{{ props.text }}</p>
    <a class="c-header-sub-text__link" v-if="props.href" :href="props.href">
      <i class="fa-solid fa-chevron-left"></i>
    </a>
  </div>
</template>

<style lang="scss">
.c-header-sub-text {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  height: 50px;
  &__text {
    font-size: 18px;
    font-weight: var(--bold);
  }
  &__link {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    left: 20px;
    color: inherit;
  }
}
</style>
