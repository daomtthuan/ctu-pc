<template>
  <b-form @submit.prevent="submit" @reset.prevent="reset">
    <b-form-group label="Số lượng" label-for="input-quantity">
      <b-input type="number" id="input-quantity" v-model="$v.form.quantity.$model" :state="validateState('quantity')"></b-input>
      <b-form-invalid-feedback>Số lượng không hợp lệ</b-form-invalid-feedback>
    </b-form-group>
    <div class="text-right">
      <b-button type="reset" variant="danger" :disabled="pending" class="mr-2">
        <span v-if="!pending">Xoá</span>
        <span v-else><b-spinner small></b-spinner> Xử lý...</span>
      </b-button>
      <b-button type="submit" variant="primary" :disabled="pending">
        <span v-if="!pending">Cập nhật</span>
        <span v-else><b-spinner small></b-spinner> Xử lý...</span>
      </b-button>
    </div>
  </b-form>
</template>

<script lang="ts">
  import { editProductCart, getCart, removeProductCart } from '@/plugin/cart';
  import { createValidation, getValidateState, validationMixin } from '@/plugin/validation';
  import { Component, mixins, Prop, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'component-cart-edit',
    validations: createValidation('quantity'),
  })
  export default class extends mixins(validationMixin) {
    @Prop({ type: Number, required: true })
    private idProduct!: number;

    private carts: Entity.Cart.Storage = [];
    private form: App.Form.Cart.Edit = { quantity: null };
    private pending: boolean = false;

    public fetch() {
      if (process.client) {
        let cart = getCart(this.$auth.user.id);
        this.form.quantity = cart.filter((product) => product.id == this.idProduct)[0].quantity;
      }
    }

    public validateState(name: string) {
      return getValidateState(this, name);
    }

    public submit() {
      this.$v.form.$touch();
      if (this.$v.$anyError) {
        return;
      }
      this.pending = true;
      editProductCart(this.$auth.user.id, this.idProduct, this.form.quantity);
      this.$nextTick(() => this.$v.$reset());
      this.$nuxt.$bvToast.toast('Đã cập nhật sản phẩm trong giỏ hàng.', {
        title: 'Cập nhật thành công!',
        variant: 'success',
        solid: true,
        toaster: 'b-toaster-bottom-right',
      });
      this.$emit('change');
      this.pending = false;
    }

    public async reset() {
      let confirm = await this.$nuxt.$bvModal.msgBoxConfirm('Bạn có chắc muốn xoá?', {
        title: 'Xác nhận thao tác',
        okVariant: 'danger',
        okTitle: 'Có, hãy xoá',
        cancelTitle: 'Không',
      });

      if (confirm) {
        this.pending = true;
        removeProductCart(this.$auth.user.id, this.idProduct);
        this.$nuxt.$bvToast.toast('Đã xoá sản phẩm khỏi giỏ hàng.', {
          title: 'Xoá thành công!',
          variant: 'success',
          solid: true,
          toaster: 'b-toaster-bottom-right',
        });
        this.$emit('change');
        this.pending = false;
      }
    }
  }
</script>
