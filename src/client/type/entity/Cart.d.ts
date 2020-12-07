declare namespace Entity {
  namespace Cart {
    interface Product {
      idProduct: number;
      quantity: number;
    }

    interface Storage extends Object {
      [id: number]: Product[];
    }
  }
}
