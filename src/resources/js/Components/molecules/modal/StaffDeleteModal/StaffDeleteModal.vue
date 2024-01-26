<script lang="ts" setup>
import { StaffDeleteModalProps } from './type';
import Paragraph from '@/Components/atom/typograph/Paragraph/Paragraph.vue';

const props = defineProps<StaffDeleteModalProps>();

const emit = defineEmits(['submit', 'close']);

const onClickSubmit = () => {
  emit('submit');
};

const onClickClose = (): void => {
  emit('close');
};
</script>

<template>
  <div class="c-staff-delete-modal">
    <div class="c-staff-delete-modal__overlay" @click="onClickClose" />
    <div class="c-staff-delete-modal__content">
      <Paragraph class="c-staff-delete-modal__content-text">{{ props.name }}<br />を削除しますか？</Paragraph>
      <div class="c-staff-delete-modal__content-button">
        <button class="c-staff-delete-modal__content-button-ok" @click="onClickSubmit">はい</button>
        <button class="c-staff-delete-modal__content-button-cancel" @click="onClickClose">いいえ</button>
      </div>
    </div>
  </div>
</template>

<style lang="scss">
.c-staff-delete-modal {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  &__overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
  }
  &__content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 260px;
    border-radius: 10px;
    box-shadow: 0px 0px 10px 0px #00000050;
    background-color: var(--white);
    &-text {
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      height: 120px;
      border-bottom: 0.2px solid #d9d9d9;
    }
    &-button {
      display: flex;
      width: 100%;
      height: 80px;
      &-ok {
        border-right: 0.2px solid #d9d9d9;
      }
      &-ok,
      &-cancel {
        cursor: pointer;
        display: block;
        width: 100%;
        height: 100%;
        &:hover {
          background-color: #d9d9d9;
        }
      }
    }
  }
}
</style>
