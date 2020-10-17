<template>
  <div>
    <client-only>
      {{ $auth.user }}
    </client-only>
  </div>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component
  export default class IndexUserIndex extends Vue {}
</script>
