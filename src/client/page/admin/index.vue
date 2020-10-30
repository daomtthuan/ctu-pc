<template>
  <div>Admin</div>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'page-child-admin-index',
    head: {
      title: 'Quản trị - Trang chủ',
    },
  })
  export default class extends Vue {}
</script>
