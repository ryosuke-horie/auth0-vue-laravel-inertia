<script lang="ts" setup></script>

<template>
  <h2 class="c-lp-heading2"><slot /></h2>
</template>

<style lang="scss">
.c-lp-heading2 {
  display: flex;
  align-items: center;
  font-size: 18px;
  line-height: 1.5;
  padding: 8px 16px;
  border-bottom: solid 5px #66ccbb;
  font-weight: var(--bold);
}
</style>
