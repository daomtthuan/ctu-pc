declare namespace Entity {
  interface Bill extends Entity {
    idAccount: number;
    createDate: string;
    payDate: string;
    status: number;
    imageUrl: string;
    total: number;
    numberProductCarts: number;
  }
}
