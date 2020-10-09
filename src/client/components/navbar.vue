<template>
  <section>
    <b-navbar type="dark" variant="primary" class="fixed-top">
      <b-navbar-brand to="/" class="py-0 font-weight-bold">CTU PC SHOP</b-navbar-brand>

      <b-navbar-nav class="d-none d-lg-flex">
        <b-nav-item-dropdown text="Danh mục sản phẩm" no-caret menu-class="accordion p-0 border-0" role="tablist">
          <b-card v-for="(categoryGroup, index) in categoryGroups" :key="categoryGroup.id" no-body class="dropdown-width">
            <b-card-header header-tag="header" class="p-1" role="tab">
              <b-button v-b-toggle="`category-group-${categoryGroup.id}`" block variant="light" class="text-left">
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
        <b-nav-item>Tin tức - Sự kiện</b-nav-item>
        <b-nav-item-dropdown text="Chính sách - Hướng dẫn" no-caret>
          <b-dropdown-item to="/guidelines-policies/payment-guide">Hướng dẫn thanh toán</b-dropdown-item>
          <b-dropdown-item to="/guidelines-policies/installment-guide">Hướng dẫn trả góp</b-dropdown-item>
          <b-dropdown-item to="/guidelines-policies/shipping-policy">Chính sách vận chuyển</b-dropdown-item>
          <b-dropdown-item to="/guidelines-policies/warranty-policy">Chính sách bảo hành</b-dropdown-item>
        </b-nav-item-dropdown>
      </b-navbar-nav>

      <b-navbar-nav class="ml-3 flex-grow-1 d-none d-sm-flex">
        <b-form action="/search" class="w-100">
          <b-input-group size="sm">
            <b-form-input name="keyword" placeholder="Tìm kiếm" type="search" class="border-light"></b-form-input>
            <b-input-group-append>
              <b-button type="submit" variant="light" class="text-primary border-light ml-1">
                <fa :icon="['fas', 'search']"></fa>
              </b-button>
            </b-input-group-append>
          </b-input-group>
        </b-form>
      </b-navbar-nav>

      <b-navbar-nav class="ml-auto ml-sm-3">
        <b-button v-b-toggle.sidebar variant="light" class="d-lg-none" size="sm">
          <fa :icon="['fas', 'bars']"></fa>
        </b-button>
      </b-navbar-nav>
    </b-navbar>

    <b-sidebar id="sidebar" shadow backdrop no-header>
      <template v-slot:default="{ hide }">
        <b-navbar type="primary" variant="light" class="fixed-top">
          <b-navbar-brand to="/" class="py-0 font-weight-bold">CTU PC SHOP</b-navbar-brand>

          <b-button variant="danger" @click="hide" class="ml-auto" size="sm">
            <fa :icon="['fas', 'times']"></fa>
          </b-button>
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
              Tin tức - Sự kiện
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
  import { Component, Prop, Vue } from 'nuxt-property-decorator';

  @Component
  export default class Navbar extends Vue {
    @Prop(Array) categoryGroups!: App.Models.CategoryGroup[];
    @Prop(Array) categories!: App.Models.Category[][];
  }
</script>

<style lang="scss" scoped>
  .dropdown-width {
    min-width: 250px;
  }
</style>
