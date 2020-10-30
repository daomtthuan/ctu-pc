<template>
  <main>
    <c-navbar></c-navbar>
    <div class="mt-5 pt-4">
      <nuxt-child></nuxt-child>
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
