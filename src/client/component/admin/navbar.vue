<template>
  <b-navbar type="light" variant="light" class="fixed-top shadow">
    <b-navbar-brand to="/" class="font-weight-bold text-primary d-flex align-items-center h-100 margin-logo py-0">
      <c-logo class="mr-3"></c-logo>
      <div>CTU PC SHOP</div>
    </b-navbar-brand>

    <b-navbar-nav class="flex-grow-1 d-none d-sm-flex mr-2">
      <b-form action="/admin/search" class="w-100">
        <b-input-group size="sm">
          <b-form-input name="keyword" placeholder="Tìm kiếm" type="search"></b-form-input>
          <b-input-group-append>
            <b-button type="submit" variant="primary" class="ml-1">
              <fa :icon="['fas', 'search']"></fa>
            </b-button>
          </b-input-group-append>
        </b-input-group>
      </b-form>
    </b-navbar-nav>

    <b-navbar-nav class="ml-auto">
      <b-dropdown variant="primary" size="sm" right no-caret>
        <template #button-content>
          <span class="d-none d-sm-inline">
            Tài khoản
          </span>
          <span class="d-sm-none">
            <fa :icon="['fas', 'user']"></fa>
          </span>
        </template>
        <b-dropdown-item>Thông tin tài khoản</b-dropdown-item>
        <b-dropdown-divider></b-dropdown-divider>
        <b-dropdown-item @click="logout">Đăng xuất</b-dropdown-item>
      </b-dropdown>
      <b-button v-b-toggle.sidebar variant="primary" size="sm" class="d-lg-none ml-2">
        <fa :icon="['fas', 'bars']"></fa>
      </b-button>
    </b-navbar-nav>

    <b-sidebar id="sidebar" :shadow="!largeDevice" :backdrop="!largeDevice" no-header :visible="visible">
      <template #default="{ hide }">
        <b-navbar type="light" variant="light" class="fixed-top">
          <b-navbar-brand to="/" class="py-0 font-weight-bold text-primary d-flex align-items-center h-100 margin-logo">
            <c-logo class="mr-3"></c-logo>
            <div>CTU PC SHOP</div>
          </b-navbar-brand>
          <b-navbar-nav class="ml-auto" v-if="!largeDevice">
            <b-button variant="danger" @click="hide" size="sm">
              <fa :icon="['fas', 'times']"></fa>
            </b-button>
          </b-navbar-nav>
        </b-navbar>

        <div class="pt-2">
          <div class="px-3 mt-5">
            <b-form action="/admin/search" class="d-sm-none">
              <b-input-group size="sm">
                <b-form-input name="keyword" placeholder="Tìm kiếm" type="search"></b-form-input>
                <b-input-group-append>
                  <b-button type="submit" variant="primary" class="ml-1">
                    <fa :icon="['fas', 'search']"></fa>
                  </b-button>
                </b-input-group-append>
              </b-input-group>
            </b-form>

            <b-button v-b-toggle.account-management block variant="primary" class="text-left my-2">
              Tài khoản
            </b-button>
            <b-collapse id="account-management" class="my-2">
              <b-card no-body>
                <b-card-body class="py-2 px-0">
                  <nuxt-link to="/admin/management/account/user" class="dropdown-item">Người dùng</nuxt-link>
                  <nuxt-link to="/admin/management/account/role" class="dropdown-item">Quyền truy cập</nuxt-link>
                  <nuxt-link to="/admin/management/account/permission" class="dropdown-item">Phân quyền</nuxt-link>
                </b-card-body>
              </b-card>
            </b-collapse>

            <b-button v-b-toggle.product-management block variant="primary" class="text-left my-2">
              Sản phẩm
            </b-button>
            <b-collapse id="product-management" class="my-2">
              <b-card no-body>
                <b-card-body class="py-2 px-0">
                  <nuxt-link to="/admin/management/product/brand" class="dropdown-item">Thương hiệu</nuxt-link>
                  <nuxt-link to="/admin/management/product/category-group" class="dropdown-item">Nhóm danh mục</nuxt-link>
                  <nuxt-link to="/admin/management/product/category" class="dropdown-item">Danh mục</nuxt-link>
                  <nuxt-link to="/admin/management/product/product" class="dropdown-item">Sản phẩm</nuxt-link>
                  <nuxt-link to="/admin/management/product/review" class="dropdown-item">Đánh giá</nuxt-link>
                </b-card-body>
              </b-card>
            </b-collapse>
          </div>
        </div>
      </template>
    </b-sidebar>
  </b-navbar>
</template>

<script lang="ts">
  import { Component, Prop, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'component-admin-navbar',
  })
  export default class extends Vue {
    @Prop(Boolean)
    private largeDevice!: boolean;

    @Prop(Boolean)
    private visible!: boolean;

    public async logout() {
      await this.$auth.logout();
      localStorage.removeItem('token');
    }
  }
</script>
