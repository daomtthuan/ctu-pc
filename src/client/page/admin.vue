<template>
  <main v-if="!$fetchState.pending">
    <c-admin-navbar :large-device="largeDevice" :visible="visibleNavbar"></c-admin-navbar>
    <section class="container-fluid mt-5" :style="{ marginLeft: visibleNavbar ? '320px' : '0px' }">
      <nuxt-child></nuxt-child>
    </section>
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
    private largeDevice: boolean = window.innerWidth > 960;
    private visibleNavbar: boolean = this.largeDevice;

    public fetch() {
      if (!this.$auth.hasScope('admin')) {
        this.$nuxt.error({ statusCode: 404 });
      }
    }

    public mounted() {
      window.onresize = () => {
        this.largeDevice = window.innerWidth > 960;
        this.visibleNavbar = this.largeDevice;
      };
    }
  }
</script>
