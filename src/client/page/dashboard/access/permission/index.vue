<template>
  <div>
    <b-breadcrumb class="bg-light">
      <b-breadcrumb-item text="Bảng điều khiến" to="/dashboard"></b-breadcrumb-item>
      <b-breadcrumb-item text="Truy cập - Phân quyền" to="/dashboard/access/permission"></b-breadcrumb-item>
    </b-breadcrumb>
    <hr />
    <b-button size="sm" :to="`${$route.path}/create`" variant="primary">Tạo mới</b-button>
    <hr />
    <div v-if="$fetchState.pending" class="text-center"><b-spinner small></b-spinner> Đang tải...</div>
    <div v-else-if="!$fetchState.error">
      <b-form-group label="Quyền truy cập:" label-for="select-role" label-size="sm">
        <b-form-select id="select-role" v-model="selected" :options="options" :disabled="pending" size="sm"></b-form-select>
      </b-form-group>
      <div v-if="selected != null">
        <div v-if="pending" class="text-center"><b-spinner small></b-spinner> Đang tải...</div>
        <c-dashboard-table
          :title="`Danh sách tài khoản có quyền truy cập ${nameRole}`"
          :items="items"
          :fields="fields"
          :notes="notes"
          :row-class="rowClass"
          :remove-item="remove"
          :allow-edit="false"
          v-else
        ></c-dashboard-table>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
  import { Component, Vue, Watch } from 'nuxt-property-decorator';

  @Component({
    name: 'page-dashboard-access-permission',
    head: {
      title: 'Bảng điều khiển - Truy cập - Phân quyền',
    },
  })
  export default class extends Vue {
    private nameRole: string | null = null;
    private items: Entity.Account[] = [];
    private fields: App.Component.Table.Field[] = [];
    private notes: App.Component.Table.Note[] = [{ label: 'Vô hiệu hoá', class: 'text-secondary bg-light font-weight-light' }];
    private selected: number | null = null;
    private options: App.Control.SeleteOption[] = [];
    private pending: boolean = false;

    public rowClass(item: Entity.Account) {
      return item.state ? null : 'text-secondary bg-light font-weight-light';
    }

    public async fetch() {
      try {
        let roles: Entity.Role[] = (await this.$axios.get('/api/admin/role')).data;
        if (roles.length > 0) {
          this.options = [{ value: null, text: 'Chọn quyền truy cập', disabled: true }];
          for (let role of roles) {
            this.options.push({ value: role.id, text: role.name });
          }
        } else {
          this.options = [{ value: null, text: 'Không có quyền truy cập nào', disabled: true }];
        }
      } catch (error) {
        this.$nuxt.error({ statusCode: (<Response>error.response).status });
      }
    }

    @Watch('selected')
    public async onSelectedChanged(newValue: number) {
      if (newValue != null) {
        try {
          this.pending = true;
          this.nameRole = this.options.filter((role) => role.value == newValue)[0].text;
          this.items = (await this.$axios.get('/api/admin/permission', { params: { idRole: newValue, notIn: false } })).data;
          this.fields = [
            { key: 'id', label: 'Id', sortable: true, class: 'd-none' },
            { key: 'username', label: 'Tài khoản', sortable: true, class: 'align-middle fit' },
            { key: 'fullName', label: 'Họ và tên', sortable: true, class: 'align-middle' },
            { key: 'birthday', label: 'Ngày sinh', sortable: true, class: 'align-middle text-md-right fit' },
            {
              key: 'gender',
              label: 'Giới tính',
              sortable: true,
              class: 'align-middle fit',
              formatter: (value) => (value == 1 ? 'Nam' : 'Nữ'),
              sortByFormatted: true,
              filterByFormatted: true,
            },
            { key: 'email', label: 'Email', sortable: true, class: 'align-middle' },
            { key: 'address', label: 'Địa chỉ', sortable: true, class: 'align-middle' },
            { key: 'phone', label: 'Điện thoại', sortable: true, class: 'align-middle' },
            {
              key: 'state',
              label: 'Trạng thái',
              sortable: true,
              class: 'd-none',
              formatter: (value) => (value == 1 ? 'Kích hoạt' : 'Vô hiệu hoá'),
              sortByFormatted: true,
              filterByFormatted: true,
            },
            { key: 'actions', label: 'Thao tác', class: 'align-middle fit' },
          ];
        } catch (error) {
          this.$nuxt.error({ statusCode: (<Response>error.response).status });
        } finally {
          this.pending = false;
        }
      }
    }

    public async remove(id: number) {
      try {
        await this.$axios.delete('/api/admin/permission', { params: { idAccount: id, idRole: this.selected } });
        this.items = this.items.filter((item) => item.id != id);
        this.$nuxt.$bvToast.toast('Đã xoá phân quyền của tài khoản.', {
          title: 'Xoá thành công!',
          variant: 'success',
          solid: true,
          toaster: 'b-toaster-bottom-right',
        });
      } catch (error) {
        this.$nuxt.error({ statusCode: (<Response>error.response).status });
      }
    }
  }
</script>
