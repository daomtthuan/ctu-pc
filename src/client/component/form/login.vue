<template>
  <b-form @submit.prevent="submit">
    <b-form-group label="Tên đăng nhập:" label-for="input-username">
      <b-form-input
        id="input-username"
        v-model="$v.form.username.$model"
        :state="validateState('username')"
        type="text"
        placeholder="Nhập tên đăng nhập"
      ></b-form-input>
      <b-form-invalid-feedback>Tên đăng nhập không hợp lệ</b-form-invalid-feedback>
    </b-form-group>
    <b-form-group label="Mật khẩu:" label-for="input-password">
      <b-form-input
        id="input-password"
        v-model="$v.form.password.$model"
        :state="validateState('password')"
        type="password"
        placeholder="Nhập mật khẩu"
      ></b-form-input>
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
  import { AxiosResponse } from 'axios';
  import { Component, mixins, Vue, Watch } from 'nuxt-property-decorator';
  import { createValidation, getValidateState, validationMixin } from '@/plugin/validation';
  import { addProductCart } from '@/plugin/cart';

  @Component({
    name: 'component-form-login',
    validations: createValidation('username', 'password'),
  })
  export default class extends mixins(validationMixin) {
    private form: App.Form.Login = { username: null, password: null };
    private remember: boolean = false;
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
        let response: App.Response.Login = (<AxiosResponse>await this.$auth.loginWith('local', { data: this.form })).data;
        if (this.remember) {
          window.localStorage.setItem('token', this.$auth.getToken('local'));
        }

        this.$router.push(this.$auth.$state.redirect ?? '/', () => {
          this.$nuxt.$bvToast.toast(this.$createElement('div', ['Chào mừng ', this.$createElement('strong', response.fullName), ' đã trở lại!']), {
            title: 'Đăng nhập thành công!',
            variant: 'success',
            solid: true,
            toaster: 'b-toaster-bottom-right',
          });
        });

        let tempProductCart = window.sessionStorage.getItem('tempProductCart');
        if (tempProductCart != null) {
          let product: Entity.Cart.Product = JSON.parse(tempProductCart);
          addProductCart(this.$auth.user.id, product.id, product.quantity);
          this.$nuxt.$bvToast.toast('Đã thêm sản phẩm vào giỏ hàng.', {
            title: 'Thêm thành công!',
            variant: 'success',
            solid: true,
            toaster: 'b-toaster-bottom-right',
          });
          window.sessionStorage.removeItem('tempProductCart');
        }
      } catch (error) {
        this.$v.$reset();
        this.form = {
          username: null,
          password: null,
        };

        let response = <Response>error.response;
        switch (response.status) {
          case 401:
            this.$nuxt.$bvToast.toast('Tên đăng nhập hoặc mật khẩu không đúng.', {
              title: 'Đăng nhập không thành công!',
              variant: 'danger',
              solid: true,
              toaster: 'b-toaster-bottom-right',
            });
            break;

          case 406:
            this.$nuxt.$bvToast.toast('Tài khoản đã bị vô hiệu hoá.', {
              title: 'Đăng nhập không thành công!',
              variant: 'danger',
              solid: true,
              toaster: 'b-toaster-bottom-right',
            });
            break;

          default:
            this.$nuxt.error({ statusCode: response.status });
            break;
        }
      } finally {
        this.pending = false;
      }
    }

    @Watch('remember')
    public onRememberChanged(newValue: boolean, oldValue: boolean) {
      if (newValue) {
        this.$nuxt.$bvToast.toast('Không nên ghi nhớ đăng nhập trên thiết bị công cộng hoặc không đáng tin cậy.', {
          title: 'Cảnh báo bảo mật!',
          variant: 'warning',
          solid: true,
          toaster: 'b-toaster-bottom-right',
        });
      }
    }
  }
</script>
