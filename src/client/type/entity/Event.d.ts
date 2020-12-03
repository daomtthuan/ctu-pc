declare namespace Entity {
  interface Event extends Entity {
    title: string;
    post: string;
    idAccount: number;
    author: Account;
    imageUrl: string;
    postUrl: string;
  }
}
