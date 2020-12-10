<template>
  <b-container>
    <b-card border-variant="primary">
      <b-card-body>
        <b-card-title title-tag="h2" class="text-primary">
          Đơn hàng
        </b-card-title>
        <hr />
        <b-nav tabs>
          <b-nav-item :active="status == 0" to="/account/bill/status/pending">Chờ xác nhận</b-nav-item>
          <b-nav-item :active="status == 1" to="/account/bill/status/shipping">Đang giao hàng</b-nav-item>
          <b-nav-item :active="status == 2" to="/account/bill/status/paid">Đã thanh toán</b-nav-item>
          <b-nav-item :active="status == 3" to="/account/bill/status/cancel">Đã huỷ</b-nav-item>
        </b-nav>
        <div v-if="$fetchState.pending || pending" class="text-center mt-3"><b-spinner small></b-spinner> Đang tải...</div>
        <div v-else-if="!$fetchState.error">
          <div v-if="bills.length == 0" class="text-center mt-3"><small>Không có đơn hàng nào</small></div>
          <div v-else>
            <b-card no-body class="mt-3" border-variant="primary" v-for="bill in bills" :key="bill.id">
              <b-row no-gutters>
                <b-col lg="4" md="6">
                  <div
                    class="w-100 h-100 d-none d-md-block"
                    :style="{
                      backgroundImage: `url('${bill.imageUrl}')`,
                      backgroundSize: 'cover',
                      backgroundPosition: 'center',
                      backgroundRepeat: 'no-repeat',
                    }"
                  ></div>
                  <div
                    class="w-100 d-block d-md-none"
                    :style="{
                      backgroundImage: `url('${bill.imageUrl}')`,
                      backgroundSize: 'cover',
                      backgroundPosition: 'center',
                      backgroundRepeat: 'no-repeat',
                      height: 'calc(100vh / 3)',
                    }"
                  ></div>
                </b-col>
                <b-col lg="8" md="6">
                  <b-card-body>
                    <div>
                      Ngày tạo: {{ bill.createDate }}<br />
                      Tổng sản phẩm: {{ bill.numberProductCarts }}
                    </div>
                    <h6>Tình trạng: {{ nameStatus }}</h6>
                    <h5 class="text-right">
                      Tổng cộng: <span class="text-primary">{{ toMoney(bill.total) }}</span>
                    </h5>
                    <div class="text-right">
                      <hr />
                      <b-button variant="danger" @click.prevent="cancel(bill.id)" v-if="status == 0" class="mr-2">Huỷ đơn hàng</b-button>
                      <b-button :to="`/account/bill/${bill.id}`" v-if="status == 2" class="mr-2">Đánh giá</b-button>
                      <b-button variant="primary" :to="`/account/bill/${bill.id}`">Xem chi tiết</b-button>
                    </div>
                  </b-card-body>
                </b-col>
              </b-row>
            </b-card>
          </div>
        </div>
      </b-card-body>
    </b-card>
  </b-container>
</template>

<script lang="ts">
  import { toMoney } from '@/plugin/helper';
  import { Component, Vue, Watch } from 'nuxt-property-decorator';

  @Component({
    name: 'page-account-bill-list',
    head: {
      title: 'Đơn hàng',
    },
    methods: { toMoney },
  })
  export default class extends Vue {
    private bills: Entity.Bill[] = [];
    private pending: boolean = false;

    public async fetch() {
      let status = this.$route.params.status ? this.$route.params.status.toLowerCase() : 'pending';
      if (status != 'pending' && status != 'shipping' && status != 'paid' && status != 'cancel') {
        this.$nuxt.error({ statusCode: 404 });
        return;
      }

      try {
        this.bills = (await this.$axios.get('/api/user/bill', { params: { status: this.status } })).data;
      } catch (error) {
        this.$nuxt.error({ statusCode: (<Response>error.response).status });
      }
    }

    @Watch('$route.params.status')
    public async onStatusChanged() {
      this.$fetch();
    }

    public async cancel(idBill: number) {
      try {
        this.pending = true;
        await this.$axios.delete('/api/user/bill', { params: { id: idBill } });
        this.bills = this.bills.filter((bill) => bill.id != idBill);
      } catch (error) {
        this.$nuxt.error({ statusCode: (<Response>error.response).status });
      } finally {
        this.pending = false;
      }
    }

    public get status() {
      switch (this.$route.params.status) {
        case 'pending':
          return 0;

        case 'shipping':
          return 1;

        case 'paid':
          return 2;

        case 'cancel':
          return 3;
      }
    }

    public get nameStatus() {
      switch (this.status) {
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
