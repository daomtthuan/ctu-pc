export function toMoney(price: number) {
  return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + ',000 vnđ';
}

export function addProductCart(idAccount: number, idProduct: number, quantity: number) {
  let rawCarts = window.localStorage.getItem('carts');
  let carts: Entity.Cart.Storage = rawCarts != null ? JSON.parse(rawCarts) : [];

  if (!carts.hasOwnProperty(idAccount)) {
    carts[idAccount] = [];
  }

  let index = carts[idAccount].findIndex((product) => product.idProduct == idProduct);
  if (index == -1) {
    carts[idAccount].push({ idProduct, quantity });
  } else {
    carts[idAccount][index].quantity += quantity;
  }

  window.localStorage.setItem('carts', JSON.stringify(carts));
}
