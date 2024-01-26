<script setup lang="ts">
import { RouteName } from '@/Utilities';
import BaseLayout from '@/Layouts/BaseLayout.vue';
import Link from '@/Components/atom/link/Link/Link.vue';
import Heading2 from '@/Components/_lp/Heading2/Heading2.vue';
import Heading3 from '@/Components/_lp/Heading3/Heading3.vue';
import Paragraph from '@/Components/_lp/Paragraph/Paragraph.vue';
import Button from '@/Components/_lp/Button/Button.vue';
import { ButtonVariantProp } from '@/Components/_lp/Button/type';
import PickUpBanner from '@/Components/_lp/PickupBanner/PickupBanner.vue';
import Slide from '@/Components/_lp/Slide/Slide.vue';
import SlideRecommendShop from '@/Components/_lp/SlideRecommendShop/SlideRecommendShop.vue';
</script>

<template>
  <BaseLayout
    title="チアペイ"
    :header-menus="[
      { text: 'チアペイとは', href: route(RouteName.Welcome), hrefId: 'about' },
      { text: '導入店舗', href: route(RouteName.Welcome), hrefId: 'pickup' },
      { text: '特徴', href: route(RouteName.Welcome), hrefId: 'feature' },
      { text: '使い方', href: route(RouteName.Welcome), hrefId: 'use' },
    ]"
  >
    <div class="top">
      <div style="position: relative; height: 315px">
        <iframe
          style="position: absolute; top: 0px; left: 0px; width: 100%; height: 100%"
          height="315"
          src="https://www.youtube.com/embed/lNNX9jlp0rU?rel=0&showinfo=0&autoplay=1&mute=1&playsinline=1&controls=0&loop=1&disablekb=1"
          frameborder="0"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
          allowfullscreen
          loading="lazy"
        />
      </div>
      <section id="about">
        <Heading2>チアペイとは？</Heading2>
        <figure>
          <img src="@/../assets/images/cp_top_img1.jpg" alt="" />
        </figure>
        <div class="content">
          <Heading3 class="heading3">日本最大級のギフティングサービス</Heading3>
          <Paragraph>テキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト</Paragraph>
        </div>
      </section>
      <section id="pickup">
        <Heading2>全国のいろいろなお店が一堂に集結！！</Heading2>
        <div class="content">
          <PickUpBanner
            title-before="全国導入店舗"
            title-count="1,000"
            title-after="店舗以上！！！"
            button-text="推したいお店がきっと見つかる！"
          />
          <Heading3 class="heading3" variant="brown">チアペイおすすめ店舗ご紹介</Heading3>
          <SlideRecommendShop
            class="slide-recommend-shop"
            id="shop-recommend"
            :items="[
              {
                name: 'SHOPNAME',
                text: '住所',
                src: 'https://www.mamiya-its.co.jp/public/images/4_service/webservice.jpg',
              },
              {
                name: 'SHOPNAME',
                text: '住所',
                src: 'https://www.mamiya-its.co.jp/public/images/4_service/webservice.jpg',
              },
              {
                name: 'SHOPNAME',
                text: '住所',
                src: 'https://www.mamiya-its.co.jp/public/images/4_service/webservice.jpg',
              },
              {
                name: 'SHOPNAME',
                text: '住所',
                src: 'https://www.mamiya-its.co.jp/public/images/4_service/webservice.jpg',
              },
            ]"
          />
          <Button
            class="button"
            text="今すぐ会員登録！"
            :variant="ButtonVariantProp.Green"
            :href="route(RouteName.UserRegister)"
          />
        </div>
      </section>
      <section id="feature">
        <Heading2>チアペイの特徴</Heading2>
        <figure>
          <img src="@/../assets/images/cp_top_img2.jpg" alt="" />
        </figure>
        <div class="content">
          <Heading3 class="heading3">お気に入りのスタッフが見つかる！応援できる！！</Heading3>
          <Paragraph>テキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト</Paragraph>
        </div>
        <figure>
          <img src="@/../assets/images/cp_top_img3.jpg" alt="" />
        </figure>
        <div class="content">
          <Heading3 class="heading3">スタッフとの距離が縮まる？？来店する楽しみが増える！？</Heading3>
          <Paragraph>テキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト</Paragraph>
        </div>
      </section>
      <section id="use">
        <Heading2>チアペイの使い方</Heading2>
        <Slide
          class="slide"
          id="use-1"
          title="会員登録不要！すぐに応援できます！！"
          :items="[
            {
              src: 'https://www.mamiya-its.co.jp/public/images/4_service/webservice.jpg',
              text: '説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト',
            },
            {
              src: 'https://www.mamiya-its.co.jp/public/images/4_service/systemintegration.jpg',
              text: '説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト',
            },
            {
              src: 'https://www.mamiya-its.co.jp/public/images/4_service/Internetofthings.jpg',
              text: '説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト',
            },
          ]"
        />
        <Slide
          class="slide"
          id="use-2"
          title="無料会員なるともっと便利に！"
          :items="[
            {
              src: 'https://www.mamiya-its.co.jp/public/images/4_service/webservice.jpg',
              text: '説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト',
            },
            {
              src: 'https://www.mamiya-its.co.jp/public/images/4_service/systemintegration.jpg',
              text: '説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト',
            },
            {
              src: 'https://www.mamiya-its.co.jp/public/images/4_service/Internetofthings.jpg',
              text: '説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト',
            },
          ]"
        />
        <Slide
          class="slide"
          id="use-3"
          title="応援ポイント（CP）の購入方法"
          :items="[
            {
              src: 'https://www.mamiya-its.co.jp/public/images/4_service/webservice.jpg',
              text: '説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト',
            },
            {
              src: 'https://www.mamiya-its.co.jp/public/images/4_service/systemintegration.jpg',
              text: '説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト',
            },
            {
              src: 'https://www.mamiya-its.co.jp/public/images/4_service/Internetofthings.jpg',
              text: '説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト',
            },
          ]"
        />
        <Slide
          class="slide"
          id="use-4"
          title="あなたのお気に入りスタッフを応援しよう！"
          :items="[
            {
              src: 'https://www.mamiya-its.co.jp/public/images/4_service/webservice.jpg',
              text: '説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト',
            },
            {
              src: 'https://www.mamiya-its.co.jp/public/images/4_service/systemintegration.jpg',
              text: '説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト',
            },
            {
              src: 'https://www.mamiya-its.co.jp/public/images/4_service/Internetofthings.jpg',
              text: '説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト説明テキスト',
            },
          ]"
        />
        <div class="content">
          <Button
            class="button"
            text="今すぐ会員登録！"
            :variant="ButtonVariantProp.Green"
            :href="route(RouteName.UserRegister)"
          />
        </div>
      </section>
      <section>
        <Heading2>一緒に盛り上げてくれる店舗様も募集してます！</Heading2>
        <figure>
          <img src="@/../assets/images/cp_top_img4.jpg" alt="" />
        </figure>
        <div class="content">
          <Heading3 class="heading3">スタッフとの距離が縮まる？？来店する楽しみが増える！？</Heading3>
          <Paragraph class="paragraph"
            >テキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト</Paragraph
          >
          <Button
            class="button"
            text="１店舗様のお申し込み"
            :variant="ButtonVariantProp.Orange"
            :href="route(RouteName.BusinessOperatorRegister)"
          />
          <Button
            class="button"
            text="複数店舗様のお申し込み（チェーン店・グループ店など）"
            :variant="ButtonVariantProp.Orange"
            :href="route(RouteName.CorporationRegister)"
          />
          <Button
            class="button"
            text="店舗様向けのサービスの詳細はこちら"
            :variant="ButtonVariantProp.Black"
            :href="route(RouteName.Owner)"
          />
        </div>
      </section>
    </div>
    <div>
      <p>Adminへ</p>
      <Link :href="RouteName.AdminLogin" text="ログイン" />
      <Link :href="RouteName.AdminRegister" text="新規登録" />
    </div>

    <div>
      <p>Userへ</p>
      <Link :href="RouteName.UserLogin" text="ログイン" />
      <Link :href="RouteName.UserRegister" text="新規登録" />
    </div>

    <div>
      <p>Corporationへ</p>
      <Link :href="RouteName.CorporationLogin" text="ログイン" />
      <Link :href="RouteName.CorporationRegister" text="新規登録" />
    </div>

    <div>
      <p>BusinessOperatorへ</p>
      <Link :href="RouteName.BusinessOperatorLogin" text="ログイン" />
      <Link :href="RouteName.BusinessOperatorRegister" text="新規登録" />
    </div>

    <div>
      <p>Staffへ</p>
      <Link :href="RouteName.StaffLogin" text="ログイン" />
      <Link :href="RouteName.StaffRegister" text="新規登録" />
    </div>
  </BaseLayout>
</template>

<style lang="scss">
.top {
  section {
    padding-top: 90px;
    margin-top: -90px;
    @media screen and (min-width: 1025px) {
      padding-top: 60px;
      margin-top: -60px;
    }
  }
  figure {
    width: 100%;
    img {
      width: 100%;
    }
  }
  .content {
    padding: 16px;
    .heading3 {
      margin-bottom: 16px;
    }
    .paragraph {
      margin-bottom: 16px;
    }
    .button {
      width: 100%;
      & + .button {
        margin-top: 16px;
      }
    }
  }
  .slide {
    & + .slide {
      margin-top: 16px;
    }
  }
  .slide-recommend-shop {
    margin-bottom: 16px;
  }
}
</style>
