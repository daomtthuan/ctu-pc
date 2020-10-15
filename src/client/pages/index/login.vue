<template>
  <b-row>
    <b-col md="8" lg="6" offset-md="2" offset-lg="3">
      <b-card border-variant="primary" class="shadow-sm">
        <b-card-body>
          <b-card-title title-tag="h2" class="text-primary">
            Đăng nhập
          </b-card-title>
          <b-card-sub-title sub-title-tag="p">
            Hoặc
            <b-link to="/register">đăng ký</b-link>
            tài khoản
          </b-card-sub-title>

          <b-form @submit.prevent="login" class="mt-3">
            <b-form-group label="Tên đăng nhập:" label-for="input-username">
              <b-form-input id="input-username" v-model="user.username" type="text" required placeholder="Điền tên đăng nhập" autocomplete="on"></b-form-input>
            </b-form-group>

            <b-form-group label="Mật khẩu:" label-for="input-password">
              <b-form-input id="input-password" v-model="user.password" type="password" required placeholder="Điền mật khẩu" autocomplete="on"></b-form-input>
            </b-form-group>

            <b-form-group>
              <b-form-checkbox id="checkbox-remember" v-model="remember" :value="true" :unchecked-value="false">
                Ghi nhớ đăng nhập
              </b-form-checkbox>
            </b-form-group>

            <b-button type="submit" variant="primary">Đăng nhập</b-button>
          </b-form>
        </b-card-body>
      </b-card>
    </b-col>
  </b-row>
</template>

<script lang="ts">
  import { Component, Vue, Watch } from 'nuxt-property-decorator';

  @Component
  export default class extends Vue {
    private user: App.Pages.Index.User = {
      username: '',
      password: '',
    };
    private remember: boolean = false;

    public async login() {
      try {
        await this.$auth.loginWith('local', { data: this.user });
        if (this.remember) {
          localStorage.setItem('token', this.$auth.getToken('local'));
        }
      } catch (error) {
        this.user.username = '';
        this.user.password = '';

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
