declare namespace Entity {
  interface Review extends Entity {
    start: number;
    content: string;
    idAccount: number;
    idProduct: number;
    writer: Account | string;
  }
}
