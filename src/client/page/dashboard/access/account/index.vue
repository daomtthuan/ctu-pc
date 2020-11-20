<template>
  <div>
    <b-breadcrumb class="bg-light">
      <b-breadcrumb-item text="Bảng điều khiến" to="/dashboard"></b-breadcrumb-item>
      <b-breadcrumb-item text="Quản lý truy cập - Tài khoản" :to="$route.path"></b-breadcrumb-item>
    </b-breadcrumb>
    <hr />
    <div v-if="$fetchState.pending" class="text-center"><b-spinner small></b-spinner> Đang tải...</div>
    <c-dashboard-table :items="items" :fields="fields" :notes="notes" :row-class="rowClass" class="mt-1" :remove-item="remove" v-else-if="!this.$fetchState.error"></c-dashboard-table>
  </div>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'page-dashboard-access-account',
    head: {
      title: 'Bảng điều khiển - Quản lý truy cập - Tài khoản',
    },
  })
  export default class extends Vue {
    private items: Entity.Account[] = [];
    private fields: Table.Field[] = [];
    private notes: Table.Note[] = [{ label: 'Vô hiệu hoá', class: 'text-secondary bg-light font-weight-light' }];

    public rowClass(item: Entity.Account) {
      return item.state ? null : 'text-secondary bg-light font-weight-light';
    }

    public async fetch() {
      try {
        this.items = (await this.$axios.get('admin/account')).data;
        this.fields = [
          { key: 'id', label: 'Id', sortable: true, class: 'align-middle text-md-right fit' },
          { key: 'username', label: 'Tài khoản', sortable: true, class: 'align-middle' },
          { key: 'fullName', label: 'Họ và tên', sortable: true, class: 'align-middle' },
          { key: 'birthday', label: 'Ngày sinh', sortable: true, class: 'align-middle' },
          { key: 'gender', label: 'Giới tính', sortable: true, class: 'align-middle', formatter: (value) => (value == 1 ? 'Nam' : 'Nữ'), sortByFormatted: true, filterByFormatted: true },
          { key: 'email', label: 'Email', sortable: true, class: 'align-middle' },
          { key: 'address', label: 'Địa chỉ', sortable: true, class: 'd-none' },
          { key: 'phone', label: 'Điện thoại', sortable: true, class: 'align-middle' },
          { key: 'state', label: 'Trạng thái', sortable: true, class: 'd-none', formatter: (value) => (value == 1 ? 'Kích hoạt' : 'Vô hiệu hoá'), sortByFormatted: true, filterByFormatted: true },
          { key: 'actions', label: 'Thao tác', class: 'align-middle fit' },
        ];
      } catch (error) {
        this.$nuxt.error({ statusCode: (<Response>error.response).status });
      }
    }

    public async remove(id: number) {
      try {
        await this.$axios.delete('admin/account', { params: { id } });
        this.items = this.items.filter((item) => item.id != id);
      } catch (error) {
        this.$nuxt.error({ statusCode: (<Response>error.response).status });
      }
    }
  }
</script>
