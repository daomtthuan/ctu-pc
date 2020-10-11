<template>
  <section>
    <b-form @submit.prevent="login">
      <b-form-group label="Tên đăng nhập:" label-for="input-username">
        <b-form-input id="input-username" v-model="user.username" type="text" required placeholder="Điền tên đăng nhập" autocomplete="on"></b-form-input>
      </b-form-group>

      <b-form-group label="Mật khẩu:" label-for="input-password">
        <b-form-input id="input-password" v-model="user.password" type="password" required placeholder="Điền mật khẩu" autocomplete="on"></b-form-input>
      </b-form-group>

      <b-button type="submit" variant="primary">Đăng nhập</b-button>
    </b-form>
  </section>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component
  export default class Login extends Vue {
    private user: App.Pages.Index.User = {
      username: '',
      password: '',
    };

    public async login() {
      try {
        let response = await this.$auth.loginWith('local', { data: this.user });
        console.log(response);
      } catch (err) {
        console.log(err);
      }
    }
  }
</script>
