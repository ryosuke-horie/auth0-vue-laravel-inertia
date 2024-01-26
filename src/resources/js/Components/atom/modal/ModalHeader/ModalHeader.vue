<script lang="ts" setup>
import { ModalHeaderProps } from './type';

const props = defineProps<ModalHeaderProps>();

const emit = defineEmits<{ (e: 'click'): void }>();

const onClick = () => {
  emit('click');
};
</script>

<template>
  <div class="c-modal-header">
    <div class="c-modal-header__container">
      <span class="c-modal-header__text">{{ props.text }}</span>
      <button class="c-modal-header__close" @click="onClick">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>
  </div>
</template>

<style lang="scss">
.c-modal-header {
  &__container {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 50px;
  }
  &__text {
    color: inherit;
    font-size: 14px;
    font-weight: var(--bold);
  }
  &__close {
    cursor: pointer;
    color: inherit;
    position: absolute;
    top: 50%;
    right: 16px;
    transform: translateY(-50%);
  }
}
</style>
