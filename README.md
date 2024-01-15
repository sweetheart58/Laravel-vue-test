## Installation

1. Install PHP dependencies:

```sh
composer install
```
or
```sh
composer install --ignore-platform-req=ext-gd
```

2. Install NPM dependencies:

```sh
npm ci
```

3. Build assets:

```sh
npm run dev
```

4. Generate application key:

```sh
php artisan key:generate
```

5. Setup configuration:

```sh
cp .env.example .env
```

6. Configure the database connection in the .env file.

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel-test
DB_USERNAME=root
DB_PASSWORD=
```

7. Run the database migrations.

```shell
php artisan migrate
```

8. Seed the database with sample data.

```shell
php artisan db:seed
```

## Usage

9. To run the application, start the Laravel development server.

```shell
php artisan serve
```

Then, navigate to http://localhost:8000 in your web browser to view the application.

## Running tests

```
php artisan test
```
