<script lang="ts" setup>
import { BusinessOperatorListItemProps } from './type';
import { Link } from '@inertiajs/vue3';
import Divider from '@/Components/atom/divider/Divider.vue';
import Image from '@/Components/atom/image/Image/Image.vue';

const props = defineProps<BusinessOperatorListItemProps>();

const imageStyle = {
  width: '100%',
  height: '100%',
};
</script>

<template>
  <li class="c-business-operator-list-item__shop-item">
    <Link :href="props.href">
      <Image :src="props.image" alt="事業者画像" :width="imageStyle.width" :height="imageStyle.height" />
      <p class="c-business-operator-list-item__name">{{ props.name }}</p>
      <p class="c-business-operator-list-item__city">{{ props.city }}</p>
    </Link>
    <Divider />
  </li>
</template>

<style lang="scss">
.c-business-operator-list-item {
  &__shop-item {
    margin-bottom: 20px;
    img {
      width: 100%;
      height: 200px;
      object-fit: cover;
    }
    a {
      color: var(--black);
    }
  }
  &__name {
    font-weight: bold;
  }
  &__city {
    font-size: 13px;
    margin-bottom: 10px;
    color: var(--gray);
  }
}
</style>
