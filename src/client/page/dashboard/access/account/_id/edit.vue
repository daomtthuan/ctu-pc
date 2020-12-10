<template>
  <div>
    <b-breadcrumb class="bg-light">
      <b-breadcrumb-item text="Bảng điều khiến" to="/dashboard"></b-breadcrumb-item>
      <b-breadcrumb-item text="Truy cập - Tài khoản" to="/dashboard/access/account"></b-breadcrumb-item>
      <b-breadcrumb-item text="Chỉnh sửa" :to="$route.path"></b-breadcrumb-item>
    </b-breadcrumb>
    <hr />
    <c-dashboard-form-edit-access-account :id="$route.params.id"></c-dashboard-form-edit-access-account>
  </div>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'page-dashboard-access-account-edit',
    head: {
      title: 'Bảng điều khiển - Truy cập - Tài khoản - Chỉnh sửa',
    },
  })
  export default class extends Vue {}
</script>
