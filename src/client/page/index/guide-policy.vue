<template>
  <div class="container">
    <b-card border-variant="primary" class="shadow-sm">
      <nuxt-child></nuxt-child>
    </b-card>
  </div>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'page-child-guide-policy',
  })
  export default class extends Vue {}
</script>
