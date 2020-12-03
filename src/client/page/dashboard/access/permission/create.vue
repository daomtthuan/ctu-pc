<template>
  <div>
    <b-breadcrumb class="bg-light">
      <b-breadcrumb-item text="Bảng điều khiến" to="/dashboard"></b-breadcrumb-item>
      <b-breadcrumb-item text="Truy cập - Phân quyền" to="/dashboard/access/permission"></b-breadcrumb-item>
      <b-breadcrumb-item text="Tạo mới" to="/dashboard/access/permission/create"></b-breadcrumb-item>
    </b-breadcrumb>
    <hr />
    <c-dashboard-form-create-access-permission></c-dashboard-form-create-access-permission>
  </div>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'page-dashboard-access-permission-create',
    head: {
      title: 'Bảng điều khiển - Truy cập - Phân quyền - Thêm',
    },
  })
  export default class extends Vue {}
</script>
