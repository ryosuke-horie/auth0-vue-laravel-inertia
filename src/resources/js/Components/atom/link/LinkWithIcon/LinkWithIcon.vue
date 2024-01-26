<script setup lang="ts">
import type { LinkWithIconProps } from './type';
import { Link } from '@inertiajs/vue3';

const props = defineProps<LinkWithIconProps>();
</script>

<template>
  <Link class="c-link-with-icon" :href="route(props.href)">
    <span class="c-link-with-icon__text">{{ props.text }}</span>
    <span class="c-link-with-icon__icon">></span>
  </Link>
</template>

<style lang="scss">
.c-link-with-icon {
  display: inline-flex;
  align-items: center;
  text-decoration: none;
  line-height: 1.8;
  color: var(--anker);
  &__text {
    font-size: 11px;
  }
  &__icon {
    display: inline-block;
    margin-left: 4px;
  }
}
</style>
