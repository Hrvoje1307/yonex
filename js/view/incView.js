import { COMPANY, AUTHORS } from "../../js/config.js";

class Inc {
  #footerConntainer = document.querySelector(".footer__info");
  #numberOfCards = document.querySelectorAll(".card__products").length;
  #productQuantityWord = document.querySelector(".quantity__word");
  #productPrice = Array.from(document.querySelectorAll(".real__price"));
  footerContent() {
    const year = new Date().getFullYear();
    this.#footerConntainer.innerHTML = `<p class="text-lightgrey m-0">&copy; ${year} ${COMPANY} | Created by ${AUTHORS}</p>`;
  }
  showQuantityWishlist() {
    if (this.#numberOfCards === 0) return;
    const wishlistQuanitiy = +this.#numberOfCards;
    wishlistQuanitiy !== 1
      ? (this.#productQuantityWord.innerHTML = "proizvoda")
      : (this.#productQuantityWord.innerHTML = "proizvod");
  }

  totalPrice() {
    console.log(+this.#productPrice[0].innerHTML);
  }
}

export default new Inc();
