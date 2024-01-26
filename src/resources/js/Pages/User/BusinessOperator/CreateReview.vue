<script lang="ts" setup>
// Vue関連のインポート
import { useForm } from '@inertiajs/vue3';
// ユーティリティ
import { RouteName, RouteRoleName } from '@/Utilities';
// 型定義
import { type AuthLayoutProps } from '@/Layouts/AuthLayout/type';
import { ButtonVariantProp } from '@/Components/atom/button/Button/type';
// レイアウトコンポーネント
import AuthLayout from '@/Layouts/AuthLayout/AuthLayout.vue';
// UIコンポーネント
import FormGroupTextarea from '@/Components/molecules/form/FormGroupTextarea/FormGroupTextarea.vue';
import Link from '@/Components/atom/link/Link/Link.vue';
import Button from '@/Components/atom/button/Button/Button.vue';
import Image from '@/Components/atom/image/Image/Image.vue';

type CreateReviewProps = {
  businessId: number;
  nickname: string;
  userProfileImage: string;
  fileName: string;
  review: string;
};

const props = defineProps<CreateReviewProps>();

const form = useForm({
  review: props.review || '',
});

const onSubmit = (): void => {
  if (form.processing) return;
  form.post(route(RouteName.UserBusinessOperatorStoreReview, { businessId: props.businessId }));
};

// モデルバリューを更新するための関数
const updateReview = (value: string) => {
  form.review = value;
};

// AuthLayoutコンポーネントのプロパティ設定
const authLayoutProps: AuthLayoutProps = {
  isAuthRoute: true,
  title: 'チアペイ',
  header: {
    role: RouteRoleName.User,
    href: RouteName.UserBusinessOperatorShow,
    params: { businessId: props.businessId },
    text: '口コミ投稿',
  },
};
</script>

<template>
  <AuthLayout v-bind="authLayoutProps">
    <div class="p-user-business-operator-create-review">
      <div class="p-user-business-operator-create-review__profile">
        <Image
          class="p-user-business-operator-create-review__profile-image"
          :src="props.userProfileImage ?? '/images/noimage.png'"
          alt="ユーザー画像"
        />
        <p>{{ props.nickname }}</p>
      </div>
      <form @submit.prevent="onSubmit" class="p-user-business-operator-create-review__form">
        <FormGroupTextarea
          id="review"
          label="口コミ"
          placeholder="口コミを入力してください"
          required-type="required"
          description="口コミは最大100文字まで入力できます。"
          :model-value="form.review"
          @update:model-value="updateReview"
          :error="form.errors.review"
          :is-count="true"
          :count-limit="100"
        />
        <p class="p-user-business-operator-create-review__annotation">
          他の人を傷つける恐れのある内容や個人を特定するコメントは固く禁止されております。詳しくは
          <Link :href="RouteName.ReviewGuideLine" text="ガイドライン" />をご確認ください。
        </p>
        <Button
          class="p-user-business-operator-create-review__submit"
          :variant="ButtonVariantProp.Success"
          :disabled="form.processing"
          :is-loading="form.processing"
          loading-text="Uploading"
          text="投稿する"
        />
      </form>
    </div>
  </AuthLayout>
</template>

<style lang="scss">
.p-user-business-operator-create-review {
  padding: 0 10px;
  &__profile {
    display: flex;
    gap: 15px;
    margin: 20px 10px;
    align-items: center;
  }
  &__annotation {
    margin: 20px 0px;
  }
  &__profile-image img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
  }
  &__submit {
    width: 100%;
  }
}
</style>
