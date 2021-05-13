var Chance = require('chance');
var chance = new Chance();

var express = require('express');
var app =  express();

app.get('/test', function(req, res) {
	res.send("Hello RES - test is working");
});

app.get('/animals', function(req, res) {
	res.send( generateAnimals() );
});

//fonction appelée de base lors du d'une requete par default
app.get('/', function(req, res) {
	res.send("Hello RES");
});

app.listen(3000, function() {
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
         min: 2000, max: 2020
      });
      animals.push({
         race: chance.animal(),
         firstName: chance.first({
            gender: gender
         }),
         gender: gender,
         birthYear: birthYear
      });
   };
   console.log(animals);
   return animals;
}