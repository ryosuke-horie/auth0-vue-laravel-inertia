<script lang="ts" setup>
import { ref } from 'vue';
import Button from '@/Components/atom/button/Button/Button.vue';
import Modal from '@/Components/molecules/modal/Modal/Modal.vue';
import { ButtonVariantProp } from '@/Components/atom/button/Button/type';

const isOpen = ref<boolean>(false);

const onClickIsIsOpen = () => {
  isOpen.value = !isOpen.value;
};

const fixPhraseData: string[] = [
  '楽しかったです。\nまた遊びに行きます',
  'がんばってください。\n応援しています！',
  '定型文定型文定型文定型文定型文定型文定型文',
];

const emit = defineEmits<{
  click: [message: string];
}>();

const onClick = (index: number): void => {
  const message = fixPhraseData[index];
  emit('click', message);
  onClickIsIsOpen();
};
</script>

<template>
  <div class="c-message-fix-phrase-button">
    <Button
      class="c-message-fix-phrase-button__button"
      :variant="ButtonVariantProp.Secondary"
      text="定型文から選ぶ"
      @click="onClickIsIsOpen"
    />
    <Modal v-if="isOpen" header-text="定型文を選ぶ" class="c-message-fix-phrase-button__modal" @close="onClickIsIsOpen">
      <ul class="c-message-fix-phrase-button__content">
        <li
          v-for="(item, index) of fixPhraseData"
          :key="item"
          class="c-message-fix-phrase-button__item"
          @click="onClick(index)"
        >
          {{ item }}
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
