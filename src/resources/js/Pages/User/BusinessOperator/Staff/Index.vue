<script lang="ts" setup>
// Vue関連のインポート
import { defineProps, ref, reactive, computed } from 'vue';
// ユーティリティ
import { RouteName, RouteRoleName } from '@/Utilities';
// 型定義
import { type AuthLayoutProps } from '@/Layouts/AuthLayout/type';
import { type UserStaffListItemProps } from '@/Components/molecules/list/UserStaffListItem/type';
// レイアウトコンポーネント
import AuthLayout from '@/Layouts/AuthLayout/AuthLayout.vue';
// UIコンポーネント
import Divider from '@/Components/atom/divider/Divider.vue';
import FormInput from '@/Components/atom/form/FormInput/FormInput.vue';
import Heading2 from '@/Components/atom/heading/Heading2/Heading2.vue';
import ColorSection from '@/Components/atom/section/ColorSection/ColorSection.vue';
// 組織的コンポーネント
import UserStaffListItem from '@/Components/molecules/list/UserStaffListItem/UserStaffListItem.vue';
// API
import { GUESTApi } from '@/api';
import { configuration } from '@/lib/configuration';

// 型宣言
type BusinessOperatorStaffListItemProps = {
  UserStaffDetailListItem: UserStaffListItemProps[];
  businessId: number;
  staffId: number;
  favoriteId: number | null;
  staffName: string;
  todayShiftStatus: number;
  images: { image: string; order: number }[];
};

const props = defineProps<{
  businessId: number;
  staffList: BusinessOperatorStaffListItemProps[];
}>();

// お気に入りの切り替え
const onToggleFavorite = async (staff: BusinessOperatorStaffListItemProps): Promise<void> => {
  await new GUESTApi(configuration)
    .toggleFavorite(staff.staffId, staff.favoriteId)
    .then((res) => {
      staff.favoriteId = typeof res.data === 'object' ? null : res.data;
    })
    .catch((e) => {
      console.error(e);
      alert('予期せぬエラーが発生しました。');
    });
};

// 検索フォームの状態管理
const search = reactive({ staffName: '' });
const searchStaffList = ref<BusinessOperatorStaffListItemProps[]>(props.staffList);

// スタッフ名で検索する
const computedStaffList = computed(() => {
  const searchQuery = search.staffName.toLowerCase();
  return searchStaffList.value.filter((staff) => {
    const isMatchStaffName = staff.staffName.toLowerCase().includes(searchQuery);
    return isMatchStaffName;
  });
});

// AuthLayoutコンポーネントのプロパティ設定
const authLayoutProps: AuthLayoutProps = {
  isAuthRoute: true,
  title: 'チアペイ',
  header: {
    role: RouteRoleName.User,
    href: RouteName.UserBusinessOperatorShow,
    params: { businessId: props.businessId },
    text: 'スタッフ一覧',
  },
};
</script>

<template>
  <AuthLayout v-bind="authLayoutProps">
    <div class="p-user-business-operator-staff">
      <Heading2 text="キーワードから探す" />
      <Divider />
      <ColorSection>
        <FormInput
          id="search-staff-name"
          type="text"
          v-model="search.staffName"
          class="p-user-business-operator-staff__input-search"
        />
      </ColorSection>
      <ul class="p-user-business-operator-staff__staff-list">
        <UserStaffListItem
          v-for="(staff, index) in computedStaffList"
          :key="index"
          :href="
            route(RouteName.UserBusinessOperatorStaffShow, { staffId: staff.staffId, businessId: props.businessId })
          "
          :staff-id="staff.staffId"
          :staff="staff"
          :favorite-id="staff.favoriteId"
          :staff-name="staff.staffName"
          :today-shift-status="staff.todayShiftStatus"
          :images="staff.images"
          @toggle-favorite="onToggleFavorite"
        />
      </ul>
    </div>
  </AuthLayout>
</template>

<style lang="scss">
.p-user-business-operator-staff {
  &__input-search {
    background-color: #ffffff;
    width: 100%;
  }
}
</style>
