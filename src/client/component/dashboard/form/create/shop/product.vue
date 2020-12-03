<template>
  <div class="text-center" v-if="$fetchState.pending"><b-spinner small></b-spinner> Đang tải...</div>
  <b-form @submit.prevent="submit" v-else-if="!$fetchState.error">
    <b-row>
      <b-col lg="6">
        <b-form-group label="Tên:" label-for="input-name">
          <b-form-input id="input-name" type="text" placeholder="Nhập tên" v-model="$v.form.name.$model" :state="validateState('name')"></b-form-input>
          <b-form-invalid-feedback>Tên không hợp lệ</b-form-invalid-feedback>
        </b-form-group>
        <b-form-group label="Đơn giá:" label-for="input-price">
          <b-form-input id="input-price" type="number" placeholder="Nhập đơn giá" v-model="$v.form.price.$model" :state="validateState('price')"></b-form-input>
          <b-form-invalid-feedback>Đơn giá không hợp lệ</b-form-invalid-feedback>
        </b-form-group>
        <b-form-group label="Số lượng:" label-for="input-quantity">
          <b-form-input
            id="input-quantity"
            type="number"
            placeholder="Nhập số lượng"
            v-model="$v.form.quantity.$model"
            :state="validateState('quantity')"
          ></b-form-input>
          <b-form-invalid-feedback>Số lượng không hợp lệ</b-form-invalid-feedback>
        </b-form-group>
      </b-col>
      <b-col lg="6">
        <b-form-group label="Nhóm danh mục:" label-for="select-category-group">
          <b-form-select
            id="select-category-group"
            v-model="$v.form.idCategoryGroup.$model"
            :options="categoryGroupOptions"
            :state="validateState('idCategoryGroup')"
            :disabled="categoryPending"
          ></b-form-select>
          <b-form-invalid-feedback>Nhóm danh mục không hợp lệ</b-form-invalid-feedback>
        </b-form-group>
        <div v-if="form.idCategoryGroup != null">
          <div class="text-center" v-if="categoryPending"><b-spinner small></b-spinner> Đang tải...</div>
          <b-form-group label="Danh mục:" label-for="select-category" v-else>
            <b-form-select
              id="select-category"
              v-model="$v.form.idCategory.$model"
              :options="categoryOptions"
              :state="validateState('idCategory')"
            ></b-form-select>
            <b-form-invalid-feedback>Danh mục không hợp lệ</b-form-invalid-feedback>
          </b-form-group>
        </div>
        <b-form-group label="Thương hiệu:" label-for="select-brand">
          <b-form-select id="select-brand" v-model="$v.form.idBrand.$model" :options="brandOptions" :state="validateState('idBrand')"></b-form-select>
          <b-form-invalid-feedback>Thương hiệu không hợp lệ</b-form-invalid-feedback>
        </b-form-group>
      </b-col>
    </b-row>

    <b-form-group class="text-center">
      <b-button type="submit" variant="primary" :disabled="pending">
        <span v-if="!pending">Tạo mới</span>
        <span v-else><b-spinner small></b-spinner> Xử lý...</span>
      </b-button>
    </b-form-group>
  </b-form>
</template>

<script lang="ts">
  import { createValidation, getValidateState, resetForm, validationMixin } from '@/plugin/validation';
  import { Component, mixins, Vue, Watch } from 'nuxt-property-decorator';

  @Component({
    name: 'component-dashboard-form-create-shop-product',
    validations: createValidation('name', 'idCategoryGroup', 'idCategory', 'idBrand', 'price', 'quantity'),
  })
  export default class extends mixins(validationMixin) {
    private form: App.Form.Create.Shop.Product = {
      name: null,
      idCategoryGroup: null,
      idCategory: null,
      idBrand: null,
      price: null,
      quantity: null,
    };
    private categoryGroupOptions: App.Control.SeleteOption[] = [];
    private categoryOptions: App.Control.SeleteOption[] = [];
    private brandOptions: App.Control.SeleteOption[] = [];
    private pending: boolean = false;
    private categoryPending: boolean = false;

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

        let brands: Entity.Brand[] = (await this.$axios.get('/api/admin/brand')).data;
        if (brands.length > 0) {
          this.brandOptions = [{ value: null, text: 'Chọn thương hiệu', disabled: true }];
          for (let brand of brands) {
            this.brandOptions.push({ value: brand.id, text: brand.name });
          }
        } else {
          this.brandOptions = [{ value: null, text: 'Không có thương hiệu nào', disabled: true }];
        }
      } catch (error) {
        this.$nuxt.error({ statusCode: (<Response>error.response).status });
      }
    }

    public validateState(name: string) {
      return getValidateState(this, name);
    }

    public async submit() {
      this.$v.form.$touch();
      if (this.$v.$anyError) {
        return;
      }

      try {
        this.pending = true;
        let form: any = { ...this.form };
        delete form.idCategoryGroup;
        await this.$axios.post('/api/admin/product', form);

        resetForm(this);
        this.$nuxt.$bvToast.toast('Đã tạo mới sản phẩm.', {
          title: 'Tạo mới thành công!',
          variant: 'success',
          solid: true,
          toaster: 'b-toaster-bottom-right',
        });
      } catch (error) {
        this.$nuxt.error({ statusCode: (<Response>error.response).status });
      } finally {
        this.pending = false;
      }
    }

    @Watch('form.idCategoryGroup')
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
          this.form.idCategory = null;
        } catch (error) {
          this.$nuxt.error({ statusCode: (<Response>error.response).status });
        } finally {
          this.categoryPending = false;
        }
      } else {
        this.categoryOptions = [];
      }
    }
  }
</script>
