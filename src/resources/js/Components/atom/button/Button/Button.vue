<script setup lang="ts">
import { computed } from 'vue';
import { ButtonVariantProp, type ButtonProps } from './type';

const props = withDefaults(defineProps<ButtonProps>(), {
  variant: ButtonVariantProp.Primary,
  type: 'button',
  isOutlined: false,
  isLoading: false,
  loadingText: 'Loading...',
  disabled: false,
});

const computedClasses = computed<string[]>(() => {
  const classes: string[] = [];

  classes.push(props.variant);

  if (props.isOutlined) {
    classes.push('is-outlined');
  }

  return classes;
});

const emit = defineEmits<{
  (e: 'click'): void;
}>();

const onClick = () => {
  emit('click');
};
</script>

<template>
  <button class="c-button" :class="computedClasses" :disabled="props.disabled" @click="onClick">
    <template v-if="isLoading">
      <span class="c-button__loading-spin" />
      <span>{{ props.loadingText }}</span>
    </template>
    <template v-else>
      <span v-if="props.icon" class="c-button__icon">
        <i :class="props.icon"></i>
      </span>
      {{ props.text }}
    </template>
  </button>
</template>

<style lang="scss" scoped>
.c-button {
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  box-sizing: border-box;
  height: 50px;
  border-radius: 4px;
  border: none;
  border: solid 1px;
  min-width: 120px;
  padding: 0 16px;
  font-weight: bold;
  &__icon {
    display: inline-block;
    margin-right: 8px;
  }
  &__loading {
    &-spin {
      position: relative;
      margin-right: 16px;
      &::before {
        content: '';
        cursor: default;
        position: absolute;
        width: 15px;
        height: 15px;
        border-radius: 50%;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-top-color: #fff;
        animation: spin 1s linear infinite;
      }
    }
  }
  &.primary {
    color: var(--white);
    background-color: var(--anker);
    border-color: var(--anker);
    &.is-outlined {
      background-color: var(--white);
      border-color: var(--anker);
      color: var(--anker);
    }
  }
  &.secondary {
    color: var(--white);
    background-color: var(--gray);
    border-color: var(--gray);
    &.is-outlined {
      color: var(--gray);
      background-color: var(--white);
      border-color: var(--gray);
    }
  }
  &.derk {
    color: var(--white);
    background-color: var(--black);
    border-color: var(--black);
    &.is-outlined {
      color: var(--black);
      background-color: var(--white);
      border-color: var(--black);
    }
  }
  &.success {
    color: var(--white);
    background-color: var(--green);
    border-color: var(--green);
    &.is-outlined {
      color: var(--green);
      background-color: var(--white);
      border-color: var(--green);
    }
  }
  &.danger {
    color: var(--white);
    background-color: var(--red);
    border-color: var(--red);
    &.is-outlined {
      color: var(--red);
      background-color: var(--white);
      border-color: var(--red);
    }
  }
  &.warning {
    color: var(--white);
    background-color: var(--yellow);
    border-color: var(--yellow);
    &.is-outlined {
      color: var(--yellow);
      background-color: var(--white);
      border-color: var(--yellow);
    }
  }
  &.info {
    color: var(--white);
    background-color: var(--light-blue);
    border-color: var(--light-blue);
    &.is-outlined {
      color: var(--light-blue);
      background-color: var(--white);
      border-color: var(--light-blue);
    }
  }
  &.light {
    color: var(--white);
    background-color: var(--light-gray);
    border-color: var(--light-gray);
    &.is-outlined {
      color: var(--light-gray);
      background-color: var(--white);
      border-color: var(--light-gray);
    }
  }
  &:disabled {
    color: white;
    background-color: #aaa;
    border-color: #aaa;
    &.is-outlined {
      color: #aaa;
      background-color: white;
      border-color: #aaa;
    }
  }
  @keyframes spin {
    0% {
      transform: translate(-50%, -50%) rotate(0deg);
    }
    100% {
      transform: translate(-50%, -50%) rotate(360deg);
    }
  }
}
</style>
