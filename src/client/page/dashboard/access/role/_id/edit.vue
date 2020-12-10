<template>
  <div>
    <b-breadcrumb class="bg-light">
      <b-breadcrumb-item text="Bảng điều khiến" to="/dashboard"></b-breadcrumb-item>
      <b-breadcrumb-item text="Truy cập - Quyền truy cập" to="/dashboard/access/role"></b-breadcrumb-item>
      <b-breadcrumb-item text="Chỉnh sửa" :to="$route.path"></b-breadcrumb-item>
    </b-breadcrumb>
    <hr />
    <c-dashboard-form-edit-access-role :id="$route.params.id"></c-dashboard-form-edit-access-role>
  </div>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'page-dashboard-access-role-edit',
    head: {
      title: 'Bảng điều khiển - Truy cập - Quyền truy cập - Chỉnh sửa',
    },
  })
  export default class extends Vue {}
</script>
