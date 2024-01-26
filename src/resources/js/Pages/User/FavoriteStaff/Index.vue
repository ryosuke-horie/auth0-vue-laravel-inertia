<script setup lang="ts">
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
import LoadingModal from '@/Components/atom/loading/LoadingModal/LoadingModal.vue';
// 組織的コンポーネント
import UserStaffListItem from '@/Components/molecules/list/UserStaffListItem/UserStaffListItem.vue';
// API
import { GUESTApi } from '@/api';
import { configuration } from '@/lib/configuration';

// 型定義
type FavoriteStaffListItemProps = {
  UserStaffDetailListItem: UserStaffListItemProps[];
  businessId: number;
  staffId: number;
  favoriteId: number | null;
  staffName: string;
  todayShiftStatus: number;
  staffProfileImages: { image: string; order: number }[];
};

const props = defineProps<{
  staffList: FavoriteStaffListItemProps[];
}>();

// 検索フォームの状態管理
const search = reactive({ staffName: '' });
const searchStaffList = ref<FavoriteStaffListItemProps[]>(props.staffList);
// ローディング状態
const isLoading = ref(false);

// スタッフ名で検索する
const computedStaffList = computed(() => {
  const searchQuery = search.staffName.toLowerCase();
  return searchStaffList.value.filter((staff) => {
    const isMatchStaffName = staff.staffName.toLowerCase().includes(searchQuery);
    return isMatchStaffName;
  });
});

// お気に入りの切り替え
const onToggleFavorite = async (staff: FavoriteStaffListItemProps): Promise<void> => {
  if (isLoading.value) return;
  isLoading.value = true;
  await new GUESTApi(configuration)
    .toggleFavorite(staff.staffId, staff.favoriteId)
    .then((res) => {
      staff.favoriteId = typeof res.data === 'object' ? null : res.data;
      searchStaffList.value = searchStaffList.value.filter((item) => item.favoriteId !== staff.favoriteId);
    })
    .catch((e) => {
      console.error(e);
      alert('予期せぬエラーが発生しました。');
    })
    .finally(() => {
      isLoading.value = false;
    });
};

// AuthLayoutコンポーネントのプロパティ設定
const authLayoutProps: AuthLayoutProps = {
  isAuthRoute: true,
  title: 'チアペイ',
  header: { role: RouteRoleName.User, text: 'お気に入りスタッフ一覧', href: RouteName.UserMypage },
};
</script>

<template>
  <AuthLayout v-bind="authLayoutProps">
    <LoadingModal v-if="isLoading" />
    <div class="p-user-favorite-staff">
      <Heading2 text="キーワードから探す" />
      <Divider />
      <ColorSection>
        <FormInput
          id="search-staff-name"
          type="text"
          v-model="search.staffName"
          class="p-user-favorite-staff__input-search"
        />
      </ColorSection>
      <ul class="p-user-favorite-staff__staff-list">
        <UserStaffListItem
          v-for="(staff, index) in computedStaffList"
          :key="index"
          :href="
            route(RouteName.UserBusinessOperatorStaffShow, { staffId: staff.staffId, businessId: staff.businessId })
          "
          :staff-id="staff.staffId"
          :staff="staff"
          :favorite-id="staff.favoriteId"
          :staff-name="staff.staffName"
          :today-shift-status="staff.todayShiftStatus"
          :images="staff.staffProfileImages"
          @toggle-favorite="onToggleFavorite"
        />
      </ul></div
  ></AuthLayout>
</template>

<style lang="scss">
.p-user-favorite-staff {
  &__input-search {
    background-color: #ffffff;
    width: 100%;
  }
}
</style>
