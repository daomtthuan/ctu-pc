<template>
  <b-form @submit.prevent="submit">
    <b-row>
      <b-col lg="6">
        <b-form-group label="Tài khoản:" label-for="input-username">
          <b-form-input
            id="input-username"
            type="text"
            placeholder="Nhập tài khoản"
            v-model="$v.form.username.$model"
            :state="validateState('username')"
          ></b-form-input>
          <b-form-invalid-feedback>Tên đăng nhập không hợp lệ</b-form-invalid-feedback>
        </b-form-group>
        <b-form-group label="Email:" label-for="input-email">
          <b-form-input id="input-email" type="email" placeholder="Nhập email" v-model="$v.form.email.$model" :state="validateState('email')"></b-form-input>
          <b-form-invalid-feedback>Email không hợp lệ</b-form-invalid-feedback>
        </b-form-group>
        <b-form-group label="Họ và tên:" label-for="input-full-name">
          <b-form-input
            id="input-full-name"
            type="text"
            placeholder="Nhập họ tên"
            v-model="$v.form.fullName.$model"
            :state="validateState('fullName')"
          ></b-form-input>
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
            popup-class="border shadow"
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
            <b-form-radio id="radio-gender-male" :value="true">Nam</b-form-radio>
            <b-form-radio id="radio-gender-female"  :value="false">Nữ</b-form-radio>
          </b-form-radio-group>
          <div class="text-danger small mt-1" v-show="validateState('gender') === false">Giới tính không hợp lệ</div>
        </b-form-group>
        <b-form-group label="Số điện thoại:">
          <b-form-input
            id="input-phone"
            type="text"
            placeholder="Nhập số điện thoại"
            v-model="$v.form.phone.$model"
            :state="validateState('phone')"
          ></b-form-input>
          <b-form-invalid-feedback>Số điện thoại không hợp lệ</b-form-invalid-feedback>
        </b-form-group>
      </b-col>
    </b-row>
    <b-form-group label="Địa chỉ:">
      <b-form-textarea
        id="input-address"
        placeholder="Nhập địa chỉ"
        rows="3"
        max-rows="6"
        v-model="$v.form.address.$model"
        :state="validateState('address')"
      ></b-form-textarea>
      <b-form-invalid-feedback>Địa chỉ không hợp lệ</b-form-invalid-feedback>
    </b-form-group>

    <b-form-group class="text-center">
      <b-button type="submit" variant="primary" :disabled="pending">
        <span v-if="!pending">Tạo mới</span>
        <span v-else><b-spinner small></b-spinner> Xử lý...</span>
      </b-button>
    </b-form-group>
  </b-form>
</template>

<script lang="ts">
  import { createValidation, getValidateState, validationMixin } from '@/plugin/validation';
  import { Component, mixins, Vue } from 'nuxt-property-decorator';
  import { DatePicker } from '@/plugin/datepicker';

  @Component({
    name: 'component-dashboard-form-create-access-account',
    components: { DatePicker },
    validations: createValidation('username', 'email', 'fullName', 'birthday', 'gender', 'phone', 'address'),
  })
  export default class extends mixins(validationMixin) {
    private form: App.Form.Create.Access.Account = {
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
      return getValidateState(this, name);
    }

    public async submit() {
      this.$v.form.$touch();
      if (this.$v.$anyError) {
        return;
      }

      try {
        this.pending = true;
        await this.$axios.post('/api/admin/account', this.form);

        this.$nuxt.$bvToast.toast('Email chứa thông tin tài khoản đã được gửi.', {
          title: 'Tạo mới thành công!',
          variant: 'success',
          solid: true,
          toaster: 'b-toaster-bottom-right',
        });
        this.$router.back();
      } catch (error) {
        let response = <Response>error.response;
        if (response.status == 406) {
          this.$nuxt.$bvToast.toast('Tên đăng nhập đã được sử dụng.', {
            title: 'Tạo mới không thành công!',
            variant: 'danger',
            solid: true,
            toaster: 'b-toaster-bottom-right',
          });
        } else {
          this.$nuxt.error({ statusCode: response.status });
        }
      } finally {
        this.pending = false;
      }
    }
  }
</script>

<style lang="scss">
  @import '@/asset/style/datepicker';
</style>
