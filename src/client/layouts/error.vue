<template>
  <main class="d-flex align-items-center vh-100">
    <section class="mx-auto text-center">
      <h1 class="text-danger">Lỗi {{ error.statusCode }}</h1>
      <h4>{{ message }}</h4>
      <hr />
      <nuxt-link to="/">Về trang chủ</nuxt-link>
    </section>
  </main>
</template>

<script lang="ts">
  import { Component, Prop, Vue } from 'nuxt-property-decorator';

  @Component
  export default class ErrorLayout extends Vue {
    @Prop(Object)
    private error!: App.Nuxt.ErrorPage;
    private message: string = 'Đã có lỗi xảy ra';

    public beforeMount() {
      switch (this.error.statusCode) {
        case 404:
          this.message = 'Không tìm thấy';
          break;

        case 403:
          this.message = 'Truy cập bị giới hạn';
          break;
      }
    }
  }
</script>

<style lang="scss" scoped></style>
