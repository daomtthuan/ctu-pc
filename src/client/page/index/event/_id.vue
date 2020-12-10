<template>
  <div class="text-center py-5" v-if="$fetchState.pending || event == null"><b-spinner small></b-spinner> Đang tải...</div>
  <b-container class="py-5" v-else-if="!$fetchState.error">
    <b-card border-variant="primary">
      <b-card-body>
        <b-card-title title-tag="h2" class="text-primary">
          Sự kiện
        </b-card-title>
        <hr />
        <h4>{{ event.title }}</h4>
        <h6 class="mb-3 text-muted">Được đăng vào lúc {{ event.post }}</h6>
        <p>
          <b-img class="w-100 border" :src="`${event.imageUrl}`"></b-img>
        </p>
        <div v-html="post"></div>
      </b-card-body>
    </b-card>
  </b-container>
</template>

<script lang="ts">
  import { Component, Prop, Vue, Watch } from 'nuxt-property-decorator';

  @Component({
    name: 'page-event-details',
    head: {
      title: 'Sự kiện - Chi tiết',
    },
  })
  export default class extends Vue {
    private idEvent: number = parseInt(this.$route.params.id);
    private event: Entity.Event | null = null;
    private post: string | null = null;

    public async fetch() {
      if (isNaN(this.idEvent) || this.idEvent < 1) {
        this.$nuxt.error({ statusCode: 404 });
        return;
      }

      try {
        let events: Entity.Event[] = (await this.$axios.get('/api/event', { params: { id: this.idEvent } })).data;
        if (events.length != 1) {
          this.$nuxt.error({ statusCode: 404 });
          return;
        }

        this.event = events[0];
        this.post = (await this.$axios.get(this.event.postUrl)).data;
      } catch (error) {
        this.$nuxt.error({ statusCode: (<Response>error.response).status });
      }
    }

    @Watch('$route.params.id')
    public onIdEventChanged(newValue: string) {
      this.idEvent = parseInt(newValue);
      this.$fetch();
    }
  }
</script>
