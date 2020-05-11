# Fororum

[![StyleCI](https://github.styleci.io/repos/134251696/shield?style=square)](https://github.styleci.io/repos/134251696)
[![MITLicense](https://img.shields.io/badge/License-MIT-yellow.svg)](https://github.com/trhgquan/Fororum/blob/master/LICENSE)

_Forum creavit cum Laravel_

[What is Fororum](#what-is-fororum-anyway) | [Installation](#installation) | [Authors](#authors) | [License](#license)

# What is Fororum, anyway?
An open-source Forum project made with Laravel. _Fororum_ in Latin means _Forums_.

This project also had a very-long-time-ago-and-simplest-as-i-could-thought name: _MyApp_.

## Why Fororum?
- Easy to install (which is not correct when you do not know what is Composer).
- SEO Friendly
- Fully-support admin in managing users and forum posts.

# Installation
## Requirements:
- PHP >= 7.3
- Composer (for installing support packages).

## How-to:

Follow these guides to install Fororum on your server:

1. Execute a `git-clone` this project: `git clone https://github.com/trhgquan/Fororum.git`.

2. Run `composer install` to install components.

3. Rename `.env.example` to `.env`. This is the enviromental configuration for your Fororum install.
    - Update `DB_HOST` with your databse host (usually `localhost`).
    - Update `DB_USERNAME` with your database username.
    - Update `DB_PASSWORD` with your database password.

4. Generate `APP_KEY`: `php artisan key:generate`.

5. Migrate database tables: `php artisan migrate`.

6. Install default administrator account: `php artisan db:seed`.  

# Authors
|Author              |GitHub                                    |
|--------------------|------------------------------------------|
|**Quan, Tran Hoang**|[@trhgquan](https://github.com/trhgquan)  |
|**me_a_doge**       |[@meadoge](https://github.com/meadoge)    |
|**Hwang S. Wan**    |[@hwangswan](https://github.com/hwangswan)|

# LICENSE
__Fororum is licensed under the MIT License__. [view LICENSE](https://github.com/trhgquan/Fororum/blob/master/LICENSE).

# Built with
* [Laravel](https://laravel.com) newest version of Laravel - The Framework for web artisans by Taylor Otwell
* [Bootstrap](https://getbootstrap.com) Bootstrap 3.3.7
