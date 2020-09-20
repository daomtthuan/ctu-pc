import Dotenv from 'dotenv';
import Path from 'path';

const pathEnv = Path.resolve(process.cwd(), '../');

Dotenv.config({ path: Path.resolve(pathEnv, './.env') });

export default {
  // Server
  server: {
    host: '127.0.0.1',
    port: 3000,
  },

  // Project
  components: true,
  head: {
    meta: [
      { charset: 'utf-8' },
      { 'http-equiv': 'X-UA-Compatible', content: 'IE=edge' },
      { name: 'viewport', content: process.env.CLIENT_VIEWPORT },
      { name: 'keywords', content: 'NEXUS RENTAL PARTNER, NEXUS, RENTAL PARTNER' },
      { name: 'author', content: 'Daomtthuan' },
      { name: 'robots', content: 'index, follow, archive' },
      { hid: 'description', name: 'description', content: process.env.CLIENT_DESCRIPTION },
      { property: 'st:section', content: process.env.CLIENT_DESCRIPTION },
      { name: 'twitter:title', content: process.env.CLIENT_NAME },
      { name: 'twitter:description', content: process.env.CLIENT_DESCRIPTION },
      { name: 'og:locale', content: 'ja_JP' },
      // { name: 'twitter:image', content: `${process.env.CLIENT_BASE}/images/index/hand.png` },
      { name: 'og:image:width', content: '544' },
      { name: 'og:image:height', content: '362' },
      // { name: 'og:image:secure_url', content: `${process.env.CLIENT_BASE}/images/index/hand.png` },
    ],
    title: process.env.CLIENT_NAME,
    titleTemplate: `${process.env.CLIENT_NAME} - %s`,
    noscript: [{ innerHTML: 'This website requires JavaScript. （このWebサイトにはJavaScriptが必要です。）' }],
  },
  css: ['~/assets/styles/theme'],
  modules: [
    [
      '@nuxtjs/pwa',
      {
        meta: {
          viewport: process.env.CLIENT_VIEWPORT,
          name: process.env.CLIENT_NAME,
          author: process.env.CLIENT_AUTHOR,
          description: process.env.CLIENT_DESCRIPTION,
          theme_color: process.env.CLIENT_COLOR,
          lang: process.env.CLIENT_LANGUAGE,
          ogHost: process.env.CLIENT_BASE,
          // ogImage: `${process.env.CLIENT_BASE}/images/index/hand.png`,
          twitterCard: 'summary_large_image',
          nativeUI: true,
        },
        manifest: {
          name: process.env.CLIENT_NAME,
          description: process.env.CLIENT_DESCRIPTION,
          lang: process.env.CLIENT_LANGUAGE,
          background_color: process.env.CLIENT_COLOR,
          theme_color: process.env.CLIENT_COLOR,
        },
      },
    ],
    [
      'bootstrap-vue/nuxt',
      {
        bootstrapCSS: false,
        bootstrapVueCSS: false,
      },
    ],
  ],

  // Dev
  watch: ['~/../.env'],

  // Build
  target: 'static',
  buildModules: [
    '@nuxt/typescript-build',
    [
      '@nuxtjs/dotenv',
      {
        path: pathEnv,
      },
    ],
  ],
  build: {
    analyze: false,
    babel: {
      presets: () => [['@nuxt/babel-preset-app', { loose: true }]],
      compact: true,
    },
    loaders: {
      scss: {
        additionalData: `$base: '${process.env.CLIENT_BASE}';`,
      },
    },
  },
};
