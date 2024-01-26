<script setup lang="ts">
import type { LinkProps } from './type';
import { Link } from '@inertiajs/vue3';

const props = defineProps<LinkProps>();
</script>

<template>
  <Link class="c-link" :href="route(props.href)">{{ props.text }}</Link>
</template>

<style lang="scss">
.c-link {
  display: inline-block;
  align-items: center;
  text-decoration: none;
  line-height: 1.8;
  color: var(--anker);
  &__text {
    font-size: 11px;
  }
}
</style>
