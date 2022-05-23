## About Find A PR
Find A PR is a platform that curates issues around Laravel based project.
## Installation
Here is how you can run the project locally:
1. Clone this repo
    ```sh
    git clone https://github.com/ash-jc-allen/find-a-pr.git
    ```
1. Go into the project root directory
    ```sh
    cd find-a-pr
    ```
1. Copy .env.example file to .env file
    ```sh
    cp .env.example .env
    ```
1. Create database `find_a_pr` (you can change database name)

1. Go to `.env` file 
    - set database credentials (`DB_DATABASE=find_a_pr`, `DB_USERNAME=root`, `DB_PASSWORD=`)
    > Make sure to follow your database username and password

1. Install PHP dependencies 
    ```sh
    composer install
    ```
1. Generate app key 
    ```sh
    php artisan key:generate
    ```
1. Run migration
    ```
    php artisan migrate
    ```
1. Run server 
    ```sh
    php artisan serve
    ``` 
