<script lang="ts" setup>
// Vue関連のインポート
import { defineProps } from 'vue';
// サードパーティライブラリ
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Pagination } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/pagination';
// ユーティリティ
import { RouteName, RouteRoleName } from '@/Utilities';
// 型定義
import type { MypageProps } from './type';
import { type AuthLayoutProps } from '@/Layouts/AuthLayout/type';
import { ButtonVariantProp } from '@/Components/atom/button/Button/type';
// レイアウトコンポーネント
import AuthLayout from '@/Layouts/AuthLayout/AuthLayout.vue';
// UIコンポーネント
import Heading2 from '@/Components/atom/heading/Heading2/Heading2.vue';
import Divider from '@/Components/atom/divider/Divider.vue';
import AnkerButton from '@/Components/atom/button/AnkerButton/AnkerButton.vue';
import Image from '@/Components/atom/image/Image/Image.vue';
import ColorSection from '@/Components/atom/section/ColorSection/ColorSection.vue';
// 組織的コンポーネント
import FavoriteStaffListItem from '@/Components/molecules/list/FavoriteStaffListItem/FavoriteStaffListItem.vue';
import NotificationListItem from '@/Components/molecules/list/NotificationListItem/NotificationListItem.vue';

// Swiperのモジュール設定
const modules = [Pagination];

// ページプロパティの定義
const props = defineProps<MypageProps>();

// AuthLayoutコンポーネントのプロパティ設定
const authLayoutProps: AuthLayoutProps = {
  isAuthRoute: true,
  title: 'チアペイ',
  header: { role: RouteRoleName.User, text: 'マイページ' },
};
</script>

<template>
  <AuthLayout v-bind="authLayoutProps">
    <div class="p-user-mypage" :class="isGuestUser ? 'guest' : 'user'">
      <div class="p-user-mypage__user-info">
        <Image :src="props.userProfileImage ? props.userProfileImage : `/images/noimage.png`" alt="ユーザー画像" />
        <p>{{ props.nickname }} 様</p>
      </div>
      <!-- 会員レイアウト -->
      <ColorSection v-if="!isGuestUser">
        <div class="p-user-mypage__contents__main-content">
          <div class="p-user-mypage__flex__button-group">
            <AnkerButton
              :variant="ButtonVariantProp.Derk"
              icon="fa-solid fa-coins icon"
              :is-outlined="true"
              :href="route(RouteName.UserTips)"
              class="p-user-mypage__button--shadow p-user-mypage__button--top"
              text="ポイント"
            />
            <AnkerButton
              :variant="ButtonVariantProp.Derk"
              icon="fa-solid fa-user icon"
              :is-outlined="true"
              :href="route(RouteName.UserMypage)"
              class="p-user-mypage__button--shadow p-user-mypage__button--top"
              text="会員情報"
            />
          </div>
          <div class="p-user-mypage__flex__button-group">
            <AnkerButton
              :variant="ButtonVariantProp.Derk"
              icon="fa-solid fa-bullhorn icon"
              :is-outlined="true"
              :href="route(RouteName.UserTips)"
              class="p-user-mypage__button--shadow p-user-mypage__button--top"
              text="応援履歴"
            />
            <AnkerButton
              :variant="ButtonVariantProp.Derk"
              icon="fa-solid fa-crown icon"
              :is-outlined="true"
              :href="route(RouteName.UserMypage)"
              class="p-user-mypage__button--shadow p-user-mypage__button--top"
              text="ランキング"
            />
          </div>
        </div>
        <div class="p-user-mypage__anker-button-wrap" v-if="!isGuestUser">
          <AnkerButton
            :variant="ButtonVariantProp.Derk"
            icon="fa-solid fa-shop"
            :is-outlined="true"
            :href="route(RouteName.UserBusinessOperator)"
            class="p-user-mypage__button--shadow"
            text="ショップ一覧"
          />
          <AnkerButton
            :variant="ButtonVariantProp.Warning"
            :href="route(RouteName.UserMypage)"
            class="p-user-mypage__button--point-charge"
            text="ポイントチャージ"
          />
          <!-- 支払い情報はあとで消す -->
          <AnkerButton
            :variant="ButtonVariantProp.Warning"
            :href="route(RouteName.UserPaymentInfoShow)"
            class="p-user-mypage__button--point-charge"
            text="支払い情報"
          />
        </div>
      </ColorSection>

      <div class="p-user-mypage__favorites" v-if="!isGuestUser">
        <Heading2 text="お気に入りスタッフ" />
        <Divider />
        <div class="p-user-mypage__swiper-contents">
          <swiper
            :slides-per-view="3"
            :space-between="30"
            :free-mode="true"
            :pagination="{
              clickable: true,
            }"
            :modules="modules"
            class="mySwiper"
          >
            <swiper-slide v-for="(item, index) in props.favoriteStaff" :key="index">
              <FavoriteStaffListItem
                :href="
                  route(RouteName.UserBusinessOperatorStaffShow, { businessId: item.businessId, staffId: item.staffId })
                "
                :staff-name="item.staffName"
                :staff-profile-images="item.staffProfileImages"
                :business-name="item.businessName"
              />
            </swiper-slide>
            <swiper-slide>Slide 3</swiper-slide><swiper-slide>Slide 5</swiper-slide> <swiper-slide>Slide 6</swiper-slide
            ><swiper-slide>Slide 7</swiper-slide> <swiper-slide>Slide 8</swiper-slide
            ><swiper-slide>Slide 9</swiper-slide>
          </swiper>
        </div>
        <div class="p-user-mypage__favorite-staff-button">
          <AnkerButton
            :href="route(RouteName.UserFavoriteStaff)"
            :variant="ButtonVariantProp.Derk"
            text="お気に入りスタッフ一覧"
          />
        </div>
      </div>

      <!-- ゲストレイアウト -->
      <ColorSection v-if="isGuestUser">
        <div class="p-user-mypage__contents__main-content">
          <div class="p-user-mypage__flex__button-group">
            <AnkerButton
              :variant="ButtonVariantProp.Info"
              :is-outlined="true"
              :href="route(RouteName.UserSignup)"
              class="p-user-mypage__guest-button--shadow p-user-mypage__guest-button--top"
              text="無料会員登録"
            />
            <AnkerButton
              :variant="ButtonVariantProp.Info"
              :is-outlined="true"
              :href="route(RouteName.UserLoginMethod)"
              class="p-user-mypage__guest-button--shadow p-user-mypage__guest-button--top"
              text="ログイン"
            />
          </div>
        </div>
        <div class="p-user-mypage__anker-button-wrap" v-if="isGuestUser">
          <AnkerButton
            :variant="ButtonVariantProp.Derk"
            icon="fa-solid fa-shop"
            :is-outlined="true"
            :href="route(RouteName.UserBusinessOperator)"
            class="p-user-mypage__button--shadow"
            text="ショップ一覧"
          />
        </div>
      </ColorSection>

      <!-- 共通レイアウト -->
      <div class="p-user-mypage__notification">
        <Heading2 text="運営からのお知らせ" />
        <Divider />
        <ul class="p-user-mypage__notification-content">
          <NotificationListItem
            class="p-user-mypage__notification-item"
            v-for="(item, index) of props.notifications"
            :key="item.title + index"
            :is-read="item.isRead"
            :title="item.title"
            :start-at="item.startAt"
            :url="route(RouteName.UserNotificationShow, { id: 1, type: 1 })"
          />
        </ul>
        <div class="p-user-mypage__notification-button">
          <AnkerButton
            :variant="ButtonVariantProp.Derk"
            :href="route(RouteName.UserNotification)"
            text="お知らせ一覧"
          />
        </div>
      </div>
    </div>
  </AuthLayout>
</template>

<style lang="scss">
.p-user-mypage {
  &.guest .p-user-mypage__favorites {
    display: none;
  }

  &__user-info {
    display: flex;
    align-items: center;
    margin: 20px;

    & img {
      width: 50px;
      height: 50px;
      border-radius: 50%;
    }

    & p {
      margin-left: 10px;
      font-weight: bold;
    }
  }

  &__anker-button-wrap {
    display: flex;
    flex-direction: column;
    margin: 10px 20px;
  }

  &__button--point-charge {
    margin-top: 10px;
    box-shadow: 0 4px 4px rgba(0, 0, 0, 0.05);
  }

  &__staff-info {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    margin: 10px 0 0 5px;
  }

  &__staff-name {
    font-size: 14px;
    font-weight: bold;
  }

  &__business-name {
    font-size: 12px;
    color: var(--gray);
  }

  &__notification-button {
    margin-top: 30px;
    padding: 0 20px;
  }

  &__contents__main-content {
    margin: 20px 15px;
  }

  &__flex__button-group {
    display: flex;
    justify-content: space-around;
    margin: 10px 0;
    gap: 10px;
  }

  &__favorite-staff-button {
    margin: 20px;
  }

  .swiper {
    width: 100%;
    height: 100%;

    .swiper-slide {
      text-align: center;
      font-size: 18px;
      background: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      margin-bottom: 40px;

      img {
        width: 100%;
        height: 100%;
        object-fit: cover;
      }
    }
  }
}

.c-anker-button.p-user-mypage {
  &__button--shadow {
    box-shadow: 0 4px 4px rgba(0, 0, 0, 0.05);
    border: none;

    & span i {
      color: #ffeb3b;
    }
  }

  &__button--top {
    height: 70px;
    width: 160px;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
  }

  &__guest-button--top {
    width: 160px;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
  }

  &__guest-button--shadow {
    box-shadow: 0 4px 4px rgba(0, 0, 0, 0.05);

    & span i {
      color: #ffeb3b;
    }
  }
}
</style>
