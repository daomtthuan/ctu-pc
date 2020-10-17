<template>
  <section>
    <b-navbar type="light" variant="light" class="fixed-top shadow">
      <b-navbar-brand to="/" class="py-0 font-weight-bold text-primary d-flex align-items-center h-100 margin-logo">
        <b-img :src="$icon(30)" class="mr-2"></b-img>
        <div>CTU PC SHOP</div>
      </b-navbar-brand>

      <b-navbar-nav class="d-none d-lg-flex mr-2">
        <b-nav-item-dropdown text="Danh mục sản phẩm" no-caret menu-class="accordion p-0 border-0" role="tablist">
          <b-card v-for="(categoryGroup, index) in categoryGroups" :key="categoryGroup.id" no-body class="dropdown-width">
            <b-card-header header-tag="header" class="p-1" role="tab">
              <b-button v-b-toggle="`category-group-${categoryGroup.id}`" block variant="primary" class="text-left">
                {{ categoryGroup.name }}
              </b-button>
            </b-card-header>

            <b-collapse :id="`category-group-${categoryGroup.id}`" accordion="category-group-accordion" role="tabpanel">
              <b-card-body class="py-2 px-0">
                <b-dropdown-item v-for="category in categories[index]" :key="category.id">
                  {{ category.name }}
                </b-dropdown-item>
              </b-card-body>
            </b-collapse>
          </b-card>
        </b-nav-item-dropdown>
        <b-nav-item>Sự kiện</b-nav-item>
        <b-nav-item-dropdown text="Chính sách - Hướng dẫn" no-caret>
          <b-dropdown-item to="/guidelines-policies/payment-guide">Hướng dẫn thanh toán</b-dropdown-item>
          <b-dropdown-item to="/guidelines-policies/installment-guide">Hướng dẫn trả góp</b-dropdown-item>
          <b-dropdown-item to="/guidelines-policies/shipping-policy">Chính sách vận chuyển</b-dropdown-item>
          <b-dropdown-item to="/guidelines-policies/warranty-policy">Chính sách bảo hành</b-dropdown-item>
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
          <template slot="placeholder">
            <b-button variant="primary" size="sm" class="mr-2" disabled>
              <b-spinner small></b-spinner>
            </b-button>
          </template>

          <b-dropdown text="Tài khoản" class="mr-2" v-if="$auth.loggedIn" variant="primary" size="sm" right no-caret>
            <b-dropdown-item>Thông tin tài khoản</b-dropdown-item>
            <b-dropdown-item>Giỏ hàng</b-dropdown-item>
            <div v-if="$auth.hasScope('admin')">
              <b-dropdown-divider></b-dropdown-divider>
              <b-dropdown-item to="/admin">Quản trị</b-dropdown-item>
            </div>
            <b-dropdown-divider></b-dropdown-divider>
            <b-dropdown-item @click="logout">Đăng xuất</b-dropdown-item>
          </b-dropdown>
          <b-button variant="primary" size="sm" class="mr-2 mr-lg-0" v-else to="/login">
            Đăng nhập
          </b-button>
        </client-only>

        <b-button v-b-toggle.sidebar variant="primary" size="sm" class="d-lg-none">
          <fa :icon="['fas', 'bars']"></fa>
        </b-button>
      </b-navbar-nav>
    </b-navbar>

    <b-sidebar id="sidebar" shadow backdrop no-header>
      <template v-slot:default="{ hide }">
        <b-navbar type="light" variant="light" class="fixed-top">
          <b-navbar-brand to="/" class="py-0 font-weight-bold text-primary d-flex align-items-center h-100 margin-logo">
            <b-img :src="$icon(30)" class="mr-2"></b-img>
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
            <b-button v-b-toggle.category-group block variant="primary" class="text-left my-2">
              Danh mục sản phẩm
            </b-button>
            <b-collapse id="category-group" class="accordion my-2">
              <b-card v-for="(categoryGroup, index) in categoryGroups" :key="categoryGroup.id" no-body>
                <b-card-header header-tag="header" class="p-1" role="tab">
                  <b-button v-b-toggle="`category-group-${categoryGroup.id}`" block variant="light" class="text-left">
                    {{ categoryGroup.name }}
                  </b-button>
                </b-card-header>

                <b-collapse :id="`category-group-${categoryGroup.id}`" accordion="category-group-accordion" role="tabpanel">
                  <b-card-body class="py-2 px-0">
                    <b-link v-for="category in categories[index]" :key="category.id" class="dropdown-item">
                      {{ category.name }}
                    </b-link>
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
                  <b-link to="/guidelines-policies/payment-guide" class="dropdown-item">Hướng dẫn thanh toán</b-link>
                  <b-link to="/guidelines-policies/installment-guide" class="dropdown-item">Hướng dẫn trả góp</b-link>
                  <b-link to="/guidelines-policies/shipping-policy" class="dropdown-item">Chính sách vận chuyển</b-link>
                  <b-link to="/guidelines-policies/warranty-policy" class="dropdown-item">Chính sách bảo hành</b-link>
                </b-card-body>
              </b-card>
            </b-collapse>
          </div>
        </div>
      </template>
    </b-sidebar>
  </section>
</template>

<script lang="ts">
  import { Context } from '@nuxt/types';
  import { Component, Prop, Vue } from 'nuxt-property-decorator';

  @Component
  export default class Navbar extends Vue {
    private categoryGroups: App.Models.CategoryGroup[] = [];
    private categories: App.Models.Category[][] = [];

    public async fetch() {
      try {
        this.categoryGroups = (await this.$axios.get('/user/category-group')).data;
        this.categories = [];

        for (const categoryGroup of this.categoryGroups) {
          let categories: App.Models.Category[] = (await this.$axios.get('/user/category', { params: { idCategoryGroup: categoryGroup.id } })).data;
          this.categories.push(categories);
        }
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

<style lang="scss" scoped>
  .margin-logo {
    margin-bottom: 0.2rem;
  }
  .dropdown-width {
    min-width: 250px;
  }
</style>
