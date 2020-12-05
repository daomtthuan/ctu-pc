<template>
  <nuxt-child class="py-5"></nuxt-child>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'page-dashboard-account',
    head: {
      title: 'Tài khoản',
    },
  })
  export default class extends Vue {}
</script>
