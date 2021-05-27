var Chance = require('chance');
var chance = new Chance();

var express = require('express');
var app = express();

app.get('/', function (req, res) {
   res.send(generateAnimals());
});

app.listen(3000, function () {
   console.log('Accepting HTTP requests on port 3000.');
});

function generateAnimals() {
   var numberOfAnimals = chance.integer({
      min: 0, max: 10
   });
   console.log(numberOfAnimals);
   var animals = [];
   for (var i = 0; i < numberOfAnimals; ++i) {
      var gender = chance.gender();
      var birthYear = chance.year({
         min: 1986, max: 2020
      });
      animals.push({
         firstName: chance.first({
            gender: gender
         }),
         race: chance.animal(),
         gender: gender,
         birthYear: birthYear
      });
   };
   console.log(animals);
   return animals;
}