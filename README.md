# Restaurant Reservation System

A simple Laravel application for managing restaurant reservations.  
Supports multiple restaurants, tables, party sizes, and guest lists with validation for availability and capacity.  

---

## Features
- Restaurant management (name, number of tables, max capacity).
- Table management per restaurant.
- Reservation form (with guests).
- Validation:
  - Ensures total capacity is not exceeded.
  - Ensures enough free tables exist for the requested time.
- API endpoints for restaurants & reservations.
- Seeders for demo data.

---

## Installation

### 1. Clone the repository
```bash
git clone https://github.com/aldask/reservation-laravel.git
```

### 2. Install dependencies
```bash
composer install
npm install
```

### 3. Environment setup
Change name `.env.example` to `.env`:

Generate the application key:
```bash
php artisan key:generate
```

Update your `.env` with your database credentials, e.g.:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=reservation_system
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Run migrations & seeders
```bash
php artisan migrate:fresh --seed
```

### 5. Start the server
```bash
php artisan serve
```
Application will be available at:  
http://127.0.0.1:8000  

---

## Endpoints

### Restaurants
- `GET /api/restaurants` – list all restaurants with tables.
- `GET /api/restaurants/{id}` – details for a single restaurant.
- `POST /api/restaurants` – create a restaurant.

### Reservations
- `GET /api/reservations` – list all reservations.
- `POST /api/reservations` – create a reservation.
