<template>
  <b-container>
    <b-overlay :show="pendingSubmit" spinner-variant="primary">
      <b-card border-variant="primary">
        <b-card-body>
          <div v-if="$fetchState.pending || pending" class="text-center"><b-spinner small></b-spinner> Đang tải...</div>
          <div v-else-if="!$fetchState.error">
            <b-card-title title-tag="h2" class="text-primary">
              Giỏ hàng
            </b-card-title>
            <hr />
            <small v-if="cart.length == 0">Không có sản phẩm nào trong giỏ hàng</small>
            <div v-else>
              <h6>Tổng sản phẩm: {{ numberProducts }}</h6>
              <b-card no-body v-for="product in products" :key="product.id" class="mt-3" border-variant="primary">
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
                      <p>
                        <small>Số lượng còn lại: {{ product.quantity }}</small>
                      </p>
                      <c-form-edit-cart :id-product="product.id" @change="onChanged"></c-form-edit-cart>
                    </b-card-body>
                  </b-col>
                </b-row>
              </b-card>
              <hr />
              <h4 class="text-right">
                Tổng cộng:
                <span class="text-primary">{{ toMoney(total) }}</span>
              </h4>
              <b-form class="text-right" @submit.prevent="submit">
                <b-button type="submit" variant="primary" size="lg">Thanh toán</b-button>
              </b-form>
            </div>
          </div>
        </b-card-body>
      </b-card>
    </b-overlay>
    <hr />
    <c-product-carousel></c-product-carousel>
  </b-container>
</template>

<script lang="ts">
  import { clearCart, getCart } from '@/plugin/cart';
  import { toMoney } from '@/plugin/helper';
  import { Component, Vue, Watch } from 'nuxt-property-decorator';

  @Component({
    name: 'page-account-cart',
    head: {
      title: 'Giỏ hàng',
    },
    methods: { toMoney },
  })
  export default class extends Vue {
    private cart: Entity.Cart.Cart = [];
    private products: Entity.Product[] = [];
    private numberProducts: number = 0;
    private total: number = 0;
    private pending: boolean = false;
    private pendingSubmit: boolean = false;

    public async fetch() {
      if (process.client) {
        this.cart = getCart(this.$auth.user.id);
      }
    }

    public onChanged() {
      this.cart = getCart(this.$auth.user.id);
    }

    public submit() {
      try {
        this.pendingSubmit = true;
        this.$axios.post('/api/user/pay', { cart: this.cart });
        clearCart(this.$auth.user.id);
        this.$router.push('/account/bill/status/pending');
      } catch (error) {
        this.$nuxt.error({ statusCode: (<Response>error.response).status });
      } finally {
        this.pendingSubmit = false;
      }
    }

    @Watch('cart')
    public async onCartChanged(newValue: Entity.Cart.Cart) {
      try {
        this.pending = true;
        this.products = [];
        this.numberProducts = 0;
        this.total = 0;
        for (let product of newValue) {
          let tempProducts: Entity.Product[] = (await this.$axios.get('/api/product', { params: { id: product.id } })).data;
          if (tempProducts.length != 1) {
            this.$nuxt.error({ statusCode: 404 });
            return;
          }

          this.products.push(tempProducts[0]);
          this.numberProducts += product.quantity;
          this.total += product.quantity * this.products[this.products.length - 1].price;
        }
      } catch (error) {
        this.$nuxt.error({ statusCode: (<Response>error.response).status });
      } finally {
        this.pending = false;
      }
    }
  }
</script>
