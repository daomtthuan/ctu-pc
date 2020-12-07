export function focusEditor(id: string) {
  (<HTMLElement>document.querySelector(`#${id} .ql-editor.ql-blank`)).focus();
}
