<template>
  <div>
    <b-breadcrumb class="bg-light">
      <b-breadcrumb-item text="Bảng điều khiến" to="/dashboard"></b-breadcrumb-item>
      <b-breadcrumb-item text="Cửa hàng - Sự kiện" to="/dashboard/shop/event"></b-breadcrumb-item>
      <b-breadcrumb-item text="Tạo mới" :to="$route.path"></b-breadcrumb-item>
    </b-breadcrumb>
    <hr />
    <c-dashboard-form-create-shop-event></c-dashboard-form-create-shop-event>
  </div>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'page-dashboard-shop-event-create',
    head: {
      title: 'Bảng điều khiển - Cửa hàng - Sự kiện - Tạo mới',
    },
  })
  export default class extends Vue {
    public fetch() {
      Vue.use(require('vue2-editor'));
    }
  }
</script>
