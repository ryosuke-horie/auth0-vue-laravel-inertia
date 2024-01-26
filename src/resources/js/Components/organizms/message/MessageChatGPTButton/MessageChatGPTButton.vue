<script lang="ts" setup>
import { ref } from 'vue';
import LoadingModal from '@/Components/atom/loading/LoadingModal/LoadingModal.vue';
import Button from '@/Components/atom/button/Button/Button.vue';
import Modal from '@/Components/molecules/modal/Modal/Modal.vue';
import { ButtonVariantProp } from '@/Components/atom/button/Button/type';
import { MessageChatGPTButtonProps } from './type';
import { ALLApi } from '@/api';
import { configuration } from '@/lib/configuration';

const props = defineProps<MessageChatGPTButtonProps>();

const isLoading = ref<boolean>(false);
const isOpen = ref<boolean>(false);

const setIsOpen = (val: boolean) => {
  isOpen.value = val;
};

const onClickShowModal = () => {
  if (props.limit <= 0) return;
  setIsOpen(true);
};

const promptData: { promptId: number; text: string }[] = [
  { promptId: 1, text: '大人びた感じで' },
  { promptId: 2, text: '楽しく盛り上げて' },
  { promptId: 3, text: '礼儀正しく' },
];

const emit = defineEmits<{
  click: [data: { aiCount: number; message: string }];
}>();

const onClick = async (promptId: number): Promise<void> => {
  if (isLoading.value) return;
  isLoading.value = true;
  await new ALLApi(configuration)
    .getAllTipsTipIdPromptsPromptId(props.tipId, promptId)
    .then((res) => {
      emit('click', res.data);
    })
    .catch(() => {
      alert('予期せぬエラーが発生しました。');
    })
    .finally(() => {
      setIsOpen(false);
      isLoading.value = false;
    });
};
</script>

<template>
  <div class="c-message-fix-phrase-button">
    <LoadingModal v-if="isLoading" />
    <Button
      class="c-message-fix-phrase-button__button"
      :variant="ButtonVariantProp.Secondary"
      :disabled="!props.limit"
      :text="`AIで作成する(残り${props.limit}回)`"
      @click="onClickShowModal()"
    />
    <Modal
      v-if="isOpen"
      header-text="どんなメッセージにしますか？"
      class="c-message-fix-phrase-button__modal"
      @close="setIsOpen(false)"
    >
      <ul class="c-message-fix-phrase-button__content">
        <li
          v-for="item of promptData"
          :key="item.promptId"
          class="c-message-fix-phrase-button__item"
          @click="onClick(item.promptId)"
        >
          {{ item.text }}
        </li>
      </ul>
    </Modal>
  </div>
</template>

<style lang="scss">
.c-message-fix-phrase-button {
  &__button {
    width: 100%;
  }
  &__content {
    display: flex;
    flex-direction: column;
    padding: 16px;
    display: grid;
    grid-row-gap: 16px;
    grid-column-gap: 16px;
    list-style: none;
  }
  &__item {
    cursor: pointer;
    white-space: pre-wrap;
    padding: 16px 40px;
    border-radius: 5px;
    font-weight: var(--bold);
    color: var(--black);
    background-color: var(--white);
  }
}
</style>
