import { Context } from '@nuxt/types';

export default function (context: Context) {
  if (process.client) {
    let token = localStorage.getItem('token');
    if (token != null && token != context.$auth.getToken('local')) {
      context.$auth.setToken('local', token);
    }
  }
}
