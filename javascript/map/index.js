import 'leaflet/dist/leaflet.css'
import L from 'leaflet'

/* global $ */
//test
const lat = 36.2110486
const long = -81.6777839

const accessToken = 'pk.eyJ1IjoibWNuYW5leW0iLCJhIjoiY2prNDJ5NDNzMTVmejN3bGVrNGFvM2UxZSJ9.5GmrHJStz_X0X7X3EJinwg'

/*
https://nominatim.openstreetmap.org/search.php?format=json&q=287+Rivers+Street%2C+Boone%2C+NC%2C+28608&email=mcnaneym@appstate.edu

https://nominatim.openstreetmap.org/search.php?format=json&q=287+Rivers+Street%2C+Boone%2C+NC%2C+28608&email=mcnaneym@appstate.edu


*/

/*
https://api.mapbox.com/styles/v1/mapbox/streets-v10/static/-81.678245,36.212966,17,0,60/300x200?access_token=pk.eyJ1IjoibWNuYW5leW0iLCJhIjoiY2prNDJ5NDNzMTVmejN3bGVrNGFvM2UxZSJ9.5GmrHJStz_X0X7X3EJinwg
*/

https://api.mapbox.com/styles/v1/mapbox/streets-v10/static/-81.715395,36.187237,17,0,60/300x200?access_token=pk.eyJ1IjoibWNuYW5leW0iLCJhIjoiY2prNDJ5NDNzMTVmejN3bGVrNGFvM2UxZSJ9.5GmrHJStz_X0X7X3EJinwg

//36.187237
//-81.715395

const showMap = (lat, long) => {
  const map = L.map('map', {zoomControl: false}).setView([
    lat, long,
  ], 17)

  

  L.tileLayer(
    'http://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}',
    {
      attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> con' +
          'tributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA<' +
          '/a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
      id: 'mapbox.streets',
      zoomControl: false,
      accessToken: accessToken,
    }
  ).addTo(map)
}

showMap(lat, long)


https://nominatim.openstreetmap.org/search?format=json&q=287+River+Street,+Boone,+North+Carolina,+28608&email=mcnaneym@appstate.edu
/*
$.getJSON('https://nominatim.openstreetmap.org/search', {
  format: 'json',
  q: '287 Rivers Street Boone, North Carolina 28608',
  email: 'mcnaneym@appstate.edu'
}).done(function (data) {
  showMap(data[0].lat, data[0].lon)
}.bind(this))
*/
