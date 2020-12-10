declare namespace Entity {
  interface Review extends Entity {
    star: number;
    content: string;
    idAccount: number;
    idProduct: number;
    writer: Account | string;
  }
}
