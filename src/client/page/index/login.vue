<template>
  <b-row>
    <b-col lg="6" offset-lg="3">
      <b-card border-variant="primary" class="shadow-sm">
        <b-card-body v-if="$fetchState.pending" class="text-center"><b-spinner small></b-spinner> Xác thực...</b-card-body>
        <b-card-body v-else-if="!this.$fetchState.error">
          <b-card-title title-tag="h2" class="text-primary">
            Đăng nhập
          </b-card-title>
          <b-card-sub-title class="text-primary"> Hoặc <nuxt-link to="/register">đăng ký</nuxt-link> tài khoản.</b-card-sub-title>
          <hr />
          <c-form-login></c-form-login>
        </b-card-body>
      </b-card>
    </b-col>
  </b-row>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'page-child-index-login',
    head: {
      title: 'Đăng nhập',
    },
    fetchOnServer: false,
  })
  export default class extends Vue {
    public fetch() {
      if (this.$auth.loggedIn) {
        this.$router.replace('/user');
      }
    }
  }
</script>
