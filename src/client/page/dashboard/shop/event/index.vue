<template>
  <div>
    <b-breadcrumb class="bg-light">
      <b-breadcrumb-item text="Bảng điều khiến" to="/dashboard"></b-breadcrumb-item>
      <b-breadcrumb-item text="Cửa hàng - Sự kiện" :to="$route.path"></b-breadcrumb-item>
    </b-breadcrumb>
    <hr />
    <b-button size="sm" :to="`${$route.path}/create`" variant="primary">Tạo mới</b-button>
    <hr />
    <div v-if="$fetchState.pending" class="text-center"><b-spinner small></b-spinner> Đang tải...</div>
    <c-dashboard-table
      title="Danh sách sự kiện"
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
    name: 'page-dashboard-shop-event',
    head: {
      title: 'Bảng điều khiển - Cửa hàng - Sự kiện',
    },
  })
  export default class extends Vue {
    private items: Entity.Event[] = [];
    private fields: App.Component.Table.Field[] = [];
    private notes: App.Component.Table.Note[] = [{ label: 'Vô hiệu hoá', class: 'text-secondary bg-light font-weight-light' }];

    public rowClass(item: Entity.Event) {
      return item.state ? null : 'text-secondary bg-light font-weight-light';
    }

    public async fetch() {
      try {
        this.items = (await this.$axios.get('/api/admin/event')).data;
        this.fields = [
          { key: 'id', label: 'Id', sortable: true, class: 'd-none' },
          { key: 'title', label: 'Tiêu đề', sortable: true, class: 'align-middle' },
          { key: 'post', label: 'Ngày đăng', sortable: true, class: 'align-middle fit' },
          { key: 'idAccount', label: 'Id tài khoản người viết', sortable: true, class: 'd-none' },
          {
            key: 'author',
            label: 'Tên người viết',
            sortable: true,
            class: 'align-middle',
            formatter: (author: Entity.Account) => author.fullName,
            sortByFormatted: true,
            filterByFormatted: true,
          },
          { key: 'imageUrl', label: 'Đường dẫn hình ảnh', class: 'd-none' },
          { key: 'postUrl', label: 'Đường dẫn nội dung', class: 'd-none' },
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
        await this.$axios.delete('/api/admin/event', { params: { id } });
        this.items = this.items.filter((item) => item.id != id);
        this.$nuxt.$bvToast.toast('Đã xoá sự kiện.', {
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
