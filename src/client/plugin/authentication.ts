import { Plugin } from '@nuxt/types';

let authenticate: Plugin = async function (context) {
  if (process.client) {
    if (context.route.path == '/login' && context.$auth.loggedIn) {
      context.redirect(context.env.BASE);
    }

    try {
      let token = localStorage.getItem('token');
      if (token != null && token != context.$auth.getToken('local')) {
        context.$auth.setToken('local', token);
        await context.$auth.fetchUser();
      }
    } catch (error) {
      context.error({ statusCode: (<Response>error.response).status });
    }
  }
};

export default authenticate;
