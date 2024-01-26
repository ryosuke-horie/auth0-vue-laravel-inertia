<script setup lang="ts">
import { computed } from 'vue';
import { AnkerButtonVariantProp, type AnkerButtonProps } from './type';
import { Link } from '@inertiajs/vue3';

const props = withDefaults(defineProps<AnkerButtonProps>(), {
  variant: AnkerButtonVariantProp.Primary,
  isOutlined: false,
});

const computedClasses = computed<string[]>(() => {
  const classes: string[] = [];

  classes.push(props.variant);

  if (props.isOutlined) {
    classes.push('is-outlined');
  }

  return classes;
});
</script>

<template>
  <Link class="c-anker-button" :href="props.href" :class="computedClasses" :method="props.method">
    <span v-if="props.icon" class="c-button__icon">
      <i :class="props.icon"></i>
    </span>
    {{ props.text }}
  </Link>
</template>

<style lang="scss" scoped>
.c-anker-button {
  display: block;
  cursor: pointer;
  box-sizing: border-box;
  height: 50px;
  line-height: 50px;
  border-radius: 4px;
  border: none;
  border: solid 1px;
  min-width: 120px;
  font-weight: bold;
  text-align: center;
  text-decoration: none;
  &__icon {
    display: inline-block;
    margin-right: 8px;
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
}
</style>
