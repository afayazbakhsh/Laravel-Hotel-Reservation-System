# Laravel Hotel Reservation System

A free REST API program for hotel reservation, powered by Laravel. This project is designed to work similarly to the hotel reservation section on www.alibaba.ir

## Features

    Database design based on host and hotel management
    Management of the application using laravel-admin
    Authentication using Sanctum
    Storage of files in cloud storage

## Packages Used

### This project uses the following packages:

    horizon
    telescope
    flysystem-aws
    phpspreadsheet
    spatie-medialibrary

### Installation

    Clone the repository:
    git clone https://github.com/YOUR_USERNAME/laravel-hotel-reservation-system.git

    Navigate to the project directory:
    cd laravel-hotel-reservation-system

    Install dependencies:
    composer install

    Set up environment variables:
    cp .env.example .env and configure your environment variables in the .env file 
    Generate a key:
    php artisan key:generate 

    Run the migrations and seed:
    php artisan migrate --seed

    Start the development server: 
    php artisan serve
     

## Contributing

    Fork the repository
    Create a new branch for your changes (git checkout -b my-new-feature)
    Commit your changes (git commit -am 'Add my new feature')
    Push to the branch (git push origin my-new-feature)
    Create a new Pull Request


