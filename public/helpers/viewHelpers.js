const { LABELS } = require("../models/ProductModel");

function formatPrice(amount) {
  return "৳ " + Number(amount).toLocaleString("en-IN");
}

function getDiscount(price, oldPrice) {
  return Math.round(((oldPrice - price) / oldPrice) * 100);
}

function getLabel(labelKey) {
  return LABELS[labelKey] || LABELS.hot;
}

function enrichProduct(p) {
  const discount = getDiscount(p.price, p.oldPrice);
  const label = getLabel(p.label);
  return {
    ...p,
    discount,
    labelText: label.text,
    labelClass: label.cls,
    hasEmi: p.price >= 10000,
    formattedPrice: formatPrice(p.price),
    formattedOldPrice: formatPrice(p.oldPrice)
  };
}

module.exports = { formatPrice, getDiscount, getLabel, enrichProduct };
