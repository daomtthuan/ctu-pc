<template>
  <div>
    <b-breadcrumb class="bg-light">
      <b-breadcrumb-item text="Bảng điều khiến" to="/dashboard"></b-breadcrumb-item>
      <b-breadcrumb-item text="Truy cập - Quyền truy cập" to="/dashboard/access/role"></b-breadcrumb-item>
    </b-breadcrumb>
    <hr />
    <div v-if="$fetchState.pending" class="text-center"><b-spinner small></b-spinner> Đang tải...</div>
    <c-dashboard-table
      title="Danh sách quyền truy cập"
      :items="items"
      :fields="fields"
      :notes="notes"
      :row-class="rowClass"
      v-else-if="!$fetchState.error"
      :allow-create="false"
      :allow-remove="false"
    ></c-dashboard-table>
  </div>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'page-dashboard-access-role',
    head: {
      title: 'Bảng điều khiển - Truy cập - Quyền truy cập',
    },
  })
  export default class extends Vue {
    private items: Entity.Role[] = [];
    private fields: App.Component.Table.Field[] = [];
    private notes: App.Component.Table.Note[] = [{ label: 'Vô hiệu hoá', class: 'text-secondary bg-light font-weight-light' }];

    public rowClass(item: Entity.Role) {
      return item.state ? null : 'text-secondary bg-light font-weight-light';
    }

    public async fetch() {
      try {
        this.items = (await this.$axios.get('/api/admin/role')).data;
        this.fields = [
          { key: 'id', label: 'Id', sortable: true, class: 'd-none' },
          { key: 'name', label: 'Quyền', sortable: true, class: 'align-middle' },
          { key: 'state', label: 'Trạng thái', sortable: true, class: 'd-none', formatter: (value) => (value == 1 ? 'Kích hoạt' : 'Vô hiệu hoá') },
          { key: 'actions', label: 'Thao tác', class: 'align-middle fit' },
        ];
      } catch (error) {
        this.$nuxt.error({ statusCode: (<Response>error.response).status });
      }
    }
  }
</script>
