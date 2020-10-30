<template>
  <b-navbar type="light" variant="light" class="c-navbar fixed-top shadow">
    <b-navbar-brand to="/" class="font-weight-bold text-primary d-flex align-items-center h-100 margin-logo py-0">
      <c-logo class="mr-3"></c-logo>
      <div>CTU PC SHOP</div>
    </b-navbar-brand>

    <b-navbar-nav class="d-none d-lg-flex mr-2">
      <b-nav-item-dropdown text="Danh mục sản phẩm" no-caret menu-class="accordion p-0 border-0" role="tablist">
        <div class="text-center py-3 border" v-if="$fetchState.pending"><b-spinner small></b-spinner> Đang tải...</div>

        <b-card v-for="categoryGroup in categoryGroups" :key="categoryGroup.id" no-body class="dropdown-width" v-else-if="!$fetchState.error">
          <b-card-header header-tag="header" class="p-1" role="tab">
            <b-button v-b-toggle="`category-group-${categoryGroup.id}`" block variant="primary" class="text-left">
              {{ categoryGroup.name }}
            </b-button>
          </b-card-header>

          <b-collapse :id="`category-group-${categoryGroup.id}`" accordion="category-group-accordion" role="tabpanel">
            <b-card-body class="py-2 px-0">
              <b-dropdown-item v-for="category in categories[categoryGroup.id]" :key="category.id">
                {{ category.name }}
              </b-dropdown-item>
            </b-card-body>
          </b-collapse>
        </b-card>
      </b-nav-item-dropdown>
      <b-nav-item>Sự kiện</b-nav-item>
      <b-nav-item-dropdown text="Chính sách - Hướng dẫn" no-caret>
        <b-dropdown-item to="/guide-policy/payment">Hướng dẫn thanh toán</b-dropdown-item>
        <b-dropdown-item to="/guide-policy/installment">Hướng dẫn trả góp</b-dropdown-item>
        <b-dropdown-item to="/guide-policy/shipping">Chính sách vận chuyển</b-dropdown-item>
        <b-dropdown-item to="/guide-policy/warranty">Chính sách bảo hành</b-dropdown-item>
      </b-nav-item-dropdown>
    </b-navbar-nav>

    <b-navbar-nav class="flex-grow-1 d-none d-sm-flex mr-2">
      <b-form action="/search" class="w-100">
        <b-input-group size="sm">
          <b-form-input name="keyword" placeholder="Tìm kiếm sản phẩm" type="search"></b-form-input>
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
        <b-dropdown variant="primary" size="sm" right no-caret v-if="$auth.loggedIn">
          <template #button-content>
            <span class="d-none d-sm-inline">
              Tài khoản
            </span>
            <span class="d-sm-none">
              <fa :icon="['fas', 'user']"></fa>
            </span>
          </template>
          <b-dropdown-item>Thông tin tài khoản</b-dropdown-item>
          <b-dropdown-item>Giỏ hàng</b-dropdown-item>
          <div v-if="$auth.hasScope('admin')">
            <b-dropdown-divider></b-dropdown-divider>
            <b-dropdown-item to="/admin">Quản trị viên</b-dropdown-item>
          </div>
          <b-dropdown-divider></b-dropdown-divider>
          <b-dropdown-item @click="logout">Đăng xuất</b-dropdown-item>
        </b-dropdown>
        <b-button variant="primary" size="sm" to="/login" v-else>
          Đăng nhập
        </b-button>

        <template #placeholder>
          <b-button variant="primary" size="sm" class="mr-2" disabled> <b-spinner small></b-spinner> Xác thực...</b-button>
        </template>
      </client-only>

      <b-button v-b-toggle.sidebar variant="primary" size="sm" class="d-lg-none ml-2">
        <fa :icon="['fas', 'bars']"></fa>
      </b-button>
    </b-navbar-nav>

    <b-sidebar id="sidebar" shadow backdrop no-header>
      <template #default="{ hide }">
        <b-navbar type="light" variant="light" class="fixed-top">
          <b-navbar-brand to="/" class="py-0 font-weight-bold text-primary d-flex align-items-center h-100 margin-logo">
            <c-logo class="mr-3"></c-logo>
            <div>CTU PC SHOP</div>
          </b-navbar-brand>
          <b-navbar-nav class="ml-auto">
            <b-button variant="danger" @click="hide" size="sm">
              <fa :icon="['fas', 'times']"></fa>
            </b-button>
          </b-navbar-nav>
        </b-navbar>

        <div class="pt-2">
          <div class="px-3 mt-5">
            <b-form action="/search" class="d-sm-none">
              <b-input-group size="sm">
                <b-form-input name="keyword" placeholder="Tìm kiếm sản phẩm" type="search"></b-form-input>
                <b-input-group-append>
                  <b-button type="submit" variant="primary" class="ml-1">
                    <fa :icon="['fas', 'search']"></fa>
                  </b-button>
                </b-input-group-append>
              </b-input-group>
            </b-form>
            <b-button v-b-toggle.category-group block variant="primary" class="text-left my-2">
              Danh mục sản phẩm
            </b-button>
            <b-collapse id="category-group" class="accordion my-2">
              <div class="text-center py-3 border bg-white rounded" v-if="$fetchState.pending"><b-spinner small></b-spinner> Đang tải...</div>

              <b-card v-for="categoryGroup in categoryGroups" :key="categoryGroup.id" no-body v-else-if="!$fetchState.error">
                <b-card-header header-tag="header" class="p-1" role="tab">
                  <b-button v-b-toggle="`category-group-${categoryGroup.id}`" block variant="light" class="text-left">
                    {{ categoryGroup.name }}
                  </b-button>
                </b-card-header>
                <b-collapse :id="`category-group-${categoryGroup.id}`" accordion="category-group-accordion" role="tabpanel">
                  <b-card-body class="py-2 px-0">
                    <nuxt-link v-for="category in categories[categoryGroup.id]" :key="category.id" class="dropdown-item" to="/">
                      {{ category.name }}
                    </nuxt-link>
                  </b-card-body>
                </b-collapse>
              </b-card>
            </b-collapse>

            <b-button block variant="primary" class="text-left my-2">
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
          </div>
        </div>
      </template>
    </b-sidebar>
  </b-navbar>
</template>

<script lang="ts">
  import { Component, Prop, Vue } from 'nuxt-property-decorator';
  import { Context } from '@nuxt/types';

  @Component({
    name: 'component-navbar',
  })
  export default class extends Vue {
    private categoryGroups: Entity.CategoryGroup[] = [];
    private categories: { [id: number]: Entity.Category[] } = {};

    public async fetch() {
      try {
        this.categoryGroups = (await this.$axios.get('/user/category-group')).data;
        this.categories = {};

        await Promise.all(
          this.categoryGroups.map(async (categoryGroup) => {
            this.categories[categoryGroup.id] = <Entity.Category[]>(await this.$axios.get('/user/category', { params: { idCategoryGroup: categoryGroup.id } })).data;
          })
        );
      } catch (error) {
        this.$nuxt.error({ statusCode: (<Response>error.response).status });
      }
    }

    public async logout() {
      await this.$auth.logout();
      localStorage.removeItem('token');
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
