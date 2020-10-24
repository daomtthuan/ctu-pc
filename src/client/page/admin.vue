<template>
  <main>
    <nuxt-child></nuxt-child>
  </main>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'page-admin',
    middleware: 'auth',
  })
  export default class extends Vue {
    public fetch() {
      if (!this.$auth.hasScope('admin')) {
        this.$nuxt.error({ statusCode: 404 });
      }
    }
  }
</script>
