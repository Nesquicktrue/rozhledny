const fs = require('fs');
const result = JSON.parse(fs.readFileSync('./rozhledny_2021.json'));

const mysql = require('mysql');
const array = [];

const con = mysql.createConnection({
    host: "localhost",
    port: "8889",
    user: "root",
    password: "root",
    database: "rozhledny"
});

result.rozhledny.forEach((zaznam) => {
    let nazevRozhledny = zaznam.properties.Name;
    let web = zaznam.properties.description;
    let souradniceX = zaznam.geometry.coordinates[0];
    let souradniceY = zaznam.geometry.coordinates[1];
    // console.log(`${nazevRozhledny} X: ${souradniceX} Y: ${souradniceY} web: ${web}`);
    array.push([nazevRozhledny, souradniceX, souradniceY, web])
})

con.connect(function (err) {
    if (err) throw err;
    console.log("Connected!");

    var sql = "INSERT INTO towers (name, x, y, url) VALUES ?";
    var values = array;

  con.query(sql, [values], function (err, result) {
    if (err) throw err;
    console.log("Number of records inserted: " + result.affectedRows);
  });
});

