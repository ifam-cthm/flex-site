var axios = require('axios');

var axiosInstance = axios.create({
  //baseURL: 'http://localhost/flex-site/Back/public/', //Base da API
  baseURL: 'http://localhost/CTHM-FLEX/flex-site/Back/public/',
  responseType: 'json',
  responseEncoding: 'utf8',
  headers: {
    'Accept': 'application/json',
    "Content-Type": "application/json;charset=UTF-8",
    "Access-Control-Allow-Origin": "*",
    "Access-Control-Allow-Methods": "GET,POST,PUT,DELETE,OPTIONS",
  }
});

module.exports = axiosInstance;