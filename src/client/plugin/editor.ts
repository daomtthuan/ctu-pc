import Vue from 'vue';

export function initEditor() {
  if (process.client) {
    Vue.use(require('vue2-editor'));
  }
}

export function focusEditor(id: string) {
  (<HTMLElement>document.querySelector(`#${id} .ql-editor.ql-blank`)).focus();
}

export function resetEditor(id: string) {
  (<HTMLElement>document.querySelector('#input-content')).parentElement!.classList.remove('is-valid', 'is-invalid');
}
