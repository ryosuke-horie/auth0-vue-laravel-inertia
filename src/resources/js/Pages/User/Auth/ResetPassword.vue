<script lang="ts" setup>
import BaseLayout from '@/Layouts/BaseLayout.vue';
import Button from '@/Components/atom/button/Button/Button.vue';
import Divider from '@/Components/atom/divider/Divider.vue';
import FormGroupInput from '@/Components/molecules/form/FormGroupInput/FormGroupInput.vue';
import { FormInputTypeProp } from '@/Components/atom/form/FormInput/type';
import { FormRequiredLabelTypeProp } from '@/Components/atom/form/FormRequiredLabel/type';
import HeaderSubText from '@/Components/atom/header/HeaderSubText/HeaderSubText.vue';
import Paragraph from '@/Components/atom/typograph/Paragraph/Paragraph.vue';
import { RouteName } from '@/Utilities';
import { useForm } from '@inertiajs/vue3';

const props = defineProps<{ token: string; email: string }>();

const form = useForm({
  token: props.token,
  email: props.email,
  password: '',
  password_confirmation: '',
});

const submit = () => {
  form.post(route(RouteName.UserPasswordStore), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  });
};
</script>

<template>
  <BaseLayout title="パスワード再設定">
    <HeaderSubText text="パスワード再設定" />
    <Divider />
    <div class="p-user-reset-password">
      <div class="p-user-reset-password__container">
        <Paragraph class="p-user-reset-password__text">新しいパスワードを設定します。</Paragraph>
        <form class="p-user-reset-password__form" @submit.prevent="submit">
          <FormGroupInput
            id="password"
            label="パスワード"
            :type="FormInputTypeProp.Password"
            v-model="form.password"
            :required-type="FormRequiredLabelTypeProp.Required"
            :error="form.errors.password"
            class="p-user-reset-password__password"
          />
          <FormGroupInput
            id="password_confirmation"
            label="パスワード-確認"
            annotation="パスワードは、半角8文字以上から半角100文字以下です。英大文字・英小文字・数字それぞれを最低1文字ずつ含んでください。"
            :type="FormInputTypeProp.Password"
            v-model="form.password_confirmation"
            :required-type="FormRequiredLabelTypeProp.Required"
            :error="form.errors.password_confirmation"
            class="p-user-reset-password__password-confirm"
          />
          <Button class="p-user-reset-password__submit" :disabled="form.processing" text="変更する" />
        </form>
      </div>
    </div>
  </BaseLayout>
</template>

<style lang="scss">
.p-user-reset-password {
  &__container {
    padding: 24px 16px;
  }
  &__text {
    margin-bottom: 30px;
  }
  &__form {
    display: flex;
    flex-direction: column;
  }
  &__password,
  &__password-confirm {
    margin-bottom: 30px;
  }
}
</style>
