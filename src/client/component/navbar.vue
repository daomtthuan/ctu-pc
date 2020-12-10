<template>
  <b-navbar type="light" variant="light" class="c-navbar fixed-top border-bottom border-primary">
    <b-navbar-brand to="/" class="font-weight-bold text-primary d-flex align-items-center h-100 margin-logo py-0">
      <c-logo class="mr-3"></c-logo>
      <div>CTU PC SHOP</div>
    </b-navbar-brand>

    <b-navbar-nav class="d-none d-lg-flex mr-2">
      <b-nav-item-dropdown text="Sản phẩm" no-caret menu-class="accordion p-0 border-0" role="tablist">
        <div class="text-center py-3 border" v-if="$fetchState.pending"><b-spinner small></b-spinner> Đang tải...</div>
        <div v-else-if="!$fetchState.error">
          <div class="text-center py-3 border" v-if="categoryGroups.length == 0" :style="{ width: '200px' }">Không có sản phẩm nào</div>
          <b-card v-for="categoryGroup in categoryGroups" :key="categoryGroup.id" no-body class="dropdown-width" v-else>
            <b-card-header header-tag="header" class="p-1" role="tab">
              <b-button v-b-toggle="`category-group-${categoryGroup.id}`" block variant="primary" class="text-left">
                {{ categoryGroup.name }}
              </b-button>
            </b-card-header>

            <b-collapse :id="`category-group-${categoryGroup.id}`" accordion="category-group-accordion" role="tabpanel">
              <b-card-body class="py-2 px-0">
                <b-dropdown-text v-if="categories[categoryGroup.id].length == 0">Không có sản phẩm nào </b-dropdown-text>
                <div v-else>
                  <b-dropdown-item v-for="category in categories[categoryGroup.id]" :key="category.id" :to="`/product/category/${category.id}/page/1`">
                    {{ category.name }}
                  </b-dropdown-item>
                </div>
              </b-card-body>
            </b-collapse>
          </b-card>
        </div>
      </b-nav-item-dropdown>
      <b-nav-item to="/event/page/1">Sự kiện</b-nav-item>
      <b-nav-item-dropdown text="Chính sách - Hướng dẫn" no-caret>
        <b-dropdown-item to="/guide-policy/payment">Hướng dẫn thanh toán</b-dropdown-item>
        <b-dropdown-item to="/guide-policy/installment">Hướng dẫn trả góp</b-dropdown-item>
        <b-dropdown-item to="/guide-policy/shipping">Chính sách vận chuyển</b-dropdown-item>
        <b-dropdown-item to="/guide-policy/warranty">Chính sách bảo hành</b-dropdown-item>
      </b-nav-item-dropdown>
    </b-navbar-nav>

    <b-navbar-nav class="flex-grow-1 d-none d-md-flex mr-2">
      <b-form action="/search" class="w-100">
        <b-input-group>
          <b-form-input placeholder="Tìm kiếm sản phẩm" type="search"></b-form-input>
          <b-input-group-append>
            <b-button type="submit" variant="primary" class="ml-1">
              <fa :icon="['fas', 'search']"></fa>
            </b-button>
          </b-input-group-append>
        </b-input-group>
      </b-form>
    </b-navbar-nav>

    <b-navbar-nav class="ml-auto">
      <client-only>
        <b-dropdown variant="primary" right no-caret v-if="$auth.loggedIn" :disabled="pending">
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
          <b-dropdown-header>Tài khoản</b-dropdown-header>
          <b-dropdown-item to="/account">Thông tin cá nhân</b-dropdown-item>
          <b-dropdown-item to="/account/change-password">Đổi mật khẩu</b-dropdown-item>
          <b-dropdown-item to="/account/cart">Giỏ hàng</b-dropdown-item>
          <b-dropdown-item to="/account/bill/status/pending">Đơn hàng</b-dropdown-item>
          <div v-if="$auth.hasScope('Admin')">
            <b-dropdown-divider></b-dropdown-divider>
            <b-dropdown-header>Dành cho quản trị</b-dropdown-header>
            <b-dropdown-item to="/dashboard">Bảng điều khiển</b-dropdown-item>
          </div>
          <b-dropdown-divider></b-dropdown-divider>
          <b-dropdown-header>Hỗ trợ</b-dropdown-header>
          <b-dropdown-item href="https://mail.google.com/mail/?view=cm&fs=1&to=daomtthuan.clone@gmail.com&su=Ý kiến phản hồi" target="_blank">
            Ý kiến phản hồi
          </b-dropdown-item>
          <b-dropdown-divider></b-dropdown-divider>
          <b-dropdown-item @click="logout">Đăng xuất</b-dropdown-item>
        </b-dropdown>
        <b-button variant="primary" to="/login" v-else>
          <span class="d-none d-sm-inline">
            Đăng nhập
          </span>
          <span class="d-sm-none">
            <fa :icon="['fas', 'sign-in-alt']"></fa>
          </span>
        </b-button>

        <template #placeholder>
          <b-button variant="primary" class="mr-2" disabled> <b-spinner small></b-spinner> Xác thực...</b-button>
        </template>
      </client-only>

      <b-button v-b-toggle.sidebar variant="primary" class="d-lg-none ml-2">
        <fa :icon="['fas', 'bars']"></fa>
      </b-button>
    </b-navbar-nav>

    <b-sidebar id="sidebar" sidebar-class="border-right border-primary" body-class="p-3" shadow backdrop>
      <template #title="{ hide }">
        <b-navbar type="light" variant="light" class="fixed-top">
          <b-navbar-brand to="/" class="pb-0 font-weight-bold text-primary d-flex align-items-center h-100 margin-logo">
            <c-logo class="mr-3"></c-logo>
            <div>CTU PC SHOP</div>
          </b-navbar-brand>
          <b-navbar-nav class="ml-auto">
            <b-button variant="outline-danger" class="border-0" @click="hide">
              <fa :icon="['fas', 'times']"></fa>
            </b-button>
          </b-navbar-nav>
        </b-navbar>
      </template>
      <template #default>
        <b-form action="/search" class="d-md-none">
          <b-input-group>
            <b-form-input placeholder="Tìm kiếm sản phẩm" type="search"></b-form-input>
            <b-input-group-append>
              <b-button type="submit" variant="primary" class="ml-1">
                <fa :icon="['fas', 'search']"></fa>
              </b-button>
            </b-input-group-append>
          </b-input-group>
        </b-form>
        <b-button v-b-toggle.category-group block variant="primary" class="text-left my-2">
          Sản phẩm
        </b-button>
        <b-collapse id="category-group" class="accordion my-2">
          <div class="text-center py-3 border bg-white" v-if="$fetchState.pending"><b-spinner small></b-spinner> Đang tải...</div>

          <b-card v-for="categoryGroup in categoryGroups" :key="categoryGroup.id" no-body v-else-if="!$fetchState.error">
            <b-card-header header-tag="header" class="p-1" role="tab">
              <b-button v-b-toggle="`category-group-${categoryGroup.id}`" block variant="light" class="text-left">
                {{ categoryGroup.name }}
              </b-button>
            </b-card-header>
            <b-collapse :id="`category-group-${categoryGroup.id}`" accordion="category-group-accordion" role="tabpanel">
              <b-card-body class="py-2 px-0">
                <nuxt-link
                  v-for="category in categories[categoryGroup.id]"
                  :key="category.id"
                  class="dropdown-item"
                  :to="`/product/category/${category.id}/page/1`"
                >
                  {{ category.name }}
                </nuxt-link>
              </b-card-body>
            </b-collapse>
          </b-card>
        </b-collapse>

        <b-button block variant="primary" class="text-left my-2" to="/event/page/1">
          Sự kiện
        </b-button>

        <b-button v-b-toggle.guidelines-policies block variant="primary" class="text-left my-2">
          Chính sách - Hướng dẫn
        </b-button>
        <b-collapse id="guidelines-policies" class="my-2">
          <b-card no-body>
            <b-card-body class="py-2 px-0">
              <nuxt-link to="/guide-policy/payment" class="dropdown-item">Hướng dẫn thanh toán</nuxt-link>
              <nuxt-link to="/guide-policy/installment" class="dropdown-item">Hướng dẫn trả góp</nuxt-link>
              <nuxt-link to="/guide-policy/shipping" class="dropdown-item">Chính sách vận chuyển</nuxt-link>
              <nuxt-link to="/guide-policy/warranty" class="dropdown-item">Chính sách bảo hành</nuxt-link>
            </b-card-body>
          </b-card>
        </b-collapse>
      </template>
    </b-sidebar>
  </b-navbar>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';
  import { Context } from '@nuxt/types';
  import { getCart } from '@/plugin/cart';

  @Component({
    name: 'component-navbar',
  })
  export default class extends Vue {
    private pending: boolean = false;
    private categoryGroups: Entity.CategoryGroup[] = [];
    private categories: { [id: number]: Entity.Category[] } = {};

    public async fetch() {
      try {
        this.categoryGroups = (await this.$axios.get('/api/category-group')).data;
        this.categories = {};

        await Promise.all(
          this.categoryGroups.map(async (categoryGroup) => {
            this.categories[categoryGroup.id] = <Entity.Category[]>(
              (await this.$axios.get('/api/category', { params: { idCategoryGroup: categoryGroup.id } })).data
            );
          })
        );
      } catch (error) {
        this.$nuxt.error({ statusCode: (<Response>error.response).status });
      }
    }

    public async logout() {
      this.pending = true;
      await this.$auth.logout();
      window.localStorage.removeItem('token');
      this.pending = false;
    }
  }
</script>

<style lang="scss">
  .c-navbar {
    .margin-logo {
      margin-bottom: 0.2rem;
    }
    .dropdown-width {
      min-width: 250px;
    }
  }
</style>
