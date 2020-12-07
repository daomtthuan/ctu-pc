<template>
  <b-container>
    <b-card border-variant="primary">
      <b-card-body>
        <div v-if="$fetchState.pending" class="text-center"><b-spinner small></b-spinner> Đang tải...</div>
        <div v-else-if="!this.$fetchState.error">
          <b-card-title title-tag="h2" class="text-primary">
            Giỏ hàng
          </b-card-title>
          <hr />
        </div>
      </b-card-body>
    </b-card>
  </b-container>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'page-account-cart',
    head: {
      title: 'Giỏ hàng',
    },
  })
  export default class extends Vue {}
</script>
