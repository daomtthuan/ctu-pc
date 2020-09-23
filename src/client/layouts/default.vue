<template>
  <main>
    <nuxt></nuxt>
  </main>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component
  export default class DefaultLayout extends Vue {}
</script>

<style lang="scss" scoped></style>
