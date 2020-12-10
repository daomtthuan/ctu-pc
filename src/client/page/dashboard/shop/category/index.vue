<template>
  <div>
    <b-breadcrumb class="bg-light">
      <b-breadcrumb-item text="Bảng điều khiến" to="/dashboard"></b-breadcrumb-item>
      <b-breadcrumb-item text="Cửa hàng - Danh mục" :to="$route.path"></b-breadcrumb-item>
    </b-breadcrumb>
    <hr />
    <b-button size="sm" :to="`${$route.path}/create`" variant="primary">Tạo mới</b-button>
    <hr />
    <div v-if="$fetchState.pending" class="text-center"><b-spinner small></b-spinner> Đang tải...</div>
    <div v-else-if="!$fetchState.error">
      <b-form-group label="Nhóm danh mục:" label-for="select-category-group" label-size="sm">
        <b-form-select id="select-category-group" v-model="selected" :options="options" :disabled="pending" size="sm"></b-form-select>
      </b-form-group>
      <div v-if="selected != null">
        <div v-if="pending" class="text-center"><b-spinner small></b-spinner> Đang tải...</div>
        <c-dashboard-table
          :title="`Danh sách danh mục thuộc nhóm danh mục ${nameCategoryGroup}`"
          :items="items"
          :fields="fields"
          :notes="notes"
          :row-class="rowClass"
          :remove-item="remove"
          v-else
        ></c-dashboard-table>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
  import { Component, Vue, Watch } from 'nuxt-property-decorator';

  @Component({
    name: 'page-dashboard-shop-category',
    head: {
      title: 'Bảng điều khiển - Cửa hàng - Danh mục',
    },
  })
  export default class extends Vue {
    private nameCategoryGroup: string | null = null;
    private items: Entity.Category[] = [];
    private fields: App.Component.Table.Field[] = [];
    private notes: App.Component.Table.Note[] = [{ label: 'Vô hiệu hoá', class: 'text-secondary bg-light font-weight-light' }];
    private selected: number | null = null;
    private options: App.Control.SeleteOption[] = [];
    private pending: boolean = false;

    public rowClass(item: Entity.Account) {
      return item.state ? null : 'text-secondary bg-light font-weight-light';
    }

    public async fetch() {
      try {
        let categoryGroups: Entity.CategoryGroup[] = (await this.$axios.get('/api/admin/category-group')).data;
        if (categoryGroups.length > 0) {
          this.options = [{ value: null, text: 'Chọn nhóm danh mục', disabled: true }];
          for (let categoryGroup of categoryGroups) {
            this.options.push({ value: categoryGroup.id, text: categoryGroup.name });
          }
        } else {
          this.options = [{ value: null, text: 'Không có nhóm danh mục nào', disabled: true }];
        }
      } catch (error) {
        this.$nuxt.error({ statusCode: (<Response>error.response).status });
      }
    }

    @Watch('selected')
    public async onSelectedChanged(newValue: number) {
      if (newValue != null) {
        try {
          this.pending = true;
          this.nameCategoryGroup = this.options.filter((categoryGroup) => categoryGroup.value == newValue)[0].text;
          this.items = (await this.$axios.get('/api/admin/category', { params: { idCategoryGroup: newValue } })).data;
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
        } finally {
          this.pending = false;
        }
      }
    }

    public async remove(id: number) {
      try {
        await this.$axios.delete('/api/admin/category', { params: { id } });
        this.items = this.items.filter((item) => item.id != id);
        this.$nuxt.$bvToast.toast('Đã xoá danh mục.', {
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
