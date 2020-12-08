function getCarts() {
  let rawCarts = window.localStorage.getItem('carts');
  let carts: Entity.Cart.Storage = rawCarts != null ? JSON.parse(rawCarts) : [];
  return carts;
}

export function getCart(idAccount: number) {
  let carts = getCarts();

  if (!carts.hasOwnProperty(idAccount) || carts[idAccount] == null) {
    carts[idAccount] = [];
  }

  return <Entity.Cart.Cart>carts[idAccount];
}

export function clearCart(idAccount: number) {
  let carts = getCarts();

  if (!carts.hasOwnProperty(idAccount)) {
    return;
  }

  delete carts[idAccount];

  window.localStorage.setItem('carts', JSON.stringify(carts));
}

export function addProductCart(idAccount: number, idProduct: number, quantity: number | string | null) {
  if (quantity != null) {
    let carts = getCarts();

    if (!carts.hasOwnProperty(idAccount) || carts[idAccount] == null) {
      carts[idAccount] = [];
    }

    let index = carts[idAccount]!.findIndex((product) => product.id == idProduct);
    if (index == -1) {
      carts[idAccount]!.push({ id: idProduct, quantity: parseInt(quantity.toString()) });
    } else {
      carts[idAccount]![index].quantity += parseInt(quantity.toString());
    }

    window.localStorage.setItem('carts', JSON.stringify(carts));
  }
}

export function editProductCart(idAccount: number, idProduct: number, quantity: number | string | null) {
  if (quantity != null) {
    let carts = getCarts();

    if (!carts.hasOwnProperty(idAccount) || carts[idAccount] == null) {
      carts[idAccount] = [];
    }

    let index = carts[idAccount]!.findIndex((product) => product.id == idProduct);
    if (index == -1) {
      return;
    } else {
      carts[idAccount]![index].quantity = parseInt(quantity.toString());
    }

    window.localStorage.setItem('carts', JSON.stringify(carts));
  }
}

export function removeProductCart(idAccount: number, idProduct: number) {
  let carts = getCarts();

  if (!carts.hasOwnProperty(idAccount) || carts[idAccount] == null) {
    carts[idAccount] = [];
  }

  carts[idAccount] = carts[idAccount]!.filter((product) => product.id != idProduct);

  window.localStorage.setItem('carts', JSON.stringify(carts));
}
