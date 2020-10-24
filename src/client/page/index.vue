<template>
  <main>
    <c-navbar></c-navbar>
    <section class="container mt-5 pt-3">
      Index
    </section>
  </main>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'page-index',
  })
  export default class extends Vue {}
</script>
