<template>
  <main class="vh-min-100 pt-4">
    <app-navbar></app-navbar>
    <nuxt-child class="container mt-5 pt-3"></nuxt-child>
  </main>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component
  export default class Index extends Vue {}
</script>
