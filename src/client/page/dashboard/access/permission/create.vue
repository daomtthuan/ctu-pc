<template>
  <div>
    <b-breadcrumb class="bg-light">
      <b-breadcrumb-item text="Bảng điều khiến" to="/dashboard"></b-breadcrumb-item>
      <b-breadcrumb-item text="Quản lý truy cập - Tài khoản" to="/dashboard/access/account"></b-breadcrumb-item>
      <b-breadcrumb-item text="Thêm mới" to="/dashboard/access/account/create"></b-breadcrumb-item>
    </b-breadcrumb>
    <hr />
    <c-dashboard-form-create-access-account></c-dashboard-form-create-access-account>
  </div>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'page-dashboard-access-account-create',
    head: {
      title: 'Bảng điều khiển - Quản lý truy cập - Tài khoản - Thêm',
    },
  })
  export default class extends Vue {}
</script>
