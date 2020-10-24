<template>
  <main>
    Admin
  </main>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'page-admin',
    middleware: 'auth',
  })
  export default class extends Vue {}
</script>
