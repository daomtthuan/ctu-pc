<template>
  <div>
    <b-breadcrumb class="bg-light">
      <b-breadcrumb-item text="Bảng điều khiến" to="/dashboard"></b-breadcrumb-item>
      <b-breadcrumb-item text="Quản lý truy cập - Phân quyền" to="/dashboard/access/permission"></b-breadcrumb-item>
    </b-breadcrumb>
    <hr />
    <div v-if="$fetchState.pending" class="text-center"><b-spinner small></b-spinner> Đang tải...</div>
    <c-dashboard-table :items="items" :fields="fields" :notes="notes" :row-class="rowClass" class="mt-1" v-else-if="!this.$fetchState.error"></c-dashboard-table>
  </div>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'page-dashboard-access-permission',
    head: {
      title: 'Bảng điều khiển - Quản lý truy cập - Phân quyền',
    },
  })
  export default class extends Vue {
    private items: Entity.Permission[] = [];
    private fields: Table.Field[] = [];
    private notes: Table.Note[] = [{ label: 'Vô hiệu hoá', class: 'text-secondary bg-light font-weight-light' }];

    public rowClass(item: Entity.Permission) {
      return item.state ? null : 'text-secondary bg-light font-weight-light';
    }

    public async fetch() {
      try {
        this.items = (await this.$axios.get('admin/permission')).data;
        this.fields = [
          { key: 'id', label: 'Id', sortable: true, class: 'align-middle text-md-right fit' },
          { key: 'idAccount', label: 'Id tài khoản', sortable: true, class: 'align-middle' },
          { key: 'idRole', label: 'Id quyền', sortable: true, class: 'align-middle' },
          { key: 'state', label: 'Trạng thái', sortable: true, class: 'd-none', formatter: (value) => (value == 1 ? 'Kích hoạt' : 'Vô hiệu hoá') },
          { key: 'actions', label: 'Thao tác', class: 'align-middle fit' },
        ];
      } catch (error) {
        this.$nuxt.error({ statusCode: (<Response>error.response).status });
      }
    }
  }
</script>
