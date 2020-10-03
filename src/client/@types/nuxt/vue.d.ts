declare module '*.vue' {
  import '@types/node';
  import '@nuxt/types';
  import '@nuxtjs/axios';
  import 'vue-class-component/hooks';

  import Vue from 'vue';
  export default Vue;
}
