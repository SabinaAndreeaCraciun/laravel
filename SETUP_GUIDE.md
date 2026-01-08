# Student Management System

A comprehensive Laravel 12 application for managing students, courses, and their enrollments with authentication and API support.

## Features

### Web Application
- **User Authentication**: Manual user registration and login (no starter kits)
- **Student Management**: Full CRUD operations for students
- **Course Management**: Full CRUD operations for courses
- **Student-Course Assignment**: Assign students to courses (one student can be in zero or one course)
- **CSV Export**: Export students, courses, and enrolled students to CSV files
- **Responsive UI**: Built with Bootstrap 5

### REST API
- **Sanctum Authentication**: Token-based API authentication
- **Student API**: Full REST endpoints for student management
- **Course API**: Full REST endpoints for course management
- **CSV Export API**: Export data to CSV via API endpoints

## Technology Stack

- **Framework**: Laravel 12
- **Authentication**: Session-based (web) + Laravel Sanctum (API)
- **Database**: SQLite (default) or your configured database
- **Frontend**: Bootstrap 5
- **API Documentation**: Postman collection included

## Project Structure

```
project-root/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php         # Manual authentication
│   │   │   ├── StudentController.php      # Student CRUD
│   │   │   ├── CourseController.php       # Course CRUD
│   │   │   └── Api/
│   │   │       ├── AuthController.php     # API authentication
│   │   │       ├── StudentApiController.php
│   │   │       └── CourseApiController.php
│   └── Models/
│       ├── User.php
│       ├── Student.php
│       └── Course.php
├── database/
│   ├── migrations/
│   │   ├── *_create_users_table.php
│   │   ├── *_create_students_table.php
│   │   ├── *_create_courses_table.php
│   │   └── *_create_personal_access_tokens_table.php
│   └── factories/
├── routes/
│   ├── web.php      # Web routes with authentication middleware
│   └── api.php      # API routes with Sanctum middleware
├── resources/views/
│   ├── auth/        # Login and register views
│   ├── students/    # Student CRUD views
│   ├── courses/     # Course CRUD views
│   ├── app.blade.php
│   ├── welcome.blade.php
│   └── dashboard.blade.php
└── Student_Management_API.postman_collection.json
```

## Installation

1. **Clone and Install Dependencies**
   ```bash
   cd /home/sabina/laravel/prova
   composer install
   ```

2. **Setup Environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Database Setup**
   ```bash
   php artisan migrate
   ```

4. **Install API Scaffolding (if not already done)**
   ```bash
   php artisan install:api
   ```

## Running the Application

### Start Development Server
```bash
php artisan serve
```

The application will be available at `http://127.0.0.1:8000`

## Web Application Usage

### 1. Registration and Login
- Go to `http://127.0.0.1:8000/register` to create a new account
- Login at `http://127.0.0.1:8000/login`
- You'll be redirected to the dashboard after successful login

### 2. Manage Students
- Navigate to **Students** from the main menu
- **View Students**: See all registered students with their course assignments
- **Create Student**: Click "Create Student" button to add a new student
- **Edit Student**: Click edit icon to modify student information
- **Delete Student**: Click delete button to remove a student
- **Export to CSV**: Click "Export CSV" button to download all students data

### 3. Manage Courses
- Navigate to **Courses** from the main menu
- **View Courses**: See all courses with student count
- **Create Course**: Click "Create Course" button to add a new course
- **Edit Course**: Click edit icon to modify course information
- **Delete Course**: Click delete button to remove a course
- **Export to CSV**: Click "Export CSV" button to download all courses with enrolled students

## API Documentation

### Authentication Endpoints

#### Register
```
POST /api/register
Content-Type: application/json

{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}

Response:
{
  "success": true,
  "message": "User registered successfully",
  "user": { ... },
  "token": "YOUR_API_TOKEN"
}
```

#### Login
```
POST /api/login
Content-Type: application/json

{
  "email": "john@example.com",
  "password": "password123"
}

Response:
{
  "success": true,
  "message": "Login successful",
  "user": { ... },
  "token": "YOUR_API_TOKEN"
}
```

### Using API Endpoints

All API endpoints (except register and login) require authentication:

```
Authorization: Bearer YOUR_API_TOKEN
Accept: application/json
```

### Students Endpoints

#### List Students
```
GET /api/students?page=1
```

#### Create Student
```
POST /api/students
Content-Type: application/json

{
  "first_name": "Jane",
  "last_name": "Smith",
  "email": "jane@example.com",
  "course_id": 1
}
```

#### Get Student Details
```
GET /api/students/{id}
```

#### Update Student
```
PUT /api/students/{id}
Content-Type: application/json

{
  "first_name": "Jane",
  "last_name": "Doe",
  "email": "jane.doe@example.com",
  "course_id": 2
}
```

#### Delete Student
```
DELETE /api/students/{id}
```

#### Export Students to CSV
```
GET /api/students/export
```

### Courses Endpoints

#### List Courses
```
GET /api/courses?page=1
```

#### Create Course
```
POST /api/courses
Content-Type: application/json

{
  "name": "Introduction to Computer Science",
  "description": "Learn the basics of computer science"
}
```

#### Get Course Details
```
GET /api/courses/{id}
```

#### Update Course
```
PUT /api/courses/{id}
Content-Type: application/json

{
  "name": "Advanced Computer Science",
  "description": "Advanced topics in computer science"
}
```

#### Delete Course
```
DELETE /api/courses/{id}
```

#### Export Courses to CSV
```
GET /api/courses/export
```

## Postman Collection

A Postman collection is included (`Student_Management_API.postman_collection.json`) for easy API testing.

### How to Import in Postman

1. Open Postman
2. Click "Import" button
3. Select "Student_Management_API.postman_collection.json" file
4. The collection will be imported with all endpoints

### Using the Collection

1. **Register a New User**
   - Go to Authentication → Register
   - Update the request body with your details
   - Send the request and copy the token from the response

2. **Login**
   - Go to Authentication → Login
   - Update the credentials
   - Copy the token from the response

3. **Update Token in Requests**
   - In each request that requires authentication, replace `YOUR_TOKEN_HERE` with the actual token
   - Or set a Postman variable for the token to use across all requests

## Database Schema

### Users Table
```sql
- id (primary key)
- name
- email (unique)
- password
- email_verified_at
- remember_token
- created_at
- updated_at
```

### Students Table
```sql
- id (primary key)
- first_name
- last_name
- email (unique)
- course_id (foreign key, nullable)
- created_at
- updated_at
```

### Courses Table
```sql
- id (primary key)
- name (unique)
- description (nullable)
- created_at
- updated_at
```

### Personal Access Tokens Table (Sanctum)
```sql
- id (primary key)
- tokenable_type
- tokenable_id
- name
- token (unique)
- abilities
- last_used_at
- expires_at
- created_at
- updated_at
```

## CSV Export Format

### Students CSV
Columns: ID, First Name, Last Name, Email, Course, Created At, Updated At

### Courses CSV
Columns: ID, Name, Description, Students Count, Students, Created At, Updated At

## Important Notes

1. **One-to-Many Relationship**: A student can be enrolled in **only one course** at a time
2. **Soft Deletes**: Not currently implemented; deletions are permanent
3. **Authorization**: The application doesn't have role-based access control; all authenticated users have full access
4. **CORS**: API doesn't have CORS configuration; configure as needed for cross-origin requests

## Troubleshooting

### Port 8000 Already in Use
```bash
php artisan serve --port=8001
```

### Database Connection Issues
Check your `.env` file and ensure database credentials are correct

### API Token Not Working
- Ensure the token is passed with `Bearer` prefix
- Check that the token hasn't expired
- Verify the user exists in the database

## Development Tips

### Create Test Data
```bash
php artisan tinker
```

Then in tinker:
```php
$user = App\Models\User::factory()->create();
$course = App\Models\Course::create(['name' => 'Test Course', 'description' => 'Test']);
$student = App\Models\Student::create(['first_name' => 'John', 'last_name' => 'Doe', 'email' => 'john@test.com', 'course_id' => 1]);
```

### Run Tests
```bash
php artisan test
```

## Security Considerations

1. **Password Hashing**: Passwords are hashed using bcrypt
2. **CSRF Protection**: Enabled for web forms
3. **SQL Injection**: Protected by Laravel's query builder and ORM
4. **Token Expiration**: Sanctum tokens are long-lived by default
5. **Rate Limiting**: Not configured; recommended for production

## License

This project is open source and available under the MIT License.

## Support

For issues or questions, please check the Laravel documentation at https://laravel.com/docs/12.x
