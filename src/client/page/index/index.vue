<template>
  <b-container>
    <b-card border-variant="primary">
      <b-card-body>
        Trang chủ
      </b-card-body>
    </b-card>
  </b-container>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'page-register',
    head: {
      title: 'Trang chủ',
    },
    fetchOnServer: false,
  })
  export default class extends Vue {}
</script>
