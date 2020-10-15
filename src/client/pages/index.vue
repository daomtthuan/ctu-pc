<template>
  <nuxt-child name="home"></nuxt-child>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component
  export default class Index extends Vue {}
</script>
