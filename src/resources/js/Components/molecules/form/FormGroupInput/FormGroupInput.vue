<script setup lang="ts">
import FormLabel from '@/Components/atom/form/FormLabel/FormLabel.vue';
import FormInput from '@/Components/atom/form/FormInput/FormInput.vue';
import FormRequiredLabel from '@/Components/atom/form/FormRequiredLabel/FormRequiredLabel.vue';
import FormDescription from '@/Components/atom/form/FormDescription/FormDescription.vue';
import FormAnnotation from '@/Components/atom/form/FormAnnotation/FormAnnotation.vue';
import FormValidation from '@/Components/atom/form/FormValidation/FormValidation.vue';
import FormCount from '@/Components/atom/form/FormCount/FormCount.vue';
import type { FormGroupInputProps } from './type';
import { FormInputTypeProp } from '@/Components/atom/form/FormInput/type';

const props = withDefaults(defineProps<FormGroupInputProps>(), {
  type: FormInputTypeProp.Text,
});

const emit = defineEmits(['update:modelValue']);

const onInput = (e: Event): void => {
  const value = (e.target as HTMLInputElement).value;
  emit('update:modelValue', value);
};
</script>

<template>
  <div class="c-form-group-input">
    <div v-if="props.label || props.requiredType" class="c-form-group-input__head">
      <FormLabel v-if="props.label" :html-for="props.id" :label="props.label" />
      <FormRequiredLabel v-if="props.requiredType" :type="props.requiredType" />
    </div>
    <FormDescription class="c-form-group-input__description" v-if="props.description" :text="props.description" />
    <FormInput
      :id="props.id"
      :type="props.type"
      :placeholder="props.placeholder"
      :max-length="10"
      :model-value="props.modelValue"
      @input="onInput"
      :is-error="!!props.error"
      class="c-form-group-input__form"
    />
    <FormValidation class="c-form-group-input__error" v-if="props.error" :text="props.error" />
    <FormAnnotation class="c-form-group-input__annotation" v-if="props.annotation" :text="props.annotation" />
    <FormCount
      class="c-form-group-input__count"
      v-if="props.isCount"
      :count="props.modelValue.length"
      :limit="props.countLimit"
      :unit="countUnit"
    />
  </div>
</template>

<style lang="scss">
.c-form-group-input {
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
