<template>
  <section>
    <b-navbar toggleable="lg" type="dark" variant="primary" sticky>
      <b-navbar-brand to="/" tag="h1" class="mb-0">CTU PC SHOP</b-navbar-brand>

      <b-button v-b-toggle.sidebar variant="light" class="d-lg-none">
        <fa :icon="['fas', 'bars']"></fa>
      </b-button>

      <b-collapse is-nav>
        <b-navbar-nav>
          <b-nav-item>Trang chủ</b-nav-item>
          <b-nav-item-dropdown text="Danh mục sản phẩm" no-caret menu-class="accordion p-0 border-0" role="tablist">
            <b-card v-for="(categoryGroup, index) in categoryGroups" :key="categoryGroup.id" no-body style="min-width: 200px;">
              <b-card-header header-tag="header" class="p-1" role="tab">
                <b-button v-b-toggle="`category-group-${categoryGroup.id}`" block variant="primary" class="text-left">
                  {{ categoryGroup.name }}
                </b-button>
              </b-card-header>

              <b-collapse :id="`category-group-${categoryGroup.id}`" accordion="category-group-accordion" role="tabpanel">
                <b-card-body class="px-1 py-0">
                  <b-dropdown-item-button v-for="category in categories[index]" :key="category.id" class="my-1">
                    {{ category.name }}
                  </b-dropdown-item-button>
                </b-card-body>
              </b-collapse>
            </b-card>
          </b-nav-item-dropdown>
          <b-nav-item>Tin tức - Sự kiện</b-nav-item>
          <b-nav-item>Chính sách - Hướng dẫn</b-nav-item>
        </b-navbar-nav>
      </b-collapse>
    </b-navbar>

    <b-sidebar id="sidebar" shadow backdrop no-header sticky>
      <template v-slot:default="{ hide }">
        <b-navbar>
          <b-navbar-brand to="/" tag="h1" class="mb-0">CTU PC SHOP</b-navbar-brand>

          <b-button variant="danger" @click="hide" class="ml-auto">
            <fa :icon="['fas', 'times']"></fa>
          </b-button>
        </b-navbar>

        <div class="px-3">
          <b-button block variant="primary" class="text-left my-2">
            Trang chủ
          </b-button>

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
                <b-card-body class="px-1 py-0">
                  <b-button v-for="category in categories[index]" :key="category.id" block class="text-dark text-left border-0 rounded-0 my-1" variant="outline-light">
                    {{ category.name }}
                  </b-button>
                </b-card-body>
              </b-collapse>
            </b-card>
          </b-collapse>

          <b-button block variant="primary" class="text-left my-2">
            Tin tức - Sự kiện
          </b-button>
          <b-button block variant="primary" class="text-left my-2">
            Chính sách - Hướng dẫn
          </b-button>
        </div>
      </template>
    </b-sidebar>
  </section>
</template>

<script lang="ts">
  import { Component, Prop, Vue } from 'nuxt-property-decorator';

  @Component
  export default class AppNavbar extends Vue {
    @Prop(Array) categoryGroups!: App.Models.CategoryGroup[];
    @Prop(Array) categories!: App.Models.Category[][];
  }
</script>

<style lang="scss" scoped></style>
