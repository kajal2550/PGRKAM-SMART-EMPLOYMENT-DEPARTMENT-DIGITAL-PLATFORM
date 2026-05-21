<div align="center">

# 🏛️ PGRKAM
### Punjab Government Rozgar te Karobar Assistance Mission
#### Smart Employment Guidance System

![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![React](https://img.shields.io/badge/React-18-61DAFB?style=for-the-badge&logo=react&logoColor=black)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-5-646CFF?style=for-the-badge&logo=vite&logoColor=white)
![SQLite](https://img.shields.io/badge/SQLite-3-003B57?style=for-the-badge&logo=sqlite&logoColor=white)

**Punjab Government's centralized employment platform connecting job seekers with government & private job opportunities, skill training programs, professional resume tools, and career counselling services.**

[🌐 Live Demo](#demo-credentials) · [📖 API Docs](#api-overview) · [🚀 Quick Start](#quick-start) · [✨ Features](#features)

</div>

---

## 📋 Table of Contents

- [Overview](#overview)
- [Tech Stack](#tech-stack)
- [Features](#features)
- [Project Structure](#project-structure)
- [Quick Start](#quick-start)
- [Demo Credentials](#demo-credentials)
- [API Overview](#api-overview)
- [Database Schema](#database-schema)
- [Build for Production](#build-for-production)
- [Environment Variables](#environment-variables)

---

## 🎯 Overview

PGRKAM is a full-stack web application built for the **Punjab Government** to help unemployed youth find jobs, enroll in skill development training, build professional resumes, and connect with career counsellors — all in one place.

### Key Highlights
- 🔵 **54 Job Listings** (27 Government + 27 Private sector)
- 🎓 **27 Training Programs** (IT, Electrical, Marketing, Handcraft, Communication)
- 🛠️ **12 Govt Services** accessible through the portal
- 📄 **8-Section Resume Builder** with HTML/PDF export
- 🔐 **Role-based access** — Separate User and Admin dashboards
- 📱 **Fully responsive** — Works on mobile, tablet, desktop

---

## 🛠️ Tech Stack

| Layer      | Technology                                              |
|------------|---------------------------------------------------------|
| Frontend   | React 18 · Vite 5 · Tailwind CSS 3 · React Router v6   |
| Backend    | Laravel 12 · PHP 8.2 · Laravel Sanctum (Bearer tokens) |
| Database   | SQLite (dev) · MySQL 8 (production-ready)               |
| HTTP       | Axios · Vite Proxy (`/api` → `localhost:8000`)          |
| UI         | react-icons · react-hot-toast · Custom glass morphism   |
| Auth       | Sanctum SPA token auth · localStorage persistence       |

---

## ✨ Features

### 🌐 Public Pages (No Login Required)
| Page | Description |
|------|-------------|
| **Home** | Hero section, animated stats, service overview, smart search |
| **Jobs** | 54 job listings with search, filters (Govt/Private/All), location filter, skeleton loading |
| **Training** | 27 skill programs with enrollment, seat availability, category filters |
| **Services** | 12 government services with eligibility info |
| **About** | Portal mission, stats, team info |
| **Contact** | Contact form with address, map info |

### 🔐 Authenticated User Features
| Feature | Description |
|---------|-------------|
| **Dashboard** | Personalized greeting, stats cards, recent jobs, quick actions, notifications |
| **Resume Builder** | 8-section resume: Personal · Education · Experience · Skills · Certifications · Projects · References · Extras — with HTML/PDF export |
| **Profile & Settings** | Profile completion meter, skill tags, password strength indicator, account overview |
| **Job Applications** | Apply to jobs, track application status, save/bookmark jobs |
| **Training Enrollment** | Enroll in programs, view enrolled trainings |
| **Career Counselling** | Book sessions with certified career counsellors |
| **Notifications** | Real-time notifications for job matches, updates |

### 🔑 Admin Panel
| Feature | Description |
|---------|-------------|
| **Admin Dashboard** | Live stats — users, jobs, trainings, counselling sessions |
| **User Management** | List, search, view, delete users |
| **Reports** | Registration trends, job type breakdown, training enrollment analytics |

---

## 🚀 Quick Start

### Prerequisites

- Node.js 18+
- PHP 8.2+ with Composer
- SQLite (built-in with PHP) or MySQL 8

---

### 1. Clone the repository

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

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

#### Option A — SQLite (Easiest, no DB server needed)

Edit `.env`:
```env
DB_CONNECTION=sqlite
# DB_HOST, DB_DATABASE etc. can be left blank or removed
```

```bash
# Create the SQLite file
New-Item -ItemType File database/database.sqlite    # Windows PowerShell
# OR
touch database/database.sqlite                      # Linux/Mac
```

#### Option B — MySQL

Edit `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pgrkam_db
DB_USERNAME=root
DB_PASSWORD=your_password
```

```bash
# Create MySQL database
mysql -u root -p -e "CREATE DATABASE pgrkam_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

#### Continue for both options:

```bash
# Run migrations and seed demo data (54 jobs, 27 trainings, 12 services, demo users)
php artisan migrate --seed

# Start the API server
php artisan serve --port=8000
# → API running at http://localhost:8000
```

---

### 3. Frontend Setup (React + Vite)

```bash
cd ../frontend

# Install Node dependencies
npm install

# Start the dev server
npm run dev
# → App running at http://localhost:3001
```

Open **http://localhost:3001** in your browser.

---

## 🎭 Demo Credentials

| Role  | Email                    | Password | Access |
|-------|--------------------------|----------|--------|
| Admin | `admin@pgrkam.gov.in`    | `password` | Full admin panel + all user features |
| User  | `user@pgrkam.gov.in`     | `password` | Full user dashboard (Kajal Kumari) |

> ⚠️ These are seeded demo accounts for development only.

---


## 📁 Project Structure

```
PGRKAM/
│
├── frontend/                          # React 18 + Vite SPA
│   ├── index.html
│   ├── vite.config.js                 # Proxy: /api → localhost:8000
│   ├── tailwind.config.js             # Primary color: blue, darkMode: class
│   ├── package.json
│   └── src/
│       ├── main.jsx                   # App entry point
│       ├── App.jsx                    # Root component
│       ├── index.css                  # Global styles, custom utilities
│       ├── api/
│       │   └── axios.js               # Axios instance + all API functions
│       │                              # (authAPI, userAPI, jobAPI, etc.)
│       ├── components/
│       │   ├── Navbar.jsx             # Top navigation with auth state
│       │   ├── Footer.jsx
│       │   ├── QueryBox.jsx           # Floating smart guidance chatbot
│       │   ├── DashboardCard.jsx      # Reusable stat card
│       │   └── ...
│       ├── context/
│       │   └── AuthContext.jsx        # Global auth state (user, token, login/logout)
│       ├── layouts/
│       │   ├── MainLayout.jsx         # Public layout (Navbar + Footer)
│       │   └── DashboardLayout.jsx    # Auth layout (Sidebar + Navbar)
│       ├── pages/
│       │   ├── Home.jsx               # Landing page with live stats
│       │   ├── Jobs.jsx               # Job listings with filters
│       │   ├── Training.jsx           # Training programs
│       │   ├── Services.jsx           # Government services
│       │   ├── About.jsx
│       │   ├── Contact.jsx
│       │   ├── Login.jsx / Register.jsx
│       │   ├── Dashboard.jsx          # User dashboard (stats, jobs, notifications)
│       │   ├── Resume.jsx             # 8-section resume builder
│       │   ├── ProfileSettings.jsx    # Profile + password change
│       │   ├── Counselling.jsx        # Book counselling sessions
│       │   ├── MyApplications.jsx     # Applied jobs
│       │   ├── SavedJobs.jsx          # Bookmarked jobs
│       │   ├── MyEnrollments.jsx      # Enrolled trainings
│       │   ├── Notifications.jsx      # All notifications
│       │   └── admin/                 # Admin-only pages
│       │       ├── AdminDashboard.jsx
│       │       ├── UserManagement.jsx
│       │       └── Reports.jsx
│       ├── routes/
│       │   └── AppRoutes.jsx          # All routes, lazy loading, ProtectedRoute
│       └── utils/
│           └── helpers.js             # Smart guidance keywords, formatters
│
└── backend/                           # Laravel 12 REST API
    ├── artisan                        # CLI entry point
    ├── composer.json
    ├── .env                           # Environment config (DB, mail, etc.)
    ├── app/
    │   ├── Http/
    │   │   ├── Controllers/Api/
    │   │   │   ├── AuthController.php        # register, login, logout
    │   │   │   ├── UserController.php        # profile, resume, applications
    │   │   │   ├── JobController.php         # list, apply, save, unsave
    │   │   │   ├── TrainingController.php    # list, enroll, unenroll
    │   │   │   ├── ServiceController.php     # list services
    │   │   │   ├── CounsellingController.php # book, list sessions
    │   │   │   ├── NotificationController.php
    │   │   │   ├── ChatGuideController.php   # smart guidance API
    │   │   │   └── AdminController.php       # admin stats, users, reports
    │   │   └── Middleware/
    │   │       └── RoleMiddleware.php        # Guards admin routes
    │   └── Models/
    │       ├── User.php               # savedJobs(), applications(), enrollments()
    │       ├── Job.php
    │       ├── Training.php
    │       ├── Service.php
    │       ├── CounsellingRequest.php
    │       ├── Resume.php
    │       └── Notification.php
    ├── bootstrap/
    │   └── app.php                    # Middleware aliases, Sanctum config
    ├── database/
    │   ├── migrations/                # Users, jobs, trainings, services,
    │   │                              # counselling, resume, notifications
    │   └── seeders/
    │       └── DatabaseSeeder.php     # 54 jobs + 27 trainings + 12 services + demo users
    ├── routes/
    │   └── api.php                    # All REST API routes
    └── storage/
        └── app/                       # File uploads (resume attachments)
```

---

## 🌐 API Overview

### Auth Endpoints (Public)

| Method | Endpoint          | Description              |
|--------|-------------------|--------------------------|
| POST   | `/api/register`   | Register new user        |
| POST   | `/api/login`      | Login → returns token    |
| POST   | `/api/logout`     | Invalidate bearer token  |

### Public Data Endpoints

| Method | Endpoint              | Description                         |
|--------|-----------------------|-------------------------------------|
| GET    | `/api/services`       | List all government services        |
| GET    | `/api/jobs`           | All job listings (54 records)       |
| GET    | `/api/jobs/{id}`      | Single job detail                   |
| GET    | `/api/training`       | Training programs (27 records)      |
| GET    | `/api/training/{id}`  | Single training detail              |
| POST   | `/api/chat-guide`     | Smart guidance keyword match        |

### User Endpoints (Bearer token required)

| Method | Endpoint                        | Description                       |
|--------|---------------------------------|-----------------------------------|
| GET    | `/api/user/profile`             | Get authenticated user profile    |
| PUT    | `/api/user/profile`             | Update profile                    |
| POST   | `/api/user/change-password`     | Change password                   |
| GET    | `/api/user/resume`              | Fetch saved resume                |
| POST   | `/api/user/resume`              | Save/update resume (JSON)         |
| POST   | `/api/jobs/{id}/apply`          | Apply to a job                    |
| GET    | `/api/user/applications`        | My job applications               |
| POST   | `/api/jobs/{id}/save`           | Bookmark a job                    |
| DELETE | `/api/jobs/{id}/save`           | Remove bookmark                   |
| GET    | `/api/user/saved-jobs`          | My saved/bookmarked jobs          |
| POST   | `/api/training/{id}/enroll`     | Enroll in a training program      |
| DELETE | `/api/training/{id}/enroll`     | Unenroll from training            |
| GET    | `/api/user/enrollments`         | My training enrollments           |
| POST   | `/api/counselling`              | Book a counselling session        |
| GET    | `/api/user/notifications`       | Get all notifications             |

### Admin Endpoints (Admin role required)

| Method | Endpoint                  | Description                      |
|--------|---------------------------|----------------------------------|
| GET    | `/api/admin/dashboard`    | Live stats (users, jobs, etc.)   |
| GET    | `/api/admin/users`        | All registered users             |
| DELETE | `/api/admin/users/{id}`   | Delete a user                    |
| GET    | `/api/admin/reports`      | Analytics and trends data        |

---

## 🗄️ Database Schema

| Table                  | Key Columns                                                              |
|------------------------|--------------------------------------------------------------------------|
| `users`                | name, email, password, phone, dob, gender, district, qualification, skills, address, role |
| `jobs`                 | title, department, location, salary, type (govt/private), description, seats, deadline |
| `trainings`            | title, category, description, duration, seats_total, seats_available, location, fee |
| `services`             | title, description, category, eligibility, process                       |
| `job_user` (pivot)     | user_id, job_id, status, applied_at                                      |
| `saved_jobs` (pivot)   | user_id, job_id                                                          |
| `training_user` (pivot)| user_id, training_id, enrolled_at, status                               |
| `counselling_requests` | user_id, name, phone, district, message, preferred_date, status          |
| `resumes`              | user_id, resume_data (JSON — all 8 sections)                             |
| `notifications`        | user_id, title, message, type, is_read                                   |

---

## 🏗️ Build for Production

```bash
# Frontend — build optimized static files
cd frontend
npm run build
# Output: frontend/dist/  (serve with Nginx/Apache or Vercel/Netlify)

# Backend — optimize for production
cd backend
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

---

## ⚙️ Environment Variables

Key `.env` variables for the backend (`backend/.env`):

```env
APP_NAME=PGRKAM
APP_ENV=local
APP_KEY=base64:...            # auto-generated by php artisan key:generate
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database — SQLite (development)
DB_CONNECTION=sqlite

# Database — MySQL (production)
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=pgrkam_db
# DB_USERNAME=root
# DB_PASSWORD=your_password

# Mail (for notifications)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null

# Sanctum
SANCTUM_STATEFUL_DOMAINS=localhost:3001
SESSION_DOMAIN=localhost
```

---

## 🔒 Security Notes

- Passwords hashed with **bcrypt** via Laravel's Hash facade
- API protected by **Laravel Sanctum** Bearer token authentication
- Admin routes guarded by `RoleMiddleware` — non-admin requests return `403 Forbidden`
- CORS configured to allow only the frontend origin (`localhost:3001`)
- Input validation on all POST/PUT endpoints using Laravel Form Requests

---

## 👨‍💻 Development Notes

- Frontend runs on **port 3001**, backend on **port 8000**
- Vite proxy forwards `/api/*` requests to `http://localhost:8000` — no CORS issues in dev
- Auth token stored in `localStorage` as `pgrkam_token` and `pgrkam_user`
- TailwindCSS primary color = blue (`primary-600: #2563eb`)
- Dark mode support via `class` strategy (`darkMode: 'class'` in tailwind.config.js)

---

<div align="center">

**Built with ❤️ for the youth of Punjab**

*PGRKAM — Empowering Employment, Enabling Futures*

</div>

