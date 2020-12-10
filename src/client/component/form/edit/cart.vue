<template>
  <div class="text-center" v-if="$fetchState.pending"><b-spinner small></b-spinner> Đang tải...</div>
  <b-form @submit.prevent="submit" @reset.prevent="reset" v-else-if="!$fetchState.error">
    <b-form-group label="Số lượng" label-for="input-quantity">
      <b-input type="number" id="input-quantity" v-model="$v.form.quantity.$model" :state="validateState()"></b-input>
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
    name: 'component-form-edit-cart',
    validations: createValidation('quantity'),
  })
  export default class extends mixins(validationMixin) {
    @Prop({ type: Number, required: true })
    private idProduct!: number;

    private carts: Entity.Cart.Storage = [];
    private form: App.Form.Edit.Cart = { quantity: null };
    private quantity: number | null = null;
    private pending: boolean = false;

    public async fetch() {
      if (process.client) {
        let cart = getCart(this.$auth.user.id);
        this.form.quantity = cart.filter((product) => product.id == this.idProduct)[0].quantity;

        try {
          let products: Entity.Product[] = (await this.$axios.get('/api/product', { params: { id: this.idProduct } })).data;
          if (products.length != 1) {
            this.$nuxt.error({ statusCode: 404 });
          }
          this.quantity = products[0].quantity;
          if (this.quantity < this.form.quantity) {
            this.form.quantity = this.quantity;
            editProductCart(this.$auth.user.id, this.idProduct, this.form.quantity);
            this.$nuxt.$bvToast.toast('Sản phẩm còn lại không đủ. Đã cập nhật lại số lượng thành số lượng tối đa có thể.', {
              title: 'Thay đổi số lượng sản phẩm',
              variant: 'warning',
              solid: true,
              toaster: 'b-toaster-bottom-right',
            });
          }
        } catch (error) {
          this.$nuxt.error({ statusCode: (<Response>error.response).status });
        }
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
