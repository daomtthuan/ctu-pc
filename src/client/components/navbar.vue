<template>
  <section>
    <b-navbar toggleable="md" type="dark" variant="primary">
      <b-navbar-brand to="/">CTU PC SHOP</b-navbar-brand>

      <b-button v-b-toggle.sidebar variant="light" class="d-md-none">
        <fa :icon="['fas', 'bars']"></fa>
      </b-button>

      <b-collapse id="nav-collapse" is-nav>
        <b-navbar-nav>
          <b-nav-item>Trang chủ</b-nav-item>
          <b-nav-item-dropdown text="Danh mục sản phẩm">
            <b-dropdown-group v-for="(categoryGroup, index) in categoryGroups" :key="categoryGroup.id" :header="categoryGroup.name" v-b-toggle="'my-collapse'">
              <b-dropdown-item-button v-for="category in categories[index]" :key="category.id">
                {{ category.name }}
              </b-dropdown-item-button>
              <b-dropdown-divider v-if="index < categoryGroups.length - 1"></b-dropdown-divider>
            </b-dropdown-group>
          </b-nav-item-dropdown>
          <b-nav-item>Tin tức - Sự kiện</b-nav-item>
          <b-nav-item>Chính sách - Hướng dẫn</b-nav-item>
        </b-navbar-nav>

        <!-- Right aligned nav items -->
        <b-navbar-nav class="ml-auto">
          <b-nav-form>
            <b-form-input size="sm" class="mr-sm-2" placeholder="Search"></b-form-input>
            <b-button size="sm" class="my-2 my-sm-0" type="submit">Search</b-button>
          </b-nav-form>

          <b-nav-item-dropdown text="Lang" right>
            <b-dropdown-item href="#">EN</b-dropdown-item>
            <b-dropdown-item href="#">ES</b-dropdown-item>
            <b-dropdown-item href="#">RU</b-dropdown-item>
            <b-dropdown-item href="#">FA</b-dropdown-item>
          </b-nav-item-dropdown>

          <b-nav-item-dropdown right>
            <!-- Using 'button-content' slot -->
            <template v-slot:button-content>
              <em>User</em>
            </template>
            <b-dropdown-item href="#">Profile</b-dropdown-item>
            <b-dropdown-item href="#">Sign Out</b-dropdown-item>
          </b-nav-item-dropdown>
        </b-navbar-nav>
      </b-collapse>
    </b-navbar>

    <b-sidebar id="sidebar" tag="nav" shadow backdrop>
      <template slot="title">
        <b-navbar-brand to="/">CTU PC SHOP</b-navbar-brand>
      </template>
      <template slot="header-close">
        <b-button variant="danger">
          <fa :icon="['fas', 'times']"></fa>
        </b-button>
      </template>
      <div class="px-3 py-2">
        <p>
          Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.
        </p>
        <b-img src="https://picsum.photos/500/500/?image=54" fluid thumbnail></b-img>
      </div>
    </b-sidebar>
  </section>
</template>

<script lang="ts">
  import { Component, Prop, Vue } from 'nuxt-property-decorator';

  @Component
  export default class AppNavbar extends Vue {
    @Prop(Object) categoryGroups!: App.Models.CategoryGroup[];
    @Prop(Object) categories!: App.Models.Category[][];
  }
</script>

<style lang="scss" scoped></style>
