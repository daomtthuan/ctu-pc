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
        let navigation: App.Pages.Index.Navigation = {
          home: {
            title: 'Trang chủ',
          },
          categoryGroup: {
            title: 'Danh mục sản phẩm',
            subNavigation: {},
          },
          news: {
            title: 'Tin tức - Sự kiện',
          },
          policyGuide: {
            title: 'Chính sách - Hướng dẫn',
          },
        };

        let categoryGroups: App.Models.CategoryGroup[] = (await context.$axios.get(`${context.env['SERVER_BASE']}/api/category-group`)).data;

        for (let categoryGroup of categoryGroups) {
          if (navigation.categoryGroup.subNavigation) {
            navigation.categoryGroup.subNavigation[categoryGroup.id] = {
              title: categoryGroup.name,
              subNavigation: {},
            };

            let categories: App.Models.Category[] = (
              await context.$axios.get(`${context.env['SERVER_BASE']}/api/category`, {
                params: {
                  idCategoryGroup: categoryGroup.id,
                },
              })
            ).data;

            for (let category of categories) {
              if (navigation.categoryGroup.subNavigation) {
                if (navigation.categoryGroup.subNavigation[categoryGroup.id].subNavigation) {
                  navigation.categoryGroup.subNavigation[categoryGroup.id].subNavigation[category.id].title = category.name;
                }
              }
            }
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
