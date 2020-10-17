<template>
  <nuxt-child></nuxt-child>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    middleware: 'auth',
  })
  export default class UserIndex extends Vue {}
</script>
