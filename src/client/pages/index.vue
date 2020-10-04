<template>
  <main>
    <app-navbar :navigation="navigation"></app-navbar>
  </main>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';
  import { Context } from '@nuxt/types';

  @Component
  export default class IndexPage extends Vue {
    public async asyncData(context: Context) {
      try {
        let navigation = [
          {
            title: 'Trang chủ',
          },
          {
            title: 'Danh mục sản phẩm',
            sub: {},
          },
          {
            title: 'Tin tức - Sự kiện',
          },
          {
            title: 'Chính sách - Hướng dẫn',
          },
        ];

        let categoryGroups: App.Models.CategoryGroup[] = (await context.$axios.get(`${context.env['SERVER_BASE']}/api/category-group`)).data;

        for (let categoryGroup of categoryGroups) {
          navigation[1].sub[categoryGroup.id] = {
            title: categoryGroup.name,
            sub: {},
          };

          let categories: App.Models.Category[] = (
            await context.$axios.get(`${context.env['SERVER_BASE']}/api/category`, {
              params: {
                idCategoryGroup: categoryGroup.id,
              },
            })
          ).data;

          for (let category of categories) {
            navigation[1].sub[categoryGroup.id.toString()].sub = {
              title: category.name,
            };
          }
        }

        return { navigation };
      } catch (error) {
        let response = <Response>error.response;
        context.error({ statusCode: response ? response.status : 500 });
      }
    }
  }
</script>

<style lang="scss" scoped></style>
