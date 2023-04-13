## Technologies

This project is created using:

 - Laravel 10.0
 - Vue.js 3.2

## Setup

### Laravel Sail

The easiest way for running this project locally is using laravel sail.
In order to use laravel sail you need to make sure that Docker is installed on your system.

You can read more about laravel sail in official docs: [Laravel Sail Docs](https://laravel.com/docs/9.x/sail)

**1. Clone the repo using:**
   ```sh
   git clone https://github.com/pawniko/menu-test.git 
   ```
**2. Configure the environment**

Copy the .env.example file to .env by running the following command:

   ```sh
   cp .env.example .env
   ```

Then, update the variables in the .env file according to your setup. You can also use provided sample and update it.

**3. Generate an application key**

Generate an application key by running the following command:

   ```sh
php artisan key:generate
   ```

**4. Install dependencies**

Navigate to the project directory and run the following command to install the dependencies:

   ```sh
composer install
   ```

**5. Create the database**

Create a new database for the project and update the database settings in the .env file.

**6. Run database migrations and seeders**

Run the database migrations to create the necessary tables in the database by running the following command:

```sh
  php artisan migrate --seed
```

**7. Install npm dependencies**

```sh
npm install
npm run dev
```
After installation you should be able to open main page on: http://localhost

## Additional Info

### Update exchange rates

Exchange rates are automatically updated daily using CurrencyLayer API, but you can also run following command manually:

```sh
php artisan update:exchage_rates
```

If you want to execute this command more often, you can change it:
```sh
App/Console/Kernel.php

$schedule->command('update:exchange_rates')->daily();
```

### API docs

API endpoints are documented using L5-swagger package. You can check it on:

```sh
http://localhost/api/documentation
```

### Unit test

The most important calculate() function from OrderService is covered by unit test which can be run with following command:

```sh
php artisan test --filter OrderCalculationTest
```
