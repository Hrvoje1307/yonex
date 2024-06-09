import { COMPANY, AUTHORS } from "../../js/config.js";

class Data {
  #container = document.querySelector(".data__container");

  async printJson() {
    try {
      const json = await fetch("app/config/products.json");
      if (!json.ok)
        throw new Error("Something went wrong 💣💣💣" + json.statusText);
      const products = await json.json();
      const jsonString = JSON.stringify(products, null, 2);
      const id = [];
      const eachProduct = products["podjetje"]["izdelki"]["izdelek"];
      Object.entries(eachProduct).forEach((product, i) => {
        if (i < 3) {
          console.log(product[1]["izdelekID"]);
        }
      });
      // console.log(id);
      this.#container.textContent = jsonString;
    } catch (err) {
      console.error(err);
    }
  }
}

export default new Data();
