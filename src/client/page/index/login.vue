<template>
  <b-container class="py-5">
    <b-row>
      <b-col lg="6" offset-lg="3">
        <b-card border-variant="primary">
          <b-card-body>
            <div v-if="$fetchState.pending" class="text-center"><b-spinner small></b-spinner> Xác thực...</div>
            <div v-else-if="!$fetchState.error">
              <b-card-title title-tag="h2" class="text-primary">
                Đăng nhập
              </b-card-title>
              <b-card-sub-title class="text-primary"> Hoặc <nuxt-link to="/register">đăng ký</nuxt-link> tài khoản mới.</b-card-sub-title>
              <hr />
              <c-form-login></c-form-login>
            </div>
          </b-card-body>
        </b-card>
      </b-col>
    </b-row>
  </b-container>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'page-login',
    head: {
      title: 'Đăng nhập',
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
