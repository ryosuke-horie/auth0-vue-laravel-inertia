<script lang="ts" setup>
// Vue関連のインポート
import { defineProps, ref, reactive, computed } from 'vue';
// ユーティリティ
import { RouteName, RouteRoleName } from '@/Utilities';
// 型定義
import { type AuthLayoutProps } from '@/Layouts/AuthLayout/type';
// レイアウトコンポーネント
import AuthLayout from '@/Layouts/AuthLayout/AuthLayout.vue';
// UIコンポーネント
import ColorSection from '@/Components/atom/section/ColorSection/ColorSection.vue';
import FormInput from '@/Components/atom/form/FormInput/FormInput.vue';
import Heading2 from '@/Components/atom/heading/Heading2/Heading2.vue';
import Divider from '@/Components/atom/divider/Divider.vue';
// 組織的コンポーネント
import BusinessOperatorListItem from '@/Components/molecules/list/BusinessOperatorListItem/BusinessOperatorListItem.vue';

// 型定義
type BusinessOperatorListItemProps = {
  businessId: number;
  businessName: string;
  city: string;
  businessOperatorImages: { image: string; order: number }[];
};

const props = defineProps<{
  businessList: BusinessOperatorListItemProps[];
}>();

// AuthLayoutコンポーネントのプロパティ設定
const authLayoutProps: AuthLayoutProps = {
  isAuthRoute: true,
  title: 'チアペイ',
  header: { role: RouteRoleName.User, href: RouteName.UserMypage, text: '事業者一覧' },
};

// 検索フォームの状態管理
const search = reactive({ businessName: '', businessCity: '' });
const businessList = ref<BusinessOperatorListItemProps[]>(props.businessList);

// 住所と事業者名で検索する
const computedBusinessList = computed(() => {
  const searchQuery = search.businessName.toLowerCase();
  return businessList.value.filter((business) => {
    const isMatchBusinessName = business.businessName.toLowerCase().includes(searchQuery);
    const isMatchCity = business.city.toLowerCase().includes(searchQuery);
    return isMatchBusinessName || isMatchCity;
  });
});
</script>

<template>
  <AuthLayout v-bind="authLayoutProps">
    <div class="p-user-business-operator">
      <Heading2 text="キーワードから探す" />
      <Divider />
      <ColorSection>
        <FormInput
          id="search-business-name"
          type="text"
          v-model="search.businessName"
          class="p-user-business-operator__input-search"
        />
      </ColorSection>
      <ul class="p-user-business-operator__shop-list">
        <BusinessOperatorListItem
          v-for="(item, index) of computedBusinessList"
          :key="index"
          :id="item.businessId"
          :image="item.businessOperatorImages[0].image ?? '/images/noimage.png'"
          :city="item.city"
          :name="item.businessName"
          :href="route(RouteName.UserBusinessOperatorShow, { businessId: item.businessId })"
        />
      </ul>
    </div>
  </AuthLayout>
</template>

<style lang="scss">
.p-user-business-operator {
  &__input-search {
    background-color: #ffffff;
    width: 100%;
  }
}
</style>
