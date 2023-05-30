# Users API in Laravel

This repository contains a Laravel project that implements a Users API. It provides endpoints to manage user data such as creating users, retrieving user details, updating user information, deleting users, as well as managing roles and permissions.

## Requirements

- PHP
- MySQL/MariaDB
- Composer

## Installation

install the required dependencies using Composer.

```bash
composer install
```

## Environment Configuration

Create a copy of the .env.example file and rename it to .env. Modify the file to provide the necessary configuration values.

```bash
cp .env.example .env
```

## Migrate and Seed the Database

Run the database migrations and seed the database with initial data using the following command:

```bash
php artisan migrate:fresh --seed
```

## Serve the API

you can start the server using the following command:

```bash
php artisan serve
```

## Database

You can find the database file [users.sql](users.sql) in the repository. This file contains the database schema and initial data.

## Postman

You can find the Postman collection file [postman.json](postman.json) in the repository. Import this file into your Postman application to access pre-configured requests for testing the Users API.
