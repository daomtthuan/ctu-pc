<template>
  <b-card class="h-100" img-top bg-variant="white" body-class="p-0" header-class="p-0" border-variant="primary">
    <template #header>
      <nuxt-link
        class="w-100 d-block"
        :style="{
          height: '200px',
          backgroundImage: `url('${product.image1Url}')`,
          backgroundSize: 'cover',
          backgroundPosition: 'center',
          backgroundRepeat: 'no-repeat',
        }"
        :to="`/product/${product.id}`"
      ></nuxt-link>
    </template>
    <b-card-body>
      <h6>{{ product.name }}</h6>
      <h5 class="text-primary mt-auto">{{ toMoney(product.price) }}</h5>
      <small>Số lượng còn lại: {{ product.quantity }}</small>
    </b-card-body>
    <template #footer>
      <div class="text-right">
        <b-button size="sm" variant="primary" :to="`/product/${product.id}`">Xem chi tiết</b-button>
      </div>
    </template>
  </b-card>
</template>

<script lang="ts">
  import { Component, Prop, Vue } from 'nuxt-property-decorator';
  import { toMoney } from '../plugin/helper';

  @Component({
    name: 'component-product',
    methods: { toMoney },
  })
  export default class extends Vue {
    @Prop({ type: Object, required: true })
    private product!: Entity.Product;
  }
</script>
