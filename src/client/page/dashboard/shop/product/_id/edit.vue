<template>
  <div>
    <b-breadcrumb class="bg-light">
      <b-breadcrumb-item text="Bảng điều khiến" to="/dashboard"></b-breadcrumb-item>
      <b-breadcrumb-item text="Cửa hàng - Sản phẩm" to="/dashboard/shop/product"></b-breadcrumb-item>
      <b-breadcrumb-item text="Chỉnh sửa" :to="$route.path"></b-breadcrumb-item>
    </b-breadcrumb>
    <hr />
    <c-dashboard-form-edit-shop-product :id="$route.params.id"></c-dashboard-form-edit-shop-product>
  </div>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'page-dashboard-shop-product-edit',
    head: {
      title: 'Bảng điều khiển - Cửa hàng - Sản phẩm - Chỉnh sửa',
    },
  })
  export default class extends Vue {
    public fetch() {
      Vue.use(require('vue2-editor'));
    }
  }
</script>
