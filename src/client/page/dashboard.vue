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
      class="d-flex flex-column vh-min-100"
    >
      <b-container fluid class="py-3 mb-3">
        <nuxt-child></nuxt-child>
      </b-container>
      <c-footer class="mt-auto" :events="events"></c-footer>
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
    scrollToTop: true,
    middleware: 'auth',
  })
  export default class extends Vue {
    private largeDevice: boolean = window.innerWidth > 1200;
    private visibleNavbar: boolean = this.largeDevice;
    private widthSidebar: string = '320px';
    private events: Entity.Event[] = [];

    public async fetch() {
      if (!this.$auth.hasScope('Admin')) {
        this.$nuxt.error({ statusCode: 404 });
      }

      try {
        this.events = (await this.$axios.get('/api/event', { params: { start: 0, limit: 5 } })).data;
      } catch (error) {
        this.$nuxt.error({ statusCode: (<Response>error.response).status });
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
