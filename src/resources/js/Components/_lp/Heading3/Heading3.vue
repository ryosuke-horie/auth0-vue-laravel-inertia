<script lang="ts" setup>
import { computed } from 'vue';
import { Heading3Props } from './type';
const props = defineProps<Heading3Props>();

const classes = computed<string[]>(() => {
  const result: string[] = [];

  if (props.variant) result.push(props.variant);

  if (props.textAlign) result.push(props.textAlign);

  return result;
});
</script>
<template>
  <h3 class="c-lp-heading3" :class="classes"><slot /></h3>
</template>

<style lang="scss">
.c-lp-heading3 {
  font-size: 16px;
  line-height: 1.7;
  font-weight: var(--bold);
  &.green {
    color: #66ccbb;
  }
  &.brown {
    color: #aa3300;
  }
  &.center {
    text-align: center;
  }
}
</style>
