<template>
  <main>
    <c-navbar></c-navbar>
    <section class="container mt-5 pt-3">
      <b-card border-variant="primary" class="shadow-sm">
        <c-guide-policy-installment></c-guide-policy-installment>
      </b-card>
    </section>
  </main>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'page-guide-policy-installment',
  })
  export default class extends Vue {}
</script>
