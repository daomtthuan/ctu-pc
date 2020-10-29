<template>
  <main>
    <c-navbar></c-navbar>
    <section class="container mt-5 pt-3">
      <nuxt-child></nuxt-child>
    </section>
  </main>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'page-index',
    head: {
      title: 'Trang chủ',
    },
  })
  export default class extends Vue {}
</script>
