<template>
  <div>
    <b-breadcrumb class="bg-light">
      <b-breadcrumb-item text="Bảng điều khiến" to="/dashboard"></b-breadcrumb-item>
      <b-breadcrumb-item text="Cửa hàng - Sản phẩm" to="/dashboard/shop/product"></b-breadcrumb-item>
      <b-breadcrumb-item text="Tạo mới" :to="$route.path"></b-breadcrumb-item>
    </b-breadcrumb>
    <hr />
    <c-dashboard-form-create-shop-product></c-dashboard-form-create-shop-product>
  </div>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'page-dashboard-shop-product-create',
    head: {
      title: 'Bảng điều khiển - Cửa hàng - Sản phẩm - Tạo mới',
    },
  })
  export default class extends Vue {
    public fetch() {
      Vue.use(require('vue2-editor'));
    }
  }
</script>
