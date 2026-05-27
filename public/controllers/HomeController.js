const { ProductModel } = require("../models/ProductModel");
const { enrichProduct } = require("../helpers/viewHelpers");

class HomeController {
  static index(req, res) {
    const map = (list) => list.map(enrichProduct);

    res.render("home/index", {
      title: "Best Mobile, Laptop & Gadget Shop in Bangladesh",
      flashProducts: map(ProductModel.getBySection("flash")),
      dealProducts: map(ProductModel.getBySection("deals")),
      recentProducts: map(ProductModel.getBySection("recent")),
      trendingProducts: map(ProductModel.getBySection("trending")),
      brands: ProductModel.getBrands(),
      categories: ProductModel.getCategories()
    });
  }
}

module.exports = HomeController;
