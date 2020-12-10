<template>
  <div>
    <b-breadcrumb class="bg-light">
      <b-breadcrumb-item text="Bảng điều khiến" to="/dashboard"></b-breadcrumb-item>
      <b-breadcrumb-item text="Cửa hàng - Đơn hàng" to="/dashboard/shop/bill"></b-breadcrumb-item>
      <b-breadcrumb-item text="Xác nhận" :to="$route.path"></b-breadcrumb-item>
    </b-breadcrumb>
    <hr />
    <b-card border-variant="primary">
      <b-card-body>
        <b-card-title title-tag="h2" class="text-primary">
          Chi tiết đơn hàng
        </b-card-title>
        <hr />
        <div v-if="$fetchState.pending || bill == null" class="text-center mt-3"><b-spinner small></b-spinner> Đang tải...</div>
        <div v-else-if="!$fetchState.error">
          <dl>
            <dt>Tình trạng:</dt>
            <dd>{{ nameStatus }}</dd>

            <dt>Ngày tạo:</dt>
            <dd>{{ bill.createDate }}</dd>

            <div v-if="bill.payDate.length > 0">
              <dt>Ngày thanh toán:</dt>
              <dd>{{ bill.payDate }}</dd>
            </div>
          </dl>
          <hr />
          <h6>Tổng sản phẩm: {{ numberProducts }}</h6>
          <b-card no-body v-for="(product, index) in products" :key="index" class="mt-3" border-variant="primary">
            <b-row no-gutters>
              <b-col lg="4" md="6">
                <div
                  class="w-100 h-100 d-none d-md-block"
                  :style="{
                    backgroundImage: `url('${product.image1Url}')`,
                    backgroundSize: 'cover',
                    backgroundPosition: 'center',
                    backgroundRepeat: 'no-repeat',
                  }"
                ></div>
                <div
                  class="w-100 d-block d-md-none"
                  :style="{
                    backgroundImage: `url('${product.image1Url}')`,
                    backgroundSize: 'cover',
                    backgroundPosition: 'center',
                    backgroundRepeat: 'no-repeat',
                    height: 'calc(100vh / 3)',
                  }"
                ></div>
              </b-col>
              <b-col lg="8" md="6">
                <b-card-body>
                  <h5>{{ product.name }}</h5>
                  <h5 class="text-primary">{{ toMoney(product.price) }}</h5>
                  <div>Số lượng: {{ productCarts[index].quantity }}</div>
                  <hr />
                  <div class="text-right">
                    <b-button variant="primary" :to="`/product/${product.id}`">Xem chi tiết</b-button>
                  </div>
                </b-card-body>
              </b-col>
            </b-row>
          </b-card>
          <hr />
          <h4 class="text-right">
            Tổng cộng:
            <span class="text-primary">{{ toMoney(total) }}</span>
          </h4>
          <b-form @click.prevent="submit" class="text-center">
            <b-button type="submit" variant="primary" :disabled="pending">
              <span v-if="!pending">Xác nhận đơn hàng</span>
              <span v-else><b-spinner small></b-spinner> Xử lý...</span>
            </b-button>
          </b-form>
        </div>
      </b-card-body>
    </b-card>
  </div>
</template>

<script lang="ts">
  import { toMoney } from '@/plugin/helper';
  import { Component, Vue, Watch } from 'nuxt-property-decorator';

  @Component({
    name: 'page-dashboard-shop-bill-accept',
    head: {
      title: 'Bảng điều khiển - Cửa hàng - Đơn hàng - Xác nhận đơn hàng',
    },
    methods: { toMoney },
  })
  export default class extends Vue {
    private idBill: number = parseInt(this.$route.params.id);
    private bill: Entity.Bill | null = null;
    private productCarts: Entity.ProductCart[] = [];
    private products: Entity.Product[] = [];
    private numberProducts: number = 0;
    private total: number = 0;
    private pending: boolean = false;

    public async fetch() {
      if (isNaN(this.idBill) || this.idBill < 1) {
        this.$nuxt.error({ statusCode: 404 });
        return;
      }

      this.bill = (await this.$axios.get('/api/admin/bill', { params: { id: this.idBill } })).data[0];
      this.productCarts = (await this.$axios.get('/api/admin/product-cart', { params: { idBill: this.idBill } })).data;
      for (let productCart of this.productCarts) {
        let products: Entity.Product[] = (await this.$axios.get('/api/admin/product', { params: { id: productCart.idProduct } })).data;
        if (products.length != 1) {
          this.$nuxt.error({ statusCode: 404 });
          return;
        }

        this.products.push(products[0]);
        this.numberProducts += productCart.quantity;
        this.total += products[0].price * productCart.quantity;
      }
    }

    public async submit() {
      try {
        this.pending = true;
        await this.$axios.put('/api/admin/bill', { status: 1 }, { params: { id: this.idBill } });

        this.$nuxt.$bvToast.toast('Đã xác nhận đơn hàng. Thông tin được chuyển đến bộ phận giao hàng.', {
          title: 'Xác nhận thành công!',
          variant: 'success',
          solid: true,
          toaster: 'b-toaster-bottom-right',
        });
        this.$router.back();
      } catch (error) {
        this.$nuxt.error({ statusCode: (<Response>error.response).status });
      } finally {
        this.pending = false;
      }
    }

    public get nameStatus() {
      switch (this.bill!.status) {
        case 0:
          return 'Chờ xác nhận...';

        case 1:
          return 'Đang giao hàng...';

        case 2:
          return 'Đã thanh toán';

        case 3:
          return 'Đã huỷ';
      }
    }
  }
</script>
