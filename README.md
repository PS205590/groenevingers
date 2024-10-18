# Laravel Project for Groenevingers

This project is a Laravel-based web application developed in collaboration with students. It consists of two major components:

## Frontend: Website & Shop

**Description**:  
The frontend of the project is a fully functional website and e-commerce shop designed for Groenevingers. It allows users to browse, search, and purchase products related to gardening, plants, and more. The website offers a user-friendly interface, responsive design, and intuitive navigation to ensure a smooth shopping experience.

### Features:
- **Product Catalog**: Display a list of available products with images, descriptions, and prices.
- **Search & Filtering**: Users can search for products and filter them based on categories, price ranges, etc.
- **Product Details**: Each product has a dedicated page with detailed information, reviews, and related products.
- **Shopping Cart**: Users can add products to their cart, view the cart, and proceed to checkout.
- **User Authentication**: Customers can register and log in to view their order history, save addresses, and manage their profiles.
- **Order Management**: Users can place orders, select shipping options, and receive confirmation emails.
- **Payment Integration**: Secure payment gateways to handle transactions (e.g., Stripe, PayPal, etc.).
- **Blog**: A section for blog posts about gardening tips, product updates, and more.

---

## Backend: API

**Description**:  
The backend of the project is an API designed to serve product and information data to both the frontend and external applications. It handles all CRUD (Create, Read, Update, Delete) operations related to the website's content and shop functionality.

### Features:
- **API Endpoints**:
  - **Product Information**: API endpoints to retrieve product data, including name, description, price, and stock status.
  - **User Management**: Endpoints to handle user registration, login, and profile updates.
  - **Order Processing**: API for managing orders, including creating new orders, updating order statuses, and retrieving order details.
  - **Blog Management**: Endpoints to manage blog posts (create, edit, delete, and retrieve).
  - **Product Search**: API to support product search functionality.
- **Admin Dashboard**: Backend admin interface for managing the website, including product listings, blog posts, orders, and user accounts.
- **Authentication**: Utilizes Laravel's built-in authentication and API token system to secure endpoints.
- **Database Management**: The backend handles all database interactions using Laravel's Eloquent ORM, ensuring data consistency and integrity.

---

## Setup Instructions (Frontend & Backend)

To set up and run the Laravel project, follow the instructions below to install the necessary dependencies and serve both the frontend and backend.

### 1. Install Dependencies:

Run the following command to install the dependencies for both the frontend and backend:

```bash
composer install
```

### 2. Serve the application

Run the following command to serve the applications

```bash
php artisan serve
```
