<script lang="ts" setup>
// Vue関連のインポート
import { defineProps, ref, reactive, computed } from 'vue';
import { Link as staffLink } from '@inertiajs/vue3';
// サードパーティライブラリ
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Pagination } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/pagination';
// ユーティリティ
import { RouteName, RouteRoleName } from '@/Utilities';
// 型定義
import { type AuthLayoutProps } from '@/Layouts/AuthLayout/type';
import { ButtonVariantProp } from '@/Components/atom/button/Button/type';
// レイアウトコンポーネント
import AuthLayout from '@/Layouts/AuthLayout/AuthLayout.vue';
// UIコンポーネント
import Divider from '@/Components/atom/divider/Divider.vue';
import Heading2 from '@/Components/atom/heading/Heading2/Heading2.vue';
import AnkerButton from '@/Components/atom/button/AnkerButton/AnkerButton.vue';
import Link from '@/Components/atom/link/Link/Link.vue';
import Paragraph from '@/Components/_lp/Paragraph/Paragraph.vue';
import Image from '@/Components/atom/image/Image/Image.vue';
import LoadingModal from '@/Components/atom/loading/LoadingModal/LoadingModal.vue';
// 組織的コンポーネント
import { Prefecture } from '@/Enums/Prefecture';
// API
import { GUESTApi } from '@/api';
import { configuration } from '@/lib/configuration';

// 都道府県名を取得
function getPrefectureNameByValue(value: number): string | undefined {
  const entries = Object.entries(Prefecture) as [string, Prefecture][];
  for (const entry of entries) {
    const prefecture = entry[1];
    if (prefecture.value === value) {
      return prefecture.name;
    }
  }
  return undefined;
}

// Swiperのモジュール設定
const modules = [Pagination];

// 型定義
type BusinessOperatorItemProps = {
  businessName: string;
  businessDescription: string;
  city: string;
  prefCode: string;
  businessForm: string;
  images: { image: string; order: number }[];
};

type BusinessOperatorStaffListItemProps = {
  staffId: number;
  staffName: string;
  images: { image: string; order: number }[];
};

type BusinessReviewListItemProps = {
  reviewId: number;
  userId: number;
  nickname: string;
  comment: string;
  createdAgo: string;
  userProfileImage: string;
};

const props = defineProps<{
  businessId: number;
  userId: number;
  businessOperator: BusinessOperatorItemProps;
  staff: BusinessOperatorStaffListItemProps[];
  businessReviews: BusinessReviewListItemProps[];
}>();

// 口コミ用処理
const localReviews = ref([...props.businessReviews]);
const displayedReviewCount = ref(3);
const isLoading = ref(false);
const selectReviewId = ref<number | null>(null);
const showFullComment: Record<number, boolean> = reactive({});

// 表示する口コミの数
function showMoreReviews() {
  displayedReviewCount.value += 3;
}

// 表示する口コミの数をリセット
function resetReviews() {
  displayedReviewCount.value = 3;
}

// 「続きを読む」「一部表示」の切り替え
function toggleComment(index: number) {
  if (showFullComment[index]) {
    showFullComment[index] = false;
  } else {
    showFullComment[index] = true;
  }
}

// 表示する口コミ
const displayedReviews = computed(() => {
  return localReviews.value.slice(0, displayedReviewCount.value);
});

// 3件以上の口コミがあれば「もっと見る」ボタンを表示
const showMoreButton = computed(() => {
  return localReviews.value.length > displayedReviewCount.value;
});

// 削除ボタン押下時に口コミIDをセット
const setSelectReviewId = (val: number | null): void => {
  selectReviewId.value = val;
};

// 口コミ削除
const onDeleteReview = async (reviewId: number): Promise<void> => {
  if (!selectReviewId.value) return;
  if (isLoading.value) return;
  isLoading.value = true;
  await new GUESTApi(configuration)
    .deleteReviewId(props.businessId, reviewId)
    .then(() => {
      localReviews.value = localReviews.value.filter((review) => review.reviewId !== reviewId);
    })
    .catch((e) => {
      console.error(e);
      alert('予期せぬエラーが発生しました。');
    })
    .finally(() => {
      setSelectReviewId(null);
      isLoading.value = false;
    });
};

// AuthLayoutコンポーネントのプロパティ設定
const authLayoutProps: AuthLayoutProps = {
  isAuthRoute: true,
  title: 'チアペイ',
  header: { role: RouteRoleName.User, href: RouteName.UserBusinessOperator, text: '事業者詳細' },
};
</script>

<template>
  <AuthLayout v-bind="authLayoutProps">
    <LoadingModal v-if="isLoading" />
    <div class="p-user-business-operator-show">
      <!-- 事業者プロフィール -->
      <div class="p-user-business-operator-show__swiper-business-contents">
        <swiper
          :space-between="30"
          :free-mode="true"
          :pagination="{
            clickable: true,
          }"
          :modules="modules"
          class="mySwiper"
        >
          <swiper-slide v-for="(image, index) in props.businessOperator.images" :key="index">
            <img
              class="p-user-business-operator-show__shop-image"
              :src="image.image ?? '/images/noimage.png'"
              :alt="`Image ${index}`"
            />
          </swiper-slide>
        </swiper>
      </div>
      <div class="p-user-business-operator-show__shop-contents">
        <div class="p-user-business-operator-show__location-business-container">
          <p class="p-user-business-operator-show__prefecture">
            {{ getPrefectureNameByValue(Number(props.businessOperator.prefCode)) }}
          </p>
          <p class="p-user-business-operator-show__business-form">{{ props.businessOperator.businessForm }}</p>
        </div>
        <p class="p-user-business-operator-show__business-name">{{ props.businessOperator.businessName }}</p>

        <div
          v-if="props.businessOperator.businessDescription"
          class="p-user-business-operator-show__business-description"
        >
          <Divider />
          <p>
            {{ props.businessOperator.businessDescription }}
          </p>
        </div>
      </div>

      <Divider />
      <Heading2 text="スタッフ" />
      <Divider />

      <!-- 所属スタッフ -->
      <div class="p-user-business-operator-show__swiper-staff-contents">
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
          <swiper-slide v-for="(staffMember, index) in props.staff" :key="index">
            <staffLink
              :href="
                route(RouteName.UserBusinessOperatorStaffShow, {
                  businessId: props.businessId,
                  staffId: staffMember.staffId,
                })
              "
            >
              <Image
                :src="staffMember.images[0].image ?? '/images/noimage.png'"
                :alt="`Image of ${staffMember.staffName}`"
                :width="115"
                :height="130"
              />
              <p class="p-user-business-operator-show__staff-name">{{ staffMember.staffName }}</p>
            </staffLink>
          </swiper-slide>
          <swiper-slide>Slide 3</swiper-slide><swiper-slide>Slide 5</swiper-slide> <swiper-slide>Slide 6</swiper-slide
          ><swiper-slide>Slide 7</swiper-slide> <swiper-slide>Slide 8</swiper-slide><swiper-slide>Slide 9</swiper-slide>
        </swiper>
        <AnkerButton
          :variant="ButtonVariantProp.Derk"
          class="p-user-business-operator-show__staff-button"
          :href="route(RouteName.UserBusinessOperatorStaff, { businessId: props.businessId })"
          text="在籍スタッフ一覧"
        />
      </div>

      <Divider />
      <Heading2 text="応援メッセージ" />
      <Divider />

      <!-- 口コミ -->
      <div class="p-user-business-operator-show__review" v-if="props.businessReviews">
        <div
          class="p-user-business-operator-show__review-item"
          v-for="(review, index) in displayedReviews"
          :key="index"
        >
          <img
            class="p-user-business-operator-show__review-image"
            :src="review.userProfileImage ?? '/images/noimage.png'"
            :alt="`Image of ${review.nickname}`"
          />
          <div class="p-user-business-operator-show__review-content">
            <div class="p-user-business-operator-show__review-info">
              <p class="p-user-business-operator-show__review-nickname">{{ review.nickname }}</p>
              <p class="p-user-business-operator-show__review-time">（{{ review.createdAgo }}）</p>
            </div>
            <div class="p-user-business-operator-show__review-comment">
              <p v-if="!showFullComment[index]">
                {{ review.comment.slice(0, 50) }}<span v-if="review.comment.length > 50">... </span>
                <button v-if="review.comment.length > 50" @click="toggleComment(index)">▽続きを読む</button>
              </p>
              <p v-else>
                {{ review.comment }}
                <button @click="toggleComment(index)">△一部表示</button>
              </p>
            </div>
            <button
              v-if="props.userId === review.userId"
              class="p-user-business-operator-show__review-delete-button"
              @click="setSelectReviewId(review.reviewId)"
            >
              削除
            </button>
          </div>
        </div>
        <div class="p-user-business-operator-show__review-more-button">
          <button v-if="showMoreButton" @click="showMoreReviews">－もっと見る－</button>
        </div>
        <div class="p-user-business-operator-show__review-reset-button">
          <button v-if="displayedReviewCount > 3" @click="resetReviews">－元に戻す－</button>
        </div>
      </div>
      <AnkerButton
        :variant="ButtonVariantProp.Success"
        class="p-user-business-operator-show__review-button"
        :href="route(RouteName.UserBusinessOperatorCreateReview, { businessId })"
        text="口コミを送る"
      />
      <Link
        class="p-user-business-operator-show__review-link"
        :href="RouteName.ReviewGuideLine"
        text="口コミに関するガイドライン"
      />

      <Divider />
      <Heading2 text="基本情報" />
      <Divider />

      <!-- 基本情報 -->
      <div class="p-user-business-operator-show__shop-info">
        <div class="p-user-business-operator-show__shop-info-item">
          <b class="p-user-business-operator-show__shop-info-title">住所</b>
          <p class="p-user-business-operator-show__shop-info-content">
            {{ getPrefectureNameByValue(Number(props.businessOperator.prefCode)) }}{{ props.businessOperator.city }}
          </p>
        </div>
        <Divider />
      </div>

      <!-- 削除確認モーダル -->
      <div class="p-user-business-operator-show__modal" v-if="selectReviewId">
        <div class="p-user-business-operator-show__modal-overlay" @click="setSelectReviewId(null)" />
        <div class="p-user-business-operator-show__modal-content">
          <Paragraph class="p-user-business-operator-show__modal-content-text"> 口コミを削除しますか？ </Paragraph>
          <div class="p-user-business-operator-show__modal-content-button">
            <button
              class="p-user-business-operator-show__modal-content-button-ok"
              @click="onDeleteReview(selectReviewId)"
            >
              はい
            </button>
            <button class="p-user-business-operator-show__modal-content-button-cancel" @click="setSelectReviewId(null)">
              いいえ
            </button>
          </div>
        </div>
      </div>
    </div>
  </AuthLayout>
</template>

<style lang="scss">
.p-user-business-operator-show {
  &__input-search {
    background-color: #ffffff;
    width: 100%;
  }
  &__shop-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
  }
  &__shop-contents {
    margin: 5px 20px 21px 20px;
  }
  &__location-business-container {
    display: flex;
  }
  &__prefecture {
    margin-right: 10px;
  }
  &__business-name {
    font-size: 25px;
    margin-bottom: 10px;
  }
  &__business-description p {
    margin-top: 20px;
    font-weight: bold;
  }
  &__swiper-staff-contents .swiper {
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
  &__staff-name {
    color: var(--black);
  }
  &__staff-button {
    margin: 10px 20px 40px 20px;
  }
  &__review-button {
    margin: 20px;
  }
  &__review-delete-button {
    color: var(--red);
  }
  &__review-more-button {
    text-align: center;
    font-size: 13px;
  }
  &__review-reset-button {
    text-align: center;
    font-size: 13px;
  }
  &__review-link {
    margin-left: 40%;
    margin-bottom: 20px;
  }
  &__review-image {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 50%;
    margin-right: 10px;
  }
  &__review-item {
    display: flex;
    padding: 20px;
    font-size: 13px;
  }
  &__review-info {
    display: flex;
  }
  &__shop-info-item {
    display: flex;
    margin: 10px 20px;
  }
  &__shop-info-title {
    margin-right: 100px;
  }
  &__modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9;
    background-color: rgba(0, 0, 0, 0.5);
    &-content {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 260px;
      border-radius: 10px;
      box-shadow: 0px 0px 10px 0px #00000050;
      background-color: var(--white);
      &-text {
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        height: 120px;
        border-bottom: 0.2px solid #d9d9d9;
      }
      &-button {
        display: flex;
        width: 100%;
        height: 80px;
        &-ok {
          border-right: 0.2px solid #d9d9d9;
        }
        &-ok,
        &-cancel {
          cursor: pointer;
          display: block;
          width: 100%;
          height: 100%;
          &:hover {
            background-color: #d9d9d9;
          }
        }
      }
    }
  }
}
</style>
