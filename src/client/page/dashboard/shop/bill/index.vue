<template>
  <div>
    <b-breadcrumb class="bg-light">
      <b-breadcrumb-item text="Bảng điều khiến" to="/dashboard"></b-breadcrumb-item>
      <b-breadcrumb-item text="Cửa hàng - Đơn hàng" :to="$route.path"></b-breadcrumb-item>
    </b-breadcrumb>
    <hr />
    <div v-if="$fetchState.pending" class="text-center"><b-spinner small></b-spinner> Đang tải...</div>
    <div v-else-if="!$fetchState.error">
      <b-form-group label="Trạng thái:" label-for="select-status" label-size="sm">
        <b-form-select id="select-status" v-model="statusSelected" :options="statusOptions" size="sm" :disabled="billPending"></b-form-select>
      </b-form-group>
      <div v-if="statusSelected != null">
        <div v-if="billPending" class="text-center"><b-spinner small></b-spinner> Đang tải...</div>
        <c-dashboard-table
          :title="`Danh sách đơn hàng có trạng thái ${nameStatus}`"
          :items="items"
          :fields="fields"
          :notes="notes"
          :row-class="rowClass"
          :remove-item="remove"
          v-else
        >
          <template #more-actions="{row}">
            <b-button size="sm" variant="primary" :to="linkStatus(row.item)" v-if="row.item.status == 0 || row.item.status == 1">
              <span v-if="!statusPending"><fa :icon="['fas', 'check']"></fa></span>
              <span v-else><b-spinner small></b-spinner></span>
            </b-button>
          </template>
        </c-dashboard-table>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
  import { toMoney } from '@/plugin/helper';
  import { Component, Vue, Watch } from 'nuxt-property-decorator';

  @Component({
    name: 'page-dashboard-shop-bill',
    head: {
      title: 'Bảng điều khiển - Cửa hàng - Đơn hàng',
    },
  })
  export default class extends Vue {
    private nameStatus: string | null = null;
    private items: Entity.Product[] = [];
    private fields: App.Component.Table.Field[] = [];
    private notes: App.Component.Table.Note[] = [{ label: 'Vô hiệu hoá', class: 'text-secondary bg-light font-weight-light' }];
    private statusSelected: number | null = null;
    private statusOptions: App.Control.SeleteOption[] = [
      { value: null, text: 'Chọn trạng thái', disabled: true },
      { value: 0, text: 'Chờ xác nhận' },
      { value: 1, text: 'Đang giao hàng' },
      { value: 2, text: 'Đã thanh toán' },
      { value: 3, text: 'Đã huỷ' },
    ];
    private billPending: boolean = false;
    private statusPending: boolean = false;

    public rowClass(item: Entity.Account) {
      return item.state ? null : 'text-secondary bg-light font-weight-light';
    }

    public async fetch() {}

    @Watch('statusSelected')
    public async onStatusSelectedChanged(newValue: number) {
      if (newValue != null) {
        try {
          this.billPending = true;
          this.nameStatus = this.statusOptions.filter((status) => status.value == newValue)[0].text;
          this.items = (await this.$axios.get('/api/admin/bill', { params: { status: newValue } })).data;
          this.fields = [
            { key: 'id', label: 'Id', sortable: true, class: 'd-none' },
            { key: 'customer.username', label: 'Tài khoản', sortable: true, class: 'align-middle' },
            { key: 'customer.fullName', label: 'Họ và tên', sortable: true, class: 'align-middle' },
            { key: 'createDate', label: 'Ngày tạo', sortable: true, class: 'align-middle text-md-right fit' },
            { key: 'payDate', label: 'Ngày thanh toán', sortable: true, class: 'align-middle text-md-right fit' },
            {
              key: 'total',
              label: 'Tổng cộng',
              sortable: true,
              class: 'align-middle text-md-right fit',
              formatter: (value) => toMoney(value),
              filterByFormatted: true,
              sortByFormatted: true,
            },
            {
              key: 'state',
              label: 'Trạng thái',
              sortable: true,
              class: 'd-none',
              formatter: (value) => (value == 1 ? 'Kích hoạt' : 'Vô hiệu hoá'),
              sortByFormatted: true,
              filterByFormatted: true,
            },
            { key: 'actions', label: 'Thao tác', class: 'align-middle fit' },
          ];
        } catch (error) {
          this.$nuxt.error({ statusCode: (<Response>error.response).status });
        } finally {
          this.billPending = false;
        }
      }
    }

    public async remove(id: number) {
      try {
        await this.$axios.delete('/api/admin/bill', { params: { id } });
        this.items = this.items.filter((item) => item.id != id);
        this.$nuxt.$bvToast.toast('Đã xoá đơn hàng.', {
          title: 'Xoá thành công!',
          variant: 'success',
          solid: true,
          toaster: 'b-toaster-bottom-right',
        });
      } catch (error) {
        this.$nuxt.error({ statusCode: (<Response>error.response).status });
      }
    }

    public linkStatus(bill: Entity.Bill) {
      return `/dashboard/shop/bill/${bill.id}/` + (bill.status == 0 ? 'accept' : 'confirm');
    }
  }
</script>
