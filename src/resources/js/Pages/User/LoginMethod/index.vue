<script lang="ts" setup>
import BaseLayout from '@/Layouts/BaseLayout.vue';
import { RouteName } from '@/Utilities';
import HeaderSubText from '@/Components/atom/header/HeaderSubText/HeaderSubText.vue';
import Divider from '@/Components/atom/divider/Divider.vue';
import Paragraph from '@/Components/atom/typograph/Paragraph/Paragraph.vue';
import AnkerButton from '@/Components/atom/button/AnkerButton/AnkerButton.vue';
import { Link } from '@inertiajs/vue3';
import { AnkerButtonVariantProp } from '@/Components/atom/button/AnkerButton/type';
</script>

<template>
  <BaseLayout title="チアペイへようこそ！">
    <img class="p-user-login-method__icon" src="/images/cheerpayIcon.png" alt="チアペイアイコン" />
    <HeaderSubText text="チアペイへようこそ！" />
    <Divider />
    <div class="p-user-login-method">
      <div class="p-user-login-method__container">
        <h3>ログイン方法を選択してください</h3>

        <Divider class="p-user-login-method__divider" />

        <!-- コンポーネント化検討？ -->
        <div class="p-user-login-method__login-btn-container">
          <Link class="p-user-login-method__member" :href="route(RouteName.UserLogin)">
            ログイン<br />アカウントをお持ちの方
          </Link>
          <AnkerButton
            class="p-user-login-method__guest"
            text="ゲストユーザーでログイン"
            method="post"
            :variant="AnkerButtonVariantProp.Secondary"
            :href="route(RouteName.UserGuestLogin)"
          />
        </div>

        <Divider class="p-user-login-method__divider" />

        <h3>はじめてご利用される方</h3>

        <Divider class="p-user-login-method__divider" />

        <div class="p-user-login-method__link-container">
          <AnkerButton
            class="p-user-login-method__link"
            text="無料会員登録"
            :is-outlined="true"
            :href="route(RouteName.UserRegister)"
          />
          <Paragraph>
            <Link text="利用規約" :href="RouteName.UserPasswordRequest" />
            及び
            <Link text="プライバシーポリシー" :href="RouteName.UserPasswordRequest" />
            に同意の上、登録又はログインへお進みください。
          </Paragraph>
        </div>
      </div>
    </div>
  </BaseLayout>
</template>

<style lang="scss">
.p-user-login-method {
  &__container {
    padding: 24px 0px;
    & > h3 {
      text-align: center;
    }
  }
  &__member {
    display: block;
    cursor: pointer;
    box-sizing: border-box;
    line-height: 25px;
    border-radius: 6px;
    border: solid 1px;
    min-width: 120px;
    font-weight: bold;
    text-align: center;
    text-decoration: none;
    margin-bottom: 20px;
    background: var(--anker);
    color: var(--white);
    padding: 20px;
    font-size: 18px;
  }
  &__icon {
    width: 190px;
    height: 145px;
    margin: 0 auto;
    display: block;
  }
  &__link {
    margin-bottom: 20px;
  }
  &__link-icon-sns {
    display: grid;
    justify-items: center;
    padding-bottom: 20px;
    & > a {
      color: var(--black);
    }
  }
  &__sns-icons {
    display: flex;
    justify-content: center;

    i {
      margin: 5px 10px;
    }
  }
  &__link-container {
    padding: 5px 20px 20px 20px;
    & > h3 {
      color: var(--gray);
      text-align: center;
      margin-bottom: 10px;
      margin-top: 10px;
    }
  }
  &__link-icon-sns {
    margin-top: 20px;
  }
  &__divider {
    margin: 20px 0;
  }
  &__login-btn-container {
    padding: 0 20px;
  }
}
</style>
