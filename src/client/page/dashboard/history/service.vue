<template>
  <div>
    <b-breadcrumb class="bg-light">
      <b-breadcrumb-item text="Bảng điều khiến" to="/dashboard"></b-breadcrumb-item>
      <b-breadcrumb-item text="Quản lý lịch sử - Dịch vụ" :to="$route.path"></b-breadcrumb-item>
    </b-breadcrumb>
    <hr />
    <div v-if="$fetchState.pending" class="text-center"><b-spinner small></b-spinner> Đang tải...</div>
    <div v-else-if="!this.$fetchState.error">
      <b-form-group label="Ngày:" label-size="sm" label-for="input-date">
        <date-picker
          :input-attr="{ id: 'input-date', name: 'date' }"
          input-class="form-control form-control-sm"
          :clearable="false"
          value-type="YYYY-MM-DD"
          format="DD-MM-YYYY"
          popup-class="rounded border shadow"
          placeholder="Nhập ngày xem lịch sử"
          v-model="date"
          class="w-100"
          prefix-class="date-picker"
        >
          <template #icon-calendar>
            <i></i>
          </template>
        </date-picker>
      </b-form-group>
      <div v-if="pending" class="text-center"><b-spinner small></b-spinner> Đang tải...</div>
      <c-dashboard-table
        :title="`Lịch sử dịch vụ ngày ${formatDate}`"
        :items="items"
        :fields="fields"
        class="mt-1"
        :allow-create="false"
        :allow-edit="false"
        :allow-remove="false"
        v-else
      ></c-dashboard-table>
    </div>
  </div>
</template>

<script lang="ts">
  import { Component, Vue, Watch } from 'nuxt-property-decorator';
  import { DatePicker } from '@/plugin/datepicker';

  @Component({
    name: 'page-dashboard-history-service',
    components: { DatePicker },
    head: {
      title: 'Bảng điều khiển - Quản lý lịch sử - Dịch vụ',
    },
  })
  export default class extends Vue {
    private items: Entity.Account[] = [];
    private fields: App.Component.Table.Field[] = [];
    private date: string | null = null;
    private formatDate: string | null = null;
    private pending: boolean = false;

    public async fetch() {
      let today = new Date();
      this.date = `${today.getFullYear()}-${today.getMonth() + 1}-${today.getDate()}`;
    }

    @Watch('date')
    public async onDateChanged() {
      try {
        this.pending = true;
        let tempDate = new Date(this.date!);
        this.formatDate = `${tempDate.getDate()}-${tempDate.getMonth() + 1}-${tempDate.getFullYear()}`;
        this.items = (await this.$axios.get('admin/log/service', { params: { date: this.date } })).data;
        this.fields = [
          { key: 'time', label: 'Thời gian', sortable: true, class: 'align-middle text-md-right fit' },
          { key: 'mac', label: 'Địa chỉ vật lý', sortable: true, class: 'align-middle fit' },
          {
            key: 'account',
            label: 'Tài khoản',
            sortable: true,
            class: 'align-middle fit',
            formatter: (value: Entity.Account) => value.username,
            sortByFormatted: true,
            filterByFormatted: true,
          },
          { key: 'url', label: 'Đường dẫn', sortable: true, class: 'align-middle' },
          { key: 'params', label: 'Tham số', sortable: true, class: 'align-middle' },
          { key: 'method', label: 'Phương thức', sortable: true, class: 'align-middle fit' },
          { key: 'status', label: 'Trạng thái', sortable: true, class: 'align-middle fit' },
          { key: 'actions', label: 'Thao tác', class: 'align-middle fit' },
        ];
      } catch (error) {
        this.$nuxt.error({ statusCode: (<Response>error.response).status });
      } finally {
        this.pending = false;
      }
    }
  }
</script>
