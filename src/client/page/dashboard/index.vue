<template>
  <div>
    <b-breadcrumb class="bg-light">
      <b-breadcrumb-item text="Bảng điều khiến" :to="$route.path"></b-breadcrumb-item>
    </b-breadcrumb>
    <hr />
    <div>
      Hello
    </div>
  </div>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'page-dashboard-home',
    head: {
      title: 'Bảng điều khiển - Trang chủ',
    },
  })
  export default class extends Vue {}
</script>
