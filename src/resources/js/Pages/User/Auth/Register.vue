<script lang="ts" setup>
import BaseLayout from '@/Layouts/BaseLayout.vue';
import Button from '@/Components/atom/button/Button/Button.vue';
import Divider from '@/Components/atom/divider/Divider.vue';
import { FormInputTypeProp } from '@/Components/atom/form/FormInput/type';
import FormGroupHeader from '@/Components/molecules/form/FormGroupHeader/FormGroupHeader.vue';
import FormGroupInput from '@/Components/molecules/form/FormGroupInput/FormGroupInput.vue';
import { FormRequiredLabelTypeProp } from '@/Components/atom/form/FormRequiredLabel/type';
import FormSelectBox from '@/Components/atom/form/FormSelectBox/FormSelectBox.vue';
import Formvalidation from '@/Components/atom/form/FormValidation/FormValidation.vue';
import HeaderSubText from '@/Components/atom/header/HeaderSubText/HeaderSubText.vue';
import Link from '@/Components/atom/link/Link/Link.vue';
import Paragraph from '@/Components/atom/typograph/Paragraph/Paragraph.vue';
import { RouteName, yearOptions, monthOptions, dayOptions } from '@/Utilities';
import { useForm } from '@inertiajs/vue3';
import { watch } from 'vue';

const form = useForm({
  nickname: '',
  email: '',
  password: '',
  password_confirmation: '',
  year: '',
  month: '',
  day: '',
});

watch(
  () => [form.year, form.month],
  ([newYear, newMonth]) => {
    const isMatch = dayOptions(newYear, newMonth).some((item) => item.value === form.day);
    if (!isMatch) form.day = '';
  },
);

const onSubmit = () => {
  if (form.processing) return;
  form.post(route('user.register'), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  });
};
</script>

<template>
  <BaseLayout title="ユーザー新規登録">
    <HeaderSubText text="新規登録" :href="route(RouteName.UserSignup)" />
    <Divider />
    <div class="p-user-register">
      <div class="p-user-register__container">
        <form class="p-user-register__form" @submit.prevent="onSubmit">
          <FormGroupInput
            id="nickname"
            label="ニックネーム"
            :type="FormInputTypeProp.Text"
            v-model="form.nickname"
            :required-type="FormRequiredLabelTypeProp.Required"
            :error="form.errors.nickname"
            class="p-user-register__nickname"
          />
          <FormGroupHeader id="birthdate" label-name="誕生日" type="required" class="p-user-register__label" />
          <div class="p-user-register__birthdate">
            <div class="p-user-register__birthdate-wrap">
              <div class="p-user-register__birthdate-item">
                <FormSelectBox
                  id="year"
                  label="年"
                  v-model="form.year"
                  :required-type="FormRequiredLabelTypeProp.Required"
                  :is-error="!!form.errors.year"
                  :error-message="form.errors.year"
                  class="p-user-register__birthdate-item-select"
                  :options="yearOptions()"
                  name="year"
                />
                <p>年</p>
              </div>
              <div class="p-user-register__birthdate-item">
                <FormSelectBox
                  id="month"
                  label="月"
                  v-model="form.month"
                  :required-type="FormRequiredLabelTypeProp.Required"
                  :is-error="!!form.errors.month"
                  class="p-user-register__birthdate-item-select"
                  :options="monthOptions()"
                  name="month"
                />
                <p>月</p>
              </div>
              <div class="p-user-register__birthdate-item">
                <FormSelectBox
                  id="day"
                  label="日"
                  v-model="form.day"
                  :required-type="FormRequiredLabelTypeProp.Required"
                  :is-error="!!form.errors.day"
                  class="p-user-register__birthdate-item-select"
                  :options="dayOptions(form.year, form.month)"
                  name="day"
                />
                <p>日</p>
              </div>
            </div>
            <Formvalidation class="c-form-group-input__error" v-if="form.errors.year" :text="form.errors.year" />
            <Formvalidation class="c-form-group-input__error" v-if="form.errors.month" :text="form.errors.month" />
            <Formvalidation class="c-form-group-input__error" v-if="form.errors.day" :text="form.errors.day" />
          </div>
          <FormGroupInput
            id="email"
            label="メールアドレス"
            :type="FormInputTypeProp.Email"
            v-model="form.email"
            :required-type="FormRequiredLabelTypeProp.Required"
            :error="form.errors.email"
            class="p-user-register__email"
          />
          <FormGroupInput
            id="password"
            label="パスワード"
            :type="FormInputTypeProp.Password"
            v-model="form.password"
            :required-type="FormRequiredLabelTypeProp.Required"
            :error="form.errors.password"
            class="p-user-register__password"
          />
          <FormGroupInput
            id="password_confirmation"
            label="パスワード-確認"
            :type="FormInputTypeProp.Password"
            v-model="form.password_confirmation"
            :required-type="FormRequiredLabelTypeProp.Required"
            :error="form.errors.password_confirmation"
            class="p-user-register__password"
          />
          <Button
            class="p-user-register__submit"
            :disabled="form.processing"
            text="新規登録"
            :is-loading="form.processing"
          />
          <Paragraph>
            <Link text="利用規約" :href="RouteName.StaffPasswordRequest" />
            及び
            <Link text="プライバシーポリシー" :href="RouteName.StaffPasswordRequest" />
            に同意の上、登録又はログインへお進みください。
          </Paragraph>
        </form>
      </div>
    </div>
  </BaseLayout>
</template>
<style lang="scss">
.p-user-register {
  &__container {
    padding: 24px 16px;
  }
  &__label {
    margin-bottom: 10px;
  }
  &__form {
    display: flex;
    flex-direction: column;
  }
  &__nickname,
  &__email,
  &__password {
    margin-bottom: 30px;
  }
  &__birthdate {
    margin-bottom: 30px;
    &-wrap {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 16px;
    }
    &-item {
      display: inline-flex;
      align-items: flex-end;
      &-select {
        width: 100%;
      }
      p {
        font-weight: 600;
        margin-left: 8px;
      }
    }
  }
  &__submit {
    margin-bottom: 30px;
    margin-top: 10px;
  }
}
</style>
