# E-commerce Project

## Overview

This project is a simple e-commerce platform built using the MVC architecture in PHP. It allows users to register, login, browse products, add products to the cart, and place orders. The application also provides features for managing categories and products.

## Features

### Admin Dashboard

- **Admin Authentication**: Admin users must authenticate before accessing the dashboard.
- **User Management**: Admins can view, add, update, and delete users.
- **Product Management**: Admins can manage products (add, read, edit, delete).
- **Category Management**: Admins can manage product categories (add, read, edit, delete).
- **Order Management**: Admins can view all orders and their details.

### User Interface

- **Product Browsing**: Users can browse products by category.
- **Shopping Cart**: Users can add products to the cart and proceed to checkout.
- **User Authentication**: Users can register, login, and logout.
- **Order Management**: Users can place orders and view your orders with details.

## Requirements

- PHP 8.x
- MySQL
- Git for version control

## Installation

1. **Clone the Repository**

   ```bash
   git clone https://github.com/bassemelshewy/PHP-MVC-Ecommerce.git
   
2. **Create a database in MySQL**

3. **Configure the database connection**

   - Open the `config/Database.php` file.
   - Update the database credentials:

   ```php
   private $host = 'localhost';
   private $dbName = 'p-ecommerce';
   private $username = 'root';
   private $password = '';

4. **Run the project on a local server**

   ```bash
   cd PHP-MVC-Ecommerce
   php -S localhost:8000

## Usage

### 1. User Registration & Authentication

- **Register**: New users can register by navigating to the registration page and providing required details such as username, email, and password.
- **Login**: Existing users can log in using their registered credentials.
- **Logout**: Users can log out of their accounts by clicking the logout button available on header.

### 2. Browsing Products

- **Homepage**: On the homepage, users will see featured products and can navigate to different categories for specific products.
- **Categories**: Users can browse products by category by clicking on a category name. This filters products displayed on the screen.
- **Product Details**: Clicking on a product will show the detailed view of the product with information such as name, description, price, and an option to add the product to the cart.

### 3. Shopping Cart

- **Add Products to Cart**: Users can add products to their shopping cart by clicking the "Add to Cart" button on a product's page.
- **View Cart**: Users can view their shopping cart by clicking on the cart icon or link in the navigation menu. This displays all added products with quantities, prices, and the option to remove products or update quantities.
- **Checkout**: To proceed with purchasing items, users can click the "Checkout" button. They will confirm the order.

### 4. Admin Panel

- **Admin Authentication**: Admin users must authenticate using admin credentials to access the admin dashboard.
- **Manage Users**: Admins can view, add, edit, or delete users. This is accessible from the "Users" section of the dashboard.
- **Manage Products**: Admins can add, update, or delete products. They can also view a list of all products and edit their details.
- **Manage Categories**: Admins can add new categories, edit existing categories, and delete categories that are no longer needed.
- **Blogs Management**: Admins can create, edit, and delete blog posts to engage users with news, updates, and articles.
- **Order Management**: Admins can view all orders placed by users. They can see the order details, status, and any associated user information.
- **Static pages Management**: Admins can create, edit, and delete static pages for the website, such as "About Us," "Contact Us," "Privacy Policy," etc.
- **Social media Management**: Admins can manage social media links and integrations, such as adding, editing, or removing social media icons and links displayed on the site.

### 5. Order Management for Users

- **View Orders**: Logged-in users can view their past orders by navigating to the "Orders" section.
- **Order Details**: Clicking on an order shows the order's details, including the product(s) purchased, and total cost.


### URLs to Access Different Sections:

1. **Home Page**: http://localhost:8000/views/front/pages/home.php
2. **Admin Dashboard**: http://localhost:8000/views/dashboard/home.php
3. **User Registration**: http://localhost:8000/views/front/auth/register.php
4. **User Login**: http://localhost:8000/views/front/auth/login.php
5. **Categories page**: http://localhost:8000/views/front/pages/categories.php
5. **Products page**: http://localhost:8000/views/front/pages/categories.php
5. **Blogs page**: http://localhost:8000/views/front/pages/blogs.php
6. **Cart**: http://localhost:8000/views/front/pages/view_cart.php

