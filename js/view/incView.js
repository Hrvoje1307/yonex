import { COMPANY, AUTHORS, PRODUCTS_PER_PAGE } from "../../js/config.js";

class Inc {
  #footerConntainer = document.querySelector(".footer__info");

  #btnPassword = document.querySelectorAll(".btn__password");
  #btnShow = document.querySelector(".btn__show");
  #btnHide = document.querySelector(".btn__hide");
  #passwordForm = document.querySelectorAll(".password__form");

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

  //Products
  #productContainer = document.querySelectorAll("#productContainer");
  #pagesBtns = document.querySelector("#pageForm");
  #productCards = document.querySelectorAll(".product__card");

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
    totalPrice = totalPrice.toFixed(2);
    this.#totalPrice.innerHTML = totalPrice.toString();
  }

  productCards() {
    if (!this.#productContainer) return;
    let page = null;
    const url = window.location.search;
    const urlParts = new URLSearchParams(url);
    urlParts.forEach((element, key) => {
      if (key === "page") {
        page = +element;
      }
    });
    if (
      this.#productCards.length < PRODUCTS_PER_PAGE &&
      (page === 1 || page === null) &&
      this.#pagesBtns
    ) {
      this.#pagesBtns.style = "display:none";
    }
  }

  togglePasswordVisibility() {
    this.#btnPassword.forEach((button, i) => {
      let passwordVisibility = false;
      button.addEventListener("click", () => {
        passwordVisibility = !passwordVisibility;
        console.log(passwordVisibility);
        if (passwordVisibility) {
          this.#btnPassword[i].innerHTML =
            "<i class='bi bi-eye-slash-fill'></i>";
          this.#passwordForm[i].type = "text";
        } else {
          this.#btnPassword[i].innerHTML = "<i class='bi bi-eye-fill'></i>";
          this.#passwordForm[i].type = "password";
        }
      });
    });
  }
}

export default new Inc();
