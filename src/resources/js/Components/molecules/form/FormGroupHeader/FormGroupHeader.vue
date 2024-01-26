<script setup lang="ts">
import FormLabel from '@/Components/atom/form/FormLabel/FormLabel.vue';
import FormRequiredLabel from '@/Components/atom/form/FormRequiredLabel/FormRequiredLabel.vue';
import type { FormGroupHeaderProps } from './type';

const props = withDefaults(defineProps<FormGroupHeaderProps>(), {});
</script>

<template>
  <div v-if="props.labelName || props.type" class="c-form-group-header">
    <FormLabel v-if="props.labelName" :html-for="props.id" :label="props.labelName" />
    <FormRequiredLabel v-if="props.type" :type="props.type" />
  </div>
</template>

<style lang="scss">
.c-form-group-header {
  display: flex;
  justify-content: space-between;
}
</style>
