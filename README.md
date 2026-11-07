# StayHub - Vacation Rental Booking System
**Course Requirement: Backend Web Development**  
**Student Level:** 1st/2nd Year College  
**Stack:** Laravel 11 + MongoDB (MVC Structure)

---

## 📌 Project Summary
StayHub is a vacation rental booking backend system. It features an **Admin Dashboard** for managing property listings and bookings, and a set of **REST API routes** for user accounts, browsing places, and making reservations. All data is saved in **MongoDB**.

---

## 📁 Modular Route Files (Choice C)
All routes are organized into clean, separate files inside the `routes/` folder:

1. 📄 [`routes/admin.php`](file:///home/rayyan/Documents/backend%20app/routes/admin.php) &rarr; **Admin routes** (login, dashboard, property approval)
2. 📄 [`routes/auth.php`](file:///home/rayyan/Documents/backend%20app/routes/auth.php) &rarr; **Auth routes** (register, login, logout, profile)
3. 📄 [`routes/properties.php`](file:///home/rayyan/Documents/backend%20app/routes/properties.php) &rarr; **Property routes** (browse, add, edit, delete, categories)
4. 📄 [`routes/bookings.php`](file:///home/rayyan/Documents/backend%20app/routes/bookings.php) &rarr; **Booking routes** (view bookings, reserve, cancel)

---

## ✅ Requirements Checklist (From Whiteboard)

- [x] **Backend app using Laravel**: Built with Laravel 11 on PHP 8.5.
- [x] **Authentication for Admin Dashboard/Pages**: Protected admin routes (`/admin/login`, `/admin/dashboard`, `/admin/properties`).
- [x] **At least 20 routes with documentation**: Over 20 routes documented using **Scramble** at `/docs/api`.
- [x] **Documentation Library**: Uses Scramble (OpenAPI 3.1) with live "Try It Out" buttons right in the browser.
- [x] **MongoDB as Database**: Connected via official `mongodb/laravel-mongodb` package.
- [x] **Strict MVC Structure**:
  - **Models (`app/Models/`)**: `User.php`, `Property.php`, `Booking.php`, `Category.php`
  - **Views (`resources/views/admin/`)**: `login.blade.php`, `dashboard.blade.php`, `properties.blade.php`
  - **Controllers (`app/Http/Controllers/`)**:
    - `AdminController.php` (admin login & dashboard)
    - `AuthController.php` (user register & login)
    - `PropertyController.php` (property listings & categories)
    - `BookingController.php` (reservations & cancel)
- [x] **Utilize `.env` file**: Configured with `DB_CONNECTION=mongodb`, `MONGODB_URI`, `MONGODB_DATABASE`.

---

## 🔑 Test Logins (Seeded in MongoDB)

| Role | Email | Password | What it can do |
|---|---|---|---|
| **Admin** | `admin@stayhub.com` | `password123` | Can access `/admin/dashboard` and approve properties |
| **Host** | `host@stayhub.com` | `password123` | Can post new properties |
| **Guest** | `guest@stayhub.com` | `password123` | Can book places and view receipts |

---

## 🚀 How to Run the Project

1. **Seed the MongoDB Database**:
   ```bash
   php artisan db:seed
   ```

2. **Start the Laravel Server**:
   ```bash
   php artisan serve
   ```

3. **Open in Browser**:
   * **Admin Dashboard**: [http://127.0.0.1:8000/admin/login](http://127.0.0.1:8000/admin/login)
   * **API Docs (Try It Out)**: [http://127.0.0.1:8000/docs/api](http://127.0.0.1:8000/docs/api)

---

## 🧪 Running Tests
```bash
php artisan test
```
*(All 10 tests and 30 assertions pass successfully)*
