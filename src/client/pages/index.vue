<template>
  <main>
    <c-navbar :categoryGroups="categoryGroups" :categories="categories"></c-navbar>
    <div class="pt-2">
      <nuxt-child class="container mt-5"></nuxt-child>
    </div>
  </main>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';
  import { Context } from '@nuxt/types';

  @Component
  export default class Index extends Vue {
    public async asyncData(context: Context) {
      try {
        let data: {
          categoryGroups: App.Models.CategoryGroup[];
          categories: App.Models.Category[][];
        } = {
          categoryGroups: (await context.$axios.get(`${context.env['SERVER']}/data/category-group`)).data,
          categories: [],
        };

        for (const categoryGroup of data.categoryGroups) {
          let categories: App.Models.Category[] = (await context.$axios.get(`${context.env['SERVER']}/data/category`, { params: { idCategoryGroup: categoryGroup.id } })).data;
          data.categories.push(categories);
        }

        return data;
      } catch (error) {
        let response = <Response>error.response;
        context.error({ statusCode: response ? response.status : 500 });
      }
    }
  }
</script>
