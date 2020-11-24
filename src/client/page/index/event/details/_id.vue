<template>
  <b-container>
    <b-card class="border border-primary">
      <b-card-body>
        <div v-if="$fetchState.pending" class="text-center"><b-spinner small></b-spinner> Đang tải....</div>
        <div v-else-if="!this.$fetchState.error">
          <b-card-title title-tag="h2" class="text-primary">
            Sự kiện
          </b-card-title>
          <hr />
          <h4>{{ event.title }}</h4>
          <h6 class="mb-3 text-muted">Được đăng vào lúc {{ event.post }}</h6>
          <p>
            <b-img class="w-100 border" :src="`${server}/asset/image/event/${event.id}.jpg`"></b-img>
          </p>
          <div>
            Content
          </div>
        </div>
      </b-card-body>
    </b-card>
  </b-container>
</template>

<script lang="ts">
  import { Component, Prop, Vue, Watch } from 'nuxt-property-decorator';

  @Component({
    name: 'page-event',
    head: {
      title: 'Sự kiện - Chi tiết',
    },
  })
  export default class extends Vue {
    private server: string = process.env.SERVER!;
    private event: Entity.Event | null = null;

    public async fetch() {
      let temptId: number = parseInt(this.$route.params.id);
      if (isNaN(temptId)) {
        this.$nuxt.error({ statusCode: 404 });
        return;
      }

      try {
        let events: Entity.Event[] = (await this.$axios.get('/event', { params: { id: temptId } })).data;
        if (events.length != 1) {
          this.$nuxt.error({ statusCode: 404 });
          return;
        }

        this.event = events[0];
      } catch (error) {
        this.$nuxt.error({ statusCode: (<Response>error.response).status });
      }
    }
  }
</script>
