<template>
  <div class="text-center" v-if="$fetchState.pending"><b-spinner small></b-spinner> Đang tải...</div>
  <b-carousel controls v-else-if="!$fetchState.error">
    <b-carousel-slide v-for="row in Math.ceil(products.length / 4)" :key="row">
      <template #img>
        <b-row>
          <b-col v-for="column in 4" :key="column" xl="3" lg="6" md="6" class="py-3">
            <c-product :product="products[4 * row - 4 + column - 1]" v-if="4 * row - 4 + column - 1 < products.length"></c-product>
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
