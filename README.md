# Laravel Project README

## Project Overview

This Laravel project implements a CRUD (Create, Read, Update, Delete) application for managing products with image uploading using AJAX. It includes features for handling product variants dynamically.

## Features

- CRUD operations for products
- Image uploading using AJAX
- Dynamic handling of product variants (size, color)

## Installation

1. **Clone the repository:**

   ```bash
   git clone https://github.com/vishnusomanus/products.git
   cd products
   
1. **Install Composer dependencies:**

    ```
    composer install
    ```


1. **Generate application key:**

    ```
    php artisan key:generate
    ```

1. **Configure the database:***

    Update .env file with your database credentials.
    
    Run database migrations and seeders:
    
    ```
    php artisan migrate --seed
    ```

1. **Install npm dependencies:**

    ```
    npm install
    ```

1. **Compile assets:**

    ```
    npm run dev
    ```
## Usage
* Access the application in your web browser.
* Navigate to /products to manage products.
* Use the CRUD operations to add, edit, view, and delete products.
* Upload images for products with AJAX support.
* Manage product variants dynamically.
## Technologies Used
* Laravel
* PHP
* MySQL (or your preferred database)
* JavaScript (Ajax for image uploading)
* Bootstrap (for styling)
## Contributing
Contributions are welcome. Please fork the repository and submit pull requests.


