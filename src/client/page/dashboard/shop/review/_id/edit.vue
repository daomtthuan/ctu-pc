<template>
  <div>
    <b-breadcrumb class="bg-light">
      <b-breadcrumb-item text="Bảng điều khiến" to="/dashboard"></b-breadcrumb-item>
      <b-breadcrumb-item text="Cửa hàng - Sự kiện" to="/dashboard/shop/event"></b-breadcrumb-item>
      <b-breadcrumb-item text="Chỉnh sửa" :to="$route.path"></b-breadcrumb-item>
    </b-breadcrumb>
    <hr />
    <c-dashboard-form-edit-shop-category :id="$nuxt.$route.params.id"></c-dashboard-form-edit-shop-category>
  </div>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'page-dashboard-shop-review-edit',
    head: {
      title: 'Bảng điều khiển - Cửa hàng - Đánh giá - Chỉnh sửa',
    },
  })
  export default class extends Vue {}
</script>
