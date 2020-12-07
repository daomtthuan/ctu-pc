<template>
  <div>
    <div
      class="d-flex flex-column"
      :style="{
        position: 'absolute',
        top: 0,
        paddingTop: 'calc(100vh / 3 - 100px)',
        minHeight: '100vh',
        width: '100%',
        zIndex: 1,
      }"
    >
      <div class="mx-auto text-center">
        <c-logo :size="128"></c-logo>
        <h1 class="mt-4 text-primary font-weight-bold border-top border-bottom border-light py-1">CTU PC SHOP</h1>
        <h5 class="text-light">Cửa hàng máy tính trường Đại học Cần Thơ</h5>
      </div>
      <div class="text-center mt-auto mb-5">
        <img src="/image/scroll-down.gif" style="height: 5rem;" />
      </div>
    </div>

    <div class="v-100 h-100">
      <b-carousel no-touch no-hover-pause>
        <b-carousel-slide v-for="index in 5" :key="index">
          <template #img>
            <div
              class="w-100 d-block vh-100"
              :style="{
                backgroundImage: `linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 1)),url('/image/banner/${index}.jpg')`,
                backgroundSize: 'cover',
                backgroundPosition: 'top',
                backgroundRepeat: 'no-repeat',
              }"
            ></div>
          </template>
        </b-carousel-slide>
      </b-carousel>
    </div>
  </div>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'component-brand',
  })
  export default class extends Vue {}
</script>
