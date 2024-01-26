<script setup>
import BaseLayout from '@/Layouts/BaseLayout.vue';
import Button from '@/Components/atom/button/Button/Button.vue';
import ColorSection from '@/Components/atom/section/ColorSection/ColorSection.vue';
import Divider from '@/Components/atom/divider/Divider.vue';
import FormGroupInput from '@/Components/molecules/form/FormGroupInput/FormGroupInput.vue';
import { FormInputTypeProp } from '@/Components/atom/form/FormInput/type';
import { FormRequiredLabelTypeProp } from '@/Components/atom/form/FormRequiredLabel/type';
import HeaderSubText from '@/Components/atom/header/HeaderSubText/HeaderSubText.vue';
import Link from '@/Components/atom/link/Link/Link.vue';
import Paragraph from '@/Components/atom/typograph/Paragraph/Paragraph.vue';
import { RouteName } from '@/Utilities';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
  email: '',
});

const onSubmit = () => {
  form.post(route(RouteName.UserPasswordEmail));
};
</script>

<template>
  <BaseLayout title="パスワードを忘れた方">
    <HeaderSubText text="パスワードを忘れた方" :href="RouteName.UserLogin" />
    <Divider />
    <div class="p-user-forgot-password">
      <div class="p-user-forgot-password__container">
        <Paragraph class="p-user-forgot-password__message">
          パスワード再設定メールを送信します。 登録されたメールアドレスを入力してください。
        </Paragraph>
        <form class="p-user-forgot-password__form" @submit.prevent="onSubmit">
          <FormGroupInput
            id="email"
            label="メールアドレス"
            :type="FormInputTypeProp.Email"
            v-model="form.email"
            :required-type="FormRequiredLabelTypeProp.Required"
            :error="form.errors.email"
            class="p-user-forgot-password__email"
          />
          <Button class="p-user-forgot-password__submit" :disabled="form.processing" text="送信" />
          <ColorSection :is-rounded="true">
            <Paragraph>
              ※URLの有効期限は60分です。※登録時のメールアドレスが、変更等により利用できない場合は、ご本人確認ができないためパスワードの再発行ができません。その場合は、お手数ですが、
              <Link text="新規会員登録" :href="RouteName.UserRegister" />
              をお願いいたします。
              ※再設定メールが受け取れない場合は、迷惑メールボックスの設定や、ドメイン着信許可の設定をお確かめの上、〇〇〇@fav.comのメールを受信できるようにしてください。
            </Paragraph>
          </ColorSection>
        </form>
      </div>
    </div>
  </BaseLayout>
</template>

<style lang="scss">
.p-user-forgot-password {
  &__container {
    padding: 24px 16px;
  }
  &__message {
    margin-bottom: 30px;
  }
  &__form {
    display: flex;
    flex-direction: column;
  }
  &__email {
    margin-bottom: 30px;
  }
  &__reset-password {
    justify-content: flex-end;
    margin-bottom: 10px;
  }
  &__submit {
    margin-bottom: 30px;
  }
}
</style>
