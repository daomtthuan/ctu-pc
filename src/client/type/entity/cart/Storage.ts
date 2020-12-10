declare namespace Entity {
  namespace Cart {
    interface Storage extends Object {
      [id: number]: Cart | null;
    }
  }
}
