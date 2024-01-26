<script lang="ts" setup>
import { router } from '@inertiajs/vue3';
import AuthLayout from '@/Layouts/AuthLayout/AuthLayout.vue';
import { type AuthLayoutProps } from '@/Layouts/AuthLayout/type';
import { RouteName, RouteRoleName } from '@/Utilities';
import { onMounted, ref } from 'vue';
import { Stripe, loadStripe, StripeElements } from '@stripe/stripe-js';
import Axios from 'axios';

const props = defineProps<{
  stripeKey: string;
}>();

const stripe = ref<Stripe | null>(null);
const elements = ref<StripeElements | null>(null);

onMounted(async () => {
  const stripeInstance = await loadStripe(props.stripeKey); // Stripeインスタンスを初期化

  console.log(stripeInstance);
  if (stripeInstance) {
    stripe.value = stripeInstance;

    // Stripe Elementsの外観を定義するオブジェクト
    const appearance = {
      // 外観に関する設定をここで行います
    };

    elements.value = stripe.value.elements({ appearance }); // Stripe Elementsを初期化

    // 'card'タイプのStripe Elementを作成し、ページにマウントする
    // 郵便番号は表示しない
    const cardElement = elements.value.create('card', { hidePostalCode: true });
    cardElement.mount('#card-element');
  } else {
    console.error('Stripeの初期化に失敗しました。。');
  }
});

// フォームの送信を処理する関数
const handleSubmit = async (e: Event) => {
  e.preventDefault();
  if (!stripe.value || !elements.value) {
    console.error('Stripeのインスタンスが初期化されていません。');
    return;
  }

  const cardElement = elements.value.getElement('card');
  if (!cardElement) {
    console.error('カードエレメントが見つかりません。');
    return;
  }

  const { error, token } = await stripe.value.createToken(cardElement);

  if (error) {
    console.error('Stripeトークンの作成に失敗しました:', error);
  } else {
    try {
      router.post(
        route('user.payment-info.confirm', {
          token: token.id,
          brand: token.card?.brand,
          last4: token.card?.last4,
        }),
      );
    } catch (error) {
      // エラー発生時の処理
      if (Axios.isAxiosError(error)) {
        const axiosError = error;
        if (axiosError.response) {
          console.error('Error response:', axiosError.response.data);
        } else {
          console.error('Error:', axiosError.message);
        }
      } else {
        console.error('Unexpected error:', error);
      }
    }
  }
};

const authLayoutProps: AuthLayoutProps = {
  isAuthRoute: true,
  title: 'チアペイ',
  header: {
    role: RouteRoleName.User,
    text: '支払い情報登録',
    href: RouteName.UserPaymentInfoShow,
  },
};
</script>

<template>
  <AuthLayout v-bind="authLayoutProps">
    <form id="payment-form" @submit.prevent="handleSubmit">
      <div id="card-element"></div>
      <button type="submit">確認</button>
    </form>
  </AuthLayout>
</template>

<style lang="scss">
.p-user-mypage {
  &__notification-button {
    margin-top: 30px;
    padding: 0 20px;
  }
}
</style>
