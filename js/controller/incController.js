import incView from "../view/incView.js";
import dataView from "../view/dataView.js";

const inc = function () {
  incView.footerContent();
  incView.showQuantityWishlist();
  incView.totalPrice();
  incView.productCards();
  dataView.test();
};

inc();
