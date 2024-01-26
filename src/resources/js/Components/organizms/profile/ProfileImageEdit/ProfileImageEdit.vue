<script lang="ts" setup>
import { ref } from 'vue';
import LoadingModal from '@/Components/atom/loading/LoadingModal/LoadingModal.vue';
import ProfileImageTop from '@/Components/molecules/image/ProfileImageTop/ProfileImageTop.vue';
import ProfileImageSub from '@/Components/molecules/image/ProfileImageSub/ProfileImageSub.vue';
import ColorSection from '@/Components/atom/section/ColorSection/ColorSection.vue';
import { ProfileImageEditProps, ProfileImageEditImageProp } from './type';
import Button from '@/Components/atom/button/Button/Button.vue';
import FormInputFileButton from '@/Components/atom/form/FormInputFileButton/FormInputFileButton.vue';
import { ButtonVariantProp } from '@/Components/atom/button/Button/type';
import Modal from '@/Components/molecules/modal/Modal/Modal.vue';
import { OrderEnum } from '@/api';

const props = defineProps<ProfileImageEditProps>();

const selectedOrder = ref<OrderEnum | null>(null);

const onClickSelectOrder = (order: OrderEnum | null): void => {
  selectedOrder.value = order;
};

const emit = defineEmits<{
  updateFile: [order: OrderEnum | null, file: Event];
  deleteFile: [order: OrderEnum];
}>();

const onClickUpdateFile = (order: OrderEnum | null, file: Event): void => {
  emit('updateFile', order, file);
  selectedOrder.value = null;
};

const onClickDeleteFile = (order: OrderEnum): void => {
  emit('deleteFile', order);
  selectedOrder.value = null;
};

const getImage = (order: number): ProfileImageEditImageProp | undefined => {
  return props.images.find((image) => image.order === order);
};
</script>

<template>
  <LoadingModal v-if="false" />
  <div class="p-profile-image-edit">
    <ColorSection class="p-profile-image-edit__images">
      <ProfileImageTop :src="getImage(1)?.src" :alt="getImage(1)?.alt" @click="onClickSelectOrder(1)" />
      <div class="p-profile-image-edit__images-wrap">
        <ProfileImageSub :src="getImage(2)?.src" :alt="getImage(2)?.alt" @click="onClickSelectOrder(2)" />
        <ProfileImageSub :src="getImage(3)?.src" :alt="getImage(3)?.alt" @click="onClickSelectOrder(3)" />
      </div>
    </ColorSection>
    <Modal
      v-if="selectedOrder"
      header-text="プロフィール画像編集"
      class="p-profile-image-edit__modal"
      @close="onClickSelectOrder(null)"
    >
      <img
        v-if="getImage(selectedOrder)"
        class="p-profile-image-edit__modal-image"
        :src="getImage(selectedOrder)?.src"
        alt=""
      />
      <div class="p-profile-image-edit__modal-buttons">
        <FormInputFileButton
          :id="`file-${selectedOrder}`"
          text="写真・画像を選択"
          accept="image/png, image/jpeg"
          @change="onClickUpdateFile(selectedOrder, $event)"
        />
        <Button
          :variant="ButtonVariantProp.Secondary"
          :is-outlined="true"
          text="キャンセル"
          @click="onClickSelectOrder(null)"
        />
        <Button
          v-if="selectedOrder !== 1 && getImage(selectedOrder)"
          :variant="ButtonVariantProp.Secondary"
          :is-outlined="true"
          text="画像を削除"
          @click="onClickDeleteFile(selectedOrder)"
        />
      </div>
    </Modal>
  </div>
</template>

<style lang="scss">
.p-profile-image-edit {
  &__images {
    &-wrap {
      display: flex;
      justify-content: center;
      margin-top: 30px;
      > :first-of-type {
        margin-right: 20px;
      }
    }
  }
  &__modal {
    &-image {
      width: 100%;
      height: 280px;
      object-fit: cover;
    }
    &-buttons {
      display: grid;
      grid-row-gap: 16px;
      padding: 24px 16px;
    }
  }
}
</style>
