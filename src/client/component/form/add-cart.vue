<template>
  <b-form @submit.prevent="submit">
    <b-form-group label="Số lượng" label-for="input-quantity">
      <b-input type="number" id="input-quantity" v-model="form.quantity" :state="state"></b-input>
      <b-form-invalid-feedback>Số lượng không hợp lệ</b-form-invalid-feedback>
    </b-form-group>
    <div class="text-right">
      <b-button variant="primary" type="submit">Thêm vào giỏ hàng</b-button>
    </div>
  </b-form>
</template>

<script lang="ts">
  import { addProductCart } from '@/plugin/helper';
  import { Component, Prop, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'component-add-cart',
  })
  export default class extends Vue {
    @Prop({ type: Number, required: true })
    private idProduct!: number;

    private form: App.Form.AddCart = {
      quantity: 1,
    };

    public submit() {
      if (!this.state) {
        return;
      }

      let quantity = parseInt(this.form.quantity.toString());
      if (this.$auth.loggedIn) {
        addProductCart(this.$auth.user.id, this.idProduct, quantity);
        this.$nuxt.$bvToast.toast('Đã thêm sản phẩm vào giỏ hàng.', {
          title: 'Thêm thành công!',
          variant: 'success',
          solid: true,
          toaster: 'b-toaster-bottom-right',
        });
      } else {
        window.sessionStorage.setItem('tempProductCart', JSON.stringify({ idProduct: this.idProduct, quantity }));
        this.$auth.$state.redirect = this.$route.path;
        this.$router.push('/login');
      }
    }

    public get state() {
      if (/[0-9]+/.test(this.form.quantity.toString())) {
        if (this.form.quantity >= 1) {
          return true;
        }
      }

      return false;
    }
  }
</script>
