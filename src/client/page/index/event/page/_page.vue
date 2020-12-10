<template>
  <div class="text-center py-5" v-if="$fetchState.pending"><b-spinner small></b-spinner> Đang tải...</div>
  <b-container class="py-5" v-else-if="!$fetchState.error">
    <h2 class="text-primary">Sự kiện</h2>
    <hr />
    <h4>Mới nhất</h4>
    <c-event-carousel></c-event-carousel>
    <hr />
    <p v-if="total == 0">
      Hiện tại không có sự kiện nào.
    </p>
    <div v-else>
      <b-row v-for="row in rows" :key="row">
        <b-col v-for="column in 4" :key="column" class="mb-3" xl="3" lg="6" md="6">
          <b-card body-class="p-0" class="h-100" v-if="4 * row - 4 + column - 1 < events.length">
            <nuxt-link
              class="w-100 d-block"
              :style="{
                height: '200px',
                backgroundImage: `url('${events[4 * row - 4 + column - 1].imageUrl}')`,
                backgroundSize: 'cover',
                backgroundPosition: 'center',
                backgroundRepeat: 'no-repeat',
              }"
              :to="`/event/${events[4 * row - 4 + column - 1].id}`"
            ></nuxt-link>
            <b-card-body>
              <h6>{{ events[4 * row - 4 + column - 1].title }}</h6>
              {{ events[4 * row - 4 + column - 1].post }}
            </b-card-body>
            <template #footer>
              <div class="text-right">
                <b-button size="sm" variant="primary" :to="`/event/${events[4 * row - 4 + column - 1].id}`">Xem thêm</b-button>
              </div>
            </template>
          </b-card>
        </b-col>
      </b-row>
      <b-pagination-nav v-model="page" :link-gen="linkPage" :number-of-pages="numberPages" use-router align="center">
        <template #first-text>
          <fa :icon="['fas', 'angle-double-left']"></fa>
        </template>
        <template #prev-text>
          <fa :icon="['fas', 'angle-left']"></fa>
        </template>
        <template #next-text>
          <fa :icon="['fas', 'angle-right']"></fa>
        </template>
        <template #last-text>
          <fa :icon="['fas', 'angle-double-right']"></fa>
        </template>
      </b-pagination-nav>
    </div>
  </b-container>
</template>

<script lang="ts">
  import { Component, Prop, Vue, Watch } from 'nuxt-property-decorator';

  @Component({
    name: 'page-event',
    head: {
      title: 'Sự kiện',
    },
  })
  export default class extends Vue {
    private page: number = parseInt(this.$route.params.page);
    private total: number = 0;
    private perPage: number = 12;
    private numberPages: number = 1;
    private events: Entity.Event[] = [];
    private rows: number = 0;

    public async fetch() {
      if (isNaN(this.page) || this.page < 1) {
        this.$nuxt.error({ statusCode: 404 });
        return;
      }

      try {
        this.total = (<App.Response.Count>(await this.$axios.get('/api/event', { params: { count: true } })).data).count;
        this.numberPages = Math.ceil(this.total / this.perPage);
        if (this.page > this.numberPages) {
          if (this.numberPages > 0) {
            this.$nuxt.error({ statusCode: 404 });
          }
          return;
        }

        this.events = (
          await this.$axios.get('/api/event', {
            params: {
              start: this.perPage * this.page - this.perPage,
              limit: this.perPage,
            },
          })
        ).data;
        this.rows = Math.ceil(this.events.length / 4);
      } catch (error) {
        this.$nuxt.error({ statusCode: (<Response>error.response).status });
      }
    }

    public linkPage(id: number) {
      return `/event/page/${id}`;
    }

    @Watch('$route.params.page')
    public async onPageChange(newValue: string) {
      this.page = parseInt(newValue);
      this.$fetch();
    }
  }
</script>
