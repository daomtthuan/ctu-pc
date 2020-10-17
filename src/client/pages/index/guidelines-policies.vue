<template>
  <b-card border-variant="primary" class="shadow-sm">
    <nuxt-child></nuxt-child>
  </b-card>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component
  export default class GuidelinesPoliciesIndex extends Vue {}
</script>

<style lang="scss" scoped></style>
