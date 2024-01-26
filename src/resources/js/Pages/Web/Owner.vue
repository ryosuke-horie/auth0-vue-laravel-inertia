<script setup lang="ts">
import BaseLayout from '@/Layouts/BaseLayout.vue';
import Heading2 from '@/Components/_lp/Heading2/Heading2.vue';
import Heading3 from '@/Components/_lp/Heading3/Heading3.vue';
import Paragraph from '@/Components/_lp/Paragraph/Paragraph.vue';
import Button from '@/Components/_lp/Button/Button.vue';
import { ButtonVariantProp } from '@/Components/_lp/Button/type';
import PickUpBanner from '@/Components/_lp/PickupBanner/PickupBanner.vue';
import Slide from '@/Components/_lp/Slide/Slide.vue';
import FeatureList from '@/Components/_lp/FeatureList/FeatureList.vue';
import ShopVoiceList from '@/Components/_lp/ShopVoiceList/ShopVoiceList.vue';
import FlowList from '@/Components/_lp/FlowList/FlowList.vue';
import { RouteName } from '@/Utilities';
</script>

<template>
  <BaseLayout
    title="チアペイ"
    :header-menus="[
      { text: '特徴・メリット', href: route(RouteName.Owner), hrefId: 'feature' },
      { text: '導入事例', href: route(RouteName.Owner), hrefId: 'case' },
      { text: '導入までの流れ', href: route(RouteName.Owner), hrefId: 'flow' },
      { text: 'Q&A', href: route(RouteName.Owner), hrefId: 'faq' },
    ]"
  >
    <div class="owner">
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
      <section id="feature">
        <Heading2>サービスの特徴とメリット</Heading2>
        <div class="content">
          <FeatureList
            :items="[
              {
                title: '見出し',
                text: 'てきすとてきすとてきすとてきすとてきすとてきすとてきすとてきすと',
                src: 'https://www.mamiya-its.co.jp/public/images/4_service/systemintegration.jpg',
              },
              {
                title: '見出し',
                text: 'てきすとてきすとてきすとてきすとてきすとてきすとてきすとてきすと',
                src: 'https://www.mamiya-its.co.jp/public/images/4_service/systemintegration.jpg',
              },
              {
                title: '見出し',
                text: 'てきすとてきすとてきすとてきすとてきすとてきすとてきすとてきすと',
                src: 'https://www.mamiya-its.co.jp/public/images/4_service/systemintegration.jpg',
              },
              {
                title: '見出し',
                text: 'てきすとてきすとてきすとてきすとてきすとてきすとてきすとてきすと',
                src: 'https://www.mamiya-its.co.jp/public/images/4_service/systemintegration.jpg',
              },
            ]"
          />
        </div>
      </section>
      <section id="case">
        <Heading2>導入事例</Heading2>
        <div class="content">
          <PickUpBanner
            variant="green"
            title-before="登録ユーザー数"
            title-count="1,000"
            title-after="人以上！！！"
            button-text="全国ユーザーがあなたのお店を待っています！"
          />
          <Heading3 class="heading3" text-align="center" variant="green">チアペイを導入された店舗様をご紹介</Heading3>
          <ShopVoiceList
            class="shop-voice-list"
            :items="[
              {
                name: 'SHOPNAME',
                text: 'てきすとてきすとてきすとてきすとてきすとてきすとてきすとてきすとてきすとてきすと',
                src: 'https://www.mamiya-its.co.jp/public/images/4_service/systemintegration.jpg',
              },
              {
                name: 'SHOPNAME',
                text: 'てきすとてきすとてきすとてきすとてきすとてきすとてきすとてきすとてきすとてきすと',
                src: 'https://www.mamiya-its.co.jp/public/images/4_service/systemintegration.jpg',
              },
            ]"
          />

          <Button
            class="button"
            text="今すぐ申し込む"
            :variant="ButtonVariantProp.Orange"
            :href="route(RouteName.BusinessOperatorRegister)"
          />
        </div>
      </section>
      <section id="flow">
        <Heading2>サービス導入までの流れ</Heading2>
        <div class="content">
          <Paragraph class="flow-list-paragraph">
            最短3日以内に公開可能チームごとに専属のチアペイスタッフが付きサポートします
          </Paragraph>
          <FlowList
            class="flow-list"
            :items="[
              {
                title: '資料送付と日程調整',
                text: '資料請求時にまずは資料の送付とご説明の日程を調整させていただきます。',
              },
              {
                title: 'チアペイのご説明（15-30分）',
                text: 'チアペイのご説明からページには記載のない成功事例や導入のメリットをご紹介させていただきます。',
              },
              {
                title: 'お申し込み書類',
                text: 'メールにてお申し込み書類が届きましたら、記入をお願いいたします。弊社へご返送後、改めて担当者よりご連絡させていただきます。',
              },
              { title: 'アカウント発行', text: 'お申し込み書類の確認後、アカウントを発行いたします。' },
              {
                title: 'スタート',
                text: '貴社アカウント発効後、管理画面よりチーム・選手のご登録をいただきます。管理画面の設定完了後、ページ公開となります。専門の担当者がサポートでつきます。',
              },
            ]"
          />
          <Button
            class="button"
            text="まずは資料請求"
            :variant="ButtonVariantProp.Red"
            :href="route(RouteName.BusinessOperatorRegister)"
          />
        </div>
      </section>
      <section>
        <Slide
          class="slide"
          id="use-1"
          title="まずは口座登録"
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
          title="スタッフ管理もかんたん！"
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
          title="貯まったポイント（CP）も安心のお振込み申請"
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
      </section>
      <section id="faq">
        <Heading2>よくある質問</Heading2>
        <div class="content">
          よくある質問よくある質問よくある質問よくある質問よくある質問よくある質問よくある質問よくある質問よくある質問よくある質問よくある質問よくある質問よくある質問よくある質問よくある質問よくある質問よくある質問よくある質問よくある質問よくある質問よくある質問よくある質問よくある質問よくある質問よくある質問よくある質問よくある質問よくある質問よくある質問よくある質問
        </div>
      </section>
      <section>
        <Heading2>一緒に盛り上げてくれる店舗様も募集してます！</Heading2>
        <figure>
          <img src="@/../assets/images/cp_top_img4.jpg" alt="" />
        </figure>
        <div class="content">
          <Heading3 class="heading3">チアペイに参加してお店を盛り上げてみませんか</Heading3>
          <Paragraph class="paragraph">
            テキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト
          </Paragraph>
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
            :href="route(RouteName.BusinessOperatorRegister)"
          />
        </div>
      </section>
    </div>
  </BaseLayout>
</template>

<style lang="scss">
.owner {
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
  .flow-list-paragraph {
    margin-bottom: 16px;
  }
  .shop-voice-list,
  .flow-list {
    margin-bottom: 16px;
  }
}
</style>
