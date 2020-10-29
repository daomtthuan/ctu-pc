import { NuxtConfig } from '@nuxt/types';
import Dotenv from 'dotenv';
import FileSystem from 'fs';

interface ComponentsDirectoryConfig {
  path: string;
  prefix: string;
}

Dotenv.config();

let config: NuxtConfig = {
  server: { port: 3000 },
  dir: {
    assets: 'asset',
    layouts: 'layout',
    pages: 'page',
  },
  components: [{ path: '@/component', prefix: 'c' }],
  head: {
    meta: [
      { charset: 'utf-8' },
      { httpEquiv: 'X-UA-Compatible', content: 'IE=edge' },
      { name: 'viewport', content: process.env.VIEWPORT ?? '' },
      { name: 'author', content: 'Daomtthuan' },
      { name: 'robots', content: 'index, follow, archive' },
      { hid: 'description', name: 'description', content: process.env.DESCRIPTION ?? '' },
      { property: 'st:section', content: process.env.DESCRIPTION ?? '' },
      { name: 'twitter:title', content: process.env.NAME ?? '' },
      { name: 'twitter:description', content: process.env.DESCRIPTION ?? '' },
      { name: 'og:locale', content: 'ja_JP' },
      { name: 'twitter:image', content: `${process.env.BASE}/icon.png` },
      { name: 'og:image:width', content: '544' },
      { name: 'og:image:height', content: '362' },
      { name: 'og:image:secure_url', content: `${process.env.BASE}/icon.png` },
    ],
    title: process.env.NAME,
    titleTemplate: `${process.env.NAME} - %s`,
    noscript: [{ innerHTML: 'This website requires JavaScript.' }],
  },
  loading: { color: ' #3b84c0', failedColor: '#be5046', height: '3px' },
  loadingIndicator: {
    name: 'circle',
    color: '#3B8070',
    background: 'white',
  },
  modules: ['@nuxtjs/pwa', 'bootstrap-vue/nuxt', 'nuxt-fontawesome', '@nuxtjs/axios', '@nuxtjs/auth'],
  pwa: {
    meta: {
      viewport: process.env.VIEWPORT,
      name: process.env.NAME,
      author: process.env.AUTHOR,
      description: process.env.DESCRIPTION,
      theme_color: process.env.COLOR,
      lang: process.env.LANGUAGE,
      ogHost: process.env.BASE,
      ogImage: `${process.env.BASE}/icon.png`,
      twitterCard: 'summary_large_image',
      nativeUI: true,
    },
    manifest: {
      name: process.env.NAME,
      description: process.env.DESCRIPTION,
      lang: process.env.LANGUAGE,
      background_color: process.env.COLOR,
      theme_color: process.env.COLOR,
    },
  },
  bootstrapVue: { bootstrapCSS: false, bootstrapVueCSS: false },
  fontawesome: {
    component: 'fa',
    imports: [{ set: '@fortawesome/free-solid-svg-icons', icons: ['fas'] }],
  },
  proxy: { '/api': process.env.SERVER },
  axios: { prefix: '/api', proxy: true },
  auth: {
    fullPathRedirect: true,
    localStorage: false,
    strategies: {
      local: {
        endpoints: {
          user: { url: '/authentication/local', method: 'get', propertyName: 'user' },
          login: { url: '/authentication/local', method: 'post', propertyName: 'token' },
          logout: { url: '/authentication/local', method: 'delete' },
        },
        tokenType: '',
      },
    },
    plugins: [],
  },
  watch: ['@/.env', '@types'],
  target: 'static',
  router: {
    base: process.env.ROUTER,
  },
  buildModules: ['@nuxt/typescript-build', '@nuxtjs/dotenv'],
  build: {
    babel: { presets: () => [['@nuxt/babel-preset-app', { loose: true }]], compact: true },
    loaders: { scss: { additionalData: `$base: '${process.env.BASE}';` } },
  },
};

function addComponentsDirectoryConfig(parentPath: string, parentPrefix: string) {
  for (let childPath of FileSystem.readdirSync(parentPath)) {
    let path = parentPath + '/' + childPath;
    if (FileSystem.lstatSync(path).isDirectory()) {
      let prefix = `${parentPrefix}-${childPath}`;
      (<ComponentsDirectoryConfig[]>config.components).push({
        path: `@/${path}`,
        prefix: prefix,
      });
      addComponentsDirectoryConfig(path, prefix);
    }
  }
}

addComponentsDirectoryConfig('component', 'c');

export default config;
