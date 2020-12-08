<template>
  <b-form @submit.prevent="submit">
    <b-form-group label="Số lượng" label-for="input-quantity">
      <b-input type="number" id="input-quantity" v-model="$v.form.quantity.$model" :state="validateState('quantity')"></b-input>
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
    name: 'component-cart-add',
    validations: createValidation('quantity'),
  })
  export default class extends mixins(validationMixin) {
    @Prop({ type: Number, required: true })
    private idProduct!: number;

    private form: App.Form.Cart.Add = { quantity: 1 };
    private pending: boolean = false;

    public validateState(name: string) {
      return getValidateState(this, name);
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
