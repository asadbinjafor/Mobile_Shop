const path = require("path");
const express = require("express");
const config = require("./config/appConfig");
const routes = require("./routes");
const { formatPrice } = require("./helpers/viewHelpers");
const { ProductModel } = require("./models/ProductModel");

const app = express();

app.set("view engine", "ejs");
app.set("views", path.join(__dirname, "views"));

app.use(express.static(path.join(__dirname, "public")));
app.use(express.urlencoded({ extended: true }));
app.use(express.json());

app.use((req, res, next) => {
  res.locals.config = config;
  res.locals.formatPrice = formatPrice;
  res.locals.currentPath = req.path;
  res.locals.brands = ProductModel.getBrands();
  res.locals.categories = ProductModel.getCategories();
  next();
});

app.use("/", routes);

app.use((req, res) => {
  res.status(404).render("errors/404", { title: "Page Not Found" });
});

module.exports = app;
