<template>
  <main>
    <c-navbar></c-navbar>
    <section class="container mt-5 pt-3">
      <b-row>
        <b-col lg="6" offset-lg="3">
          <b-card border-variant="primary" class="shadow-sm">
            <b-card-body>
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
    </section>
  </main>
</template>

<script lang="ts">
  import { Component, Vue, Watch } from 'nuxt-property-decorator';

  @Component({
    name: 'page-login',
  })
  export default class extends Vue {}
</script>
