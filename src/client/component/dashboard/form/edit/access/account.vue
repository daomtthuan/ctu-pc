<template>
  <div class="text-center" v-if="$fetchState.pending"><b-spinner small></b-spinner> Đang tải...</div>
  <b-form @submit.prevent="submit" v-else-if="!$fetchState.error">
    <b-row>
      <b-col lg="6">
        <b-form-group label="Trạng thái:">
          <b-form-radio-group class="py-2" v-model="$v.form.state.$model" :state="validateState('state')">
            <b-form-radio id="radio-state-enabled"  :value="true">Kích hoạt</b-form-radio>
            <b-form-radio id="radio-state-disabled"  :value="false">Vô hiệu hoá</b-form-radio>
          </b-form-radio-group>
          <div class="text-danger small mt-1" v-show="validateState('state') === false">Trạng thái không hợp lệ</div>
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
            <b-form-radio id="radio-gender-male"  :value="true">Nam</b-form-radio>
            <b-form-radio id="radio-gender-female"  :value="false">Nữ</b-form-radio>
          </b-form-radio-group>
          <div class="text-danger small mt-1" v-show="validateState('gender') === false">Giới tính không hợp lệ</div>
        </b-form-group>
        <b-form-group label="Số điện thoại:" label-for="input-phone">
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
    <b-form-group label="Địa chỉ:" label-for="input-address">
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
        <span v-if="!pending">Chỉnh sửa</span>
        <span v-else><b-spinner small></b-spinner> Xử lý...</span>
      </b-button>
    </b-form-group>
  </b-form>
</template>

<script lang="ts">
  import { createValidation, getValidateState, validationMixin } from '@/plugin/validation';
  import { Component, mixins, Prop, Vue } from 'nuxt-property-decorator';
  import { DatePicker } from '@/plugin/datepicker';

  @Component({
    name: 'component-dashboard-form-edit-access-account',
    components: { DatePicker },
    validations: createValidation('email', 'fullName', 'birthday', 'gender', 'phone', 'address', 'state'),
  })
  export default class extends mixins(validationMixin) {
    @Prop({ type: String, required: true })
    private id!: number;

    private form: App.Form.Edit.Access.Account = {
      email: null,
      fullName: null,
      birthday: null,
      gender: null,
      phone: null,
      address: null,
      state: null,
    };
    private pending: boolean = false;

    public async fetch() {
      try {
        let accounts: Entity.Account[] = (await this.$axios.get('/api/admin/account', { params: { id: this.id } })).data;
        if (accounts.length == 1) {
          this.form = accounts[0];
          this.form = {
            email: accounts[0].email,
            fullName: accounts[0].fullName,
            birthday: accounts[0].birthday,
            gender: accounts[0].gender,
            phone: accounts[0].phone,
            address: accounts[0].address,
            state: accounts[0].state,
          };
        } else {
          this.$nuxt.error({ statusCode: 404 });
        }
      } catch (error) {
        let response = <Response>error.response;
        this.$nuxt.error({ statusCode: response.status });
      }
    }

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
        await this.$axios.put('/api/admin/account', this.form, { params: { id: this.id } });

        this.$nuxt.$bvToast.toast('Thông tin tài khoản đã được chỉnh sửa.', {
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

<style lang="scss">
  @import '@/asset/style/datepicker';
</style>
