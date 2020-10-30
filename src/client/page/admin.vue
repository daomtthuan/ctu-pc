<template>
  <main v-if="!$fetchState.pending">
    <c-admin-navbar :large-device="largeDevice" :visible="visibleNavbar" :width="widthSidebar"></c-admin-navbar>
    <div class="mt-5 pt-4" :style="{ paddingLeft: visibleNavbar ? widthSidebar : null }">
      <div class="container-fluid">
        <nuxt-child></nuxt-child>
      </div>
    </div>
  </main>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'page-admin-index',
    head: {
      title: 'Quản trị',
    },
    middleware: 'auth',
    fetchOnServer: false,
  })
  export default class extends Vue {
    private largeDevice: boolean = window.innerWidth > 1200;
    private visibleNavbar: boolean = this.largeDevice;
    private widthSidebar: string = '320px';

    public fetch() {
      if (!this.$auth.hasScope('admin')) {
        this.$nuxt.error({ statusCode: 404 });
      }
    }

    public mounted() {
      window.onresize = () => {
        this.largeDevice = window.innerWidth > 1200;
        this.visibleNavbar = this.largeDevice;
      };
    }
  }
</script>
