<template>
  <b-card border-variant="primary" class="shadow">
    <b-card-body v-if="$fetchState.pending" class="text-center"><b-spinner small></b-spinner> Xác thực...</b-card-body>
    <b-card-body v-else-if="!this.$fetchState.error">
      <b-card-title title-tag="h2" class="text-primary">
        Đăng ký
      </b-card-title>
      <b-card-sub-title class="text-primary"> Hoặc <nuxt-link to="/login">đăng nhập</nuxt-link>.</b-card-sub-title>
      <hr />
      <c-form-register></c-form-register>
    </b-card-body>
  </b-card>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'page-child-index-register',
    head: {
      title: 'Đăng ký',
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
