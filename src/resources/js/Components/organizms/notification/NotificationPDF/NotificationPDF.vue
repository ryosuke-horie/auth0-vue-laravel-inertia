<script lang="ts" setup>
import { NotificationPDFProps } from './type';

const props = defineProps<NotificationPDFProps>();
</script>

<template>
  <div class="c-pdf">
    <object :data="props.path" type="application/pdf" width="100%" height="100%" class="p-pdf-view"></object>
  </div>
</template>

<style lang="scss">
.c-pdf {
  height: 100vh;
}
</style>
