<script lang="ts" setup>
import { ModalProps, ModalVariantProp } from './type';
import ModalHeader from '@/Components/atom/modal/ModalHeader/ModalHeader.vue';

const props = withDefaults(defineProps<ModalProps>(), {
  variant: ModalVariantProp.Black,
});

const emit = defineEmits(['close']);

const onClick = (): void => {
  emit('close');
};
</script>

<template>
  <div class="c-modal" :class="[props.variant]">
    <ModalHeader :text="props.headerText" @click="onClick" />
    <div class="c-modal__content">
      <slot />
    </div>
  </div>
</template>

<style lang="scss">
.c-modal {
  display: flex;
  flex-direction: column;
  z-index: 2;
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  padding-top: 50px;
  &.black {
    color: var(--white);
    background-color: var(--black);
  }
  &.white {
    color: var(--black);
    background-color: var(--white);
  }
  &__content {
    overflow: hidden;
    overflow-y: scroll;
    height: calc(100vh - 100px);
  }
}
</style>
