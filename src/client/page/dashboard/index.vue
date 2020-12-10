<template>
  <div>
    <b-breadcrumb class="bg-light">
      <b-breadcrumb-item text="Bảng điều khiến" :to="$route.path"></b-breadcrumb-item>
    </b-breadcrumb>
    <hr />
    <div class="text-center" v-if="$fetchState.pending"><b-spinner small></b-spinner> Đang tải...</div>
    <div v-else-if="!$fetchState.error">
      <h4>Thống kê chung</h4>
      <b-row>
        <b-col md="6" lg="3" class="my-3">
          <b-card border-variant="primary">
            <b-card-body>
              <h6>Số lượng khách hàng</h6>
              <h3>{{ numberCustomers }}</h3>
            </b-card-body>
          </b-card>
        </b-col>
        <b-col md="6" lg="3" class="my-3">
          <b-card border-variant="primary">
            <b-card-body>
              <h6>Số lượng sản phẩm</h6>
              <h3>{{ numberProducts }}</h3>
            </b-card-body>
          </b-card>
        </b-col>
        <b-col md="6" lg="3" class="my-3">
          <b-card border-variant="primary">
            <b-card-body>
              <h6>Số lượng đơn hàng</h6>
              <h3>{{ numberBills }}</h3>
            </b-card-body>
          </b-card>
        </b-col>
        <b-col md="6" lg="3" class="my-3">
          <b-card border-variant="primary">
            <b-card-body>
              <h6>Đánh giá 5 sao</h6>
              <h3>{{ numberFiveStarReviews }}</h3>
            </b-card-body>
          </b-card>
        </b-col>
      </b-row>
      <h4>Doanh thu theo tháng</h4>
      <c-chart-area label="Doanh thu (nghìn vnđ)" v-model="revenues"></c-chart-area>
    </div>
  </div>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'page-dashboard-home',
    head: {
      title: 'Bảng điều khiển - Trang chủ',
    },
  })
  export default class extends Vue {
    private numberCustomers: number = 0;
    private numberProducts: number = 0;
    private numberBills: number = 0;
    private numberFiveStarReviews: number = 0;
    private revenues: number[] = [];

    public async fetch() {
      try {
        this.numberCustomers = (await this.$axios.get('/api/admin/report/account', { params: { numberCustomers: true } })).data.count;
        this.numberProducts = (await this.$axios.get('/api/admin/report/product', { params: { numberProducts: true } })).data.count;
        this.numberBills = (await this.$axios.get('/api/admin/report/bill', { params: { numberBills: true } })).data.count;
        this.numberFiveStarReviews = (await this.$axios.get('/api/admin/report/review', { params: { numberFiveStarReviews: true } })).data.count;
        let revenues: { month: string; total: string }[] = (await this.$axios.get('/api/admin/report/revenue', { params: { month: true } })).data;
        console.log(revenues);

        for (let month = 1; month <= 12; month++) {
          let index = revenues.findIndex((revenue) => parseInt(revenue.month) == month);
          if (index == -1) {
            this.revenues.push(0);
          } else {
            this.revenues.push(parseFloat(revenues[index].total));
          }
        }
      } catch (error) {
        let response = <Response>error.response;
        this.$nuxt.error({ statusCode: response.status });
      }
    }
  }
</script>
