<template>
  <b-container class="py-5">
    <b-card border-variant="primary">
      <b-card-body>
        <div v-if="$fetchState.pending" class="text-center"><b-spinner small></b-spinner> Xác thực...</div>
        <div v-else-if="!$fetchState.error">
          <b-card-title title-tag="h2" class="text-primary">
            Đăng ký
          </b-card-title>
          <b-card-sub-title class="text-primary"> Hoặc <nuxt-link to="/login">đăng nhập</nuxt-link> bằng tài khoản.</b-card-sub-title>
          <hr />
          <c-form-register></c-form-register>
        </div>
      </b-card-body>
    </b-card>
  </b-container>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'page-register',
    head: {
      title: 'Đăng ký',
    },
    fetchOnServer: false,
  })
  export default class extends Vue {
    public fetch() {
      if (this.$auth.loggedIn) {
        this.$router.replace('/account');
      }
    }
  }
</script>
