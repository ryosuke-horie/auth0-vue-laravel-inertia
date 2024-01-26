<script lang="ts" setup>
import BaseLayout from '@/Layouts/BaseLayout.vue';
import { RouteName } from '@/Utilities';
import HeaderSubText from '@/Components/atom/header/HeaderSubText/HeaderSubText.vue';
import Divider from '@/Components/atom/divider/Divider.vue';
import Paragraph from '@/Components/atom/typograph/Paragraph/Paragraph.vue';
import AnkerButton from '@/Components/atom/button/AnkerButton/AnkerButton.vue';
</script>

<template>
  <BaseLayout title="再設定メール送信">
    <HeaderSubText text="再設定メールを送信しました" />
    <Divider />
    <div class="p-user-complete-send-email">
      <div class="p-user-complete-send-email__container">
        <img src="/images/SendMessage.png" alt="メール送信画像" />
        <Paragraph>
          ご登録されたメールアドレス宛にパスワード再設定メールを送信しました。<br />
          メールが届きましたら、60分いないにメッセージ記載されたURLからパスワードの再設定をおこなってください。
        </Paragraph>
        <AnkerButton class="p-user-complete-send-email__link" text="戻る" :href="route(RouteName.UserLogin)" />
      </div>
    </div>
  </BaseLayout>
</template>

<style lang="scss">
.p-user-complete-send-email {
  &__container img {
    width: 100%;
    height: 100%;
    margin: 30px auto;
  }
  &__link {
    width: 100%;
    margin-top: 20px;
  }
}
</style>
