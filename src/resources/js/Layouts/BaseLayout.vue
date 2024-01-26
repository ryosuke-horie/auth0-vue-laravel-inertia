<script lang="ts" setup>
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import Baneers from '@/Components/_lp/Banners/Banners.vue';
import HamburgerMenu from '@/Components/_lp/HamburgerMenu/HamburgerMenu.vue';
import Header from '@/Components/_lp/Header/Header.vue';
import type { HeaderProps } from '@/Components/_lp/Header/type';

export type BaseLayoutProps = {
  title: string;
  headerMenus?: HeaderProps['menus'];
};

const props = defineProps<BaseLayoutProps>();

const isOpen = ref(false);
const setIsOpen = (): void => {
  isOpen.value = !isOpen.value;
};
</script>
<template>
  <Head v-bind="props" />
  <div class="l-layout">
    <div class="l-layout__container">
      <div class="l-layout__hamburger" :class="{ 'is-open': isOpen }">
        <HamburgerMenu @close="setIsOpen" />
      </div>
      <div class="l-layout__content">
        <Header class="l-layout__header" @open="setIsOpen" :menus="props.headerMenus || []" />
        <main>
          <slot />
        </main>
      </div>
      <div class="l-layout__banners">
        <Baneers />
      </div>
    </div>
  </div>
</template>

<style lang="scss">
.l-layout {
  background-color: rgb(235, 235, 235);
  &__container {
    position: relative;
    max-width: 600px;
    margin: 0 auto;
    @media screen and (min-width: 1025px) {
      display: grid;
      grid-template-columns: 375px 1fr 338px;
      gap: 8px;
      max-width: 1320px;
    }
  }
  &__content {
    max-width: 600px;
    background-color: var(--white);
  }
  &__header {
    position: sticky;
    top: 0;
    z-index: 3;
  }
  &__hamburger {
    max-width: 600px;
    @media screen and (max-width: 1024px) {
      position: fixed;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100vh;
      z-index: 1000;
      overflow-y: scroll;
      scrollbar-width: none;
      -ms-overflow-style: none;
      &::-webkit-scrollbar {
        display: none;
      }
      &.is-open {
        top: 0;
        left: unset;
      }
    }
  }
  &__banners {
    display: none;
    @media screen and (min-width: 1025px) {
      display: block;
    }
    img {
      width: 100%;
    }
  }
}
</style>
