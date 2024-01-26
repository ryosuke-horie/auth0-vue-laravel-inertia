<script lang="ts" setup>
// Vue関連のインポート
import { ref } from 'vue';
import { useForm, Link } from '@inertiajs/vue3';
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
import Button from '@/Components/atom/button/Button/Button.vue';
import ColorSection from '@/Components/atom/section/ColorSection/ColorSection.vue';
import FormGroupTextarea from '@/Components/molecules/form/FormGroupTextarea/FormGroupTextarea.vue';
import MessageFixPhraseButton from '@/Components/organizms/message/MessageFixPhraseButton/MessageFixPhraseButton.vue';
import MessageChatGPTButtonForUser from '@/Components/organizms/message/MessageChatGPTButtonForUser/MessageChatGPTButtonForUser.vue';
import Paragraph from '@/Components/atom/typograph/Paragraph/Paragraph.vue';
import LinkGuidLine from '@/Components/atom/link/Link/Link.vue';
import AnkerButton from '@/Components/atom/button/AnkerButton/AnkerButton.vue';
// API
import { GUESTApi } from '@/api';
import { configuration } from '@/lib/configuration';

const props = defineProps<{
  aiCount: number;
  totalPoints: number;
  staffId: number;
  staffName: string;
  comment: string;
  images: { image: string; order: number }[];
  businessId: number;
  businessName: string;
  businessSettings: { amount: number }[];
  favoriteId: number;
  userLikeId: number;
  userLikeCount: number;
}>();

type formProps = {
  message: string;
  amount: number;
};

const form = useForm<formProps>({
  message: '',
  amount: 0,
});

// Swiperのモジュール設定
const modules = [Pagination];

const showModal = ref(false);
const selectedButtonIndex = ref(-1);
const selectedAmount = ref(0); // 選択された金額を追跡
// const limit = ref(props.aiCount);
const favoriteId = ref<number | null>(props.favoriteId);
const userLikeId = ref<number | null>(props.userLikeId);
const userLikeCount = ref<number>(props.userLikeCount);

// 投げ銭金額選択ボタン
const selectButton = (index: number) => {
  selectedButtonIndex.value = index;
  selectedAmount.value = props.businessSettings[index].amount; // 金額を更新
};

const setFormMessage = (message: string): void => {
  form.message = message;
};

const onSubmit = (): void => {
  // ポイントが足りない場合はモーダルを表示
  if (selectedAmount.value > props.totalPoints) {
    showModal.value = true;
    return;
  }

  // フォームデータに金額を追加
  // form.message = form.message;
  form.amount = selectedAmount.value;

  form.post(
    route(RouteName.UserBusinessOperatorStaffUserTipStore, {
      businessId: props.businessId,
      staffId: props.staffId,
    }),
    {
      onSuccess: () => {
        form.reset();
      },
    },
  );
};

// お気に入りの切り替え
const onToggleFavorite = async (e: Event, staffId: number): Promise<void> => {
  await new GUESTApi(configuration)
    .toggleFavorite(staffId, favoriteId.value)
    .then((res) => {
      favoriteId.value = typeof res.data === 'object' ? null : res.data;
    })
    .catch((e) => {
      console.error(e);
      alert('予期せぬエラーが発生しました。');
    });
};

// いいね切り替え
const onToggleUserLike = async (e: Event, staffId: number): Promise<void> => {
  await new GUESTApi(configuration)
    .toggleUserLike(staffId, userLikeId.value)
    .then((res) => {
      console.log(res.data);
      userLikeCount.value = typeof res.data === 'object' ? userLikeCount.value - 1 : userLikeCount.value + 1;
      userLikeId.value = typeof res.data === 'object' ? null : res.data;
    })
    .catch((e) => {
      console.error(e);
      alert('予期せぬエラーが発生しました。');
    });
};

// AuthLayoutコンポーネントのプロパティ設定
const authLayoutProps: AuthLayoutProps = {
  isAuthRoute: true,
  title: 'チアペイ',
  header: {
    role: RouteRoleName.User,
    href: RouteName.UserBusinessOperatorShow,
    params: { businessId: props.businessId },
    text: 'スタッフ応援',
  },
};
</script>

<template>
  <AuthLayout v-bind="authLayoutProps">
    <div class="p-user-business-operator-staff-show">
      <div class="p-user-business-operator-staff-show__swiper-staff-contants">
        <swiper
          :space-between="30"
          :free-mode="true"
          :pagination="{
            clickable: true,
          }"
          :modules="modules"
          class="mySwiper"
        >
          <swiper-slide v-for="(image, index) in props.images" :key="index">
            <img class="p-user-business-operator-staff-show__staff-image" :src="image.image" :alt="`Image ${index}`" />
          </swiper-slide>
          <div class="p-user-business-operator-staff-show__icons">
            <!-- お気に入りアイコン -->
            <div class="p-user-business-operator-staff-show__icon-container">
              <p
                v-if="favoriteId"
                @click="(e) => onToggleFavorite(e, props.staffId)"
                class="p-user-business-operator-staff-show__icon"
              >
                <i class="fa-solid fa-star"></i>
              </p>
              <p
                v-else
                @click="(e) => onToggleFavorite(e, props.staffId)"
                class="p-user-business-operator-staff-show__icon p-user-business-operator-staff-show__icon--inactive"
              >
                <i class="fa-regular fa-star"></i>
              </p>
            </div>

            <!-- いいねアイコン -->
            <div class="p-user-business-operator-staff-show__like-container">
              <p
                v-if="userLikeId"
                @click="(e) => onToggleUserLike(e, props.staffId)"
                class="p-user-business-operator-staff-show__like"
              >
                <i class="fa-solid fa-thumbs-up"></i>
                <span class="p-user-business-operator-staff-show__like-count">{{ userLikeCount }}</span>
              </p>
              <p
                v-else
                @click="(e) => onToggleUserLike(e, props.staffId)"
                class="p-user-business-operator-staff-show__like p-user-business-operator-staff-show__like--inactive"
              >
                <i class="fa-regular fa-thumbs-up"></i>
                <span class="p-user-business-operator-staff-show__like-count">{{ userLikeCount }}</span>
              </p>
            </div>
          </div>
        </swiper>
      </div>
      <div class="p-user-business-operator-staff-show__staff-contents">
        <p class="p-user-business-operator-staff-show__staff-name">{{ props.staffName }}</p>

        <div v-if="props.comment" class="p-user-business-operator-staff-show__staff-comment">
          <Divider />
          <p>
            {{ props.comment }}
          </p>
        </div>
      </div>

      <Divider />
      <Heading2 class="p-user-business-operator-staff-show__gift-title" text="ギフトを選ぶ" />
      <Divider />

      <ColorSection class="p-user-business-operator-staff-show__form">
        <div class="p-user-business-operator-staff-show__gift-contents">
          <p class="p-user-business-operator-staff-show__gift-text">
            ＼ <span>送るポイントを選択してスタッフを応援</span> ／
          </p>
          <div
            v-for="(amount, index) in props.businessSettings"
            :key="index"
            class="p-user-business-operator-staff-show__gift-button-wrapper"
          >
            <Button
              class="p-user-business-operator-staff-show__gift-button--shadow"
              :class="{ selected: index === selectedButtonIndex }"
              :text="`${amount.amount}pt`"
              :icon="`fa-solid fa-coins`"
              :variant="ButtonVariantProp.Derk"
              :is-outlined="true"
              @click="selectButton(index)"
            />
          </div>
        </div>
        <div v-if="form.errors.amount" class="p-user-business-operator-staff-show__form-error">
          {{ form.errors.amount }}
        </div>
      </ColorSection>

      <Divider />
      <Heading2 class="p-user-business-operator-staff-show__cheer-title" text="応援メッセージ" />
      <Divider />

      <ColorSection class="p-user-business-operator-staff-show__form">
        <FormGroupTextarea
          id="message"
          class="p-user-business-operator-staff-show__textarea"
          placeholder="メッセージを送ってスタッフを応援しよう！"
          v-model="form.message"
          :error="form.errors.message"
          :is-count="true"
          :count-limit="200"
        />
        <MessageFixPhraseButton class="p-user-business-operator-staff-show__fix-phrase" @click="setFormMessage" />
        <MessageChatGPTButtonForUser
          class="p-user-business-operator-staff-show__ai"
          :staff-id="props.staffId"
          @click="
            (data) => {
              setFormMessage(data.message);
            }
          "
        />
        <Paragraph class="p-user-business-operator-staff-show__message">
          他の人を傷つける恐れのある内容や個人を特定す るコメントは固く禁止されております。 詳しくは
          <LinkGuidLine text="ガイドライン" :href="RouteName.StaffMyPage" />
          をご確認ください。
        </Paragraph>
        <Button
          class="p-user-business-operator-staff-show__submit-button"
          @click="onSubmit"
          text="送信する"
          :is-loading="form.processing"
        />
      </ColorSection>
      <div class="p-user-business-operator-staff-show__user-points">
        <Paragraph class="p-user-business-operator-staff-show__user-points-text">
          <span class="p-user-business-operator-staff-show__points-label">保有ポイント</span>
          <div class="p-user-business-operator-staff-show__points-value-wrapper">
            <i class="fa-brands fa-product-hunt p-user-business-operator-staff-show__points-icon"></i>
            <span class="p-user-business-operator-staff-show__points-value">{{ props.totalPoints }}</span>
          </div>
        </Paragraph>
        <Link :href="route(RouteName.UserBusinessOperator)" class="p-user-business-operator-staff-show__purchase-link">
          <i class="fa-solid fa-sack-dollar p-user-business-operator-staff-show__purchase-icon"></i>
          <span class="p-user-business-operator-staff-show__purchase-text">ポイント購入</span>
        </Link>
      </div>

      <!-- ポイント不足モーダル -->
      <div v-if="showModal" class="p-user-business-operator-staff-show__modal" @click="showModal = false">
        <div class="p-user-business-operator-staff-show__modal-content" @click.stop>
          <p class="p-user-business-operator-staff-show__modal-message">CPが不足しています。</p>
          <div class="p-user-business-operator-staff-show__modal-details">
            <p class="p-user-business-operator-staff-show__modal-details-label">必要CP</p>
            <p class="p-user-business-operator-staff-show__modal-details-value">
              {{ selectedAmount - props.totalPoints }}
            </p>
          </div>
          <Divider />
          <p class="p-user-business-operator-staff-show__modal-add-value">CPを購入しますか</p>
          <div class="p-user-business-operator-staff-show__modal-actions">
            <Button
              @click="showModal = false"
              :text="`キャンセル`"
              :variant="ButtonVariantProp.Derk"
              :is-outlined="true"
              class="p-user-business-operator-staff-show__modal-close-button"
            />
            <AnkerButton
              :href="route(RouteName.UserMypage)"
              :text="`購入する`"
              class="p-user-business-operator-staff-show__modal-purchase-button"
            />
          </div>
        </div>
      </div>
    </div>
  </AuthLayout>
</template>

<style lang="scss">
.p-user-business-operator-staff-show {
  padding-bottom: 60px;

  &__icons {
    display: flex;
    align-items: center;
    justify-content: center;
    position: absolute;
    z-index: 10;
    bottom: 30px;
    right: 10px;
  }
  &__icon-container,
  &__like-container {
    position: relative;
    margin: 0 10px;
    p {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 50px;
      height: 50px;
      border-radius: 50%;
      background-color: var(--white);
      box-shadow: 0 2px 4px rgba(0, 0, 0, 1);
      flex-direction: column;
      i {
        font-size: 24px;
      }
      i.fa-regular.fa-thumbs-up {
        color: #555;
      }
      i.fa-solid.fa-thumbs-up {
        color: var(--black);
      }
      i.fa-regular.fa-star {
        color: var(--yellow);
      }
      i.fa-solid.fa-star {
        color: var(--yellow);
      }
      .p-user-business-operator-staff-show__like-count {
        font-size: 11px;
      }
    }

    p:hover {
      background-color: #eee;
      cursor: pointer;
    }
  }
  &__staff {
    &-image {
      width: 100%;
      height: 80%;
      object-fit: cover;
    }
    &-contents {
      margin: 5px 20px 20px 20px;
    }
    &-name {
      font-size: 25px;
      margin-bottom: 10px;
    }
    &-comment p {
      margin-top: 20px;
    }
  }
  &__gift {
    &-contents {
      display: flex;
      flex-wrap: wrap;
      &--background {
        background: #e0e0e0;
      }
      & button.c-button {
        color: var(--black);
        width: 100%;
      }
      & .fa-solid.fa-coins {
        color: var(--yellow);
      }
    }
    &-title {
      margin: 10px 0;
      text-align: center;
      font-size: 20px;
    }
    &-button-wrapper {
      flex-basis: 50%;
      padding: 10px;
    }
    &-text {
      margin: 20px auto 10px;
      & span {
        font-weight: bold;
      }
    }
  }
  &__cheer-title {
    margin: 10px 0;
    text-align: center;
    font-size: 20px;
  }
  &__textarea textarea {
    background: var(--white);
  }
  &__ai {
    margin-bottom: 10px;
  }
  &__fix-phrase {
    margin: 10px 0;
  }
  &__submit-button {
    margin: 20px auto;
    width: 100%;
  }
  &__form-error {
    font-size: 13px;
    color: #ff0000;
    margin-left: 10px;
  }
  &__points {
    color: var(--yellow);
    &-icon {
      color: #c0deff;
      margin-right: 5px;
    }
    &-label {
      color: var(--white);
      font-size: 13px;
      margin-bottom: 5px;
    }
    &-value {
      color: var(--yellow);
    }
  }
  &__purchase {
    &-link {
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    &-icon {
      color: var(--yellow);
      font-size: 30px;
      margin-bottom: 5px;
    }
    &-text {
      color: var(--white);
      font-size: 11px;
    }
  }
  &__user-points {
    position: fixed;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    z-index: 1000;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: linear-gradient(to top, #080a10, #064d95);
    color: var(--white);
    max-width: 375px;
    width: 100%;
    padding: 10px 30px;
    box-sizing: border-box;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    &-text {
      display: flex;
      flex-direction: column;
    }
  }
  &__modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 100;
    &-content {
      background: var(--white);
      padding: 30px 20px 20px 20px;
      border-radius: 5px;
      text-align: center;
      width: 360px;
      height: 330px;
    }
    &-close {
      cursor: pointer;
    }
    &-actions {
      display: flex;
      gap: 10px;
      padding: 20px 0px 0px 0px;
      flex-direction: column;
    }
    &-message {
      background: #f5d9d1;
      color: #f44912;
      border: 1px solid #f3cac0;
      padding: 5px 0;
      border-radius: 5px;
    }
    &-details {
      display: flex;
      justify-content: space-around;
      margin-top: 20px;
    }
    &-add-value {
      margin-top: 30px;
      font-weight: bold;
      color: var(--gray);
    }
  }
  & .c-button.p-user-business-operator-staff-show {
    &__gift-button--shadow {
      box-shadow: 0 4px 4px rgba(0, 0, 0, 0.05);
      border: none;

      & span i {
        color: #ffeb3b;
      }
      &.derk.selected {
        background: #ff5694;
        color: var(--white);
      }
    }
  }
}
</style>
