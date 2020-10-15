<template>
  <div>
    User
  </div>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    middleware: 'auth',
  })
  export default class User extends Vue {}
</script>

<style lang="scss" scoped></style>
