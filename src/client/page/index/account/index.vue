<template>
  <b-container>
    <b-card border-variant="primary">
      <b-card-body>
        <div v-if="$fetchState.pending" class="text-center"><b-spinner small></b-spinner> Xác thực...</div>
        <div v-else-if="!this.$fetchState.error">
          <b-card-title title-tag="h2" class="text-primary">
            Thông tin tài khoản
          </b-card-title>
          <hr />
          <c-form-account :form="form"></c-form-account>
        </div>
      </b-card-body>
    </b-card>
  </b-container>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'page-account-index',
    head: {
      title: 'Thông tin tài khoản',
    },
    fetchOnServer: false,
  })
  export default class extends Vue {
    private form: {
      username: null | string;
      email: null | string;
      fullName: null | string;
      birthday: null | string;
      gender: null | boolean;
      phone: null | string;
      address: null | string;
    } = {
      username: null,
      email: null,
      fullName: null,
      birthday: null,
      gender: null,
      phone: null,
      address: null,
    };

    public async fetch() {
      try {
        this.form = (await this.$axios.get('/api/user/account')).data;
      } catch (error) {
        this.$nuxt.error({ statusCode: (<Response>error.response).status });
      }
    }
  }
</script>
