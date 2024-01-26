<script lang="ts" setup>
import AuthLayout from '@/Layouts/AuthLayout/AuthLayout.vue';
import { type AuthLayoutProps } from '@/Layouts/AuthLayout/type';
import { RouteRoleName } from '@/Utilities';
import { onMounted, ref, Ref } from 'vue';
import { Stripe, loadStripe, StripeElements } from '@stripe/stripe-js';
import Axios from 'axios';
import { RouteName } from '@/Utilities';
import { router } from '@inertiajs/vue3';

const props = defineProps<{
  stripeKey: string;
  token: string;
  brand: string;
  last4: string;
}>();

const stripe: Ref<Stripe | null> = ref(null);
const elements = ref<StripeElements | null>(null);

onMounted(async () => {
  const stripeInstance = await loadStripe(props.stripeKey);

  if (stripeInstance) {
    stripe.value = stripeInstance;

    // Stripe Elementsの外観を定義するオブジェクト
    const appearance = {
      // 外観に関する設定をここで行います
    };

    elements.value = stripe.value.elements({ appearance }); // Stripe Elementsを初期化

    // 'card'タイプのStripe Elementを作成し、ページにマウントする
    // 郵便番号は表示しない
    elements.value.create('card', { hidePostalCode: true });
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

  try {
    //登録処理
    const result = await Axios.post('/api/user/payment-info/register-payment-method', {
      token: props.token,
    });

    if (result.data) {
      //登録成功
      console.log('登録成功');
      router.get(route('user.payment-info.show'));
    } else {
      //登録失敗
      console.log('登録失敗');
    }
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
      console.log('Unexpected error:', error);
    }
  }
};

const authLayoutProps: AuthLayoutProps = {
  isAuthRoute: true,
  title: 'チアペイ',
  header: {
    role: RouteRoleName.User,
    text: '支払い情報確認',
    href: RouteName.UserPaymentInfoShow,
  },
};
</script>

<template>
  <AuthLayout v-bind="authLayoutProps">
    <div>{{ props.brand }}</div>
    <div>**** **** **** {{ props.last4 }}</div>
    <form id="payment-form" @submit.prevent="handleSubmit">
      <button type="submit">カードを登録</button>
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
