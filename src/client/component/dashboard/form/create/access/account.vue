<template>
  <b-form @submit.prevent="submit">
    <b-row>
      <b-col lg="6">
        <b-form-group label="Tài khoản:" label-for="input-username">
          <b-form-input id="input-username" type="text" placeholder="Nhập tài khoản" autocomplete="on" v-model="$v.form.username.$model" :state="validateState('username')"></b-form-input>
          <b-form-invalid-feedback>Tên đăng nhập không hợp lệ</b-form-invalid-feedback>
        </b-form-group>
        <b-form-group label="Email:" label-for="input-email">
          <b-form-input id="input-email" type="email" placeholder="Nhập email" autocomplete="on" v-model="$v.form.email.$model" :state="validateState('email')"></b-form-input>
          <b-form-invalid-feedback>Email không hợp lệ</b-form-invalid-feedback>
        </b-form-group>
        <b-form-group label="Họ và tên:" label-for="input-full-name">
          <b-form-input id="input-full-name" type="text" placeholder="Nhập họ tên" autocomplete="on" v-model="$v.form.fullName.$model" :state="validateState('fullName')"></b-form-input>
          <b-form-invalid-feedback>Họ và tên không hợp lệ</b-form-invalid-feedback>
        </b-form-group>
      </b-col>
      <b-col lg="6">
        <b-form-group label="Ngày sinh:" label-for="input-birthday">
          <date-picker
            :input-attr="{ id: 'input-birthday', name: 'birthday', autocomplete: 'on' }"
            :input-class="`form-control ${validateState('birthday') ? 'is-valid' : validateState('birthday') === false ? 'is-invalid' : ''}`"
            :clearable="false"
            value-type="YYYY-MM-DD"
            format="DD-MM-YYYY"
            popup-class="rounded border shadow"
            placeholder="Nhập ngày sinh"
            v-model="$v.form.birthday.$model"
            class="w-100"
            prefix-class="date-picker"
            :disabled-date="disabledDate"
          >
            <template #icon-calendar>
              <i></i>
            </template>
          </date-picker>
          <div class="text-danger small mt-1" v-show="validateState('birthday') === false">Ngày sinh không hợp lệ</div>
        </b-form-group>
        <b-form-group label="Giới tính:">
          <b-form-radio-group class="py-2" v-model="$v.form.gender.$model" :state="validateState('gender')">
            <b-form-radio id="radio-gender-male" name="gender" :value="1" autocomplete="on">Nam</b-form-radio>
            <b-form-radio id="radio-gender-female" name="gender" :value="0" autocomplete="on">Nữ</b-form-radio>
          </b-form-radio-group>
          <div class="text-danger small mt-1" v-show="validateState('gender') === false">Giới tính không hợp lệ</div>
        </b-form-group>
        <b-form-group label="Số điện thoại:">
          <b-form-input id="input-phone" type="text" name="phone" placeholder="Nhập số điện thoại" autocomplete="on" v-model="$v.form.phone.$model" :state="validateState('phone')"></b-form-input>
          <b-form-invalid-feedback>Số điện thoại không hợp lệ</b-form-invalid-feedback>
        </b-form-group>
      </b-col>
    </b-row>
    <b-form-group label="Địa chỉ:">
      <b-form-textarea id="input-address" name="address" placeholder="Nhập địa chỉ" rows="3" max-rows="6" autocomplete="on" v-model="$v.form.address.$model" :state="validateState('address')"></b-form-textarea>
      <b-form-invalid-feedback>Địa chỉ không hợp lệ</b-form-invalid-feedback>
    </b-form-group>

    <b-form-group class="text-center">
      <b-button type="submit" variant="primary" :disabled="pending">
        <span v-if="!pending">Thêm mới</span>
        <span v-else><b-spinner small></b-spinner> Xử lý...</span>
      </b-button>
    </b-form-group>
  </b-form>
</template>

<script lang="ts">
  import { createValidation, validationMixin } from '@/plugin/validation';
  import { Component, mixins, Vue } from 'nuxt-property-decorator';
  import { DatePicker } from '@/plugin/datepicker';

  @Component({
    name: 'component-dashboard-form-create-access-account',
    components: { DatePicker },
    validations: createValidation('username', 'email', 'fullName', 'birthday', 'gender', 'phone', 'address'),
  })
  export default class extends mixins(validationMixin) {
    private form = {
      username: null,
      email: null,
      fullName: null,
      birthday: null,
      gender: null,
      phone: null,
      address: null,
    };
    private pending: boolean = false;

    public disabledDate(date: Date) {
      let maxBirthday = new Date();
      maxBirthday.setFullYear(maxBirthday.getFullYear() - 1);
      return date > maxBirthday;
    }

    public validateState(name: string) {
      let validate = this.$v.form[name];
      return validate!.$dirty ? !validate!.$error : null;
    }

    public async submit() {
      this.$v.form.$touch();
      if (this.$v.$anyError) {
        return;
      }

      // submit

      this.form = {
        username: null,
        email: null,
        fullName: null,
        birthday: null,
        gender: null,
        phone: null,
        address: null,
      };

      this.$nextTick(() => this.$v.$reset());

      // try {
      //   this.pending = true;
      //   await this.$axios.post('/admin/account', this.form);
      //   this.$router.push('/', () => {
      //     this.$nuxt.$bvToast.toast(this.$createElement('div', ['Chào mừng ', this.$createElement('strong', response.data.fullName), ' đến với CTU PC SHOP!']), {
      //       title: 'Thêm mới thành công!',
      //       variant: 'success',
      //       solid: true,
      //     });
      //   });
      // } catch (error) {
      //   let response = <Response>error.response;
      //   if (response.status == 406) {
      //     this.pending = false;
      //     this.$bvToast.toast('Tên đăng nhập đã được sử dụng.', {
      //       title: 'Thêm mới không thành công!',
      //       variant: 'danger',
      //       solid: true,
      //     });
      //   } else {
      //     this.$nuxt.error({ statusCode: response.status });
      //   }
      // }
    }
  }
</script>

<style lang="scss">
  @import '@/asset/style/datepicker';
</style>
