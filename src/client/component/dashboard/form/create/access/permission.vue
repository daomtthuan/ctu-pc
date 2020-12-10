<template>
  <div v-if="$fetchState.pending" class="text-center"><b-spinner small></b-spinner> Đang tải...</div>
  <b-form @submit.prevent="submit" v-else-if="!$fetchState.error">
    <b-form-group label="Quyền truy cập:" label-for="select-role">
      <b-form-select
        id="select-role"
        v-model="$v.form.idRole.$model"
        :options="roleOptions"
        :disabled="idAccountPending"
        :state="validateState('idRole')"
      ></b-form-select>
      <b-form-invalid-feedback>Quyền truy cập không hợp lệ</b-form-invalid-feedback>
    </b-form-group>
    <div v-if="idAccountPending" class="text-center mb-3"><b-spinner small></b-spinner> Đang tải...</div>
    <b-form-group label="Tài khoản:" label-for="select-account" v-else-if="form.idRole != null">
      <b-form-select
        id="select-account"
        v-model="$v.form.idAccount.$model"
        :options="accountOptions"
        :state="validateState('idAccount')"
        :disabled="accountOptions.length == 1"
      ></b-form-select>
      <b-form-invalid-feedback>Tài khoản không hợp lệ</b-form-invalid-feedback>
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
  import { createValidation, getValidateState, validationMixin } from '@/plugin/validation';
  import { Component, mixins, Vue, Watch } from 'nuxt-property-decorator';

  @Component({
    name: 'component-dashboard-form-create-access-permission',
    validations: createValidation('idRole', 'idAccount'),
  })
  export default class extends mixins(validationMixin) {
    private form: App.Form.Create.Access.Permission = { idRole: null, idAccount: null };
    private roleOptions: App.Control.SeleteOption[] = [];
    private accountOptions: App.Control.SeleteOption[] = [];
    private idAccountPending: boolean = false;
    private submitPending: boolean = false;

    public async fetch() {
      try {
        this.roleOptions = [{ value: null, text: 'Chọn quyền truy cập', disabled: true }];
        for (let role of <Entity.Role[]>(await this.$axios.get('/api/admin/role')).data) {
          this.roleOptions.push({ value: role.id, text: role.name });
        }
      } catch (error) {
        this.$nuxt.error({ statusCode: (<Response>error.response).status });
      }
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
        this.submitPending = true;
        await this.$axios.post('/api/admin/permission', this.form);

        this.accountOptions = this.accountOptions.filter((option) => option.value != this.form.idAccount);

        this.$nuxt.$bvToast.toast('Đã tạo mới phân quyền cho tài khoản.', {
          title: 'Tạo mới thành công!',
          variant: 'success',
          solid: true,
          toaster: 'b-toaster-bottom-right',
        });
        this.$router.back();
      } catch (error) {
        this.$nuxt.error({ statusCode: (<Response>error.response).status });
      } finally {
        this.submitPending = false;
      }
    }

    @Watch('form.idRole')
    public async onIdRoleChanged(newValue: number) {
      if (newValue != null) {
        try {
          this.idAccountPending = true;
          let accounts: Entity.Account[] = (await this.$axios.get('/api/admin/permission', { params: { idRole: newValue, notIn: true } })).data;
          if (accounts.length > 0) {
            this.accountOptions = [{ value: null, text: 'Chọn tài khoản phân quyền', disabled: true }];
            this.form.idAccount = this.accountOptions[0].value;
            for (let account of accounts) {
              this.accountOptions.push({ value: account.id, text: `Tên đăng nhập: ${account.username} - Họ và tên: ${account.fullName}` });
            }
          } else {
            this.accountOptions = [{ value: null, text: 'Không có tài khoản nào phù hợp', disabled: true }];
          }
        } catch (error) {
          this.$nuxt.error({ statusCode: (<Response>error.response).status });
        } finally {
          this.idAccountPending = false;
        }
      }
    }
  }
</script>
