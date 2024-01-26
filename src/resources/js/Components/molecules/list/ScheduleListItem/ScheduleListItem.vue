<script lang="ts" setup>
import type { ScheduleListItemProps } from './type';

const props = defineProps<ScheduleListItemProps>();

const emit = defineEmits(['update:modelValue']);

const onClick = (value: string | number): void => {
  emit('update:modelValue', value);
};

const buttons = [
  { id: 'work', value: 3, icon: 'fa-regular fa-circle', text: '出勤' },
  { id: 'holiday', value: 2, icon: 'fa-solid fa-xmark', text: '休日' },
  { id: 'notYet', value: 1, icon: 'fa-solid fa-question', text: '未定' },
];
</script>

<template>
  <li class="c-schedule-list-item">
    <div class="c-schedule-list-item__date">{{ props.date }}（{{ props.dayOfWeek }}）</div>
    <div class="c-schedule-list-item__buttons">
      <button
        v-for="(item, index) of buttons"
        :key="index"
        class="c-schedule-list-item__button"
        :class="[`c-schedule-list-item__button--${item.id}`, { 'is-active': item.value === props.modelValue }]"
        type="button"
        @click="onClick(item.value)"
      >
        <i class="c-schedule-list-item__button-icon" :class="item.icon"></i>
        <span class="c-schedule-list-item__button-text">{{ item.text }}</span>
      </button>
    </div>
  </li>
</template>

<style lang="scss">
.c-schedule-list-item {
  display: flex;
  align-items: center;
  padding: 16px;
  border-bottom: solid 1px #ddd;
  &__date {
    font-weight: var(--bold);
  }
  &__buttons {
    display: flex;
    margin-left: auto;
  }
  &__button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    width: 60px;
    height: 60px;
    border-radius: 10px;
    color: #cccccc;
    background-color: #eeeeee;
    font-weight: var(--bold);
    & + .c-schedule-list-item__button {
      margin-left: 16px;
    }
    &-icon {
      font-size: 26px;
    }
    &-text {
      font-size: 14px;
      margin-top: 4px;
    }
    &--work {
      &.is-active {
        color: #1d9bf0;
      }
    }
    &--holiday {
      &.is-active {
        color: #ff0000;
      }
    }
    &--notYet {
      &.is-active {
        color: #f0850e;
      }
    }
  }
}
</style>
