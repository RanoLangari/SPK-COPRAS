<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# COPRASS-APP Project

This project is an application for conducting assessments based on the Decision Support System using the COPRAS method. This application is built using the Laravel framework.


## How to Clone the Project

To clone this project, follow the steps below:

1. Open a terminal or command prompt.

2. Navigate to the directory where you want to save the project.

3. Run the following command to clone the repository:
   ```
   git clone https://github.com/RanoLangari/SPK-COPRAS.git
   ```

4. After the cloning process is complete, navigate to the project directory:
   ```
   cd coprass-app
   ```


## How to Run the Project

Follow the steps below to run the project:

1. Copy the `.env.example` file to `.env` and adjust the database and application configuration according to your needs:
   ```
   cp .env.example .env
   ```

2. Install all required dependencies using npm:
   ```
   npm install
   ```

3. Install all required dependencies using composer:
   ```
   composer install
   ```

4. Generate the application key:
   ```
   php artisan key:generate
   ```

5. Run migrations to create the database structure:
   ```
   php artisan migrate
   ```

6. (Optional) Run the seeder to populate the database with initial data:
   ```
   php artisan db:seed
   ```

7. Run Vite using the command:
   ```
   npm run dev
   ```

8. Run the Laravel development server using the command:
   ```
   php artisan serve
   ```

9. Open your browser and access the application through the URL provided by the development server (usually http://localhost:8000).


10. If you are using Laragon as your development environment, you can follow these steps:

   a. Ensure Laragon is installed and all services (Apache/Nginx, MySQL, PHP) are running.

   b. Clone your project repository into the `www` directory of Laragon using the command `git clone https://github.com/RanoLangari/SPK-COPRAS.git`.

   c. Open Laragon, right-click, select `Terminal`, and run the command `composer install` to install all necessary PHP dependencies and `npm install` to install all necessary JavaScript dependencies.

   d. Copy the `.env.example` file to `.env` and adjust the database and application configuration according to your needs. Be sure to set `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` according to the MySQL settings in Laragon.

   e. Open Laragon, right-click, and select `Start All` to start the MySQL service.

   f. Run the command `php artisan key:generate` to generate the application key.

   g. Run the command `php artisan migrate` to execute migrations and create the database structure.

   h. (Optional) Run the command `php artisan db:seed` to populate the database with initial data.

   i. Run the command `npm run dev` to compile JavaScript and CSS assets.

   j. Access the project through the browser with the URL provided by Laragon (usually http://your-project-name.test).
