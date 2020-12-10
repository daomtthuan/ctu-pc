<template>
  <b-navbar type="light" variant="light" class="fixed-top border-bottom border-primary" :style="{ paddingLeft: visible ? width : null }">
    <b-navbar-brand to="/dashboard" class="font-weight-bold text-primary d-flex align-items-center h-100 margin-logo py-0" v-if="!largeDevice">
      <c-logo class="mr-3"></c-logo>
      <div>CTU PC SHOP</div>
    </b-navbar-brand>

    <b-navbar-nav class="flex-grow-1 d-none d-md-flex mr-2" :class="largeDevice ? 'ml-3' : null">
      <b-form action="/dashboard/search" class="w-100">
        <b-input-group>
          <b-form-input placeholder="Tìm kiếm" type="search"></b-form-input>
          <b-input-group-append>
            <b-button type="submit" variant="primary" class="ml-1">
              <fa :icon="['fas', 'search']"></fa>
            </b-button>
          </b-input-group-append>
        </b-input-group>
      </b-form>
    </b-navbar-nav>

    <b-navbar-nav class="ml-auto">
      <b-dropdown variant="primary" right no-caret :disabled="pending">
        <template #button-content>
          <span v-if="!pending">
            <span class="d-none d-md-inline">
              Tài khoản
            </span>
            <span class="d-md-none">
              <fa :icon="['fas', 'user']"></fa>
            </span>
          </span>
          <span v-else><b-spinner small></b-spinner> Xử lý...</span>
        </template>
        <b-dropdown-item to="/dashboard/account">Thông tin cá nhân</b-dropdown-item>
        <b-dropdown-item to="/dashboard/account/change-password">Đổi mật khẩu</b-dropdown-item>
        <b-dropdown-divider></b-dropdown-divider>
        <b-dropdown-item to="/">Trở về vai trò người dùng</b-dropdown-item>
        <b-dropdown-item @click="logout">Đăng xuất</b-dropdown-item>
      </b-dropdown>
      <b-button v-b-toggle.sidebar variant="primary" class="d-xl-none ml-2">
        <fa :icon="['fas', 'bars']"></fa>
      </b-button>
    </b-navbar-nav>

    <b-sidebar
      id="sidebar"
      sidebar-class="border-right border-primary"
      body-class="p-3"
      :shadow="!largeDevice"
      :backdrop="!largeDevice"
      :no-slide="largeDevice"
      :no-close-on-esc="largeDevice"
      :no-close-on-route-change="largeDevice"
      :visible="visible"
      :style="{ width }"
    >
      <template #title="{ hide }">
        <b-navbar type="light" variant="light" class="fixed-top">
          <b-navbar-brand to="/dashboard" class="font-weight-bold text-primary d-flex align-items-center h-100 margin-logo">
            <c-logo class="mr-3"></c-logo>
            <div>CTU PC SHOP</div>
          </b-navbar-brand>
          <b-navbar-nav class="ml-auto" v-if="!largeDevice">
            <b-button variant="outline-danger" class="border-0" @click="hide">
              <fa :icon="['fas', 'times']"></fa>
            </b-button>
          </b-navbar-nav>
        </b-navbar>
      </template>
      <template #default>
        <b-form action="/dashboard/search" class="d-md-none">
          <b-input-group>
            <b-form-input placeholder="Tìm kiếm" type="search"></b-form-input>
            <b-input-group-append>
              <b-button type="submit" variant="primary" class="ml-1">
                <fa :icon="['fas', 'search']"></fa>
              </b-button>
            </b-input-group-append>
          </b-input-group>
        </b-form>

        <b-button v-b-toggle.access block variant="primary" class="text-left my-2">
          Truy cập
        </b-button>
        <b-collapse id="access" class="my-2">
          <b-card no-body>
            <b-card-body class="py-2 px-0">
              <nuxt-link to="/dashboard/access/account" class="dropdown-item">Tài khoản</nuxt-link>
              <nuxt-link to="/dashboard/access/role" class="dropdown-item">Quyền truy cập</nuxt-link>
              <nuxt-link to="/dashboard/access/permission" class="dropdown-item">Phân quyền</nuxt-link>
            </b-card-body>
          </b-card>
        </b-collapse>

        <b-button v-b-toggle.shop block variant="primary" class="text-left my-2">
          Cửa hàng
        </b-button>
        <b-collapse id="shop" class="my-2">
          <b-card no-body>
            <b-card-body class="py-2 px-0">
              <nuxt-link to="/dashboard/shop/brand" class="dropdown-item">Thương hiệu</nuxt-link>
              <nuxt-link to="/dashboard/shop/category-group" class="dropdown-item">Nhóm danh mục</nuxt-link>
              <nuxt-link to="/dashboard/shop/category" class="dropdown-item">Danh mục</nuxt-link>
              <nuxt-link to="/dashboard/shop/product" class="dropdown-item">Sản phẩm</nuxt-link>
              <nuxt-link to="/dashboard/shop/review" class="dropdown-item">Đánh giá</nuxt-link>
              <nuxt-link to="/dashboard/shop/event" class="dropdown-item">Sự kiện</nuxt-link>
              <nuxt-link to="/dashboard/shop/bill" class="dropdown-item">Đơn hàng</nuxt-link>
            </b-card-body>
          </b-card>
        </b-collapse>

        <b-button v-b-toggle.logger block variant="primary" class="text-left my-2">
          Ghi vết
        </b-button>
        <b-collapse id="logger" class="my-2">
          <b-card no-body>
            <b-card-body class="py-2 px-0">
              <nuxt-link to="/dashboard/logger/service" class="dropdown-item">Dịch vụ</nuxt-link>
            </b-card-body>
          </b-card>
        </b-collapse>
      </template>
    </b-sidebar>
  </b-navbar>
</template>

<script lang="ts">
  import { Component, Prop, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'component-dashboard-navbar',
  })
  export default class extends Vue {
    @Prop({ type: Boolean, required: true })
    private largeDevice!: boolean;

    @Prop({ type: Boolean, required: true })
    private visible!: boolean;

    @Prop({ type: String, required: true })
    private width!: string;

    private pending: boolean = false;

    public async logout() {
      this.pending = true;
      await this.$auth.logout();
      window.localStorage.removeItem('token');
      this.pending = false;
    }
  }
</script>
