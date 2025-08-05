# Leave Management System API

This is a PHP RESTful API for managing users, departments, leave requests, feedback, and reports in a leave management system.

## Requirements

- PHP 7.2 or higher (with `pdo_mysql` extension enabled)
- Composer
- MySQL database

## Setup

1. **Clone the repository**  
   ```
   git clone <your-repo-url>
   cd Leave-Management/api
   ```

2. **Install dependencies**  
   ```
   composer install
   ```

3. **Configure environment variables**  
   Edit the `.env` file with your database credentials:
   ```
   DB_HOST=localhost
   DB_PORT=3306
   DB_DATABASE=leave_management_system
   DB_USERNAME=root
   DB_PASSWORD=admin
   ```

4. **Enable PHP extensions**  
   Make sure `pdo_mysql` is enabled in your `php.ini`:
   ```
   extension=pdo_mysql
   ```

5. **Start the API server**  
   ```
   php -S localhost:8000
   ```
   or, if your entry point is in the `api` subfolder:
   ```
   php -S localhost:8000 -t api
   ```

## API Endpoints

| Resource      | Example Endpoint                        | Description                |
|---------------|----------------------------------------|----------------------------|
| Users         | `GET /user`, `GET /user/{id}`          | List users, get user info  |
| Departments   | `GET /department`, `GET /department/{id}` | List departments           |
| Login         | `POST /login`                          | User login                 |
| Utility       | `GET /utility/{type}`                  | Utility functions          |
| Feedback      | `GET /feedback/{type}/{id}`            | Feedback operations        |
| Email         | `POST /email/{id}`                     | Email operations           |
| Leave         | `GET /leave/{type}/{id}`               | Leave management           |
| Report        | `GET /report/{type}/{id}`              | Reporting                  |

- All endpoints are relative to `http://localhost:8000/api/`.

## Notes

- Make sure your MySQL database and tables are set up as expected.
- If you see `could not find driver`, enable `pdo_mysql` in your `php.ini`.
- For CORS, the API allows requests from `http://localhost:3000`.

## Troubleshooting

- **Deprecation Warnings:** Update your PHP version and dependencies, or suppress deprecated warnings in `index.php`:
  ```php
  error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);
  ```
- **Database Connection Issues:** Check your `.env` and ensure the database is running.

## License

MIT
