<script lang="ts" setup>
import IconImage from '@/Components/atom/image/IconImage/IconImage.vue';
import { IconNameListItemProps } from './type';

const props = defineProps<IconNameListItemProps>();
</script>

<template>
  <li class="c-icon-name-list-item">
    <IconImage :src="props.src" :width="60" :height="60" />
    <span class="c-icon-name-list-item__name">{{ props.name }}</span>
  </li>
</template>

<style lang="scss">
.c-icon-name-list-item {
  display: flex;
  align-items: center;
  &__name {
    font-size: 16px;
    margin-left: 20px;
  }
}
</style>
