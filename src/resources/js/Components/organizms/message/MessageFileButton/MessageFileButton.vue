<script lang="ts" setup>
import FormInputFileButton from '@/Components/atom/form/FormInputFileButton/FormInputFileButton.vue';
import { MessageFileButtonProps } from './type';

const props = defineProps<MessageFileButtonProps>();

const emit = defineEmits<{
  changeImage: [e: Event];
  changeVideo: [e: Event];
  clickReset: [];
}>();

const onClickReset = (): void => {
  emit('clickReset');
};

const onChangeImage = (e: Event): void => {
  emit('changeImage', e);
};

const onChangeVideo = (e: Event): void => {
  emit('changeVideo', e);
};
</script>

<template>
  <div class="c-message-file-button">
    <div class="c-message-file-button__buttons">
      <FormInputFileButton
        id="image"
        text="写真"
        accept="image/png, image/jpeg"
        icon="fa-solid fa-image"
        @change="onChangeImage"
        @click="(e) => (e.target.value = '')"
      />
      <FormInputFileButton
        id="video"
        text="動画"
        accept="video/mp4"
        icon="fa-solid fa-film"
        @change="onChangeVideo"
        @click="(e) => (e.target.value = '')"
      />
    </div>
    <template v-if="props.previewSrc">
      <video controls v-if="props.previewType === 'video'" class="c-message-file-button__preview">
        <source :src="props.previewSrc" />
      </video>
      <img v-else-if="props.previewType === 'image'" :src="props.previewSrc" class="c-message-file-button__preview" />
      <div class="c-message-file-button__reset" @click="onClickReset">ファイル削除</div>
    </template>
  </div>
</template>

<style lang="scss">
.c-message-file-button {
  &__buttons {
    display: flex;
    > :first-of-type {
      margin-right: 16px;
    }
    > * {
      flex: 1;
      width: 100%;
    }
  }
  &__preview {
    width: 100%;
    margin-top: 16px;
  }
  &__reset {
    cursor: pointer;
    width: 100%;
    margin-top: 16px;
    font-size: 20px;
  }
}
</style>
