<template>
  <b-form @submit.prevent="submit">
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
    name: 'component-dashboard-form-create-shop-brand',
    validations: createValidation('name'),
  })
  export default class extends mixins(validationMixin) {
    private form: App.Form.Create.Shop.Brand = {
      name: null,
    };
    private pending: boolean = false;

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
        await this.$axios.post('/api/admin/brand', this.form);

        this.$nuxt.$bvToast.toast('Đã tạo mới thương hiệu.', {
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
