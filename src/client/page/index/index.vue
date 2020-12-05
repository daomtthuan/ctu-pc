<template>
  <div class="text-center py-5" v-if="pending"><b-spinner small></b-spinner> Đang tải...</div>
  <div v-else>
    <c-brand></c-brand>

    <div class="py-5" style="background: #c0c6cf">
      <b-container class="text-center">
        <h4>Lý do lựa chọn CTU PC SHOP</h4>
        <hr />
        <b-row>
          <b-col lg="4">
            <fa :icon="['fas', 'dollar-sign']" class="my-3 text-primary" style="font-size: 3rem;"></fa>
            <h5>Đảm bảo giá tốt</h5>
            <p>
              Sản phẩm chất lượng, giá tốt<br />
              So sánh dễ dàng lựa chọn
            </p>
          </b-col>
          <b-col lg="4">
            <fa :icon="['fas', 'thumbs-up']" class="my-3 text-primary" style="font-size: 3rem;"></fa>
            <h5>Cam kết chất lượng</h5>
            <p>
              Không bán hàng giả, hàng kém chất lượng<br />
              Chính sách bảo hành, đổi trả 1 - 1
            </p>
          </b-col>
          <b-col lg="4">
            <fa :icon="['fas', 'tools']" class="my-3 text-primary" style="font-size: 3rem;"></fa>
            <h5>Dịch vụ tốt</h5>
            <p>
              Dịch vụ cài đặt, nâng cấp cấu hình<br />
              Dịch vụ vệ sinh máy tính
            </p>
          </b-col>
        </b-row>
      </b-container>
    </div>

    <div class="bg-white py-5">
      <b-container class="text-center">
        <h4 class="text-primary">Sản phẩm mới nhất</h4>
        <hr class="bg-primary" />
        <c-product-carousel></c-product-carousel>
      </b-container>
    </div>

    <div class="bg-dark py-5">
      <b-container class="text-center">
        <h4 class="text-light">Đánh giá khách hàng</h4>
        <hr class="bg-light" />
        <c-review-carousel></c-review-carousel>
      </b-container>
    </div>

    <div class="bg-white py-5">
      <b-container class="text-center">
        <h4 class="text-primary">Sự kiện mới nhất</h4>
        <hr class="bg-primary" />
        <c-event-carousel></c-event-carousel>
      </b-container>
    </div>
  </div>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'page-home',
    head: {
      title: 'Trang chủ',
    },
  })
  export default class extends Vue {
    private pending: boolean = true;

    public mounted() {
      this.$nextTick(() => (this.pending = false));
    }
  }
</script>
