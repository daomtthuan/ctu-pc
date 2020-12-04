<template>
  <b-container class="py-5">
    <b-card border-variant="primary">
      <nuxt-child></nuxt-child>
    </b-card>
  </b-container>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'page-guide-policy',
  })
  export default class extends Vue {}
</script>
