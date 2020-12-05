<template>
  <div class="text-center" v-if="$fetchState.pending"><b-spinner small></b-spinner> Đang tải...</div>
  <b-carousel label-prev="Trước" label-next="Sau" label-goto-slide="Chi tiết" label-indicators="Chọn để xem chi tiết" controls v-else-if="!$fetchState.error">
    <b-carousel-slide v-for="row in Math.ceil(products.length / 3)" :key="row">
      <template #img>
        <b-row>
          <b-col v-for="column in 3" :key="column" lg="4" class="py-3">
            <b-card v-if="3 * row - 3 + column - 1 < products.length" class="h-100" img-top bg-variant="white" body-class="p-0" header-class="p-0">
              <template #header>
                <div
                  class="w-100 d-block"
                  :style="{
                    height: '300px',
                    backgroundImage: `url('/asset/image/product/${products[3 * row - 3 + column - 1].id}/1.jpg')`,
                    backgroundSize: 'cover',
                    backgroundPosition: 'center',
                    backgroundRepeat: 'no-repeat',
                  }"
                ></div>
              </template>
              <b-card-body>
                <h6>{{ products[3 * row - 3 + column - 1].name }}</h6>
                <h5 class="text-primary mt-auto">{{ products[3 * row - 3 + column - 1].price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') }},000 vnđ</h5>
                <small>Số lượng còn lại: {{ products[3 * row - 3 + column - 1].quantity }}</small>
              </b-card-body>

              <template #footer>
                <div class="text-right">
                  <b-button variant="primary" size="sm">Thêm vào giỏ hàng</b-button>
                </div>
              </template>
            </b-card>
          </b-col>
        </b-row>
      </template>
    </b-carousel-slide>
  </b-carousel>
</template>

<script lang="ts">
  import { Component, Prop, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'component-product-carousel',
  })
  export default class extends Vue {
    private products: Entity.Product[] = [];

    public async fetch() {
      this.products = (await this.$axios.get('/api/product')).data;
    }
  }
</script>
