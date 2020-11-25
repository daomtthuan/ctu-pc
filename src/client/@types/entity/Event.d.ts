declare namespace Entity {
  interface Event {
    id: number;
    title: string;
    post: string;
    idAccount: number;
    author?: Entity.Account;
    imageUrl: string;
    postUrl: string;
    state: boolean;
  }
}
