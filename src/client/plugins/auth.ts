import { Context } from '@nuxt/types';

export default async function (context: Context) {
  if (process.client) {
    let token = localStorage.getItem('token');
    if (token != null && token != context.$auth.getToken('local')) {
      context.$auth.setToken('local', token);
      await context.$auth.fetchUser();
    }
  }
}
