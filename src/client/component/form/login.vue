<template>
  <b-form @submit.prevent="login">
    <b-form-group label="Tên đăng nhập:" label-for="input-username">
      <b-form-input id="input-username" v-model="$v.form.username.$model" :state="validateState('username')" type="text" placeholder="Nhập tên đăng nhập" autocomplete="on"></b-form-input>
      <b-form-invalid-feedback>Tên đăng nhập không hợp lệ</b-form-invalid-feedback>
    </b-form-group>
    <b-form-group label="Mật khẩu:" label-for="input-password">
      <b-form-input id="input-password" v-model="$v.form.password.$model" :state="validateState('password')" type="password" placeholder="Nhập mật khẩu" autocomplete="on"></b-form-input>
      <b-form-invalid-feedback>Mật khẩu không hợp lệ</b-form-invalid-feedback>
    </b-form-group>
    <b-form-group>
      <b-form-checkbox id="checkbox-remember" v-model="remember" :value="true" :unchecked-value="false">
        Ghi nhớ đăng nhập
      </b-form-checkbox>
    </b-form-group>
    <b-button type="submit" variant="primary" :disabled="pending">
      <span v-if="!pending">Đăng nhập</span>
      <span v-else><b-spinner small></b-spinner> Xác thực...</span>
    </b-button>
  </b-form>
</template>

<script lang="ts">
  import { createValidation, validationMixin } from '@/plugin/validation';
  import { Component, mixins, Vue, Watch } from 'nuxt-property-decorator';

  @Component({
    name: 'component-form-login',
    validations: createValidation('username', 'password'),
  })
  export default class extends mixins(validationMixin) {
    private form = {
      username: null,
      password: null,
    };
    private remember: boolean = false;
    private pending: boolean = false;

    public validateState(name: string) {
      let validate = this.$v.form[name];
      return validate!.$dirty ? !validate!.$error : null;
    }

    public async login() {
      this.$v.form.$touch();
      if (this.$v.$anyError) {
        return;
      }

      try {
        this.pending = true;
        await this.$auth.loginWith('local', { data: this.form });
        if (this.remember) {
          localStorage.setItem('token', this.$auth.getToken('local'));
        }
      } catch (error) {
        this.pending = false;
        this.$v.$reset();
        this.form = {
          username: null,
          password: null,
        };

        let response = <Response>error.response;
        switch (response.status) {
          case 401:
            this.$bvToast.toast('Tên đăng nhập hoặc mật khẩu không đúng.', {
              title: 'Đăng nhập không thành công!',
              variant: 'danger',
              solid: true,
            });
            break;

          case 406:
            this.$bvToast.toast('Tài khoản đã bị vô hiệu hoá.', {
              title: 'Đăng nhập không thành công!',
              variant: 'danger',
              solid: true,
            });
            break;

          default:
            this.$nuxt.error({ statusCode: response.status });
            break;
        }
      }
    }

    @Watch('remember')
    public onRememberChanged(newValue: boolean, oldValue: boolean) {
      if (newValue) {
        this.$bvToast.toast('Không nên ghi nhớ đăng nhập trên thiết bị công cộng hoặc không đáng tin cậy.', {
          title: 'Cảnh báo bảo mật!',
          variant: 'warning',
          solid: true,
        });
      }
    }
  }
</script>
