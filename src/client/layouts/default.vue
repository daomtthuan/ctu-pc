<template>
  <main class="vh-min-100 pt-4">
    <c-navbar></c-navbar>
    <nuxt class="container mt-5 pt-3"></nuxt>
  </main>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component
  export default class DefaultLayout extends Vue {}
</script>

<style lang="scss" scoped></style>
