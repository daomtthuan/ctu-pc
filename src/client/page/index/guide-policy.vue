<template>
  <b-container>
    <b-card border-variant="primary">
      <nuxt-child></nuxt-child>
    </b-card>
  </b-container>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'page-child-home-guide-policy',
  })
  export default class extends Vue {}
</script>
