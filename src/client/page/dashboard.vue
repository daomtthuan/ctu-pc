<template>
  <main v-if="!$fetchState.pending">
    <c-dashboard-navbar :large-device="largeDevice" :visible="visibleNavbar" :width="widthSidebar"></c-dashboard-navbar>
    <div
      :style="{
        marginLeft: visibleNavbar ? widthSidebar : null,
        marginTop: '3.4rem',
        minHeight: 'calc(100vh - 3.4rem)',
        width: 'calc(100vw - ' + (largeDevice ? widthSidebar : '0px') + ')',
      }"
      class="border-primary border-top border-left"
    >
      <b-container fluid class="pt-2">
        <nuxt-child class="mt-1"></nuxt-child>
      </b-container>
    </div>
  </main>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'page-dashboard',
    head: {
      title: 'Bảng điều khiển',
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
