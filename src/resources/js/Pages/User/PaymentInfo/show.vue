<script lang="ts" setup>
import AuthLayout from '@/Layouts/AuthLayout/AuthLayout.vue';
import { type AuthLayoutProps } from '@/Layouts/AuthLayout/type';
import { RouteRoleName } from '@/Utilities';
import { onMounted, ref } from 'vue';
import { Stripe, loadStripe } from '@stripe/stripe-js';
import Axios from 'axios';
import AnkerButton from '@/Components/atom/button/AnkerButton/AnkerButton.vue';
import { RouteName } from '@/Utilities';

type PaymentMethod = {
  id: string;
  card: {
    brand: string;
    last4: string;
    exp_month: number;
    exp_year: number;
  };
};

const props = defineProps<{
  stripeKey: string;
}>();

const stripe = ref<Stripe | null>(null);

const paymentMethods = ref<PaymentMethod[]>([]);

onMounted(async () => {
  const stripeInstance = await loadStripe(props.stripeKey);

  if (stripeInstance) {
    createPaymentIntent(1000);
    stripe.value = stripeInstance;
    paymentMethods.value = await fetchPaymentMethods();
  } else {
    console.error('Stripeの初期化に失敗しました。。');
  }
});

const createPaymentIntent = async (amount: number) => {
  try {
    await Axios.post('/api/user/payment-info/create-payment-intent', {
      amount,
    });
  } catch (error) {
    console.error('Error creating payment intent:', error);
  }
};

const fetchPaymentMethods = async (): Promise<PaymentMethod[]> => {
  try {
    const response = await Axios.post('/api/user/payment-info/get-payment-methods');
    return response.data as PaymentMethod[];
  } catch (error) {
    console.error('Error fetching payment methods:', error);
    return [];
  }
};

const deletePaymentMethod = async (paymentMethodId: string) => {
  try {
    await Axios.post('/api/user/payment-info/delete-payment-method', {
      paymentMethodId,
    });
    paymentMethods.value = await fetchPaymentMethods();
  } catch (error) {
    console.error('Error deleting payment method:', error);
  }
};

const authLayoutProps: AuthLayoutProps = {
  isAuthRoute: true,
  title: 'チアペイ',
  header: {
    role: RouteRoleName.User,
    text: '支払い情報詳細',
    href: RouteName.UserMypage,
  },
};
</script>

<template>
  <AuthLayout v-bind="authLayoutProps">
    <div v-if="paymentMethods.length > 0">
      <div v-for="method in paymentMethods" :key="method.id">
        <p>ブランド: {{ method.card.brand }}</p>
        <!-- 名前が取れないので、カード番号4桁表示 -->
        <p>カード情報: **** **** **** {{ method.card.last4 }}</p>
        <p>有効期限: {{ method.card.exp_month }} / {{ method.card.exp_year }}</p>
        <button @click="deletePaymentMethod(method.id)">削除</button>
      </div>
    </div>
    <div v-else>
      <AnkerButton text="カード登録" :href="route(RouteName.UserPaymentInfoCreate)" />
    </div>
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
