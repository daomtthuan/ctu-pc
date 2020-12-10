declare namespace Entity {
  namespace Cart {
    interface Cart extends Array<Product> {
      [id: number]: Product;
    }
  }
}
