# **Safety Rental**

Safety Rental is a vehicle rental web application built with Laravel. This guide contains the steps required to download, configure, initialize, and run the project locally.

## **1. Table of Contents**

- [2. Team Members](#2-team-members)
- [3. Requirements](#3-requirements)
- [4. Clone the Repository](#4-clone-the-repository)
- [5. Install Dependencies](#5-install-dependencies)
- [6. Configure the Environment](#6-configure-the-environment)
- [7. Configure the Database](#7-configure-the-database)
- [8. Run Migrations and Seeders](#8-run-migrations-and-seeders)
- [9. Run the Application](#9-run-the-application)
- [10. Application Access](#10-application-access)
- [11. Seeded Users](#11-seeded-users)
- [12. Local Email Verification and Password Reset](#12-local-email-verification-and-password-reset)
- [13. Verification Commands](#13-verification-commands)
- [14. Common Problems](#14-common-problems)
- [15. Public Vehicle API](#15-public-vehicle-api)
- [16. Partner Fleet Integration](#16-partner-fleet-integration)
- [17. Google Maps Route Estimates](#17-google-maps-route-estimates)
- [18. Architecture diagram](#18-architecture-diagram)

## **2. Team Members**

- Isabella Cadavid Posada
- Isabella Ocampo S.
- Wendy Atehortua
- Alejandro Correa Marin

## **3. Requirements**

Install the following tools before starting:

- PHP 8.3 or later
- Composer
- MySQL
- Git
- A local server package such as MAMP or XAMPP, if preferred

Verify the installations:

```bash
php --version
composer --version
git --version
```

## **4. Clone the Repository**

Clone the repository:

```bash
git clone https://github.com/IsabellaCada2506/safety-rental.git
cd safety-rental
```

Switch to the main branch and download its latest changes:

```bash
git switch main
git pull origin main
```

## **5. Install Dependencies**

Install the PHP dependencies:

```bash
composer install
```

Regenerate Composer's autoload files:

```bash
composer dump-autoload
```

## **6. Configure the Environment**

Create the local environment file:

```bash
cp .env.example .env
```

On Windows Command Prompt, use:

```bat
copy .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

Set the main application values in `.env`:

```dotenv
APP_NAME="Safety Rental"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

APP_LOCALE=es
APP_FALLBACK_LOCALE=en
```

## **7. Configure the Database**

Start MySQL and create an empty database named:

```text
safety_rental
```

### **7.1. Standard MySQL Configuration**

For a standard local MySQL installation, set the following values in `.env`:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=safety_rental
DB_USERNAME=root
DB_PASSWORD=
```

### **7.2. MAMP Configuration on macOS**

For a default MAMP installation on macOS, the common configuration is:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=8889
DB_DATABASE=safety_rental
DB_USERNAME=root
DB_PASSWORD=root
```

If MAMP uses a different port or password, use the values displayed in its MySQL settings.

### **7.3. Clear the Configuration Cache**

After editing `.env`, run:

```bash
php artisan optimize:clear
```

## **8. Run Migrations and Seeders**

### **8.1. First Installation**

For the first local installation, create all tables and insert the sample data:

```bash
php artisan migrate:fresh --seed
```

> **Warning:** `migrate:fresh` deletes all existing tables and information in the configured database. Use it only for a new installation or when the current information can be discarded.

### **8.2. Existing Database**

If the database already contains information that must be preserved, use:

```bash
php artisan migrate
php artisan db:seed
```
our 

```bash
php artisan migrate:refresh --seed
```

## **9. Run the Application**

Start the Laravel development server:

```bash
php artisan serve
```

Open the application at:

- Home: <http://127.0.0.1:8000>
- Login: <http://127.0.0.1:8000/login>
- Registration: <http://127.0.0.1:8000/register>

Stop the server with:

```text
Control + C
```

## **10. Application Access**

| Area | URL | Access |
|---|---|---|
| Public home | <http://127.0.0.1:8000> | Everyone |
| Login | <http://127.0.0.1:8000/login> | Everyone |
| Registration | <http://127.0.0.1:8000/register> | Guests |
| Customer home | <http://127.0.0.1:8000/home> | Verified customers |
| Profile | <http://127.0.0.1:8000/profile> | Authenticated customers |
| Catalog | <http://127.0.0.1:8000/catalog> | Verified customers |
| Reservations | <http://127.0.0.1:8000/reservations> | Verified customers |
| Administration | <http://127.0.0.1:8000/admin/dashboard> | Verified administrators |

## **11. Seeded Users**

The following accounts are created by either of these commands:

```bash
php artisan db:seed
```

```bash
php artisan migrate:fresh --seed
```

| Name | Role | Email | Password | Email status |
|---|---|---|---|---|
| Safety Rental Administrator | Administrator | `admin@safetyrental.test` | `password` | Verified |
| Admin User | Administrator | `admin@safetyrental.com` | `admin12345` | Not marked as verified by the seeder |
| Isabella Ocampo | Customer | `isa@gmail.com` | `b12345678` | Verified |
| Carlos Rueda | Customer | `carlos@gmail.com` | `c12345678` | Verified |
| Safety Rental Customer | Customer | `customer@safetyrental.test` | `password` | Verified |

### **11.1. Recommended Administrator Account**

Use this account for immediate access to all administrator features:

```text
Email: admin@safetyrental.test
Password: password
```

### **11.2. Recommended Customer Account**

Use this account for immediate customer access:

```text
Email: customer@safetyrental.test
Password: password
```

> **Important:** Seeded credentials are intended only for local development and testing. Change or remove them before deploying the application.

## **12. Local Email Verification and Password Reset**

### **12.1. Configure Local Email Logging**

Keep the following value in `.env` while testing locally:

```dotenv
MAIL_MAILER=log
```

Verification and password-reset messages will be written to:

```text
storage/logs/laravel.log
```

### **12.2. Request a Password Reset**

Open the password recovery page:

```text
http://127.0.0.1:8000/password/request
```

Enter the email address of an existing user and submit the form.

### **12.3. Obtain the Password Reset Link**

After requesting the password reset, run the following command in the project terminal:

```bash
grep -oE 'http\://[^ ]+/password/reset/[^ ]+' storage/logs/laravel.log | tail -1
```

The terminal will display the most recent password-reset URL.

Copy the complete URL, paste it into the browser, and enter the new password.

### **12.4. Open the Log Manually**

You can also open the following file:

```text
storage/logs/laravel.log
```

Find the most recent verification or password-reset link and copy it into the browser.

## **13. Verification Commands**

Run these commands before submitting changes:

```bash
composer dump-autoload
php artisan optimize:clear
php artisan route:list
php artisan test
./vendor/bin/pint --test
```

If Pint reports formatting problems, apply its automatic corrections:

```bash
./vendor/bin/pint
```

Run the verification again:

```bash
./vendor/bin/pint --test
php artisan test
```

## **14. Common Problems**

### **14.1. Database Connection Error**

- Confirm that MySQL is running.
- Confirm the database name in `.env`.
- Confirm the database port, username, and password.
- Run `php artisan optimize:clear` after changing `.env`.

For MAMP, verify that the MySQL port is normally:

```dotenv
DB_PORT=8889
```

### **14.2. Application Key Is Missing**

Run:

```bash
php artisan key:generate
```

Then clear the cached configuration:

```bash
php artisan optimize:clear
```

### **14.3. Classes, Routes, or Recent Changes Are Not Recognized**

Run:

```bash
composer dump-autoload
php artisan optimize:clear
```

If dependencies have not been installed, run:

```bash
composer install
composer dump-autoload
php artisan optimize:clear
```

### **14.4. Seed Data Was Not Created**

Run:

```bash
php artisan db:seed
```

To recreate the complete local database and seed all sample information, run:

```bash
php artisan migrate:fresh --seed
```

> **Warning:** This command deletes the existing tables and information.

### **14.5. Port 8000 Is Already in Use**

Run the application using another port:

```bash
php artisan serve --port=8001
```

Then open:

```text
http://127.0.0.1:8001
```

### **14.6. Password Reset Link Is Not Displayed**

Confirm that `.env` contains:

```dotenv
MAIL_MAILER=log
```

Clear the cached configuration:

```bash
php artisan optimize:clear
```

Request the password reset again and run:

```bash
grep -oE 'http\://[^ ]+/password/reset/[^ ]+' storage/logs/laravel.log | tail -1
```

Copy the URL printed in the terminal and paste it into the browser.

## **15. Public Vehicle API**

Safety Rental exposes a public JSON catalog of vehicles that are currently available for rent. Other teams can consume this endpoint without authentication.

### **15.1. List available vehicles**

```text
GET /api/vehicles
```

Example:

```bash
curl http://127.0.0.1:8000/api/vehicles
```

Example response:

```json
{
  "vehicles": [
    {
      "id": 1,
      "make": "Toyota",
      "model": "Corolla",
      "category": "Sedan",
      "location": "Sede El Poblado",
      "daily_rate": 180000,
      "availability": "available",
      "detail_url": "http://127.0.0.1:8000/catalog/1"
    }
  ]
}
```

### **15.2. Vehicle detail**

```text
GET /api/vehicles/{id}
```

Example:

```bash
curl http://127.0.0.1:8000/api/vehicles/1
```

Fields returned:

- `make`: vehicle brand
- `model`: vehicle model
- `category`: vehicle type
- `location`: pickup branch name
- `daily_rate`: rental price per day in COP
- `availability`: `available` when the vehicle can be rented
- `detail_url`: application URL with the full vehicle detail

Deactivated vehicles are excluded. An empty fleet returns `{ "vehicles": [] }`.

## **16. Partner Fleet Integration**

Safety Rental consumes the preceding team's public JSON API and shows those vehicles in `/partners`. Keys and URLs stay in environment variables. A local JSON file is not used as a substitute for the real HTTP call.

Set these values in `.env`:

```dotenv
PARTNER_API_URL=https://TEAM-05-PUBLIC-URL/api/vehicles
PARTNER_API_TOKEN=
PARTNER_API_TIMEOUT=8
```

Until the architect delivers the team 05 URL, the local public catalog can be used to verify the HTTP client:

```dotenv
PARTNER_API_URL=http://127.0.0.1:8000/api/vehicles
```

The partners page translates HTTP errors, timeouts, connection failures, empty payloads, and missing configuration.

## **17. Google Maps Route Estimates**

Customers can estimate driving distance and travel time from their current location to a pickup branch. The application calls the Google Maps Routes API from the server. `GOOGLE_MAPS_API_KEY` must never be sent to the browser.

Set these values in `.env`:

```dotenv
GOOGLE_MAPS_API_KEY=your-server-side-key
GOOGLE_ROUTES_API_URL=https://routes.googleapis.com/directions/v2:computeRoutes
GOOGLE_ROUTES_TIMEOUT=8
```

The estimate appears on `/route-estimates` after the customer shares the browser location from a vehicle detail or branch page. HTTP errors, timeouts, empty routes, and missing configuration are translated in the interface.

## **18. Architecture diagram**

The MVC architecture diagram is [`docs/arquitectura-mvc-completa-en.drawio`](docs/arquitectura-mvc-completa-en.drawio).

Open it in [diagrams.net](https://app.diagrams.net). It lists every Authentication, Admin, and User controller with its model and view folder.
