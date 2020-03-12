# pokelidokeli

## Basic idea
- find pokemon by browings or searching by type. Add them to your favourites cookie and e-mail a friend with a pokemonster to check out
- Becode PHP exercise

## implementation
- paid more attention to code quality: type hinting, security on classes, re-usability, yoda rule, limit indentation, strict type, defensive programming, names, comments, file structure, refactoring ...
- database class fills up pokemonS class and while constructing it calls the pokemon class that also contains another api call to get more details (image and so)
- created half working function (yet good concept) that easily searches json for property and sets this as property of pokemon instance. Functional for images, not much more
- also have universal getters function that returns any property of class instance that is called. There are not any properties that need to be hidden atm
- basic bootstrap styling
- Heroku deployment
- concated array of previous pokemons searched with new pokemons in order to be able to search it to display it when for instance you are browsing page 2 but still want to be able to see a favourited pokemon on page 1

## To do's
- separate json logic from pokemon classes in order to have reusable code in case the API changes in structure, MVC
- overview page's base logic is solid, but I don't know what info to display there. Not first priority anyway
- style block of favourites. Something with row and width, check margins and such because the borders are overlapping. Maybe different box-model?
- testing
- need to set array of pokemons visited earlier not in SESSION, but in cookies / alternatively, throw away this way of thinking and just call the api with the id's of the favourited pokemon (probably better)
- or I could use react front-end with state and such and only call API if new things are needed. This should greatly improve loading speed

# ORIGINAL ASSIGNMENT BELOW

# Title: The Extreme pokemon challenge
- Repository: `challenge-pokemon-php` (You should already have this repo, just make a branch on it.)
- Type of Challenge: `Learning Challenge`
- Duration: `3 days`
- Deployment strategy : `Heroku`
- Team challenge : `solo`

## Javascript or PHP?
This challenge can be done in PHP or Javascript.

## Learning Objectives
- To be able to solve frontend problems in PHP
- To be able to process a form in PHP

## Mission
We are going to use the PHP implementation of the Pokemon challenge you made before, but we are going to expand on it in various steps:

- Make a "category" page where you show 20 pokemon at the time in a grid. Display their picture and name, a make it clickable to go to their overview page.
- At the top and bottom of that "category" page, add a [pagination component](https://getbootstrap.com/docs/4.0/components/pagination/).
- At the top of the page, create a dropdown with all the types (fire, water, ...). When the user selects one, the interface only shows pokemon of that specific type.
- Add a dropdown that changes the amount of pokemon you can see on the category page.
- Make it possible to "favorite" a Pokemon. When you "favor" a pokemon, it shows up at the top of the category page in a separate section labeled "Favorite pokemon". (You can save this in a Cookie.)
- Once a pokemon is favored, add the possibility to mail a friend the url of a favored pokemon with the text "Look at this pokemon, it is so cool!"
