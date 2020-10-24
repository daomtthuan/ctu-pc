<template>
  <nuxt class="vh-min-100 py-4"></nuxt>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'layout',
  })
  export default class extends Vue {}
</script>

<style lang="scss">
  @import '@/asset/style/theme';
</style>
