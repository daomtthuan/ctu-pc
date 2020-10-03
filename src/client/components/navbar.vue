<template>
  <section>
    <b-navbar toggleable="md" type="dark" variant="primary">
      <b-navbar-brand to="/">CTU PC SHOP</b-navbar-brand>

      <b-button v-b-toggle.sidebar variant="light" class="d-md-none">
        <fa :icon="['fas', 'bars']"></fa>
      </b-button>

      <b-collapse id="nav-collapse" is-nav>
        <b-navbar-nav>
          <div v-for="(value, key, index) in navigation" :key="index">
            <b-nav-item-dropdown :text="value.title" v-if="value.subNavigation">
              <b-dropdown-group v-for="(subValue, subKey, subIndex) in value.subNavigation" :key="subIndex" :header="subValue.title">
                <b-dropdown-item-button v-for="(subSubValue, subSubKey, subSubIndex) in subValue.subNavigation" :key="subSubIndex">
                  {{ subSubValue }}
                </b-dropdown-item-button>
              </b-dropdown-group>
            </b-nav-item-dropdown>
            <b-nav-item v-else>
              {{ value.title }}
            </b-nav-item>
          </div>
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
    @Prop(Object) navigation!: App.Pages.Index.Navigation;
  }
</script>

<style lang="scss" scoped></style>
