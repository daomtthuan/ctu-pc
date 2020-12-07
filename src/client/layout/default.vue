<template>
  <nuxt></nuxt>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'layout',
  })
  export default class extends Vue {
    public async beforeCreate() {
      if (process.client) {
        try {
          let token = window.localStorage.getItem('token');
          if (token != null && token != this.$auth.getToken('local')) {
            this.$auth.setToken('local', token);
            await this.$auth.fetchUser();
          }
        } catch (error) {
          this.$nuxt.error({ statusCode: (<Response>error.response).status });
        }
      }
    }
  }
</script>

<style lang="scss">
  @import '@/asset/style/theme';
</style>
