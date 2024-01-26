<script lang="ts" setup>
import { computed } from 'vue';
import { ScheduleStaffListButtonProps } from './type';
import ColorSection from '@/Components/atom/section/ColorSection/ColorSection.vue';
import LoadingIcon from '@/Components/atom/loading/LoadingIcon/LoadingIcon.vue';
import IconImage from '@/Components/atom/image/IconImage/IconImage.vue';
import { StaffListItem } from '@/api';

const props = defineProps<ScheduleStaffListButtonProps>();

const staff = computed<StaffListItem | undefined>(() => {
  return props.staffList.find((staff) => staff.staffId == props.staffId);
});

const staffList = computed<StaffListItem[]>(() => {
  return props.staffList.filter((staff) => staff.staffId != props.staffId);
});

const emit = defineEmits<{
  clickButton: [];
  clickStaffId: [staffId: number];
}>();

const onClickButton = () => {
  emit('clickButton');
};

const onClickStaffId = async (staffId: number): Promise<void> => {
  emit('clickStaffId', staffId);
};
</script>

<template>
  <ColorSection>
    <div class="c-staff-select">
      <button
        v-if="staff"
        class="c-staff-select__button c-staff-select__button--staff"
        type="button"
        @click="onClickButton"
      >
        <IconImage
          class="c-staff-select__button-image"
          :src="staff.image || 'https://www.mamiya-its.co.jp/public/images/4_service/systemintegration.jpg'"
          :width="40"
          :height="40"
          :alt="staff.staffName"
        />
        <p class="c-staff-select__button-name">{{ staff.staffName }}</p>
        <i v-if="props.isOpen" class="c-staff-select__button-icon fa-solid fa-xmark" />
      </button>
      <button v-else class="c-staff-select__button" type="button" @click="onClickButton">
        スタッフ選択
        <i v-if="props.isOpen" class="c-staff-select__button-icon fa-solid fa-xmark" />
      </button>
      <div v-if="props.isOpen" class="c-staff-select__content">
        <LoadingIcon v-if="props.isLoading" />
        <ul v-else-if="staffList.length" class="c-staff-select__list">
          <li
            v-for="item of staffList"
            :key="item.staffId"
            class="c-staff-select__list-item"
            @click="onClickStaffId(item.staffId)"
          >
            <IconImage
              :src="item.image || 'https://www.mamiya-its.co.jp/public/images/4_service/systemintegration.jpg'"
              :width="40"
              :height="40"
              :alt="item.staffName"
            />
            <p class="c-staff-select__list-item-name">{{ item.staffName }}</p>
          </li>
        </ul>
        <div v-else class="c-staff-select__empty">選択できるスタッフがいません。</div>
      </div>
    </div>
  </ColorSection>
</template>

<style lang="scss">
.c-staff-select {
  &:has(.c-staff-select__list),
  &:has(.c-staff-select__empty) {
    .c-staff-select__button {
      border-radius: 5px 5px 0px 0px;
    }
  }
  &__button {
    position: relative;
    width: 100%;
    min-height: 50px;
    padding: 5px 40px;
    border-radius: 5px;
    box-shadow: 0 4px 4px 0 #00000005;
    font-weight: var(--bold);
    background-color: var(--white);
    &--staff {
      display: flex;
      align-items: center;
      justify-content: flex-start;
      padding: 5px 40px 5px 10px;
    }
    &-name {
      flex: 1;
      font-size: 18px;
      margin-left: 16px;
      text-align: left;
    }
    &-icon {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      position: absolute;
      top: 50%;
      right: 10px;
      transform: translateY(-50%);
      font-size: 20px;
      width: 20px;
      height: 20px;
    }
  }
  &__content {
    margin-top: 4px;
  }
  &__list {
    &-item {
      cursor: pointer;
      display: flex;
      align-items: center;
      padding: 5px 10px;
      font-size: 18px;
      background-color: var(--white);
      border-bottom: solid 3px #eee;
      &-name {
        flex: 1;
        margin-left: 16px;
      }
    }
  }
  &__empty {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 80px;
    background-color: var(--white);
  }
}
</style>
