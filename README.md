<div align="center">

# 🏛️ PGRKAM
### Punjab Government Rozgar te Karobar Assistance Mission
#### Smart Employment Guidance System

![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Blade](https://img.shields.io/badge/Blade-Templates-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8-4479A1?style=for-the-badge&logo=mysql&logoColor=white)

**Punjab Government's centralized employment platform connecting job seekers with government & private job opportunities, skill training programs, professional resume tools, and career counselling services.**

[🌐 Live Demo](
https://pgrkam-portal.onrender.com/) · [🚀 Quick Start](#quick-start) · [✨ Features](#features)

</div>

---

## 📋 Table of Contents

- [Overview](#overview)
- [Tech Stack](#tech-stack)
- [Features](#features)
- [Project Structure](#project-structure)
- [Quick Start](#quick-start)
- [Demo Credentials](#demo-credentials)
- [Database Schema](#database-schema)
- [Environment Variables](#environment-variables)

---

## 🎯 Overview

PGRKAM is a full-stack Laravel web application built for the **Punjab Government** to help unemployed youth find jobs, enroll in skill development training, build professional resumes, and connect with career counsellors — all in one place.

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
| Frontend   | Laravel Blade · Tailwind CSS 3 · Vite                  |
| Backend    | Laravel 12 · PHP 8.2 · Laravel Sanctum                 |
| Database   | MySQL 8                                                 |
| Auth       | Laravel Session Auth · Role Middleware                  |

---

## ✨ Features

### 🌐 Public Pages (No Login Required)
| Page | Description |
|------|-------------|
| **Home** | Hero section, animated stats, service overview, smart search |
| **Jobs** | 54 job listings with search, filters (Govt/Private/All), location filter |
| **Training** | 27 skill programs with enrollment, seat availability, category filters |
| **Services** | 12 government services with eligibility info |
| **About** | Portal mission, stats, team info |
| **Contact** | Contact form with address, map info |

### 🔐 Authenticated User Features
| Feature | Description |
|---------|-------------|
| **Dashboard** | Personalized greeting, stats cards, recent jobs, quick actions, notifications |
| **Resume Builder** | 8-section resume: Personal · Education · Experience · Skills · Certifications · Projects · References · Extras — with HTML/PDF export |
| **Profile & Settings** | Profile completion meter, skill tags, password strength indicator |
| **Job Applications** | Apply to jobs, track application status, save/bookmark jobs |
| **Training Enrollment** | Enroll in programs, view enrolled trainings |
| **Career Counselling** | Book sessions with certified career counsellors |
| **Notifications** | Notifications for job matches, updates |

### 🔑 Admin Panel
| Feature | Description |
|---------|-------------|
| **Admin Dashboard** | Live stats — users, jobs, trainings, counselling sessions |
| **User Management** | List, search, view, delete users |
| **Reports** | Registration trends, job type breakdown, training enrollment analytics |

---

## 🚀 Quick Start

### Prerequisites

- PHP 8.2+ with Composer
- MySQL 8
- Node.js (for Vite/Tailwind assets)

---

### 1. Clone the repository

```bash
git clone <repo-url>
cd PGRKAM
```

---

### 2. Setup

```bash
cd "Laravel Project"

# Install PHP dependencies
composer install

# Install Node dependencies
npm install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

---

### 3. Configure Database

Edit `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pgrkam_db
DB_USERNAME=root
DB_PASSWORD=your_password
```

Create the MySQL database:
```bash
mysql -u root -p -e "CREATE DATABASE pgrkam_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

---

### 4. Run Migrations & Seed

```bash
php artisan migrate --seed
```

---

### 5. Build Assets & Start Server

```bash
# Build Tailwind/Vite assets
npm run build

# Start Laravel server
php artisan serve
# → App running at http://localhost:8000
```

---

## 🎭 Demo Credentials

| Role  | Email                    | Password | Access |
|-------|--------------------------|----------|--------|
| Admin | `admin@pgrkam.gov.in`    | `password` | Full admin panel + all user features |
| User  | `user@pgrkam.gov.in`     | `password` | Full user dashboard |

> ⚠️ These are seeded demo accounts for development only.

---

## 📁 Project Structure

```
PGRKAM/
│
└── Laravel Project/                   # Laravel 12 Full-Stack App
    ├── artisan
    ├── composer.json
    ├── .env
    ├── app/
    │   ├── Http/
    │   │   ├── Controllers/
    │   │   │   ├── Api/               # REST API controllers (Sanctum)
    │   │   │   │   ├── AuthController.php
    │   │   │   │   ├── UserController.php
    │   │   │   │   ├── JobController.php
    │   │   │   │   ├── TrainingController.php
    │   │   │   │   ├── ServiceController.php
    │   │   │   │   ├── CounsellingController.php
    │   │   │   │   ├── ChatGuideController.php
    │   │   │   │   └── AdminController.php
    │   │   │   └── Web/               # Blade view controllers
    │   │   │       ├── AuthController.php
    │   │   │       ├── DashboardController.php
    │   │   │       ├── JobController.php
    │   │   │       ├── TrainingController.php
    │   │   │       ├── ServiceController.php
    │   │   │       └── ProfileController.php
    │   │   └── Middleware/
    │   │       └── RoleMiddleware.php
    │   └── Models/
    │       ├── User.php
    │       ├── Job.php
    │       ├── Training.php
    │       ├── Service.php
    │       ├── CounsellingRequest.php
    │       ├── Resume.php
    │       └── Notification.php
    ├── resources/
    │   ├── views/                     # Blade templates
    │   └── css/ & js/                 # Tailwind + Vite assets
    ├── routes/
    │   ├── web.php                    # Blade/web routes
    │   └── api.php                    # REST API routes
    └── database/
        ├── migrations/
        └── seeders/
            └── DatabaseSeeder.php     # 54 jobs + 27 trainings + 12 services + demo users
```

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

## ⚙️ Environment Variables

Key `.env` variables (`Laravel Project/.env`):

```env
APP_NAME=PGRKAM
APP_ENV=local
APP_KEY=base64:...
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database — MySQL
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pgrkam_db
DB_USERNAME=root
DB_PASSWORD=your_password

# Mail
MAIL_MAILER=log
MAIL_FROM_ADDRESS="hello@pgrkam.gov.in"
MAIL_FROM_NAME="${APP_NAME}"
```

---

## 🔒 Security Notes

- Passwords hashed with **bcrypt** via Laravel's Hash facade
- Admin routes guarded by `RoleMiddleware` — non-admin requests return `403 Forbidden`
- Input validation on all POST/PUT endpoints using Laravel Form Requests
- CSRF protection on all web routes via Laravel middleware

---

<div align="center">

**Built with ❤️ for the youth of Punjab**

*PGRKAM — Empowering Employment, Enabling Futures*

</div>
