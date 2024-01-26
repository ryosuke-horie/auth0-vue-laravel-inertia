<script lang="ts" setup>
import { Link } from '@inertiajs/vue3';
import Paragraph from '@/Components/atom/typograph/Paragraph/Paragraph.vue';
import { AnkerSettingListItemProps } from './type';

const props = defineProps<AnkerSettingListItemProps>();
</script>

<template>
  <li class="c-anker-setting-list-item">
    <Link :href="props.href" class="c-anker-setting-list-item__link">
      <Paragraph class="c-anker-setting-list-item__text" font>{{ props.text }}</Paragraph>
      <i class="fa-solid fa-chevron-right"></i>
    </Link>
  </li>
</template>
<style lang="scss">
.c-anker-setting-list-item {
  & + .c-anker-setting-list-item {
    border-top: solid 1px #dddddd;
  }
  &__link {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px;
    color: var(--black);
  }
}
</style>
