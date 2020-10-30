<template>
  <transition name="page">
    <main class="d-flex align-items-center vh-100">
      <section class="mx-auto text-center">
        <h1 class="text-danger">Lỗi {{ error.statusCode }}</h1>
        <h4>{{ message }}</h4>
        <hr />
        <b-link href="/">Về trang chủ</b-link>
      </section>
    </main>
  </transition>
</template>

<script lang="ts">
  import { Component, Prop, Vue } from 'nuxt-property-decorator';

  interface ErrorPage {
    statusCode: number;
    message: string;
  }

  @Component({
    name: 'error',
  })
  export default class extends Vue {
    @Prop(Object)
    private error!: ErrorPage;

    private message: string = 'Máy chủ đã xảy ra lỗi';

    public beforeMount() {
      switch (this.error.statusCode) {
        case 400:
          this.message = 'Yêu cầu không hợp lệ';
          break;

        case 401:
          this.message = 'Cần đăng nhập để thực hiện yêu cầu này';
          break;

        case 403:
          this.message = 'Truy cập bị giới hạn';
          break;

        case 404:
          this.message = 'Không tìm thấy';
          break;

        case 406:
          this.message = 'Yêu cầu không được chấp nhận';
          break;

        case 504:
          this.message = 'Máy chủ không thể xử lý yêu cầu ngay lúc này';
          break;
      }
    }
  }
</script>
