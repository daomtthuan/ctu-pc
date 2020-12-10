<template>
  <div>
    <b-breadcrumb class="bg-light">
      <b-breadcrumb-item text="Bảng điều khiến" to="/dashboard"></b-breadcrumb-item>
      <b-breadcrumb-item text="Cửa hàng - Nhóm danh mục" to="/dashboard/shop/category-group"></b-breadcrumb-item>
      <b-breadcrumb-item text="Chỉnh sửa" :to="$route.path"></b-breadcrumb-item>
    </b-breadcrumb>
    <hr />
    <c-dashboard-form-edit-shop-category-group :id="$route.params.id"></c-dashboard-form-edit-shop-category-group>
  </div>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'page-dashboard-shop-category-group-edit',
    head: {
      title: 'Bảng điều khiển - Cửa hàng - Nhóm danh mục - Chỉnh sửa',
    },
  })
  export default class extends Vue {}
</script>
