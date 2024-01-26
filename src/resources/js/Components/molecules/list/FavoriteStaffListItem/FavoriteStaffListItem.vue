<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import Image from '@/Components/atom/image/Image/Image.vue';
import type { FavoriteStaffListItemPorps } from './type';

const imageStyle = {
  width: 115,
  height: 130,
};

const props = defineProps<FavoriteStaffListItemPorps>();
</script>

<template>
  <Link :href="props.href" class="c-favorite-staff__staff-list-item">
    <Image
      :src="props.staffProfileImages[0].image ? props.staffProfileImages[0].image : `/images/noimage.png`"
      alt="スタッフ画像"
      :width="imageStyle.width"
      :height="imageStyle.height"
      class="c-favorite-staff__staff-image"
    />
    <div class="c-favorite-staff__staff-info">
      <p class="c-favorite-staff__staff-name">{{ props.staffName }}</p>
      <p class="c-favorite-staff__business-name">{{ props.businessName }}</p>
    </div>
  </Link>
</template>

<style lang="scss">
.c-favorite-staff {
  &__staff-list-item {
    color: var(--black);
  }
  &__staff-info {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    margin: 10px 0 0 5px;
  }

  &__staff-name {
    font-size: 14px;
    font-weight: bold;
  }

  &__business-name {
    font-size: 12px;
    color: var(--gray);
  }
}
</style>
