<script lang="ts" setup></script>
<template>
  <div class="c-banners">
    <figure>
      <img src="@/../assets/images/cp_top_img1.jpg" alt="" />
    </figure>
    <figure>
      <img src="@/../assets/images/cp_top_img2.jpg" alt="" />
    </figure>
    <figure>
      <img src="@/../assets/images/cp_top_img3.jpg" alt="" />
    </figure>
  </div>
</template>

<style lang="scss">
.c-banners {
  position: sticky;
  top: 0;
  background-color: var(--white);
  figure {
    width: 100%;
    margin: 0;
    & + figure {
      margin-top: 16px;
    }
    img {
      width: 100%;
      vertical-align: top;
    }
  }
}
</style>
