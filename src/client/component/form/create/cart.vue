<template>
  <div v-if="$fetchState.pending" class="text-center"><b-spinner small></b-spinner> Đang tải...</div>
  <b-form @submit.prevent="submit" v-else-if="!$fetchState.error">
    <b-form-group label="Số lượng" label-for="input-quantity">
      <b-input type="number" id="input-quantity" v-model="$v.form.quantity.$model" :state="validateState()"></b-input>
      <b-form-invalid-feedback>Số lượng không hợp lệ</b-form-invalid-feedback>
    </b-form-group>
    <div class="text-right">
      <b-button type="submit" variant="primary" :disabled="pending">
        <span v-if="!pending">Thêm vào giỏ hàng</span>
        <span v-else><b-spinner small></b-spinner> Xử lý...</span>
      </b-button>
    </div>
  </b-form>
</template>

<script lang="ts">
  import { addProductCart } from '@/plugin/cart';
  import { createValidation, getValidateState, validationMixin } from '@/plugin/validation';
  import { Component, mixins, Prop, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'component-form-create-cart',
    validations: createValidation('quantity'),
  })
  export default class extends mixins(validationMixin) {
    @Prop({ type: Number, required: true })
    private idProduct!: number;

    private quantity: number | null = null;
    private form: App.Form.Create.Cart = { quantity: 1 };
    private pending: boolean = false;

    public async fetch() {
      try {
        let products: Entity.Product[] = (await this.$axios.get('/api/product', { params: { id: this.idProduct } })).data;
        if (products.length != 1) {
          this.$nuxt.error({ statusCode: 404 });
        }
        this.quantity = products[0].quantity;
      } catch (error) {
        this.$nuxt.error({ statusCode: (<Response>error.response).status });
      }
    }

    public validateState() {
      let state = getValidateState(this, 'quantity');
      return state === true ? state && this.form.quantity! <= this.quantity! : state;
    }

    public submit() {
      this.$v.form.$touch();
      if (this.$v.$anyError) {
        return;
      }

      if (this.$auth.loggedIn) {
        this.pending = true;
        addProductCart(this.$auth.user.id, this.idProduct, this.form.quantity);
        this.$nuxt.$bvToast.toast('Đã thêm sản phẩm vào giỏ hàng.', {
          title: 'Thêm thành công!',
          variant: 'success',
          solid: true,
          toaster: 'b-toaster-bottom-right',
        });
        this.pending = false;
      } else {
        window.sessionStorage.setItem(
          'tempProductCart',
          JSON.stringify(<Entity.Cart.Product>{ id: this.idProduct, quantity: parseInt(this.form.quantity!.toString()) })
        );
        this.$auth.$state.redirect = this.$route.path;
        this.$router.push('/login');
      }
    }
  }
</script>
