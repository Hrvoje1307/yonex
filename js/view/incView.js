import {COMPANY, AUTHORS} from "../../js/config.js";

class Inc {
   #footerConntainer = document.querySelector(".footer__info");
   footerContent() {
      const year = new Date().getFullYear();
      this.#footerConntainer.innerHTML= `<p class="text-lightgrey m-0">&copy; ${year} ${COMPANY} | Created by ${AUTHORS}</p>`;
   }
}

export default new Inc();