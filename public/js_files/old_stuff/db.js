const mysql = require('mysql');

var app = express();

var con = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: '',
  database: 'darts'
});

con.connect((err) => {
  if (err)
    throw err;
  
  console.log('bine tu');
});
