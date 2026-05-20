# PGRKAM – Smart Employment Guidance Portal

Punjab Government's centralized employment portal that connects job seekers with government & private opportunities, skill training, resume tools, and career counselling.

---

## Tech Stack

| Layer     | Technology                               |
|-----------|------------------------------------------|
| Frontend  | React 18 · Vite · Tailwind CSS 3 · Axios |
| Backend   | Laravel 12 · PHP 8.2 · Sanctum (tokens)  |
| Database  | MySQL 8                                   |
| Auth      | Laravel Sanctum (Bearer token, SPA-ready) |

---

## Quick Start

### Prerequisites

- Node.js 18+
- PHP 8.2+ with Composer
- MySQL 8

---

### 1. Clone & enter the project

```bash
git clone <repo-url>
cd PGRKAM
```

---

### 2. Backend Setup (Laravel)

```bash
cd backend

# Install PHP dependencies
composer install

# Copy and configure environment
cp .env.example .env
php artisan key:generate
```

Edit `.env` and set your database credentials:

```env
DB_DATABASE=pgrkam_db
DB_USERNAME=root
DB_PASSWORD=your_password
```

```bash
# Create the database (MySQL)
mysql -u root -p -e "CREATE DATABASE pgrkam_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Run migrations and seed demo data
php artisan migrate --seed

# (Optional) Generate Sanctum link
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"

# Start the API server
php artisan serve
# → running at http://localhost:8000
```

---

### 3. Frontend Setup (React + Vite)

```bash
cd ../frontend

# Install Node dependencies
npm install

# Start the dev server
npm run dev
# → running at http://localhost:3000
```

---

### 4. Demo Credentials

| Role  | Email                    | Password |
|-------|--------------------------|----------|
| Admin | admin@pgrkam.gov.in      | password |
| User  | user@pgrkam.gov.in       | password |

---

## Features

### Public Pages
- **Home** – Hero section, service overview, AI-powered smart search
- **Jobs** – Searchable & filterable government and private job listings
- **Training** – Skill development programs with seat availability
- **Services** – All portal services at a glance
- **About / Contact**

### Authenticated User Features
- **Dashboard** – Stats overview, recent jobs, quick actions
- **Resume Builder** – Multi-section resume (education, experience, skills) with PDF download
- **Career Counselling** – Book sessions with certified career counsellors
- **Smart Guidance Widget (QueryBox)** – Floating AI chat to route queries to the right module

### Admin Panel
- **Admin Dashboard** – Live stats (users, jobs, training, counselling)
- **User Management** – List, search, delete users
- **Reports** – Registration trends, job type breakdown, training enrollment

---

## Project Structure

```
PGRKAM/
├── frontend/
│   ├── src/
│   │   ├── api/           # Axios instance + all API call functions
│   │   ├── components/    # Navbar, Sidebar, Footer, QueryBox, etc.
│   │   ├── context/       # AuthContext (global auth state)
│   │   ├── layouts/       # MainLayout, DashboardLayout
│   │   ├── pages/         # All route pages
│   │   ├── routes/        # AppRoutes (lazy-loaded), route guards
│   │   └── utils/         # helpers.js (dummy data, smart guidance logic)
│   ├── index.html
│   ├── package.json
│   ├── tailwind.config.js
│   └── vite.config.js
│
└── backend/
    ├── app/
    │   ├── Http/
    │   │   ├── Controllers/Api/   # AuthController, UserController, JobController,
    │   │   │                      # TrainingController, ServiceController,
    │   │   │                      # ChatGuideController, CounsellingController,
    │   │   │                      # AdminController
    │   │   └── Middleware/        # RoleMiddleware (role:admin)
    │   └── Models/                # User, Job, Training, Service,
    │                              # CounsellingRequest, Resume, Notification
    ├── bootstrap/app.php          # Middleware aliases registered here
    ├── database/
    │   ├── migrations/            # 7 migration files (users → notifications)
    │   └── seeders/               # DatabaseSeeder (demo users, jobs, trainings)
    └── routes/api.php             # All REST API routes
```

---

## API Overview

| Method | Endpoint                        | Auth       | Description                     |
|--------|---------------------------------|------------|---------------------------------|
| POST   | /api/register                   | Public     | Register new user               |
| POST   | /api/login                      | Public     | Login, returns token            |
| POST   | /api/logout                     | Bearer     | Invalidate token                |
| GET    | /api/services                   | Public     | List all services               |
| GET    | /api/jobs                       | Public     | Job listings with filters       |
| GET    | /api/training                   | Public     | Training programs               |
| POST   | /api/chat-guide                 | Public     | Smart guidance keyword match    |
| GET    | /api/user/profile               | Bearer     | Authenticated user profile      |
| POST   | /api/training/{id}/enroll       | Bearer     | Enroll in training program      |
| POST   | /api/jobs/{id}/apply            | Bearer     | Apply to a job                  |
| GET    | /api/user/resume                | Bearer     | Fetch resume                    |
| POST   | /api/user/resume                | Bearer     | Save/update resume              |
| POST   | /api/counselling                | Bearer     | Book counselling session        |
| GET    | /api/admin/dashboard            | Admin      | Admin stats                     |
| GET    | /api/admin/users                | Admin      | All users                       |
| DELETE | /api/admin/users/{id}           | Admin      | Delete user                     |
| GET    | /api/admin/reports              | Admin      | Analytics data                  |

---

## Build for Production

```bash
# Frontend
cd frontend
npm run build        # outputs to frontend/dist/

# Backend
cd backend
php artisan config:cache
php artisan route:cache
php artisan optimize
```
