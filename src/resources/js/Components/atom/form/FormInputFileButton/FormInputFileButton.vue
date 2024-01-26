<script lang="ts" setup>
import { type FormInputFileButtonProps } from './type';

const props = defineProps<FormInputFileButtonProps>();
</script>

<template>
  <label :for="props.id" class="c-form-input-file-button">
    <span v-if="props.icon" class="c-form-input-file-button__icon">
      <i :class="props.icon"></i>
    </span>
    {{ props.text }}
    <input :id="props.id" type="file" :accept="props.accept" ref="preview" />
  </label>
</template>

<style lang="scss">
.c-form-input-file-button {
  cursor: pointer;
  display: flex;
  justify-content: center;
  align-items: center;
  box-sizing: border-box;
  height: 50px;
  border-radius: 4px;
  border: none;
  border: solid 1px;
  min-width: 120px;
  font-weight: bold;
  > input {
    display: none;
  }
  &__icon {
    display: inline-block;
    margin-right: 12px;
    font-size: 26px;
  }
}
</style>
