# Library Management API

This is a RESTful API for a Library Management System built with Laravel. The API allows users to manage books, authors, and borrowing/returning records. It supports different roles such as Admin, Librarian, and Member, each with specific permissions.

## Features

- **Authentication**: Users can login, receive role-based tokens (`Admin`, `Librarian`, `Member`), and make requests based on their roles.
- **Book Management**: CRUD operations for books (create, view, update, delete) based on user roles.
- **Author Management**: CRUD operations for authors.
- **Borrow & Return Books**: Members can borrow and return books, with availability status updated automatically.
- **Search Books**: Search for books by title, author, or ISBN.
- **Role-Based Access**: Admins, Librarians, and Members have different permissions.

## Technologies

- **Backend**: Laravel 11, Sanctum for API token authentication.
- **Database**: MySQL.
- **Middleware**: Role-based access control.

## Setup Instructions

### Prerequisites

- PHP 8.0+
- Composer
- MySQL 
- Postman (for testing API requests)

### Installation

1. **Clone the repository**:
   ```bash
   git clone https://github.com/Casmir293/Library-Management-System.git
   cd Library-Management-System

2. **Install dependencies**:
    ```bash
    composer install

3. **Set up environment**:

- Duplicate the .env.example file and rename it to .env.
- Set your database credentials and other necessary environment variables.

4. **Generate application key**:
    ```bash
    php artisan key:generate

5. **Run migrations**:
    ```bash
    php artisan migrate

6. **Seed the database**(optional):
    ```bash
    php artisan db:seed

7. **Run the development server**:
    ```bash
    php artisan serve

## API Endpoints

| Method | Endpoint                      | Description              | Role                |
| -------| ----------------------------- | ------------------------ | ------------------- |
| GET    | `/api/v1/books`               | Fetch all books          | All (Authenticated) |
| POST   | `/api/v1/books`               | Create a book            | Admin, Librarian    |
| POST   | `/api/v1/books/{id}/borrow`   | Borrow a book            | Member              |
| POST   | `/api/v1/books/{id}/return`   | Return a book            | Member              |
| GET    | `/api/v1/books/{id}`          | Fetch a book             | All (Authenticated) |
| PUT    | `/api/v1/books/{id}`          | Update a book            | Admin, Librarian    |
| DELETE | `/api/v1/books/{id}`          | Delete a book            | Admin               |
| GET    | `/api/v1/authors`             | Fetch all authors        | All (Authenticated) |
| POST   | `/api/v1/authors`             | Create an author         | Admin, Librarian    |
| GET    | `/api/v1/authors/{id}`        | Fetch an author          | All (Authenticated) |
| PUT    | `/api/v1/authors/{id}`        | Update an author         | Admin, Librarian    |
| DELETE | `/api/v1/authors/{id}`        | Delete an author         | Admin               |
| GET    | `/api/v1/borrow-records`      | Fetch all borrowed books | Admin, Librarian    |
| GET    | `/api/v1/borrow-records/{id}` | Fetch a borrowed book    | Admin, Librarian    |
| GET    | `/api/v1/users`               | Fetch all users          | Admin, Librarian    |
| GET    | `/api/v1/users/{id}`          | Fetch single user        | Admin               |
| PUT    | `/api/v1/users/{id}`          | Update a user            | Admin, Self         |
| DELETE | `/api/v1/users/{id}`          | Delete a user            | Admin               |
| POST   | `/api/v1/users`               | Create a user            | -                   |
| POST   | `/api/v1/logout`              | logout a user            | All (Authenticated) |
| POST   | `/api/v1/login`               | login a user             | -                   |

## Role-Based Access Control

- **Admin**: Can manage all users, books, and authors.
- **Librarian**: Can manage books and authors.
- **Member**: Can borrow and return books.

## Postman Testing

You can use Postman to test the API endpoints. Make sure to include the token in the Authorization header as a Bearer token for authenticated requests.