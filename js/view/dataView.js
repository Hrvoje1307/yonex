import { COMPANY, AUTHORS, PRODUCTS_PER_PAGE } from "../../js/config.js";

class Data {
  //BTNS
  #closeBtn = document.querySelector(".close__btn");
  #submitBtn = document.querySelector(".submit__btn");

  //ADDITIONAL SELECTORS
  #inputForm = document.querySelectorAll(".product-input__field");


  //TABLES
  #tableBodyClassicFilters = document.querySelector(
    ".table__body__classicfilters"
  );
  #tableBodyRackets = document.querySelector(".table__body__rackets");
  #tableBodyBags = document.querySelector(".table__body__bags");
  #tableBodyBalls = document.querySelector(".table__body__balls");
  #tableBodyClothing = document.querySelector(".table__body__clothing");
  #tableBodyCords = document.querySelector(".table__body__cords");
  #tableBodyShoes = document.querySelector(".table__body__shoes");

  //ADDITIONAL
  #url = new URL(window.location.href);
  #pageNum = +this.#url.search.slice(6);
  #urlPathName = this.#url.pathname;
  #totalProducts = 0;

  //CONTAINERS
  #pagesBtnContainer = document.querySelector(".pages__btns");

  async getJson(url) {
    try {
      const json = await fetch(url);
      if (!json.ok)
        throw new Error("Something went wrong 💣💣💣" + json.statusText);
      const data = await json.json();
      return data;
    } catch (error) {
      console.error(error);
    }
  }

  async printCrotian(tableColumn, table) {
    try {
      const data = await this.getJson("app/config/prijevod.json");
      if (!data) throw new Error("Something went wrong with json");
      const products = data[tableColumn];
      const min = this.#pageNum * PRODUCTS_PER_PAGE - PRODUCTS_PER_PAGE;
      const max = this.#pageNum * PRODUCTS_PER_PAGE - 1;
      this.#totalProducts += products.length;
      products.forEach((product, key) => {
        if (key >= min && key <= max) {
          // prettier-ignore
          table.innerHTML += `
            <tr onclick="window.location.href='productSingle.php?id=${product.ID}'">
              <th scope="row">${key + 1}</th>
              <td>${product["ID"]}</td>
              <td>${product["name"]}</td>
              <td><img width="50px" src="${product["img_url"]}" alt=""></td>
              <td>${product["price"]}</td>
              <td>${product["priceNOTAX"]}</td>
              <td>${product["description"].substring(0, 50)}...</td>
              <td>${product["category"]}</td>
              <td>${product["quantity"]}</td>
            </tr>
          `;
        }
      });
    } catch (error) {
      if (error) {
        console.log(error.message);
      }
    }
  }

  async printCrotianClassicFilters() {
    if (!this.#tableBodyClassicFilters) return;
    await this.printCrotian("classicFilters", this.#tableBodyClassicFilters);
    const totalProducts = this.#totalProducts;
    this.printBtnsPages(totalProducts);
    this.changePageNum();
  }

  async printCrotianBags() {
    if (!this.#tableBodyBags) return;
    await this.printCrotian("bags", this.#tableBodyBags);
    const totalProducts = this.#totalProducts;
    this.printBtnsPages(totalProducts);
    this.changePageNum();
  }

  async printCrotianBalls() {
    if (!this.#tableBodyBalls) return;
    await this.printCrotian("balls", this.#tableBodyBalls);
    const totalProducts = this.#totalProducts;
    this.printBtnsPages(totalProducts);
    this.changePageNum();
  }

  async printCrotianRackets() {
    if (!this.#tableBodyRackets) return;
    await this.printCrotian("rackets", this.#tableBodyRackets);
    const totalProducts = this.#totalProducts;
    this.printBtnsPages(totalProducts);
    this.changePageNum();
  }

  async printCrotianClothing() {
    if (!this.#tableBodyClothing) return;
    await this.printCrotian("clothing", this.#tableBodyClothing);
    const totalProducts = this.#totalProducts;
    this.printBtnsPages(totalProducts);
    this.changePageNum();
  }

  async printCrotianCords() {
    if (!this.#tableBodyCords) return;
    await this.printCrotian("cords", this.#tableBodyCords);
    const totalProducts = this.#totalProducts;
    this.printBtnsPages(totalProducts);
    this.changePageNum();
  }

  async printCrotianShoes() {
    if (!this.#tableBodyShoes) return;
    await this.printCrotian("shoes", this.#tableBodyShoes);
    const totalProducts = this.#totalProducts;
    this.printBtnsPages(totalProducts);
    this.changePageNum();
  }

  printBtnsPages(totalProducts) {
    if (totalProducts < PRODUCTS_PER_PAGE) return;
    const lastPage = Math.ceil(totalProducts / PRODUCTS_PER_PAGE);
    if (this.#pageNum === 1) {
      this.#pagesBtnContainer.innerHTML = `
        <div class="d-flex justify-content-end">
          <button class="btn btn-secondary next__page">Sljedeća ${this.#pageNum + 1
        }</button>
        </div>
      `;
    } else if (this.#pageNum === lastPage) {
      this.#pagesBtnContainer.innerHTML = `
        <div class="d-flex justify-content-start">
          <button class="btn btn-secondary previous__page">Prethodna ${this.#pageNum - 1
        }</button>
        </div>
      `;
    } else {
      this.#pagesBtnContainer.innerHTML = `
        <div class="d-flex justify-content-between">
          <button class="btn btn-secondary previous__page">Prethodna ${this.#pageNum - 1
        }</button>
          <button class="btn btn-secondary next__page">Sljedeća ${this.#pageNum + 1
        }</button>
        </div>
      `;
    }
  }

  changePageNum() {
    const nextPage = document.querySelector(".next__page");
    const previousPage = document.querySelector(".previous__page");
    if (nextPage) {
      nextPage.addEventListener("click", () => {
        this.#pageNum++;
        window.location.href = this.#urlPathName + "?page=" + this.#pageNum;
      });
    }
    if (previousPage) {
      previousPage.addEventListener("click", () => {
        this.#pageNum--;
        window.location.href = this.#urlPathName + "?page=" + this.#pageNum;
      });
    }
  }

  closeUser() {
    if (!this.#closeBtn) return;
    this.#closeBtn.addEventListener("click", () => history.back());
  }

  async updateJsonProduct() {
    try {
      if (!this.#submitBtn) return;
      this.#submitBtn.addEventListener("click", async (e) => {
        // e.preventDefault();
        const productObject = {};
        const urlParams = window.location.search;
        const id = urlParams.slice(4);
        const data = await this.getJson("app/config/prijevod.json");
        const dataArray = [];
        Object.entries(data).map(entry => dataArray.push(entry[1]));
        const dataArrayMerged = [].concat(...dataArray);
        const product = dataArrayMerged.find(entry => entry.ID === id);
        this.#inputForm.forEach((field) => {
          if (field.type === "radio" && !field?.checked) return;
          productObject[field.name] = field.value;
        })

        const isUpdated = false;
        Object.keys(productObject).forEach(key => {
          if (productObject[key] === product[key]) return;
          product[key] = "CUCKO";
          isUpdated = true;
        });

        if (isUpdated) {
          const response = await fetch('/updateProduct', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify(product)
          });

          if (!response.ok) {
            throw new Error('Failed to update product');
          }

          console.log('Product updated successfully');
        }
      });

    } catch (e) {
      console.error(e.message);
    }
  }
}

export default new Data();
