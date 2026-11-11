# **Safety Rental**

Safety Rental is a vehicle rental web application built with Laravel. This guide contains the steps required to download, configure, initialize, and run the project locally or with Docker.

## **1. Table of Contents**

- [2. Team Members](#2-team-members)
- [3. Requirements](#3-requirements)
- [4. Clone the Repository](#4-clone-the-repository)
- [5. Install Dependencies](#5-install-dependencies)
- [6. Configure the Environment](#6-configure-the-environment)
- [7. Configure the Database](#7-configure-the-database)
- [8. Run Migrations and Seeders](#8-run-migrations-and-seeders)
- [9. Run the Application](#9-run-the-application)
- [10. Run with Docker](#10-run-with-docker)
- [11. Application Access & Integrations](#11-application-access--integrations)
- [12. Seeded Users](#12-seeded-users)
- [13. Local Email Verification and Password Reset](#13-local-email-verification-and-password-reset)
- [14. Verification Commands](#14-verification-commands)
- [15. Common Problems](#15-common-problems)

## **2. Team Members**

- Isabella Cadavid Posada
- Isabella Ocampo S.
- Wendy Atehortua
- Alejandro Correa Marin

## **3. Requirements**

Install the following tools before starting:

- PHP 8.3 or later
- Composer
- MySQL 8.0+
- Git
- Docker & Docker Compose *(optional, if running containerized)*
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

> **Note on Frontend Assets:** The project does not require Node.js, NPM, or Vite (`@vite`). All static CSS/JS files and icons are loaded directly via public assets or CDN links.

## **6. Configure the Environment**

Create the local environment file from the example:

```bash
cp .env.example .env
```

On Windows Command Prompt / PowerShell:

```powershell
Copy-Item .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

Configure the main application values in `.env`:

```dotenv
APP_NAME="Safety Rental"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
```

### **6.1 External APIs & Integration Keys**

Configure external service credentials in `.env`:

```dotenv
# Google Maps Routes & Directions API Key
GOOGLE_MAPS_API_KEY=your_google_maps_api_key

# External Partner Catalog API
PARTNER_API_URL=https://your-partner-api-host/api/products
PARTNER_API_ITEMS_PATH=data
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
DB_PASSWORD=root
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

## **10. Run with Docker**

The project includes containerization support via `Dockerfile` and `docker-compose.yml`.

### **10.1 Build and Start Containers**

```bash
docker compose up -d --build
```

### **10.2 Initialize Database Inside Container**

```bash
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate:fresh --seed
```

The application will be accessible at <http://localhost:8000>.

To shut down containers:

```bash
docker compose down
```

## **11. Application Access & Integrations**

| Area | URL | Access |
|---|---|---|
| Public Home | <http://127.0.0.1:8000> | Public (Guests) |
| Login | <http://127.0.0.1:8000/login> | Guests |
| Registration | <http://127.0.0.1:8000/register> | Guests |
| Customer Home | <http://127.0.0.1:8000/home> | Authenticated & Verified Customers |
| Profile | <http://127.0.0.1:8000/profile> | Authenticated Customers |
| Catalog | <http://127.0.0.1:8000/catalog> | Authenticated Customers |
| Locations | <http://127.0.0.1:8000/locations> | Authenticated Customers |
| Reservations | <http://127.0.0.1:8000/reservations> | Authenticated Customers |
| Partners (Aliados) | <http://127.0.0.1:8000/partners> | Authenticated Users (Customers & Admins) |
| Administration Dashboard | <http://127.0.0.1:8000/admin/dashboard> | Verified Administrators |
| Public Vehicles API | <http://127.0.0.1:8000/api/vehicles> | Public API |

## **12. Seeded Users**

The following accounts are created by either `php artisan db:seed` or `php artisan migrate:fresh --seed`:

| Name | Role | Email | Password | Email status |
|---|---|---|---|---|
| Safety Rental Administrator | Administrator | `admin@safetyrental.test` | `password` | Verified |
| Admin User | Administrator | `admin@safetyrental.com` | `admin12345` | Not marked as verified |
| Isabella Ocampo | Customer | `isa@gmail.com` | `b12345678` | Verified |
| Carlos Rueda | Customer | `carlos@gmail.com` | `c12345678` | Verified |
| Safety Rental Customer | Customer | `customer@safetyrental.test` | `password` | Verified |

### **12.1. Recommended Administrator Account**

```text
Email: admin@safetyrental.test
Password: password
```

### **12.2. Recommended Customer Account**

```text
Email: customer@safetyrental.test
Password: password
```

> **Important:** Seeded credentials are intended only for local development and testing. Change or remove them before deploying the application.

## **13. Local Email Verification and Password Reset**

### **13.1. Configure Local Email Logging**

Keep the following value in `.env` while testing locally:

```dotenv
MAIL_MAILER=log
```

Verification and password-reset messages will be written to:

```text
storage/logs/laravel.log
```

### **13.2. Request a Password Reset**

Open the password recovery page:

```text
http://127.0.0.1:8000/password/request
```

Enter the email address of an existing user and submit the form.

### **13.3. Obtain the Password Reset Link**

Run the following command in the project terminal:

```bash
grep -oE 'http\://[^ ]+/password/reset/[^ ]+' storage/logs/laravel.log | tail -1
```

Copy the complete URL, paste it into the browser, and enter the new password.

## **14. Verification Commands**

Run these commands to verify codebase integrity and routes:

```bash
composer dump-autoload
php artisan optimize:clear
php artisan route:list
php artisan test
```

## **15. Common Problems**

### **15.1. Database Connection Error**

- Confirm that MySQL is running.
- Confirm the database credentials and port in `.env`.
- Run `php artisan optimize:clear` after modifying `.env`.

### **15.2. Application Key Is Missing**

```bash
php artisan key:generate
php artisan optimize:clear
```

### **15.3. External Partner API or Maps Issues**

- Ensure `PARTNER_API_URL` and `GOOGLE_MAPS_API_KEY` are defined in `.env`.
- Check network connectivity and verify the key has permissions for Routes and Maps JavaScript API.

### **15.4. Classes or Views Not Updating**

```bash
composer dump-autoload
php artisan optimize:clear
php artisan view:clear
```
