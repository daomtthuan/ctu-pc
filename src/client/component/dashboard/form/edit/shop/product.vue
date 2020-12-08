<template>
  <div class="text-center" v-if="$fetchState.pending"><b-spinner small></b-spinner> Đang tải...</div>
  <b-form @submit.prevent="submit" v-else-if="!$fetchState.error">
    <b-form-group label="Trạng thái:">
      <b-form-radio-group class="py-2" v-model="$v.form.state.$model" :state="validateState('state')">
        <b-form-radio id="radio-state-enabled"  :value="true">Kích hoạt</b-form-radio>
        <b-form-radio id="radio-state-disabled"  :value="false">Vô hiệu hoá</b-form-radio>
      </b-form-radio-group>
      <div class="text-danger small mt-1" v-show="validateState('state') === false">Trạng thái không hợp lệ</div>
    </b-form-group>
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
    <b-form-group label="Hình ảnh 1:" label-for="file-image-1">
      <b-form-file
        id="file-image-1"
        v-model="form.image1"
        placeholder="Chọn hoặc kéo thả ảnh vào đây..."
        drop-placeholder="Thả ảnh vào đây..."
        browse-text="Chọn"
        accept=".jpg"
      ></b-form-file>
    </b-form-group>
    <b-form-group label="Hình ảnh 2:" label-for="file-image-2">
      <b-form-file
        id="file-image-2"
        v-model="form.image2"
        placeholder="Chọn hoặc kéo thả ảnh vào đây..."
        drop-placeholder="Thả ảnh vào đây..."
        browse-text="Chọn"
        accept=".jpg"
      ></b-form-file>
    </b-form-group>
    <b-form-group label="Hình ảnh 3:" label-for="file-image-3">
      <b-form-file
        id="file-image-3"
        v-model="form.image3"
        placeholder="Chọn hoặc kéo thả ảnh vào đây..."
        drop-placeholder="Thả ảnh vào đây..."
        browse-text="Chọn"
        accept=".jpg"
      ></b-form-file>
    </b-form-group>
    <b-form-group>
      <label class="d-block" @click="focusContent">Nội dung:</label>
      <vue-editor id="input-content" v-model="$v.form.content.$model" :class="contentClass" placeholder="Nhập nội dung" />
      <b-form-invalid-feedback>Nội dung không hợp lệ</b-form-invalid-feedback>
    </b-form-group>

    <b-form-group class="text-center">
      <b-button type="submit" variant="primary" :disabled="pending">
        <span v-if="!pending">Chỉnh sửa</span>
        <span v-else><b-spinner small></b-spinner> Xử lý...</span>
      </b-button>
    </b-form-group>
  </b-form>
</template>

<script lang="ts">
  import { focusEditor } from '@/plugin/editor';
  import { createValidation, getValidateState, validationMixin } from '@/plugin/validation';
  import { Component, mixins, Prop, Vue, Watch } from 'nuxt-property-decorator';

  @Component({
    name: 'component-dashboard-form-edit-shop-product',
    validations: createValidation('name', 'idCategoryGroup', 'idCategory', 'idBrand', 'price', 'quantity', 'content', 'state'),
  })
  export default class extends mixins(validationMixin) {
    @Prop({ type: String, required: true })
    private id!: number;

    private form: App.Form.Edit.Shop.Product = {
      name: null,
      idCategoryGroup: null,
      idCategory: null,
      idBrand: null,
      price: null,
      quantity: null,
      image1: null,
      image2: null,
      image3: null,
      content: null,
      state: null,
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

        let products: Entity.Product[] = (await this.$axios.get('/api/admin/product', { params: { id: this.id } })).data;
        if (products.length == 1) {
          this.form.name = products[0].name;
          this.form.idBrand = products[0].idBrand;
          this.form.price = products[0].price;
          this.form.quantity = products[0].quantity;
          this.form.content = (await this.$axios.get(products[0].postUrl)).data;
          this.form.state = products[0].state;
        } else {
          this.$nuxt.error({ statusCode: 404 });
        }

        let categories: Entity.Category[] = (await this.$axios.get('/api/admin/category', { params: { id: products[0].idCategory } })).data;
        if (categories.length == 1) {
          this.form.idCategoryGroup = categories[0].idCategoryGroup;
          this.form.idCategory = products[0].idCategory;
        } else {
          this.$nuxt.error({ statusCode: 404 });
        }
      } catch (error) {
        this.$nuxt.error({ statusCode: (<Response>error.response).status });
      }
    }

    @Watch('form.idCategoryGroup')
    public async onIdCategoryGroupSelectedChanged(newValue: number) {
      if (newValue != null) {
        let fetchPending = this.$fetchState.pending;
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

          if (!fetchPending) {
            this.form.idCategory = null;
          }
        } catch (error) {
          this.$nuxt.error({ statusCode: (<Response>error.response).status });
        } finally {
          this.categoryPending = false;
        }
      } else {
        this.categoryOptions = [];
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
        let formData = new FormData();
        formData.append('name', JSON.stringify({ data: this.form.name }));
        formData.append('idCategory', JSON.stringify({ data: this.form.idCategory }));
        formData.append('idBrand', JSON.stringify({ data: this.form.idBrand }));
        formData.append('price', JSON.stringify({ data: this.form.price }));
        formData.append('quantity', JSON.stringify({ data: this.form.quantity }));
        formData.append('content', JSON.stringify({ data: this.form.content }));
        formData.append('state', JSON.stringify({ data: this.form.state }));
        if (Boolean(this.form.image1)) {
          formData.append('image1', this.form.image1!);
        }
        if (Boolean(this.form.image2)) {
          formData.append('image2', this.form.image2!);
        }
        if (Boolean(this.form.image3)) {
          formData.append('image3', this.form.image3!);
        }

        await this.$axios.put('/api/admin/product', formData, {
          headers: { 'Content-Type': 'multipart/form-data' },
          params: { id: this.id },
        });

        this.$nuxt.$bvToast.toast('Thông tin sản phẩm đã được chỉnh sửa.', {
          title: 'Chỉnh sửa thành công!',
          variant: 'success',
          solid: true,
          toaster: 'b-toaster-bottom-right',
        });
        this.$router.back();
      } catch (error) {
        this.$nuxt.error({ statusCode: (<Response>error.response).status });
      } finally {
        this.pending = false;
      }
    }

    public focusContent() {
      focusEditor('input-content');
    }

    public get contentClass(): string | null {
      let state = this.validateState('content');
      return state === true ? 'is-valid' : state === false ? 'is-invalid' : null;
    }
  }
</script>

<style lang="scss">
  @import '@/asset/style/editor';
</style>
