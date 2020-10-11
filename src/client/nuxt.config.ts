import Dotenv from 'dotenv';

Dotenv.config();

export default {
  // Server
  server: { port: 3000 },

  // Project
  components: [{ path: '~/components', prefix: 'c' }],
  head: {
    meta: [
      { charset: 'utf-8' },
      { 'http-equiv': 'X-UA-Compatible', content: 'IE=edge' },
      { name: 'viewport', content: process.env.VIEWPORT },
      { name: 'keywords', content: 'NEXUS RENTAL PARTNER, NEXUS, RENTAL PARTNER' },
      { name: 'author', content: 'Daomtthuan' },
      { name: 'robots', content: 'index, follow, archive' },
      { hid: 'description', name: 'description', content: process.env.DESCRIPTION },
      { property: 'st:section', content: process.env.DESCRIPTION },
      { name: 'twitter:title', content: process.env.NAME },
      { name: 'twitter:description', content: process.env.DESCRIPTION },
      { name: 'og:locale', content: 'ja_JP' },
      // { name: 'twitter:image', content: `${process.env.BASE}/images/index/hand.png` },
      { name: 'og:image:width', content: '544' },
      { name: 'og:image:height', content: '362' },
      // { name: 'og:image:secure_url', content: `${process.env.BASE}/images/index/hand.png` },
    ],
    title: process.env.NAME,
    titleTemplate: `${process.env.NAME} - %s`,
    noscript: [{ innerHTML: 'This website requires JavaScript.' }],
  },
  css: ['~/assets/styles/theme'],
  loading: {
    color: ' #3b84c0',
    failedColor: '#be5046',
  },
  proxy: {
    '/api': process.env.SERVER,
  },
  modules: [
    //PWA
    [
      '@nuxtjs/pwa',
      {
        icon: {
          sizes: [30, 64, 120, 144, 152, 192, 384, 512],
        },
        meta: {
          viewport: process.env.VIEWPORT,
          name: process.env.NAME,
          author: process.env.AUTHOR,
          description: process.env.DESCRIPTION,
          theme_color: process.env.COLOR,
          lang: process.env.LANGUAGE,
          ogHost: process.env.BASE,
          // ogImage: `${process.env.BASE}/images/index/hand.png`,
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
    ],

    // Bootstrap Vue
    [
      'bootstrap-vue/nuxt',
      {
        bootstrapCSS: false,
        bootstrapVueCSS: false,
      },
    ],

    // Fontawesome
    [
      'nuxt-fontawesome',
      {
        component: 'fa',
        imports: [
          {
            set: '@fortawesome/free-solid-svg-icons',
            icons: ['fas'],
          },
        ],
      },
    ],

    // Axios
    [
      '@nuxtjs/axios',
      {
        prefix: '/api',
        proxy: true,
      },
    ],

    // Auth
    [
      '@nuxtjs/auth',
      {
        cookie: {
          // prefix: 'auth_',
        },
        strategies: {
          local: {
            endpoints: {
              user: { url: '/auth', method: 'get', propertyName: 'user' },
              login: { url: '/auth', method: 'post', propertyName: 'token' },
              logout: { url: '/auth', method: 'delete' },
            },
            tokenType: '',
          },
        },
      },
    ],
  ],

  // Dev
  watch: ['~/.env', '~/@types'],

  // Build
  target: 'static',
  router: {
    base: process.env.ROUTER,
  },
  buildModules: [
    // Typescript
    ['@nuxt/typescript-build', {}],

    // Dotenv
    ['@nuxtjs/dotenv', {}],
  ],
  build: {
    analyze: false,
    babel: {
      presets: () => [['@nuxt/babel-preset-app', { loose: true }]],
      compact: true,
    },
    loaders: {
      scss: {
        additionalData: `$base: '${process.env.BASE}';`,
      },
    },
  },
};
