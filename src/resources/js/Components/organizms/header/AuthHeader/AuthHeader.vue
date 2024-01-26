<script lang="ts" setup>
import HeaderSubText from '@/Components/atom/header/HeaderSubText/HeaderSubText.vue';
import { type AuthHeaderProps } from './type';
import Divider from '@/Components/atom/divider/Divider.vue';
import { computed } from 'vue';
import { RouteRoleName } from '@/Utilities';
import { ref } from 'vue';
import HamburgerMenu from '@/Components/molecules/hamburger/HamburgerMenu/HamburgerMenu.vue';

const props = defineProps<AuthHeaderProps>();

const isOpenMenu = ref<boolean>(false);
const onClickIsOpenMenu = () => {
  isOpenMenu.value = !isOpenMenu.value;
};

const emit = defineEmits<{
  (e: 'click'): void;
}>();

const onClick = () => {
  emit('click');
};

const computedHeaderLabel = computed<string>(() => {
  switch (props.role) {
    case RouteRoleName.Admin:
      return 'チアペイ';
    case RouteRoleName.Business:
      return 'チアペイ事業者';
    case RouteRoleName.Corporation:
      return 'チアペイ法人';
    case RouteRoleName.Staff:
      return 'チアペイスタッフ';
    case RouteRoleName.AdminStaff:
      return 'チアペイスタッフ管理';
    case RouteRoleName.User:
      return 'チアペイ';
    default:
      return '';
  }
});
</script>

<template>
  <header class="c-auth-header">
    <div class="c-auth-header__main">
      <span class="c-auth-header__main-toggle" @click="onClickIsOpenMenu">
        <i class="fas fa-bars"></i>
      </span>
      <h1 class="c-auth-header__main-title">{{ computedHeaderLabel }}</h1>
      <span class="c-auth-header__main-search" @click="onClick">
        <i class="fa-solid fa-magnifying-glass"></i>
      </span>
      <span class="c-auth-header__main-user" @click="onClick">
        <i class="fa-solid fa-user"></i>
      </span>
    </div>
    <Divider />
    <HeaderSubText
      :text="props.text"
      :href="!props.href ? '' : props.params ? route(props.href, props.params) : route(props.href)"
    />
    <Divider />
  </header>
  <HamburgerMenu :is-open="isOpenMenu" @click="onClickIsOpenMenu" />
</template>

<style lang="scss">
.c-auth-header {
  background-color: var(--white);
  &__main {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 50px;
    &-title {
      font-size: 16px;
    }
    &-toggle,
    &-search,
    &-user {
      cursor: pointer;
      display: inline-block;
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      width: 20px;
      height: 20px;
    }
    &-toggle {
      left: 16px;
    }
    &-search {
      right: 46px;
    }
    &-user {
      right: 16px;
    }
  }
}
</style>
