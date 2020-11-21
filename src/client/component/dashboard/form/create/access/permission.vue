<template>
  <div v-if="$fetchState.pending" class="text-center"><b-spinner small></b-spinner> Đang tải...</div>
  <b-form @submit.prevent="submit" v-else-if="!this.$fetchState.error">
    <b-form-group label="Quyền truy cập:">
      <b-form-select v-model="$v.form.idRole.$model" :options="roleOptions" :disabled="idAccountPending" :state="validateState('idRole')"></b-form-select>
      <b-form-invalid-feedback>Quyền truy cập không hợp lệ</b-form-invalid-feedback>
    </b-form-group>
    <b-form-group label="Quyền truy cập:">
      <div v-if="idAccountPending" class="text-center"><b-spinner small></b-spinner> Đang tải...</div>
      <div v-else>
        <b-form-select v-model="$v.form.idAccount.$model" :options="accountOptions" :state="validateState('idAccount')"></b-form-select>
        <b-form-invalid-feedback>Tài khoản không hợp lệ</b-form-invalid-feedback>
      </div>
    </b-form-group>
    <b-form-group class="text-center">
      <b-button type="submit" variant="primary" :disabled="submitPending">
        <span v-if="!submitPending">Tạo mới</span>
        <span v-else><b-spinner small></b-spinner> Xử lý...</span>
      </b-button>
    </b-form-group>
  </b-form>
</template>

<script lang="ts">
  import { createValidation, validationMixin } from '@/plugin/validation';
  import { Component, mixins, Vue, Watch } from 'nuxt-property-decorator';
  import { DatePicker } from '@/plugin/datepicker';

  @Component({
    name: 'component-dashboard-form-create-access-account',
    components: { DatePicker },
    validations: createValidation('idRole', 'idAccount'),
  })
  export default class extends mixins(validationMixin) {
    private form: {
      idRole: null | number;
      idAccount: null | number;
    } = {
      idRole: null,
      idAccount: null,
    };
    private roleOptions: { value: number | null; text: string; disabled?: boolean }[] = [{ value: null, text: '-- Chọn quyền truy cập --', disabled: true }];
    private accountOptions: { value: number | null; text: string; disabled?: boolean }[] = [{ value: null, text: '-- Chọn tài khoản phân quyền --', disabled: true }];
    private idAccountPending: boolean = false;
    private submitPending: boolean = false;

    public async fetch() {
      try {
        for (let role of <Entity.Role[]>(await this.$axios.get('admin/role')).data) {
          this.roleOptions.push({ value: role.id, text: role.name });
        }
      } catch (error) {
        this.$nuxt.error({ statusCode: (<Response>error.response).status });
      }
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

      try {
        this.submitPending = true;
        await this.$axios.post('/admin/permission', this.form);
        this.accountOptions = this.accountOptions.filter((option) => option.value != this.form.idAccount);
        this.form.idAccount = null;
        this.$nextTick(() => this.$v.$reset());
      } catch (error) {
        this.$nuxt.error({ statusCode: (<Response>error.response).status });
      } finally {
        this.submitPending = false;
      }
    }

    @Watch('form.idRole')
    public async onIdRoleChanged(newValue: number) {
      this.accountOptions = [{ value: null, text: '-- Chọn tài khoản phân quyền --', disabled: true }];
      if (newValue != null) {
        try {
          this.idAccountPending = true;
          for (let account of <Entity.Account[]>(await this.$axios.get('admin/permission', { params: { idRole: newValue, notIn: true } })).data) {
            this.accountOptions.push({ value: account.id, text: `Tên đăng nhập: ${account.username} - Họ và tên: ${account.fullName}` });
          }
          this.form.idAccount = this.accountOptions[0].value;
        } catch (error) {
          this.$nuxt.error({ statusCode: (<Response>error.response).status });
        } finally {
          this.idAccountPending = false;
        }
      }
    }
  }
</script>
