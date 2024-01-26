<script lang="ts" setup>
import { Head } from '@inertiajs/vue3';
import { AuthLayoutProps } from './type';
import AuthHeader from '@/Components/organizms/header/AuthHeader/AuthHeader.vue';

const props = defineProps<AuthLayoutProps>();
</script>
<template>
  <Head :title="props.title" />
  <div class="l-layout">
    <div class="l-layout__container">
      <AuthHeader v-bind="props.header" />
      <slot />
    </div>
  </div>
</template>

<style lang="scss">
.l-layout {
  &__container {
    max-width: 375px;
    margin: 0 auto;
  }
}
</style>
