<template>
  <transition name="page">
    <main class="d-flex align-items-center vh-100">
      <div class="mx-auto text-center">
        <h1 class="text-danger">Lỗi {{ error.statusCode }}</h1>
        <h4>{{ message }}</h4>
        <hr />
        <b-link href="/">Về trang chủ</b-link>
      </div>
    </main>
  </transition>
</template>

<script lang="ts">
  import { Component, Prop, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'error',
  })
  export default class extends Vue {
    @Prop({ type: Object, required: true })
    private error!: App.Nuxt.ErrorPage;
    private errorMessage: { [statusCode: number]: string } = {
      400: 'Yêu cầu không hợp lệ',
      401: 'Yêu cầu cần xác thực',
      402: 'Yêu cầu cần thanh toán',
      403: 'Yêu cầu bị cấm',
      404: 'Không tìm thấy',
      405: 'Yêu cầu không được cho phép',
      406: 'Yêu cầu không được chấp nhận',
      407: 'Yêu cầu cần xác thực proxy',
      408: 'Yêu cầu hết thời gian chờ',
      409: 'Đã xảy ra xung đột',
      410: 'Dữ liệu không cần nữa',
      411: 'Yêu cầu cần trường dữ liệu length',
      412: 'Điều kiện tiên quyết không được thoã',
      413: 'Đối tượng yêu cầu quá lớn',
      414: 'Đường dẫn yêu cầu quá lớn',
      415: 'Không hỗ trợ',
      416: 'Phạm vi yêu cầu không thể đáp ứng',
      417: 'Đã xảy ra một trường hợp ngoại lệ',
      500: 'Lỗi máy chủ',
      501: 'Máy chủ không thể triển khai',
      502: 'Lỗi giao thức',
      503: 'Dịch vụ không còn khả dụng',
      504: 'Giao thức hết thời gian chờ',
      505: 'Phiên bản giao thức không được hỗ trợ',
    };

    private message: string = 'Máy chủ đã xảy ra lỗi';

    public beforeMount() {
      if (this.errorMessage[this.error.statusCode]) {
        this.message = this.errorMessage[this.error.statusCode];
      }
    }
  }
</script>
