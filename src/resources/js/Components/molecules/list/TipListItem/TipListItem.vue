<script lang="ts" setup>
import { Link } from '@inertiajs/vue3';
import { TipListItemProps } from './type';
import IconImage from '@/Components/atom/image/IconImage/IconImage.vue';

const props = withDefaults(defineProps<TipListItemProps>(), {
  type: 'staff',
});
</script>

<template>
  <li class="c-tip-list-item">
    <Link :href="props.href" class="c-tip-list-item__link" :class="{ 'is-not-read': !props.isRead }">
      <IconImage class="c-tip-list-item__image" :src="props.src" :width="40" :height="40" />
      <div class="c-tip-list-item__content">
        <div class="c-tip-list-item__content-date">{{ props.date }}</div>
        <div class="c-tip-list-item__content-text">
          {{ props.name }}{{ props.type === 'staff' ? 'が' : 'さんに' }}
          <span class="point">{{ props.point.toLocaleString() }}CP</span>
          を贈りました。
        </div>
      </div>
      <div v-if="props.type === 'staff'" class="c-tip-list-item__read" :class="{ 'is-active': props.isReponse }">
        <i class="fa-solid fa-comment-dots"></i>
      </div>
    </Link>
  </li>
</template>

<style lang="scss">
.c-tip-list-item {
  list-style: none;
  border-bottom: solid 1px #dddddd;
  &__link {
    display: flex;
    text-decoration: none;
    padding: 16px 16px 16px 32px;
    color: var(--black);
    &.is-not-read {
      position: relative;
      &:before {
        position: absolute;
        content: '';
        top: 50%;
        left: 8px;
        transform: translateY(-50%);
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background-color: #ff0000;
      }
    }
  }
  &__content {
    flex: 1;
    display: flex;
    flex-direction: column;
    margin: 0 12px;
    &-date {
      font-size: 12px;
    }
    &-text {
      font-size: 14px;
      font-weight: var(--bold);
      span {
        color: #ff5693;
      }
    }
  }
  &__read {
    font-size: 34px;
    margin-left: auto;
    color: #ff5693;
    &.is-active {
      color: #cccccc;
    }
  }
}
</style>
