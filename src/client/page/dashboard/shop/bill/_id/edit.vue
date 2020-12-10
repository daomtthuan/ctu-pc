<template>
  <div>
    <b-breadcrumb class="bg-light">
      <b-breadcrumb-item text="Bảng điều khiến" to="/dashboard"></b-breadcrumb-item>
      <b-breadcrumb-item text="Cửa hàng - Đơn hàng" to="/dashboard/shop/bill"></b-breadcrumb-item>
      <b-breadcrumb-item text="Chỉnh sửa" :to="$route.path"></b-breadcrumb-item>
    </b-breadcrumb>
    <hr />
    <c-dashboard-form-edit-shop-bill :id="$route.params.id"></c-dashboard-form-edit-shop-bill>
  </div>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'page-dashboard-shop-review-edit',
    head: {
      title: 'Bảng điều khiển - Cửa hàng - Đơn hàng - Chỉnh sửa',
    },
  })
  export default class extends Vue {}
</script>
