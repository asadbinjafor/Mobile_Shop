const express = require("express");
const HomeController = require("../controllers/HomeController");
const ProductController = require("../controllers/ProductController");
const CartController = require("../controllers/CartController");

const router = express.Router();

router.get("/", HomeController.index);

router.get("/products", ProductController.index);
router.get("/products/:id", ProductController.show);
router.get("/category/:slug", ProductController.category);

router.get("/api/products/:id", ProductController.apiShow);
router.post("/api/cart/validate", CartController.validate);

router.get("/cart", CartController.page);

module.exports = router;
