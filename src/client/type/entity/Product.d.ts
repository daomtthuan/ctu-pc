declare namespace Entity {
  interface Product extends Entity {
    name: string;
    price: number;
    quantity: number;
    idCategory: number;
    idBrand: number;
    postUrl: string;
  }
}
