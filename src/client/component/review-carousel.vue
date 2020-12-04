<template>
  <div class="text-center" v-if="$fetchState.pending"><b-spinner small></b-spinner> Đang tải...</div>
  <b-carousel label-prev="Trước" label-next="Sau" label-goto-slide="Chi tiết" label-indicators="Chọn để xem chi tiết" controls v-else-if="!$fetchState.error">
    <b-carousel-slide v-for="row in Math.ceil(reviews.length / 3)" :key="row">
      <template #img>
        <b-row>
          <b-col v-for="column in 3" :key="column" lg="4" class="py-3">
            <b-card v-if="3 * row - 3 + column - 1 < reviews.length" class="h-100">
              <template #header>
                <div class="text-left text-primary small">
                  <fa :icon="['fas', 'star']" v-for="index in reviews[3 * row - 3 + column - 1].star" :key="`start-${index}`"></fa
                  ><fa :icon="['far', 'star']" v-for="index in 5 - reviews[3 * row - 3 + column - 1].star" :key="`unstar-${index}`"></fa>
                </div>
              </template>
              <b-card-text>
                {{ reviews[3 * row - 3 + column - 1].content }}
              </b-card-text>
              <template #footer>
                <div class="text-right small">
                  {{ reviews[3 * row - 3 + column - 1].writer }}
                </div>
              </template>
            </b-card>
          </b-col>
        </b-row>
      </template>
    </b-carousel-slide>
  </b-carousel>
</template>

<script lang="ts">
  import { Component, Prop, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'component-review-carousel',
  })
  export default class extends Vue {
    private reviews: Entity.Review[] = [];

    public async fetch() {
      this.reviews = (await this.$axios.get('/api/review')).data;
    }
  }
</script>
