# pokelidokeli

## Basic idea
- find pokemon by browings or searching by type. Add them to your favourites cookie and e-mail a friend with a pokemonster to check out
- Becode PHP exercise

## implementation
### principles
- paid more attention to code quality: type hinting, security on classes, re-usability, yoda rule, limit indentation, strict type, defensive programming, names, comments, file structure, refactoring, as little PHP in html(view) as possible
- separate json logic from pokemon classes in order to have reusable code in case the API changes in structure, MVC
### how it works
- database class fills up pokemonS class and while constructing it calls the pokemon (singular) class that also contains another api call to get more details (image and so)
- controller checks URL paramters and sets dummy paramters if not used. If/else checks structure triggers relevant database calls. (In previous version, SESSION was used for this)
- also have universal getters function that returns any property of class instance that is called. There are not any properties that need to be hidden atm
- displaying of actual pokemon is done by populating functions that in turn contains components such as pagination that re-use or append these paramters
- concated array of previous pokemons searched with new pokemons in order to be able to search it to display it when for instance you are browsing page 2 but still want to be able to see a favourited pokemon on page 1
### other stuff
- phan testing: see analysis.txt file 
- basic bootstrap styling
- Heroku deployment

## To do's
### style
- style block of favourites. Something with row and width, check margins and such because the borders are overlapping. Maybe different box-model?
- also: if too many favourites, the left column leaves a lot of whitespace that is not present when few pokes are favourited
### features
- overview page's base logic is solid, but I don't know what info to display there. Not first priority anyway
- check if mailer works from BeCode's location and elsewhere. mail-tester.com error report included here
- created half working function (yet good concept) that easily searches json for property and sets this as property of pokemon instance. Functional for images, names ... not much more
### others
- need to set array of pokemons visited earlier not in SESSION, but in cookies / alternatively, throw away this way of thinking and just call the api with the id's of the favourited pokemon (probably better)
- or I could use react front-end with state and such and only call API if new things are needed. This should greatly improve loading speed
- or maybe best, because it's php, just store previous data in cookies and concat this with new information needed
- feedback Danny: my way of including html in function is creating new view. Better to have a few lines of PHP in MY view than to create this awkward function. Thijs: you will need to mix php and html at some point anyway

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
