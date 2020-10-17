<template>
  <div>
    Admin
  </div>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    middleware: 'auth',
  })
  export default class Admin extends Vue {}
</script>
