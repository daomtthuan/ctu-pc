<template>
  <main>
    <c-navbar></c-navbar>
    <section class="container mt-5 pt-3">
      <b-card border-variant="primary" class="shadow">
        <b-card-body>
          <b-card-title title-tag="h2" class="text-primary">
            Đăng ký
          </b-card-title>
           <b-card-sub-title class="text-primary"> Hoặc <nuxt-link to="/login">đăng nhập</nuxt-link>.</b-card-sub-title>
          <hr />
          <c-form-register></c-form-register>
        </b-card-body>
      </b-card>
    </section>
  </main>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'page-register',
  })
  export default class extends Vue {}
</script>
