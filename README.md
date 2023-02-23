# CinemaHub - Movies and TV Shows API

This is an API for adding and retrieving information about movies and TV shows.

## Installation

First you have to clone the repository

```bash
git clone https://github.com/MiltonAguirre/cinemahub-api.git
cd cinemahub-api
```

Use [composer] package manager to install dependencies

```bash
composer install
```

**Configuration**

Load the values from your local DB into your [.env] file

```bash
DB_DATABASE=db_cinemahub
DB_USERNAME=root
DB_PASSWORD=asdasdasd
```

Generate JWT secret key

This will update your .env file with something like JWT_SECRET=foobar<br/>
_It is the key that will be used to sign your tokens._

```bash
php artisan jwt:secret
```

Then you must run the migrations and the seeders

```bash
php artisan migrate --seed
```

_Thanks to the seeders, 8 categories, 5 directors and 15 actors are created using Faker._
_You will also have a user so you can log in with the following data:_

-   email: user@test.com
-   password: password

Raise the server with the following command

```bash
php artisan serve
```

## Testing

To execute the unit tests you must create a database with the name:**db_cinemahub_test**

```bash
php artisan test --env=testing
```

## Endpoints

### Authentication

-   POST _/api/auth/login_ <br/>
    Sign in to get a token
-   POST _/api/auth/refresh_ <br/>
    Refresh token

### Categories

-   GET _/api/categories_ <br/>
    Returns all categories in the database.

### Movies

-   GET _/api/movies?category_id=2&year=2013_ <br/>
    Retrieves all movies in the database

##### Query parameters

| Parameters             |         Description          |
| ---------------------- | :--------------------------: |
| category_id (optional) | Filter movies by category ID |
| year (optional)        |    Filter movies by year     |

-   POST _/api/movies_ <br/>
    Add a new movie to the database.

##### Query parameters

| Parameters              |                  Description                   |
| ----------------------- | :--------------------------------------------: |
| title (required)        |                  Movie title                   |
| description (required)  |               Movie description                |
| duration (required)     | Duration of the movie, for example: '1:30 hs'  |
| year (required)         |               Movie release year               |
| director_id (required)  |               Movie director id                |
| category_ids (required) | list of category IDs associated with the movie |
| actor_ids (required)    |  list of actor IDs associated with the movie   |

### TV Shows

-   GET _/api/tvshows_ <br/>
    Returns all tv shows in the database.

-   POST _/api/tvshows_ <br/>
    Add a new tvshow to the database.

##### Query parameters

| Parameters              |                   Description                    |
| ----------------------- | :----------------------------------------------: |
| title (required)        |                  Tv show title                   |
| description (required)  |               tv show description                |
| year (required)         |               Tv show release year               |
| category_ids (required) | list of category IDs associated with the tv show |
| actor_ids (required)    |  list of actor IDs associated with the tv show   |

### Season

-   POST _/api/tvshows/seasons_ <br/>
    Add a new tvshow season to the database. <br/>

##### Query parameters

| Parameters            |     Description     |
| --------------------- | :-----------------: |
| tv_show_id (required) |     Tv show ID      |
| year (required)       | Season release year |

### Episode

-   GET _/api/tvshows/{tv_id}/seasons/{season_number}/episodes/{episode_number}/_ <br/>
    Returns specific episode of a TV Show.

-   POST _/api/tvshows/seasons/{season_number}/episodes_ <br/>
    Add an episode to a season of a tv show

##### Query parameters

| Parameters              |                   Description                    |
| ----------------------- | :----------------------------------------------: |
| title (required)        |                  Episode title                   |
| description (required)  |               Episode description                |
| duration (required)     | Duration of the episode, for example: '0:40 hs'  |
| director_id (required)  |               Episode director id                |
| category_ids (required) | list of category IDs associated with the Episode |
| actor_ids (required)    |  list of actor IDs associated with the Episode   |

# Pending to do

-   More unit tests
-   Endpoints for retrieving Actors, Directors, and all episodes of a season.
-   Add images to movies, actors and directors.
-   Add more information to entities.

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

-   [Simple, fast routing engine](https://laravel.com/docs/routing).
-   [Powerful dependency injection container](https://laravel.com/docs/container).
-   Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
-   Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
-   Database agnostic [schema migrations](https://laravel.com/docs/migrations).
-   [Robust background job processing](https://laravel.com/docs/queues).
-   [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

-   **[Vehikl](https://vehikl.com/)**
-   **[Tighten Co.](https://tighten.co)**
-   **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
-   **[64 Robots](https://64robots.com)**
-   **[Cubet Techno Labs](https://cubettech.com)**
-   **[Cyber-Duck](https://cyber-duck.co.uk)**
-   **[Many](https://www.many.co.uk)**
-   **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
-   **[DevSquad](https://devsquad.com)**
-   **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
-   **[OP.GG](https://op.gg)**
-   **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
-   **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
