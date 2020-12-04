<template>
  <nuxt-child class="py-5"></nuxt-child>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'page-account',
    head: {
      title: 'Tài khoản',
    },
    middleware: 'auth',
  })
  export default class extends Vue {}
</script>
