<script lang="ts" setup>
import { StaffListItemProps } from './type';
import { Link } from '@inertiajs/vue3';
import IconImage from '@/Components/atom/image/IconImage/IconImage.vue';
import Paragraph from '@/Components/atom/typograph/Paragraph/Paragraph.vue';

const props = defineProps<StaffListItemProps>();

const emit = defineEmits(['delete']);

const onClickDelete = () => {
  emit('delete');
};
</script>

<template>
  <li class="c-staff-list-item">
    <div class="c-staff-list-item__image">
      <IconImage :src="props.src" :width="70" :height="70" />
    </div>
    <div class="c-staff-list-item__detail">
      <Paragraph class="c-staff-list-item__detail-role">{{ props.role }}</Paragraph>
      <Paragraph class="c-staff-list-item__detail-name">{{ props.name }}</Paragraph>
    </div>
    <div class="c-staff-list-item__buttons">
      <Link text="詳細" :href="props.href" class="c-staff-list-item__buttons-link" />
      <button class="c-staff-list-item__buttons-delete" @click="onClickDelete">削除</button>
    </div>
  </li>
</template>

<style lang="scss">
.c-staff-list-item {
  display: flex;
  padding: 16px;
  & + .c-staff-list-item {
    border-top: solid 1px #dddddd;
  }
  &__image {
    width: 70px;
    margin-right: 20px;
  }
  &__detail {
    flex: 1;
    width: 100%;
    display: inline-flex;
    flex-direction: column;
    justify-content: center;
    &-role {
      margin-bottom: 4px;
    }
    &-name {
      font-size: 20px;
    }
  }
  &__buttons {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
    height: 70px;
    margin-left: 20px;
    &-link,
    &-delete {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 60px;
      height: 30px;
      border-radius: 4px;
      font-size: 14px;
      border: solid 1px;
      box-sizing: border-box;
      text-align: center;
      background-color: var(--black);
      color: var(--white);
    }
  }
}
</style>
