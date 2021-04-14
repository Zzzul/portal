# PORTAL
Event and online booking.

## What inside?
-   Laravel ^8.x - [laravel.com/docs/8.x](https://laravel.com/docs/8.x)
-   Laravel UI ^3.x - [laravel-ui](https://github.com/laravel/ui/tree/3.x)
-   Fortify ^1.x - [laravel-fortify](https://github.com/laravel/fortify)

## Users
- Email: admin@gmail.com
- Password: password
- Roles: admin
- Permissions: all permissions 
---
- Email: organizer@gmail.com
- Password: password
- Roles: organizer
- Permissions: CRUD events, CRUD performesr, event booking, event histroy, check payment, update payment, setting
---
- Email: audience@gmail.com
- Password: password
- Roles: audience
- Permissions: event booking, event histroy, setting

## Features

- CRUD Performer
- CRUD Category
- Event
    - CRUD Event
    - Event History
    - Event Book
- User
   - Index User
    - Edit User
    - Update User
- Setting
    - Profile information
    - Change Password
    - Two Factor Authentication



## What next?
After clone or download this repository, next step is install all dependency required by laravel.

```shell
# install composer-dependency
$ composer install

# install npm package
$ npm install

# build dev
$ npm run dev
```

Before start web server make sure you already generate app key, configure `.env` file and do migration.

```shell
# create copy of .env
$ cp .env.example .env

# create laravel key
$ php artisan key:generate

# laravel migrate
$ php artisan migrate

# start local server
$ php artisan serve
```
