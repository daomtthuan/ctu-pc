<template>
  <div class="text-center py-5" v-if="$fetchState.pending && currentPage == 0"><b-spinner small></b-spinner> Đang tải...</div>
  <b-container class="py-5" v-else-if="!$fetchState.error">
    <h2 class="text-primary">Sản phẩm</h2>
    <h5>Danh mục: {{ nameCategory }}</h5>
    <hr />
    <p v-if="total == 0">
      Hiện tại không có sản phẩm nào.
    </p>
    <div class="text-center" v-else-if="pending"><b-spinner small></b-spinner> Đang tải...</div>
    <div v-else>
      <b-row v-for="row in rows" :key="row">
        <b-col v-for="column in 4" :key="column" class="mb-3" xl="3" lg="6" md="6">
          <c-product :product="products[4 * row - 4 + column - 1]" v-if="4 * row - 4 + column - 1 < products.length"></c-product>
        </b-col>
      </b-row>
      <b-pagination-nav v-model="currentPage" :link-gen="linkPage" :number-of-pages="numberPages" use-router align="center">
        <template v-slot:first-text>
          <fa :icon="['fas', 'angle-double-left']"></fa>
        </template>
        <template v-slot:prev-text>
          <fa :icon="['fas', 'angle-left']"></fa>
        </template>
        <template v-slot:next-text>
          <fa :icon="['fas', 'angle-right']"></fa>
        </template>
        <template v-slot:last-text>
          <fa :icon="['fas', 'angle-double-right']"></fa>
        </template>
      </b-pagination-nav>
    </div>
  </b-container>
</template>

<script lang="ts">
  import { Component, Vue, Watch } from 'nuxt-property-decorator';

  @Component({
    name: 'page-product-list',
    head: {
      title: 'Sản phẩm',
    },
  })
  export default class extends Vue {
    private idCategory: number = 0;
    private nameCategory: string = '';
    private total: number = 0;
    private numberPages: number = 1;
    private perPage: number = 24;
    private currentPage: number = 0;
    private products: Entity.Product[] = [];
    private pending: boolean = false;
    private rows: number = 0;

    public async fetch() {
      let tempCurrentPage = parseInt(this.$route.params.page ? this.$route.params.page : '1');
      let tempIdCategory = parseInt(this.$route.params.category);
      if (isNaN(tempCurrentPage) || tempCurrentPage < 1 || isNaN(tempIdCategory) || tempIdCategory < 1) {
        this.$nuxt.error({ statusCode: 404 });
        return;
      }

      let categories: Entity.Category[] = (await this.$axios.get('/api/category', { params: { id: tempIdCategory } })).data;
      if (categories.length != 1) {
        this.$nuxt.error({ statusCode: 404 });
        return;
      }

      this.idCategory = tempIdCategory;
      this.nameCategory = categories[0].name;

      try {
        this.total = (<App.Response.Count>(
          await this.$axios.get('/api/product', {
            params: {
              count: true,
              idCategory: this.idCategory,
            },
          })
        ).data).count;
        this.numberPages = Math.ceil(this.total / this.perPage);
        if (tempCurrentPage > this.numberPages) {
          this.$nuxt.error({ statusCode: 404 });
          return;
        }

        this.currentPage = tempCurrentPage;
      } catch (error) {
        this.$nuxt.error({ statusCode: (<Response>error.response).status });
      }
    }

    public linkPage(page: number) {
      return `/product/category/${this.idCategory}/page/${page}`;
    }

    @Watch('currentPage')
    public async onCurrentPageChange(newValue: number) {
      try {
        this.pending = true;
        this.products = (
          await this.$axios.get('/api/product', {
            params: {
              idCategory: this.idCategory,
              start: this.perPage * this.currentPage - this.perPage,
              limit: this.perPage,
            },
          })
        ).data;
        this.rows = Math.ceil(this.products.length / 4);
      } catch (error) {
        this.$nuxt.error({ statusCode: (<Response>error.response).status });
      } finally {
        this.pending = false;
      }
    }
  }
</script>
