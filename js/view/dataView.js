import { COMPANY, AUTHORS } from "../../js/config.js";

class Data {
  async printJson() {
    try {
      const json = await fetch("app/config/products.json");
      if (!json.ok)
        throw new Error("Something went wrong 💣💣💣" + json.statusText);
      const products = await json.json();
      const jsonString = JSON.stringify(products, null, 2);
      const eachProduct = products["podjetje"]["izdelki"]["izdelek"];
      const array = [];

      eachProduct.forEach((element) => {
        const category = element["kategorija"]["__cdata"];
        array.push(category);
      });
      const categories = new Set(array);
      const categoriesArray = Array.from(categories);
      // categories.forEach((category) => console.log(category));
    } catch (err) {
      console.error(err);
    }
  }
}

export default new Data();
