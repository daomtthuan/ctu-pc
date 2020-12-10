<template>
  <b-form @submit.prevent="submit">
    <b-form-group label="Số sao" label-for="select-star" label-size="sm">
      <b-form-rating
        id="select-star"
        v-model="$v.form.star.$model"
        size="sm"
        :class="validateState('star') === true ? 'is-valid' : validateState('star') === false ? 'is-invalid' : null"
      ></b-form-rating>
      <b-form-invalid-feedback>Số sao không hợp lệ</b-form-invalid-feedback>
    </b-form-group>
    <b-form-group label="Đánh giá" label-for="input-content" label-size="sm">
      <b-form-textarea id="input-content" placeholder="Nhập đánh giá" rows="3" max-rows="6" size="sm" v-model="form.content"></b-form-textarea>
    </b-form-group>

    <b-form-group class="text-right">
      <b-button type="submit" variant="primary" :disabled="pending" size="sm">
        <span v-if="!pending">Đánh giá</span>
        <span v-else><b-spinner small></b-spinner> Xử lý...</span>
      </b-button>
    </b-form-group>
  </b-form>
</template>

<script lang="ts">
  import { createValidation, getValidateState, resetForm, validationMixin } from '@/plugin/validation';
  import { Component, mixins, Prop, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'component-form-create-review',
    validations: createValidation('star'),
  })
  export default class extends mixins(validationMixin) {
    @Prop({ type: Number, required: true })
    private idProduct!: number;

    private form: App.Form.Create.Review = {
      star: null,
      content: null,
    };
    private pending: boolean = false;

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
        await this.$axios.post('/api/user/review', this.form, { params: { idProduct: this.idProduct } });

        resetForm(this);
        this.$nuxt.$bvToast.toast('Đã đăng đánh giá sản phẩm.', {
          title: 'Đánh giá thành công!',
          variant: 'success',
          solid: true,
          toaster: 'b-toaster-bottom-right',
        });
      } catch (error) {
        this.$nuxt.error({ statusCode: (<Response>error.response).status });
      } finally {
        this.pending = false;
      }
    }
  }
</script>
