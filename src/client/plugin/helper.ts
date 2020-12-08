export function toMoney(price: number) {
  return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + ',000 vnđ';
}
