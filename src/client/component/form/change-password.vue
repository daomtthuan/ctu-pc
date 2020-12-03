<template>
  <b-form @submit.prevent="submit">
    <b-form-group label="Mật khẩu cũ:" label-for="input-old-password">
      <b-form-input
        id="input-old-password"
        type="password"
        placeholder="Nhập mật khẩ cũ"
        v-model="$v.form.oldPassword.$model"
        :state="validateState('oldPassword')"
      ></b-form-input>
      <b-form-invalid-feedback>Mật khẩu cũ không hợp lệ</b-form-invalid-feedback>
    </b-form-group>
    <b-form-group label="Mật khẩu mới:" label-for="input-password">
      <b-form-input
        id="input-password"
        type="password"
        placeholder="Nhập mật khẩu mới"
        v-model="$v.form.password.$model"
        :state="validateState('password')"
      ></b-form-input>
      <b-form-invalid-feedback>Mật khẩu mới không hợp lệ</b-form-invalid-feedback>
    </b-form-group>
    <b-form-group label="Nhập lại mật khẩu mới:" label-for="input-repassword">
      <b-form-input
        id="input-repassword"
        type="password"
        placeholder="Nhập lại mật khẩu mới"
        v-model="$v.form.repassword.$model"
        :state="validateState('repassword')"
      ></b-form-input>
      <b-form-invalid-feedback>Mật khẩu mới nhập lại không đúng</b-form-invalid-feedback>
    </b-form-group>

    <b-form-group class="text-center">
      <b-button type="submit" variant="primary" :disabled="pending">
        <span v-if="!pending">Thay đổi</span>
        <span v-else><b-spinner small></b-spinner> Xử lý...</span>
      </b-button>
    </b-form-group>
  </b-form>
</template>

<script lang="ts">
  import { AxiosResponse } from 'axios';
  import { Component, mixins, Vue } from 'nuxt-property-decorator';
  import { createValidation, getValidateState, resetForm, validationMixin } from '@/plugin/validation';

  @Component({
    name: 'component-form-register',
    validations: createValidation('oldPassword', 'password', 'repassword'),
  })
  export default class extends mixins(validationMixin) {
    private form: App.Form.ChangePassword = {
      oldPassword: null,
      password: null,
      repassword: null,
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

      let form: any = { ...this.form };
      delete form.repassword;

      try {
        this.pending = true;
        await this.$axios.put('/api/auth/local', form);

        this.$nuxt.$bvToast.toast('Mật khẩu tài khoản đã được đổi', {
          title: 'Đổi mật khẩu thành công!',
          variant: 'success',
          solid: true,
          toaster: 'b-toaster-bottom-right',
        });
        this.$router.push('/account');
      } catch (error) {
        resetForm(this);
        let response = <Response>error.response;
        if (response.status == 406) {
          this.$nuxt.$bvToast.toast('Mật khẩu không đúng.', {
            title: 'Đổi mật khẩu không thành công!',
            variant: 'danger',
            solid: true,
            toaster: 'b-toaster-bottom-right',
          });
        } else {
          this.$nuxt.error({ statusCode: response.status });
        }
      } finally {
        this.pending = false;
      }
    }
  }
</script>
