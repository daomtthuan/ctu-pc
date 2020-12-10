<template>
  <div class="text-center py-5" v-if="$fetchState.pending || product == null"><b-spinner small></b-spinner> Đang tải...</div>
  <b-container class="my-5" v-else-if="!$fetchState.error">
    <b-row>
      <b-col md="6" lg="4" class="mb-3">
        <b-carousel controls class="border border-primary h-100">
          <b-carousel-slide v-for="index in 3" :key="index" class="h-100">
            <template #img>
              <div
                class="w-100 h-100 d-none d-md-block"
                :style="{
                  backgroundImage: `url('${product[`image${index}Url`]}')`,
                  backgroundSize: 'cover',
                  backgroundPosition: 'center',
                  backgroundRepeat: 'no-repeat',
                }"
              ></div>
              <div
                class="w-100 d-block d-md-none"
                :style="{
                  backgroundImage: `url('${product[`image${index}Url`]}')`,
                  backgroundSize: 'cover',
                  backgroundPosition: 'center',
                  backgroundRepeat: 'no-repeat',
                  height: 'calc(200vh / 3)',
                }"
              ></div>
            </template>
          </b-carousel-slide>
        </b-carousel>
      </b-col>
      <b-col md="6" lg="8" class="mb-3">
        <b-card class="h-100" bg-variant="white" border-variant="primary">
          <b-card-body>
            <h4>{{ product.name }}</h4>
            <p>Số lượng còn lại: {{ product.quantity }}</p>
            <h2 class="text-primary">{{ toMoney(product.price) }}</h2>
            <hr />
            <c-form-create-cart :id-product="product.id"></c-form-create-cart>
          </b-card-body>
        </b-card>
      </b-col>
    </b-row>
    <b-card bg-variant="white" class="my-3" border-variant="primary">
      <b-card-body>
        <h4>Mô tả sản phẩm</h4>
        <hr />
        <div v-html="post"></div>
      </b-card-body>
    </b-card>
    <div class="mt-3">
      <client-only>
        <h4>Đánh giá của khách hàng</h4>
        <hr />
        <template #placeholder>
          <div class="text-center"><b-spinner small></b-spinner> Đang tải...</div>
        </template>
        <div v-if="reviews.length > 0">
          <strong class="mb-2">
            Tổng quan:
            <c-product-star :star="star" class="small d-inline text-primary"></c-product-star>
          </strong>
          <b-card v-for="review in reviews" :key="review.id" class="mt-2" bg-variant="white">
            <b-card-text>
              <c-product-star class="text-primary small " :star="review.star"></c-product-star>
              <div class="my-2">
                {{ review.content }}
              </div>
              <div class="small">
                {{ review.writer }}
              </div>
            </b-card-text>
          </b-card>
          <div class="text-center mt-3">
            <div v-if="pending"><b-spinner small></b-spinner> Đang tải...</div>
            <small v-else-if="noMore">Không còn đánh giá nào nữa</small>
            <b-button variant="link" @click="showMoreReview" v-else>Xem thêm</b-button>
          </div>
        </div>
        <div class="text-center small mt-3" v-else>
          Không có đánh giá nào
        </div>
      </client-only>
    </div>
    <hr />
    <c-product-carousel></c-product-carousel>
  </b-container>
</template>

<script lang="ts">
  import { Component, Vue, Watch } from 'nuxt-property-decorator';
  import { toMoney } from '@/plugin/helper';
  @Component({
    name: 'page-product',
    head: {
      title: 'Sản phẩm - Chi tiết',
    },
    methods: { toMoney },
  })
  export default class extends Vue {
    private idProduct: number = parseInt(this.$route.params.id);
    private product: Entity.Product | null = null;
    private post: string | null = null;
    private reviews: Entity.Review[] = [];
    private indexReview: number = 0;
    private noMore: boolean = false;
    private star: number = 0;
    private pending: boolean = false;

    public async fetch() {
      if (isNaN(this.idProduct) || this.idProduct < 1) {
        this.$nuxt.error({ statusCode: 404 });
        return;
      }

      try {
        let products: Entity.Product[] = (await this.$axios.get('/api/product', { params: { id: this.idProduct } })).data;
        if (products.length != 1) {
          this.$nuxt.error({ statusCode: 404 });
          return;
        }

        this.product = products[0];
        this.post = (await this.$axios.get(this.product.postUrl)).data;
        this.star = (await this.$axios.get('/api/review', { params: { idProduct: this.product.id } })).data.star;
        await this.showMoreReview();
      } catch (error) {
        this.$nuxt.error({ statusCode: (<Response>error.response).status });
      }
    }

    public async showMoreReview() {
      try {
        this.pending = true;
        let tempReviews: Entity.Review[] = (
          await this.$axios.get('/api/review', {
            params: {
              idProduct: this.product!.id,
              start: this.indexReview,
            },
          })
        ).data;
        if (tempReviews.length > 0) {
          this.reviews = this.reviews.concat(tempReviews);
          this.indexReview += tempReviews.length;
        } else {
          this.noMore = true;
        }
      } catch (error) {
        this.$nuxt.error({ statusCode: (<Response>error.response).status });
      } finally {
        this.pending = false;
      }
    }

    @Watch('$route.params.id')
    public onIdProductChanged(newValue: string) {
      this.idProduct = parseInt(newValue);
      this.$fetch();
    }
  }
</script>
