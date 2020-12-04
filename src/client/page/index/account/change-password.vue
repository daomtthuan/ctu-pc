<template>
  <b-container>
    <b-card border-variant="primary">
      <b-card-body>
        <b-card-title title-tag="h2" class="text-primary">
          Đổi mật khẩu
        </b-card-title>
        <hr />
        <c-form-change-password></c-form-change-password>
      </b-card-body>
    </b-card>
  </b-container>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'page-account-change-password',
    head: {
      title: 'Đổi mật khẩu',
    },
  })
  export default class extends Vue {}
</script>
