<template>
  <div>
    <b-breadcrumb class="bg-light">
      <b-breadcrumb-item text="Bảng điều khiến" to="/dashboard"></b-breadcrumb-item>
      <b-breadcrumb-item text="Cửa hàng - Sản phẩm" :to="$route.path"></b-breadcrumb-item>
    </b-breadcrumb>
    <hr />
    <b-button size="sm" :to="`${$route.path}/create`" variant="primary">Tạo mới</b-button>
    <hr />
    <div v-if="$fetchState.pending" class="text-center"><b-spinner small></b-spinner> Đang tải...</div>
    <div v-else-if="!$fetchState.error">
      <b-form-group label="Nhóm danh mục:" label-for="select-category-group" label-size="sm">
        <b-form-select
          id="select-category-group"
          v-model="idCategoryGroupSelected"
          :options="categoryGroupOptions"
          size="sm"
          :disabled="categoryPending || productPending"
        ></b-form-select>
      </b-form-group>
      <div v-if="idCategoryGroupSelected != null">
        <div v-if="categoryPending" class="text-center"><b-spinner small></b-spinner> Đang tải...</div>
        <div v-else>
          <b-form-group label="Danh mục:" label-for="select-category" label-size="sm">
            <b-form-select id="select-category" v-model="idCategorySelected" :options="categoryOptions" :disabled="productPending" size="sm"></b-form-select>
          </b-form-group>
          <div v-if="idCategorySelected != null">
            <div v-if="productPending" class="text-center"><b-spinner small></b-spinner> Đang tải...</div>
            <c-dashboard-table
              :title="`Danh sách sản phẩm thuộc danh mục ${nameCategory}`"
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
    </div>
  </div>
</template>

<script lang="ts">
  import { Component, Vue, Watch } from 'nuxt-property-decorator';

  @Component({
    name: 'page-dashboard-shop-product',
    head: {
      title: 'Bảng điều khiển - Cửa hàng - Sản phẩm',
    },
  })
  export default class extends Vue {
    private nameCategory: string | null = null;
    private items: Entity.Product[] = [];
    private fields: App.Component.Table.Field[] = [];
    private notes: App.Component.Table.Note[] = [{ label: 'Vô hiệu hoá', class: 'text-secondary bg-light font-weight-light' }];
    private idCategoryGroupSelected: number | null = null;
    private idCategorySelected: number | null = null;
    private categoryGroupOptions: App.Control.SeleteOption[] = [{ value: null, text: 'Chọn nhóm danh mục', disabled: true }];
    private categoryOptions: App.Control.SeleteOption[] = [];
    private categoryPending: boolean = false;
    private productPending: boolean = false;

    public rowClass(item: Entity.Account) {
      return item.state ? null : 'text-secondary bg-light font-weight-light';
    }

    public async fetch() {
      try {
        let categoryGroups: Entity.CategoryGroup[] = (await this.$axios.get('/api/admin/category-group')).data;
        if (categoryGroups.length > 0) {
          this.categoryGroupOptions = [{ value: null, text: 'Chọn nhóm danh mục', disabled: true }];
          for (let categoryGroup of categoryGroups) {
            this.categoryGroupOptions.push({ value: categoryGroup.id, text: categoryGroup.name });
          }
        } else {
          this.categoryGroupOptions = [{ value: null, text: 'Không có nhóm danh mục nào', disabled: true }];
        }
      } catch (error) {
        this.$nuxt.error({ statusCode: (<Response>error.response).status });
      }
    }

    @Watch('idCategoryGroupSelected')
    public async onIdCategoryGroupSelectedChanged(newValue: number) {
      if (newValue != null) {
        try {
          this.categoryPending = true;
          let categories: Entity.Category[] = (await this.$axios.get('/api/admin/category', { params: { idCategoryGroup: newValue } })).data;
          if (categories.length > 0) {
            this.categoryOptions = [{ value: null, text: 'Chọn danh mục', disabled: true }];
            for (let category of categories) {
              this.categoryOptions.push({ value: category.id, text: category.name });
            }
          } else {
            this.categoryOptions = [{ value: null, text: 'Không có danh mục nào', disabled: true }];
          }
          this.idCategorySelected = null;
        } catch (error) {
          this.$nuxt.error({ statusCode: (<Response>error.response).status });
        } finally {
          this.categoryPending = false;
        }
      }
    }

    @Watch('idCategorySelected')
    public async onIdCategorySelectedChanged(newValue: number) {
      if (newValue != null) {
        try {
          this.productPending = true;
          this.nameCategory = this.categoryOptions.filter((category) => category.value == newValue)[0].text;
          this.items = (await this.$axios.get('/api/admin/product', { params: { idCategory: newValue } })).data;
          this.fields = [
            { key: 'id', label: 'Id', sortable: true, class: 'd-none' },
            { key: 'name', label: 'Tên', sortable: true, class: 'align-middle' },
            { key: 'price', label: 'Đơn giá', sortable: true, class: 'align-middle text-md-right' },
            { key: 'quantity', label: 'Số lượng', sortable: true, class: 'align-middle text-md-right' },
            {
              key: 'brand',
              label: 'Thương hiệu',
              sortable: true,
              class: 'align-middle',
              formatter: (value: Entity.Brand) => value.name,
              sortByFormatted: true,
              filterByFormatted: true,
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
          this.productPending = false;
        }
      }
    }

    public async remove(id: number) {
      try {
        await this.$axios.delete('/api/admin/product', { params: { id } });
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
