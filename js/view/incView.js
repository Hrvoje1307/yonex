import { COMPANY, AUTHORS } from "../../js/config.js";

class Inc {
  #footerConntainer = document.querySelector(".footer__info");

  //---------Products------
  //Wishlist
  #numberOfCards = document.querySelectorAll(".card__products").length;
  //Wishlist and cart
  #productQuantityWord = document.querySelector(".quantity__word");
  #productPrice = Array.from(document.querySelectorAll(".real__price"));
  #quantityProduct = Array.from(
    document.querySelectorAll(".quantity__product")
  );
  #totalPrice = document.querySelector(".total__price");
  #changeQuantityBtn = document.querySelectorAll(".change__quantity-btn");

  footerContent() {
    const year = new Date().getFullYear();
    if (!this.#footerConntainer) return;
    this.#footerConntainer.innerHTML = `<p class="text-lightgrey m-0">&copy; ${year} ${COMPANY} | Created by ${AUTHORS}</p>`;
  }

  //Cart and wishlist functions
  showQuantityWishlist() {
    if (this.#numberOfCards === 0) return;
    const wishlistQuanitiy = +this.#numberOfCards;
    wishlistQuanitiy !== 1
      ? (this.#productQuantityWord.innerHTML = "proizvoda")
      : (this.#productQuantityWord.innerHTML = "proizvod");
  }

  totalPrice() {
    if (!this.#totalPrice) return;
    if (!this.#productPrice) return;
    const self = this;
    let totalPrice = 0;
    this.#productPrice.forEach((e, i) => {
      totalPrice += +e.innerHTML * +self.#quantityProduct[i].value;
    });
    this.#totalPrice.innerHTML = totalPrice.toString();
  }

  changeQuantity() {
    const self = this;
    if (!this.#changeQuantityBtn) return;
    this.#changeQuantityBtn.forEach((btn) => {
      btn.addEventListener("click", (e) => {
        let closestQuantity = e.target
          .closest(".card__products")
          .querySelector(".quantity__product").value;
        const closestQuantityString = e.target
          .closest(".card__products")
          .querySelector(".quantity__product");
        e.target.innerHTML === "+" ? closestQuantity++ : closestQuantity--;
        closestQuantity < 0 ? (closestQuantity = 0) : closestQuantity;
        closestQuantityString.value = closestQuantity;
        self.totalPrice();
      });
    });
  }
}

export default new Inc();
