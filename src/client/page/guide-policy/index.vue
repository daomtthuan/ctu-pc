<template>
  <main>
    <c-navbar></c-navbar>
    <section class="container mt-5 pt-3">
      <b-row>
        <b-col lg="6" offset-lg="3">
          <b-card border-variant="primary" class="shadow-sm">
            <b-card-body>
              <b-card-title title-tag="h2" class="text-primary">
                Hướng dẫn - Chính sách
              </b-card-title>
              <hr />
              <ul>
                <li>
                  <nuxt-link to="/guide-policy/payment">Hướng dẫn thanh toán</nuxt-link>
                </li>
                <li>
                  <nuxt-link to="/guide-policy/installment">Hướng dẫn trả góp</nuxt-link>
                </li>
                <li>
                  <nuxt-link to="/guide-policy/shipping">Chính sách vận chuyển</nuxt-link>
                </li>
                <li>
                  <nuxt-link to="/guide-policy/warranty">Chính sách bảo hành</nuxt-link>
                </li>
              </ul>
            </b-card-body>
          </b-card>
        </b-col>
      </b-row>
    </section>
  </main>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'page-guide-policy',
  })
  export default class extends Vue {}
</script>

<style lang="scss" scoped></style>
