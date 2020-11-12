<template>
  <main>
    <c-navbar></c-navbar>
    <div class="d-flex flex-column pt-5 vh-min-100">
      <div class="pt-3">
        <nuxt-child></nuxt-child>
      </div>
      <c-footer class="mt-auto"></c-footer>
    </div>
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
