<template>
  <main>
    <c-navbar></c-navbar>
    <div class="d-flex flex-column pt-5 vh-min-100">
      <nuxt-child :events="events"></nuxt-child>
      <c-footer class="mt-auto" :fluid="false" :events="events"></c-footer>
    </div>
  </main>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'page-index',
    head: {
      title: 'Trang chủ',
    },
    scrollToTop: true,
  })
  export default class extends Vue {
    private events: Entity.Event[] = [];

    public async fetch() {
      try {
        this.events = (await this.$axios.get('/api/event', { params: { start: 0, limit: 5 } })).data;
      } catch (error) {
        this.$nuxt.error({ statusCode: (<Response>error.response).status });
      }
    }
  }
</script>
