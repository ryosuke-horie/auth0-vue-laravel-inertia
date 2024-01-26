<script lang="ts" setup>
import type { HeaderProps } from './type';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { computed, onMounted } from 'vue';

const props = defineProps<HeaderProps>();

const ids = computed<(string | undefined)[]>(() => {
  return props.menus
    .map((menu) => {
      return menu.hrefId;
    })
    .filter((item) => {
      return typeof item === 'string';
    });
});

const emit = defineEmits(['open']);

const onOpen = () => {
  emit('open');
};

const currentHash = ref<string | undefined>(props.menus.length ? props.menus[0].hrefId : undefined);
onMounted(() => {
  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          const id = entry.target.id;
          if (ids.value.includes(id)) currentHash.value = id;
        }
      });
    },
    { threshold: 0.5, root: document },
  );

  const elements = document.querySelectorAll('section');
  elements.forEach((el) => {
    observer.observe(el);
  });
});
</script>

<template>
  <header class="c-header">
    <div class="c-header__head">
      <figure class="c-header__head-logo">
        <img src="@/../assets/images/logo.png" alt="" />
      </figure>
      <button class="c-header__head-menu" @click="onOpen">
        <i class="fas fa-bars"></i>
      </button>
    </div>
    <ul v-if="props.menus.length">
      <li
        v-for="(item, index) of props.menus"
        :key="`header-menu-${index}`"
        :class="item.hrefId === currentHash && 'is-active'"
      >
        <Link :href="item.hrefId ? `${item.href}#${item.hrefId}` : item.href">{{ item.text }}</Link>
      </li>
    </ul>
  </header>
</template>

<style lang="scss">
.c-header {
  box-shadow: 0px 1px 1px 0px rgba(0, 0, 0, 0.2);
  background-color: var(--white);
  &__head {
    @media screen and (min-width: 1025px) {
      display: none;
    }
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 50px;
    padding: 0 16px;
    &-logo {
      height: 34px;
      img {
        height: 100%;
      }
    }
  }
  ul {
    display: flex;
    align-items: center;
    justify-content: space-around;
    height: 40px;
    @media screen and (min-width: 1025px) {
      height: 60px;
    }
    li {
      display: inline-flex;
      align-items: center;
      font-size: 14px;
      height: 100%;
      padding: 0 8px;
      font-weight: var(--bold);
      @media screen and (min-width: 1025px) {
        font-size: 16px;
      }
      &.is-active {
        position: relative;
        &:before {
          position: absolute;
          content: '';
          bottom: 0px;
          left: 0;
          width: 100%;
          height: 3px;
          background-color: #66ccbb;
        }
      }
      a {
        color: inherit;
      }
    }
  }
}
</style>
