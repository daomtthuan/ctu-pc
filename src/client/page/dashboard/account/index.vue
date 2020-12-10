<template>
  <b-container>
    <b-card border-variant="primary">
      <b-card-body>
        <div v-if="$fetchState.pending" class="text-center"><b-spinner small></b-spinner> Đang tải...</div>
        <div v-else-if="!$fetchState.error">
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
    name: 'page-dashboard-account',
    head: {
      title: 'Thông tin tài khoản',
    },
  })
  export default class extends Vue {
    private form: App.Form.Account = {
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
