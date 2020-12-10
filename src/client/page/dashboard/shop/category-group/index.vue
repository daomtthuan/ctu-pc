<template>
  <div>
    <b-breadcrumb class="bg-light">
      <b-breadcrumb-item text="Bảng điều khiến" to="/dashboard"></b-breadcrumb-item>
      <b-breadcrumb-item text="Cửa hàng - Nhóm danh mục" :to="$route.path"></b-breadcrumb-item>
    </b-breadcrumb>
    <hr />
    <b-button size="sm" :to="`${$route.path}/create`" variant="primary">Tạo mới</b-button>
    <hr />
    <div v-if="$fetchState.pending" class="text-center"><b-spinner small></b-spinner> Đang tải...</div>
    <c-dashboard-table
      title="Danh sách nhóm danh mục"
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
    name: 'page-dashboard-shop-category-group',
    head: {
      title: 'Bảng điều khiển - Cửa hàng - Nhóm danh mục',
    },
  })
  export default class extends Vue {
    private items: Entity.CategoryGroup[] = [];
    private fields: App.Component.Table.Field[] = [];
    private notes: App.Component.Table.Note[] = [{ label: 'Vô hiệu hoá', class: 'text-secondary bg-light font-weight-light' }];

    public rowClass(item: Entity.CategoryGroup) {
      return item.state ? null : 'text-secondary bg-light font-weight-light';
    }

    public async fetch() {
      try {
        this.items = (await this.$axios.get('/api/admin/category-group')).data;
        this.fields = [
          { key: 'id', label: 'Id', sortable: true, class: 'd-none' },
          { key: 'name', label: 'Tên', sortable: true, class: 'align-middle' },
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
        await this.$axios.delete('/api/admin/category-group', { params: { id } });
        this.items = this.items.filter((item) => item.id != id);
        this.$nuxt.$bvToast.toast('Đã xoá nhóm danh mục.', {
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
