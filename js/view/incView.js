import { COMPANY, AUTHORS } from "../../js/config.js";

class Inc {
  #footerConntainer = document.querySelector(".footer__info");
  #numberOfCards = document
    .querySelectorAll(".card__wishlist")
    .length.toString();
  #wishlistQuantityWord = document.querySelector(".quantity__word-wishlist");
  footerContent() {
    const year = new Date().getFullYear();
    this.#footerConntainer.innerHTML = `<p class="text-lightgrey m-0">&copy; ${year} ${COMPANY} | Created by ${AUTHORS}</p>`;
  }
  showQuantityWishlist() {
    const wishlistQuanitiy = +this.#numberOfCards;
    wishlistQuanitiy !== 1
      ? (this.#wishlistQuantityWord.innerHTML = "proizvoda")
      : (this.#wishlistQuantityWord.innerHTML = "proizvod");
  }
}

export default new Inc();
