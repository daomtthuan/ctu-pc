<template>
  <div class="text-center" v-if="$fetchState.pending"><b-spinner small></b-spinner> Đang tải...</div>
  <b-form @submit.prevent="submit" v-else-if="!$fetchState.error">
    <b-form-group label="Trạng thái:">
      <b-form-radio-group class="py-2" v-model="$v.form.state.$model" :state="validateState('state')">
        <b-form-radio id="radio-state-enabled" :value="true">Kích hoạt</b-form-radio>
        <b-form-radio id="radio-state-disabled" :value="false">Vô hiệu hoá</b-form-radio>
      </b-form-radio-group>
      <div class="text-danger small mt-1" v-show="validateState('state') === false">Trạng thái không hợp lệ</div>
    </b-form-group>
    <b-form-group class="text-center">
      <b-button type="submit" variant="primary" :disabled="pending">
        <span v-if="!pending">Chỉnh sửa</span>
        <span v-else><b-spinner small></b-spinner> Xử lý...</span>
      </b-button>
    </b-form-group>
  </b-form>
</template>

<script lang="ts">
  import { createValidation, getValidateState, validationMixin } from '@/plugin/validation';
  import { Component, mixins, Prop, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'component-dashboard-form-edit-bill',
    validations: createValidation('state'),
  })
  export default class extends mixins(validationMixin) {
    @Prop({ type: String, required: true })
    private id!: number;

    private form: App.Form.Edit.Shop.Bill = { state: null };
    private pending: boolean = false;

    public async fetch() {
      try {
        let bills: Entity.Bill[] = (await this.$axios.get('/api/admin/bill', { params: { id: this.id } })).data;
        if (bills.length == 1) {
          this.form = {
            state: bills[0].state,
          };
        } else {
          this.$nuxt.error({ statusCode: 404 });
        }
      } catch (error) {
        let response = <Response>error.response;
        this.$nuxt.error({ statusCode: response.status });
      }
    }

    public validateState(name: string) {
      return getValidateState(this, name);
    }

    public async submit() {
      this.$v.form.$touch();
      if (this.$v.$anyError) {
        return;
      }

      try {
        this.pending = true;
        await this.$axios.put('/api/admin/bill', this.form, { params: { id: this.id } });

        this.$nuxt.$bvToast.toast('Thông tin đơn hàng đã được chỉnh sửa.', {
          title: 'Chỉnh sửa thành công!',
          variant: 'success',
          solid: true,
          toaster: 'b-toaster-bottom-right',
        });
        this.$router.back();
      } catch (error) {
        this.$nuxt.error({ statusCode: (<Response>error.response).status });
      } finally {
        this.pending = false;
      }
    }
  }
</script>
