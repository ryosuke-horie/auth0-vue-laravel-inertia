<script lang="ts" setup>
import BaseLayout from '@/Layouts/BaseLayout.vue';
import Link from '@/Components/atom/link/Link/Link.vue';
import { RouteName } from '@/Utilities';
import HeaderSubText from '@/Components/atom/header/HeaderSubText/HeaderSubText.vue';
import Divider from '@/Components/atom/divider/Divider.vue';
import Paragraph from '@/Components/atom/typograph/Paragraph/Paragraph.vue';
import AnkerButton from '@/Components/atom/button/AnkerButton/AnkerButton.vue';
import { useAuth0 } from '@auth0/auth0-vue';
// import pkg from '@auth0/auth0-vue';
// const { useAuth0 } = pkg;

const { loginWithRedirect } = useAuth0();

const handleSignUp = () => {
  loginWithRedirect({
    // appState: {
    //   target: '/profile',
    // },
    authorizationParams: {
      prompt: 'login',
      screen_hint: 'signup',
    },
  });
};
</script>

<template>
  <BaseLayout title="チアペイ無料会員長禄">
    <img class="p-user-signup__icon" src="/images/cheerpayIcon.png" alt="チアペイアイコン" />
    <HeaderSubText text="チアペイ無料会員登録" />
    <Divider />
    <div class="p-user-signup">
      <div class="p-user-signup__container">
        <div class="p-user-signup__link-icon-email">
          <i class="fa-regular fa-envelope"></i>
          <Link class="p-user-signup__register" text="メールアドレスで登録" :href="RouteName.UserRegister" />
        </div>

        <Divider class="p-user-signup__divider" />

        <!-- auth0の処理実行(てかデザインに関しては、コトダマからもらってきたらよくね？) -->
        <div class="p-user-signup__link-icon-sns">
          <div class="p-user-signup__sns-icons">
            <i class="p-user-signup__icon--line fa-brands fa-line"></i>
            <i class="p-user-signup__icon--twitter fa-brands fa-twitter"></i>
            <i class="p-user-signup__icon--google fa-brands fa-google"></i>
          </div>
          <button class="p-user-signup__sns" @click="handleSignUp">SNSアカウントで登録</button>
        </div>

        <div class="p-user-signup__link-container">
          <h3>アカウントお持ちの方</h3>
          <AnkerButton
            class="p-user-signup__link"
            text="ログイン"
            :is-outlined="true"
            :href="route(RouteName.UserLogin)"
          />
          <Paragraph>
            <Link text="利用規約" :href="RouteName.UserPasswordRequest" />
            及び
            <Link
              text="プライバシーポリシー"
              class="p-user-signup__privacy-policy"
              :href="RouteName.UserPasswordRequest"
            />
            に同意の上、登録又はログインへお進みください。
          </Paragraph>
        </div>
      </div>
    </div>
  </BaseLayout>
</template>

<style lang="scss">
.p-user-signup {
  &__container {
    padding: 24px 0px;
  }
  &__icon {
    width: 190px;
    height: 145px;
    margin: 0 auto;
    display: block;
  }
  &__icon--line {
    color: #4caf50;
    font-size: 30px;
  }
  &__icon--twitter {
    color: aqua;
    font-size: 30px;
  }
  &__icon--google {
    color: var(--red);
    font-size: 30px;
  }
  &__link-icon-email {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 19px 0 36px 0;
    & > i {
      margin-right: 10px;
    }
    & > a {
      color: var(--black);
      font-weight: 700;
    }
  }
  &__link-icon-sns {
    display: grid;
    justify-items: center;
    padding: 25px 0;
    & > button {
      color: var(--black);
      font-weight: 700;
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
    background: var(--light-gray);
    padding: 20px;
    & > h3 {
      color: var(--black);
      text-align: center;
      margin-bottom: 10px;
      margin-top: 10px;
    }
  }
  &__divider {
    margin: 5px 0px 10px 0;
  }
  &__privacy-policy {
    margin-top: 20px;
  }
}
</style>
