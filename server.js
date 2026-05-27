const app = require("./app");
const config = require("./config/appConfig");

app.listen(config.port, () => {
  console.log(`\n  MobileHub BD MVC Server`);
  console.log(`  http://localhost:${config.port}\n`);
});
