<template>
  <div class="text-center" v-if="$fetchState.pending"><b-spinner small></b-spinner> Đang tải...</div>
  <b-carousel
    label-prev="Trước"
    label-next="Sau"
    label-goto-slide="Chi tiết"
    label-indicators="Chọn để xem chi tiết"
    controls
    indicators
    v-else-if="!$fetchState.error"
  >
    <b-carousel-slide v-for="event in events" :key="event.id">
      <template #img>
        <nuxt-link
          class="w-100 d-block"
          :style="{
            height: 'calc(100vh / 3)',
            backgroundImage: `url(${server}/asset/image/event/${event.id}.jpg)`,
            backgroundSize: 'cover',
            backgroundPosition: 'center',
            backgroundRepeat: 'no-repeat',
          }"
          :to="`/event/details/${event.id}`"
        ></nuxt-link>
      </template>
      <div
        class="text-center p-3"
        :style="{
          textShadow: '1px 1px 2px var(--dark)',
          backgroundImage: 'linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8))',
        }"
      >
        <h5>{{ event.title }}</h5>
      </div>
    </b-carousel-slide>
  </b-carousel>
</template>

<script lang="ts">
  import { Component, Prop, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'component-event-carousel',
  })
  export default class extends Vue {
    private events: Entity.Event[] = [];
    private server: string = process.env.SERVER!;

    public async fetch() {
      this.events = (await this.$axios.get('/event', { params: { start: 0, limit: 5 } })).data;
    }
  }
</script>
