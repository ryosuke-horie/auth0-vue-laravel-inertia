<script setup lang="ts">
// Vue関連のインポート
import { onMounted, ref } from 'vue';
// ユーティリティ
import { RouteName, RouteRoleName } from '@/Utilities';
// 型定義
import { type AuthLayoutProps } from '@/Layouts/AuthLayout/type';
// レイアウトコンポーネント
import AuthLayout from '@/Layouts/AuthLayout/AuthLayout.vue';
// UIコンポーネント
import AnkerButton from '@/Components/atom/button/AnkerButton/AnkerButton.vue';
// ユーティリティ
import { initSnowflakeAnimation } from '@/Utilities/SnowFlakeAnimation';

const props = defineProps<{
  businessId: number;
  staffId: number;
}>();

const canvas = ref<HTMLCanvasElement | null>(null);

onMounted(() => {
  if (canvas.value) {
    initSnowflakeAnimation(canvas.value);
  }
});

// AuthLayoutコンポーネントのプロパティ設定
const authLayoutProps: AuthLayoutProps = {
  isAuthRoute: true,
  title: 'チアペイ',
  header: { role: RouteRoleName.User, text: '投げ銭完了' },
};
</script>

<template>
  <AuthLayout v-bind="authLayoutProps">
    <section class="canvas__background">
      <canvas ref="canvas"></canvas>
    </section>
    <div class="p-user-business-operator-staff-tip-complete">
      <img src="/images/img_thankyou.png" class="p-user-business-operator-staff-tip-complete__image" alt="Thank You" />
      <div class="p-user-business-operator-staff-tip-complete__content">
        <div class="p-user-business-operator-staff-tip-complete__message">
          <p class="p-user-business-operator-staff-tip-complete__message-title">ギフトを送りました</p>
          <p class="p-user-business-operator-staff-tip-complete__message-subtitle">ご利用ありがとうございます</p>
        </div>
        <AnkerButton
          :href="
            route(RouteName.UserBusinessOperatorStaffShow, { staffId: props.staffId, businessId: props.businessId })
          "
          :text="`スタッフページに戻る`"
          class="p-user-business-operator-staff-tip-complete__staff-top-button"
        />
      </div>
    </div>
  </AuthLayout>
</template>

<style lang="scss">
.p-user-business-operator-staff-tip-complete {
  box-shadow: 0 4px 4px rgba(0, 0, 0, 0.05);
  background: #fff;
  margin: 30px;
  padding-bottom: 30px;
  border-radius: 10px;
  opacity: 0.9;

  &__image {
    width: 100%;
  }

  &__message {
    text-align: center;
    font-weight: bold;
    font-size: 20px;
    margin-bottom: 20px;
  }

  & a.c-anker-button.primary.p-user-business-operator-staff-tip-complete__staff-top-button {
    width: 70%;
    margin: 0 auto;
    border-radius: 30px;
  }
}

.canvas__background {
  width: 100%;
  display: block;
  position: relative;
}

canvas {
  position: absolute;
  top: 0;
  left: 0;
  background: #f3f3f3;
  z-index: -2;
}
</style>
