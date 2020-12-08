<template>
  <div>
    <fa :icon="['fas', 'star']" v-for="index in star" :key="`start-${index}`"></fa
    ><fa :icon="['far', 'star']" v-for="index in 5 - star" :key="`unstar-${index}`"></fa>
  </div>
</template>

<script lang="ts">
  import { Component, Prop, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'component-product-star',
  })
  export default class extends Vue {
    @Prop({ type: Number, required: true })
    private star!: number;
  }
</script>
