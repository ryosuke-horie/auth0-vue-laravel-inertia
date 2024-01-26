<script lang="ts" setup>
import Link from '@inertiajs/vue3';
import IconImage from '@/Components/atom/image/IconImage/IconImage.vue';
import Paragraph from '@/Components/atom/typograph/Paragraph/Paragraph.vue';
import { AnkerStaffListItemProps } from './type';

const props = defineProps<AnkerStaffListItemProps>();
</script>

<template>
  <li class="c-anker-staff-list-item">
    <Link class="c-anker-staff-list-item__link">
      <div class="c-anker-staff-list-item__image">
        <IconImage :src="props.src" :width="70" :height="70" />
      </div>
      <Paragraph class="c-anker-staff-list-item__name">{{ props.name }}</Paragraph>
    </Link>
  </li>
</template>
<style lang="scss">
.c-anker-staff-list-item {
  & + .c-anker-staff-list-item {
    border-top: solid 1px #dddddd;
  }
  &__link {
    display: flex;
    align-items: center;
    padding: 16px;
  }
  &__image {
  }
  &__name {
  }
}
</style>
