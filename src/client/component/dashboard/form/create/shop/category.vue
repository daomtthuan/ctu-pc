<template>
  <div class="text-center" v-if="$fetchState.pending"><b-spinner small></b-spinner> Đang tải...</div>
  <b-form @submit.prevent="submit" v-else-if="!$fetchState.error">
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
        <span v-if="!pending">Tạo mới</span>
        <span v-else><b-spinner small></b-spinner> Xử lý...</span>
      </b-button>
    </b-form-group>
  </b-form>
</template>

<script lang="ts">
  import { createValidation, getValidateState, validationMixin } from '@/plugin/validation';
  import { Component, mixins, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'component-dashboard-form-create-shop-category',
    validations: createValidation('name', 'idCategoryGroup'),
  })
  export default class extends mixins(validationMixin) {
    private form: App.Form.Create.Shop.Category = {
      name: null,
      idCategoryGroup: null,
    };
    private pending: boolean = false;
    private categoryGroupOptions: App.Control.SeleteOption[] = [{ value: null, text: 'Chọn nhóm danh mục', disabled: true }];

    public async fetch() {
      try {
        for (let categoryGroup of <Entity.CategoryGroup[]>(await this.$axios.get('/api/admin/category-group')).data) {
          this.categoryGroupOptions.push({ value: categoryGroup.id, text: categoryGroup.name });
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
        await this.$axios.post('/api/admin/category', this.form);

        this.$nuxt.$bvToast.toast('Đã tạo mới nhóm danh mục.', {
          title: 'Tạo mới thành công!',
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
