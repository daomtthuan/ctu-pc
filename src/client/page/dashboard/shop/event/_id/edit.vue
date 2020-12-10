<template>
  <div>
    <b-breadcrumb class="bg-light">
      <b-breadcrumb-item text="Bảng điều khiến" to="/dashboard"></b-breadcrumb-item>
      <b-breadcrumb-item text="Cửa hàng - Sự kiện" to="/dashboard/shop/event"></b-breadcrumb-item>
      <b-breadcrumb-item text="Chỉnh sửa" :to="$route.path"></b-breadcrumb-item>
    </b-breadcrumb>
    <hr />
    <c-dashboard-form-edit-shop-event :id="$route.params.id"></c-dashboard-form-edit-shop-event>
  </div>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'page-dashboard-shop-event-edit',
    head: {
      title: 'Bảng điều khiển - Cửa hàng - Sự kiện - Chỉnh sửa',
    },
  })
  export default class extends Vue {
    public fetch() {
      Vue.use(require('vue2-editor'));
    }
  }
</script>
