<script lang="ts" setup>
import BaseLayout from '@/Layouts/BaseLayout.vue';
import { RouteName } from '@/Utilities';
import HeaderSubText from '@/Components/atom/header/HeaderSubText/HeaderSubText.vue';
import Divider from '@/Components/atom/divider/Divider.vue';
import Paragraph from '@/Components/atom/typograph/Paragraph/Paragraph.vue';
import { computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { ParagraphVariantProp } from '@/Components/atom/typograph/Paragraph/type';
import AnkerButton from '@/Components/atom/button/AnkerButton/AnkerButton.vue';
import Button from '@/Components/atom/button/Button/Button.vue';
import { ButtonVariantProp } from '@/Components/atom/button/Button/type';

const props = defineProps({
  status: {
    type: String,
    default: '',
  },
});
const form = useForm({});

const submit = () => {
  form.post(route(RouteName.UserVerificationSend));
};

// メール送信完了の状態管理
const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
</script>

<template>
  <BaseLayout title="メールアドレス確認メール送信完了">
    <HeaderSubText text="登録完了メールを送信しました。" />
    <Divider />
    <div class="p-user-verify-email">
      <div class="p-user-verify-email__container">
        <img src="/images/SendMessage.png" alt="メール送信画像" />
        <Paragraph>
          ご登録されたメールアドレス宛に申し込み完了メールを送信しました。<br />
          メールが届きましたら、メッセージ記載されたURLからログインの手続きを進めてください。
        </Paragraph>
        <Paragraph
          :variant="ParagraphVariantProp.Red"
          class="p-user-verify-email__resend-message"
          v-if="verificationLinkSent"
        >
          ご登録されたメールアドレス宛に再度メールを送信しました。
        </Paragraph>
        <Button
          class="p-user-verify-email__submit"
          :loading="form.processing"
          @click="submit"
          text="送信"
          :variant="ButtonVariantProp.Secondary"
        />
        <!-- メソッドの追加 -->
        <AnkerButton class="p-user-verify-email__link" text="戻る" method="post" :href="route(RouteName.UserLogout)" />
      </div>
    </div>
  </BaseLayout>
</template>

<style lang="scss">
.p-user-verify-email {
  &__container {
    display: flex;
    justify-content: center;
    flex-direction: column;
    padding: 24px 16px;
  }
  &__container img {
    width: 100%;
    height: 100%;
    margin: 0 auto 30px auto;
  }
  &__container form {
    text-align: center;
  }
  &__resend-message {
    margin-top: 25px;
    color: #fa5661;
  }
  &__submit {
    width: 100%;
    margin-top: 25px;
  }
  &__link {
    width: 100%;
    margin-top: 10px;
  }
}
</style>
