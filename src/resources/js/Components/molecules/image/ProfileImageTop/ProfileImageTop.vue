<script lang="ts" setup>
import type { ProfileImageTopProps } from './type';
import IconImage from '@/Components/atom/image/IconImage/IconImage.vue';
const props = defineProps<ProfileImageTopProps>();

const emit = defineEmits<{
  (e: 'click'): void;
}>();

const onClick = () => {
  emit('click');
};
</script>

<template>
  <div class="c-profile-iamge-top">
    <div class="c-profile-image-top__container">
      <div class="c-profile-image-top__image" @click="onClick">
        <IconImage v-if="props.src" :src="props.src" :alt="props.alt" :width="180" :height="180" />
        <span v-else>+</span>
        <div class="c-profile-image-top__icon">
          <i class="fa-solid fa-camera"></i>
        </div>
      </div>
    </div>
  </div>
</template>

<style lang="scss">
.c-profile-image-top {
  &__container {
    display: flex;
  }
  &__image {
    position: relative;
    margin: 0 auto 10px;
    span {
      cursor: pointer;
      width: 180px;
      height: 180px;
      display: flex;
      align-items: center;
      justify-content: center;
      width: 180px;
      height: 180px;
      border-radius: 50%;
      line-height: 1px;
      font-size: 64px;
      color: #cccccc;
      font-weight: var(--bold);
      background-color: var(--white);
    }
  }
  &__icon {
    cursor: pointer;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    position: absolute;
    right: 0;
    bottom: -10px;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    font-size: 30px;
    color: var(--white);
    background-color: var(--black);
    z-index: 1;
  }
}
</style>
