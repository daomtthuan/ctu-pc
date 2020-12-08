declare namespace Entity {
  namespace Cart {
    interface Product {
      id: number;
      quantity: number;
    }

    interface Cart extends Array<Product> {
      [id: number]: Product;
    }

    interface Storage extends Object {
      [id: number]: Cart | null;
    }
  }
}
