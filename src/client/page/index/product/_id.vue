<template>
  <div class="text-center py-5" v-if="$fetchState.pending || product == null"><b-spinner small></b-spinner> Đang tải...</div>
  <b-container class="my-5" v-else-if="!$fetchState.error">
    <b-row>
      <b-col md="6" lg="4">
        <b-carousel controls class="border">
          <b-carousel-slide v-for="index in 3" :key="index" :img-src="`/asset/image/product/${product.id}/${index}.jpg`"></b-carousel-slide>
        </b-carousel>
      </b-col>
      <b-col md="6" lg="8">
        <h3>{{ product.name }}</h3>
        <p>Số lượng còn lại: {{ product.quantity }}</p>
        <h2 class="text-primary">{{ toMoney(product.price) }}</h2>
        <hr />
        <c-form-add-cart :id-product="product.id"></c-form-add-cart>
      </b-col>
    </b-row>
  </b-container>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';
  import { toMoney } from '@/plugin/helper';
  @Component({
    name: 'page-product',
    methods: { toMoney },
  })
  export default class extends Vue {
    private product: Entity.Product | null = null;

    public async fetch() {
      let id = parseInt(this.$route.params.id ? this.$route.params.id : '1');
      if (isNaN(id) || id < 1) {
        this.$nuxt.error({ statusCode: 404 });
        return;
      }

      try {
        let products: Entity.Product[] = (await this.$axios.get('/api/product', { params: { id: id } })).data;
        if (products.length != 1) {
          this.$nuxt.error({ statusCode: 404 });
          return;
        }

        this.product = products[0];
      } catch (error) {
        this.$nuxt.error({ statusCode: (<Response>error.response).status });
      }
    }
  }
</script>

<style lang="scss" scoped></style>
