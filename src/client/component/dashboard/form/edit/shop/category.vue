<template>
  <div class="text-center" v-if="$fetchState.pending"><b-spinner small></b-spinner> Đang tải...</div>
  <b-form @submit.prevent="submit" v-else-if="!$fetchState.error">
    <b-form-group label="Trạng thái:">
      <b-form-radio-group class="py-2" v-model="$v.form.state.$model" :state="validateState('state')">
        <b-form-radio id="radio-state-enabled" :value="true">Kích hoạt</b-form-radio>
        <b-form-radio id="radio-state-disabled" :value="false">Vô hiệu hoá</b-form-radio>
      </b-form-radio-group>
      <div class="text-danger small mt-1" v-show="validateState('state') === false">Trạng thái không hợp lệ</div>
    </b-form-group>
    <b-form-group label="Nhóm danh mục:" label-for="select-category-group">
      <b-form-select
        id="select-category-group"
        v-model="$v.form.idCategoryGroup.$model"
        :options="categoryGroupOptions"
        :state="validateState('idCategoryGroup')"
      ></b-form-select>
      <b-form-invalid-feedback>Nhóm danh mục không hợp lệ</b-form-invalid-feedback>
    </b-form-group>
    <b-form-group label="Tên:" label-for="input-name">
      <b-form-input id="input-name" type="text" placeholder="Nhập tên" v-model="$v.form.name.$model" :state="validateState('name')"></b-form-input>
      <b-form-invalid-feedback>Tên không hợp lệ</b-form-invalid-feedback>
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
  import { createValidation, getValidateState, validationMixin } from '@/plugin/validation';
  import { Component, mixins, Prop, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'component-dashboard-form-edit-shop-category',
    validations: createValidation('name', 'state', 'idCategoryGroup'),
  })
  export default class extends mixins(validationMixin) {
    @Prop({ type: String, required: true })
    private id!: number;

    private form: App.Form.Edit.Shop.Category = {
      name: null,
      idCategoryGroup: null,
      state: null,
    };
    private categoryGroupOptions: App.Control.SeleteOption[] = [{ value: null, text: 'Chọn nhóm danh mục', disabled: true }];
    private pending: boolean = false;

    public async fetch() {
      try {
        for (let categoryGroup of <Entity.CategoryGroup[]>(await this.$axios.get('/api/admin/category-group')).data) {
          this.categoryGroupOptions.push({ value: categoryGroup.id, text: categoryGroup.name });
        }

        let categories: Entity.Category[] = (await this.$axios.get('/api/admin/category', { params: { id: this.id } })).data;
        if (categories.length == 1) {
          this.form.name = categories[0].name;
          this.form.idCategoryGroup = categories[0].idCategoryGroup;
          this.form.state = categories[0].state;
        } else {
          this.$nuxt.error({ statusCode: 404 });
        }
      } catch (error) {
        let response = <Response>error.response;
        this.$nuxt.error({ statusCode: response.status });
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
        await this.$axios.put('/api/admin/category', this.form, { params: { id: this.id } });

        this.$nuxt.$bvToast.toast('Thông tin danh mục đã được chỉnh sửa.', {
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
  }
</script>
