<template>
  <div class="text-center" v-if="$fetchState.pending"><b-spinner small></b-spinner> Đang tải...</div>
  <b-carousel controls v-else-if="!$fetchState.error">
    <b-carousel-slide v-for="row in Math.ceil(reviews.length / 4)" :key="row">
      <template #img>
        <b-row>
          <b-col v-for="column in 4" :key="column" xl="3" lg="6" md="6" class="py-3">
            <b-card v-if="4 * row - 4 + column - 1 < reviews.length" class="h-100" border-variant="primary">
              <template #header>
                <c-product-star class="text-left small text-primary" :star="reviews[4 * row - 4 + column - 1].star"></c-product-star>
              </template>
              <b-card-text>
                {{ reviews[4 * row - 4 + column - 1].content }}
              </b-card-text>
              <template #footer>
                <div class="text-right small">
                  {{ reviews[4 * row - 4 + column - 1].writer }}
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
