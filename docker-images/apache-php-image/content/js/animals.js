$(function () {
   console.log("Loading animals");

   function loadAnimals() {
      $.getJson("/api/animals/", function (animals) {
         console.log(animals);
         var message = "The next one is a bit slow it seems";
         if (animals.length > 0) {
            message = animals[0].firstName + ", a " + animals[0].race;
         }
         $(".masthead-subheading").text(message);
      });
   };

   loadAnimals();
   setInterval(loadAnimals, 3000);
});