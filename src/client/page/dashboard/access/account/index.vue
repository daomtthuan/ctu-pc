<template>
  <div>
    <b-breadcrumb class="bg-light">
      <b-breadcrumb-item text="Bảng điều khiến" to="/dashboard"></b-breadcrumb-item>
      <b-breadcrumb-item text="Truy cập - Tài khoản" :to="$route.path"></b-breadcrumb-item>
    </b-breadcrumb>
    <hr />
    <b-button size="sm" :to="`${$route.path}/create`" variant="primary">Tạo mới</b-button>
    <hr />
    <div v-if="$fetchState.pending" class="text-center"><b-spinner small></b-spinner> Đang tải...</div>
    <c-dashboard-table
      title="Danh sách tài khoản"
      :items="items"
      :fields="fields"
      :notes="notes"
      :row-class="rowClass"
      :remove-item="remove"
      v-else-if="!$fetchState.error"
    ></c-dashboard-table>
  </div>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'page-dashboard-access-account',
    head: {
      title: 'Bảng điều khiển - Truy cập - Tài khoản',
    },
  })
  export default class extends Vue {
    private items: Entity.Account[] = [];
    private fields: App.Component.Table.Field[] = [];
    private notes: App.Component.Table.Note[] = [{ label: 'Vô hiệu hoá', class: 'text-secondary bg-light font-weight-light' }];

    public rowClass(item: Entity.Account) {
      return item.state ? null : 'text-secondary bg-light font-weight-light';
    }

    public async fetch() {
      try {
        this.items = (await this.$axios.get('/api/admin/account')).data;
        this.fields = [
          { key: 'id', label: 'Id', sortable: true, class: 'd-none' },
          { key: 'username', label: 'Tài khoản', sortable: true, class: 'align-middle fit' },
          { key: 'fullName', label: 'Họ và tên', sortable: true, class: 'align-middle' },
          { key: 'birthday', label: 'Ngày sinh', sortable: true, class: 'align-middle text-md-right fit' },
          {
            key: 'gender',
            label: 'Giới tính',
            sortable: true,
            class: 'align-middle fit',
            formatter: (value) => (value == 1 ? 'Nam' : 'Nữ'),
            sortByFormatted: true,
            filterByFormatted: true,
          },
          { key: 'email', label: 'Email', sortable: true, class: 'align-middle' },
          { key: 'address', label: 'Địa chỉ', sortable: true, class: 'align-middle' },
          { key: 'phone', label: 'Điện thoại', sortable: true, class: 'align-middle' },
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
      }
    }

    public async remove(id: number) {
      try {
        await this.$axios.delete('/api/admin/account', { params: { id } });
        this.items = this.items.filter((item) => item.id != id);
        this.$nuxt.$bvToast.toast('Đã xoá tài khoản.', {
          title: 'Xoá thành công!',
          variant: 'success',
          solid: true,
          toaster: 'b-toaster-bottom-right',
        });
      } catch (error) {
        this.$nuxt.error({ statusCode: (<Response>error.response).status });
      }
    }
  }
</script>
