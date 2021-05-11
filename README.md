## APP Setup

1. Setup MYSQL, PHP, Composer
    * MYSQL 8
    * PHP 7.4
    * Composer 2
1. Go to root directory and run the ff:
    * `composer install`
    * `php artisan migrate`
1. Create `.env.local` on root folder  check `.env.example` for reference
1. Setup DATABASE Configuration on `.env.local` located on root folder
1. To migrate data from `developer.marvel.com`:
    * `php artisan api-marvel:migrate`
1. to run API - `php artisan serve`
1. Make sure to have the right file permissions specially on the API when running it via `php artisan serve`

If you have more questions kindly email me @ ziegfrid.gualberto@gmail.com
