# StarWars
This is a simple lumen API for interacting with the official StarWars API, to get movies, characters and post anonymous comments. Demo URL [https://starwars-dev.herokuapp.com](https://starwars-dev.herokuapp.com)

# Features
  * Get Movies
  * Get Movies Characters
  * Post Comments
  
# Installation
  * In order to run this application you must have composer and docker installed on your computer
  * Download or clone this application to your computer
  * Navigate to the project directory
  * Install all dependencies using `composer install`
  * Rename .env.example to .env in the root directory
  * Run the app with `docker-compose up`
  * Open another terminal and run `docker-compose exec php-fpm bash`
  * Migrate the database using `php artisan migrate`
  * Open http://localhost:8081 on your browser to visit the app
  * Enjoy

# Author
  Built by Sam Olabamiji

# License & Copyright
MIT (c) Sam Olabamiji.
Licensed under the MIT License
