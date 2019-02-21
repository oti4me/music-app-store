# music-app-store

[![CircleCI](https://circleci.com/gh/oti4me/music-app-store/tree/develop.svg?style=svg)](https://circleci.com/gh/oti4me/music-app-store/tree/develop)
[![Maintainability](https://api.codeclimate.com/v1/badges/7697474c1ed2f478b86e/maintainability)](https://codeclimate.com/github/oti4me/music-app-store/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/7697474c1ed2f478b86e/test_coverage)](https://codeclimate.com/github/oti4me/music-app-store/test_coverage)

## Introduction
**`Music Store`** is a simple File sharing application the user can upload, download and delete files. It has the following features; 
* User Signup
* User Signin
* Upload files
* Donwload files
* Delete files
* Authenticate users
* Create playlist
* Add sings to playlist
* Artist can create albums
* Add songs to albums
* Add songs to favorites
* View favorite list
* View playlist


## Installation and Setup
*  Install PHP
*  Install Apache web server
*  Install Postgres
*  Navigate to a directory of choice on `terminal`.
*  Clone this repository on that directory.

    > git clone https://github.com/oti4me/music-app-store.git

*  Navigate to the repo's folder on your computer
  *  `cd music-app-store/`
* Install the application's dependencies using `composer install`

  #### Note
  * In order to begin using, you need to have [PHP](www.php.net/), [Laravel](https://laravel.com/), and **composer** installed on your system.
  * For database you need to install __PostGres__ locally or setup with an online client eg. **ElephantSql**
  * Setup Database according to setting in .env.example file.
  * Migrate to database using php artisan migrate
  * Create two (2) databases one for __development__ and the other for **testing**
  * In other to interact effectively with endpoints, install and use [Postman](https://www.getpostman.com/)

* Run the app
  *  `php artisan migrate`
  *  `php artisan serve`
  *  Running the command above will run the app at `localhost:8000`.
  
  #### API Endpoints
    User endpoints: user can signup as an artist by passing the type field = 'artist'
    *  `POST:/auth/signup`
    *  `POST:/auth/signup`
    
    Song endpoints:
    *  `POST:/songs` Add songs
    *  `GET:/songs` Get the list of songs
    *  `GET:/songs/download?url=xxx` Donwload song
    *  `GET:/songs/me` Get a list of my songs
    *  `DELETE:/songs/{id}` Delete a song - can only delete own song
    
    Favourites Endpoints
    *  `POST:/songs/{id}/favourites` Add song to favorites
    *  `GET:/songs/favourites` Get my favorite songs
    *  `DELETE:/songs/{id}/favourites` Remove song from favorite
    
    Playlist Endpoints
    *  `POST:/songs/playlists` Create a playlist
    *  `DELETE:/songs/{id}/playlists/{playlist_id}` Add song song to playlist
    *  `DELETE:/songs/playlists/{playlist_id}` View playlist
    
    Album Endpoints
    *  `POST:/songs/albums` Creates an album
    
## Dependencies
* See composer.json for reference

## Tests
*  The tests have been written using **[PHPunit](https://phpunit.de/)** 
*  To run the tests, navigate to the project's folder
*  Issue the following command on terminal.
  *  `./vendor/bin/phpunit`
*  If the tests are successful, they will complete without failures or errors.

## Technologies
 * [PHP 7.1](www.php.net/): This is the newest version of JavsScript with new features such as arrow functions, spread and rest operators and many more.
 * [Laravel](https://laravel.com/): REACT is a JavaScript framework developed by Facebook and it is used for developing web application. REACT is the 'VIEW' in the MVC architecture.

# Language
- PHP

## Contributions
 Contributions are always welcome. If you are interested in enhancing the features in the project, follow these steps below:
 + Fork the project to your repository then clone it to your local machine.
 + Create a new branch and make features that will enhance it.
 + If the you wish to update an existing enhancement submit a pull request.
 + If you find bugs in the application, create a `New Issue` and let me know about it.
 + If you need clarification on what is not clear, contact me via mail [henry.otighe@andela.com](mailto:henry.otighe@andela.com)

## Author
    Henry Otighe

## License & Copyright
MIT © [Henry Otighe](https://github.com/oti4me)

Licensed under the [MIT License](https://github.com/oti4me/music-app-store/blob/develop/LICENSE).
