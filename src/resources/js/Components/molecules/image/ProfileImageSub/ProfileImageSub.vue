<script lang="ts" setup>
import type { ProfileImageSubProps } from './type';
import IconImage from '@/Components/atom/image/IconImage/IconImage.vue';
const props = defineProps<ProfileImageSubProps>();

const emit = defineEmits<{
  (e: 'click'): void;
}>();

const onClick = () => {
  emit('click');
};
</script>

<template>
  <div class="c-profile-iamge-sub" @click="onClick">
    <div class="c-profile-image-sub__image">
      <IconImage v-if="props.src" :src="props.src" :alt="props.alt" :width="90" :height="90" />
      <span v-else>+</span>
    </div>
  </div>
</template>

<style lang="scss">
.c-profile-image-sub {
  &__image {
    span {
      cursor: pointer;
      overflow: hidden;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 120px;
      height: 90px;
      border-radius: 5px;
      background-color: var(--white);
      line-height: 1px;
      font-size: 64px;
      color: #cccccc;
      font-weight: var(--bold);
    }
  }
}
</style>
