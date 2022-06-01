<div align="center">

![FindAPR](https://findapr.io/images/findapr.svg)

</div>

This is the official repository for [Find A PR](https://findapr.io/). Find A PR is a platform that curates a list of issues for Laravel-based repositories to help developers find projects to make their first open-source contributions to.

## Requirements

The following tools are required in order to start the installation and run the project locally.

- PHP 8.1
- [Composer](https://getcomposer.org/download/)
- [Valet](https://laravel.com/docs/valet#installation)

## Installation
Here is how you can run the project locally:
1. Clone this repo
    ```sh
    git clone https://github.com/ash-jc-allen/find-a-pr.git
    ```
2. Go into the project root directory
    ```sh
    cd find-a-pr
    ```
3. Copy .env.example file to .env file
    ```sh
    cp .env.example .env
    ```
4. Create database `find_a_pr` (you can change database name)

5. Go to `.env` file 
    - set database credentials (`DB_DATABASE=find_a_pr`, `DB_USERNAME=root`, `DB_PASSWORD=`)
    > Make sure to follow your database username and password

6. Install PHP dependencies 
    ```sh
    composer install
    ```
7. Generate app key 
    ```sh
    php artisan key:generate
    ```
8. Install NPM dependencies
    ```sh
    npm install
    ```
8. Build assets using NPM
    ```sh
    npm run dev
    ```
10. Run server 
     ```sh
     php artisan serve
     ``` 

