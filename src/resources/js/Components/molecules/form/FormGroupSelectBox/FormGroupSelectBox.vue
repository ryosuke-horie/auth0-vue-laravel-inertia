<script setup lang="ts">
import FormLabel from '@/Components/atom/form/FormLabel/FormLabel.vue';
import FormSelectBox from '@/Components/atom/form/FormSelectBox/FormSelectBox.vue';
import FormRequiredLabel from '@/Components/atom/form/FormRequiredLabel/FormRequiredLabel.vue';
import FormDescription from '@/Components/atom/form/FormDescription/FormDescription.vue';
import FormAnnotation from '@/Components/atom/form/FormAnnotation/FormAnnotation.vue';
import FormValidation from '@/Components/atom/form/FormValidation/FormValidation.vue';
import type { FormGroupSelectBoxProps } from './type';
import type { FormSelectBoxOptionItem } from '@/Components/atom/form/FormSelectBox/type';

const props = withDefaults(defineProps<FormGroupSelectBoxProps>(), {});

const emit = defineEmits(['update:modelValue']);

const onInput = (e: Event): void => {
  const value = (e.target as HTMLInputElement).value;
  emit('update:modelValue', value);
};

const options: FormSelectBoxOptionItem[] = [
  { value: 'test1', label: 'test1' },
  { value: 'test2', label: 'test2' },
  { value: 'test3', label: 'test3' },
  { value: 'test4', label: 'test4' },
];
</script>

<template>
  <div class="c-form-group-select-box">
    <div v-if="props.label || props.requiredType" class="c-form-group-select-box__head">
      <FormLabel v-if="props.label" :html-for="props.id" :label="props.label" />
      <FormRequiredLabel v-if="props.requiredType" :type="props.requiredType" />
    </div>
    <FormDescription class="c-form-group-select-box__description" v-if="props.description" :text="props.description" />
    <FormSelectBox
      :id="props.id"
      :placeholder="props.placeholder"
      :model-value="props.modelValue"
      :options="options"
      @input="onInput"
      :is-error="!!props.error"
      class="c-form-group-select-box__form"
    />
    <FormValidation class="c-form-group-select-box__error" v-if="props.error" :text="props.error" />
    <FormAnnotation class="c-form-group-select-box__annotation" v-if="props.annotation" :text="props.annotation" />
  </div>
</template>

<style lang="scss">
.c-form-group-select-box {
  display: flex;
  flex-direction: column;
  &__head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
  }
  &__description {
    margin-bottom: 8px;
  }
  &__error {
    margin-top: 8px;
  }
  &__annotation {
    margin-top: 8px;
  }
  &__count {
    margin-left: auto;
  }
}
</style>
