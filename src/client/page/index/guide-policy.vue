<template>
  <b-card border-variant="primary" class="shadow-sm">
    <nuxt-child></nuxt-child>
  </b-card>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'page-child-guide-policy',
  })
  export default class extends Vue {}
</script>
