-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:8889
-- Tiempo de generación: 15-09-2026 a las 20:25:00
-- Versión del servidor: 8.0.44
-- Versión de PHP: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `safety_rental`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cars`
--

CREATE TABLE `cars` (
  `id` bigint UNSIGNED NOT NULL,
  `plate` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `soat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transit_license` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int NOT NULL,
  `mileage` int NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `location_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cars`
--

INSERT INTO `cars` (`id`, `plate`, `color`, `soat`, `transit_license`, `price`, `mileage`, `image`, `description`, `status`, `category_id`, `created_at`, `updated_at`, `location_id`) VALUES
(1, 'BKV-091', 'Pearl White', 'SOAT-748392018', 'TL-849302', 95000, 18500, 'https://http2.mlstatic.com/D_NQ_NP_2X_723032-MCO112948209774_072026-F.webp', 'Toyota Corolla 2023 Sedan. Hybrid engine, automatic transmission, 5 seats.', 'Active', 1, '2026-09-13 19:58:42', '2026-09-13 19:58:42', 1),
(2, 'FTJ-482', 'Soul Red', 'SOAT-192837465', 'TL-573829', 140000, 22400, 'https://http2.mlstatic.com/D_NQ_NP_2X_766846-MCO109557663136_042026-F.webp', 'Mazda CX-5 SUV. AWD, leather interior, sunroof, and automatic transmission.', 'Active', 2, '2026-09-13 19:58:42', '2026-09-13 19:58:42', 2),
(3, 'MZN-773', 'Mineral Grey', 'SOAT-998877665', 'TL-112233', 210000, 12000, 'https://http2.mlstatic.com/D_NQ_NP_2X_861091-MCO115752059123_082026-F.webp', 'BMW 3 Series Sports Sedan. Turbocharged engine, sport seats, premium sound.', 'Active', 3, '2026-09-13 19:58:42', '2026-09-13 19:58:42', 2),
(4, 'LPR-205', 'Metallic Silver', 'SOAT-556644332', 'TL-998877', 160000, 35200, 'https://http2.mlstatic.com/D_NQ_NP_2X_637693-MCO113837874462_072026-F.webp', 'Toyota Hilux Double Cab Pickup. 4x4 turbo diesel, high payload capacity.', 'Active', 4, '2026-09-13 19:58:42', '2026-09-13 19:58:42', 3),
(5, 'GHT-910', 'Flame Red', 'SOAT-102938475', 'TL-564738', 70000, 29100, 'https://http2.mlstatic.com/D_NQ_NP_2X_790998-MCO117093433001_092026-F.webp', 'Chevrolet Spark GT Compact Hatchback. Highly economical, manual transmission.', 'Active', 5, '2026-09-13 19:58:42', '2026-09-13 19:58:42', 1),
(6, 'XYZ-112', 'Black Sapphire', 'SOAT-564738291', 'TL-342516', 260000, 15300, 'https://http2.mlstatic.com/D_NQ_NP_2X_833504-MCO117255572947_092026-F.webp', 'BMW X5 Luxury SUV. Panoramic roof, executive package, 4x4 all-wheel drive.', 'Active', 6, '2026-09-13 19:58:42', '2026-09-13 19:58:42', 3),
(7, 'KJW-845', 'Midnight Black', 'SOAT-657483920', 'TL-748392', 95000, 21000, 'https://http2.mlstatic.com/D_NQ_NP_2X_788762-MCO113954999470_072026-F.webp', 'Toyota Corolla Sedan. Reliable city vehicle with comfortable interior.', 'Active', 1, '2026-09-13 19:58:42', '2026-09-13 19:58:42', 2),
(8, 'PQR-339', 'Deep Crystal Blue', 'SOAT-883377221', 'TL-223344', 140000, 16800, 'https://http2.mlstatic.com/D_NQ_NP_2X_856759-MCO116029301425_082026-F.webp', 'Mazda CX-5 SUV. Spacious luggage area, automatic safety package.', 'Active', 2, '2026-09-13 19:58:42', '2026-09-13 19:58:42', 3),
(9, 'DFG-567', 'Alpine White', 'SOAT-445566778', 'TL-556677', 160000, 41500, 'https://http2.mlstatic.com/D_NQ_NP_2X_808459-MCO117426139975_092026-F.webp', 'Toyota Hilux 4x4. Excellent performance for rugged terrain and heavy loads.', 'Active', 4, '2026-09-13 19:58:42', '2026-09-13 19:58:42', 1),
(10, 'TYU-789', 'Silver Ice', 'SOAT-991188227', 'TL-889900', 70000, 38200, 'https://http2.mlstatic.com/D_NQ_NP_2X_701089-MCO115698502774_092026-F.webp', 'Chevrolet Spark GT Compact. Easy parking, fuel efficient city commuter.', 'Active', 5, '2026-09-13 19:58:42', '2026-09-13 19:58:42', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `model` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `passenger_capacity` int NOT NULL,
  `luggage_capacity` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `model`, `brand`, `type`, `passenger_capacity`, `luggage_capacity`, `created_at`, `updated_at`) VALUES
(1, 'Corolla', 'Toyota', 'Sedan', 5, 2, '2026-09-13 19:58:42', '2026-09-13 19:58:42'),
(2, 'CX-5', 'Mazda', 'SUV', 5, 3, '2026-09-13 19:58:42', '2026-09-13 19:58:42'),
(3, '3 Series', 'BMW', 'Sports', 4, 2, '2026-09-13 19:58:42', '2026-09-13 19:58:42'),
(4, 'Hilux', 'Toyota', 'Truck', 5, 6, '2026-09-13 19:58:42', '2026-09-13 19:58:42'),
(5, 'Spark GT', 'Chevrolet', 'Compact', 4, 1, '2026-09-13 19:58:42', '2026-09-13 19:58:42'),
(6, 'X5', 'BMW', 'Luxury', 5, 4, '2026-09-13 19:58:42', '2026-09-13 19:58:42');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `locations`
--

CREATE TABLE `locations` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `headquarters` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `locations`
--

INSERT INTO `locations` (`id`, `name`, `address`, `headquarters`, `telephone`, `city`, `created_at`, `updated_at`) VALUES
(1, 'Sede El Poblado', 'Carrera 43A # 1-50', 'Sede Principal Medellín', '+57 604 444 1122', 'Medellín', '2026-09-13 19:58:42', '2026-09-13 19:58:42'),
(2, 'Sede Laureles', 'Avenida Nutibara # 73-20', 'Sede Occidente', '+57 604 444 3344', 'Medellín', '2026-09-13 19:58:42', '2026-09-13 19:58:42'),
(3, 'Sede Aeropuerto JMC', 'Aeropuerto Internacional José María Córdova, Módulo 2', 'Sede Aeroportuaria Rionegro', '+57 604 444 5566', 'Rionegro', '2026-09-13 19:58:42', '2026-09-13 19:58:42');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_09_05_034438_create_authentication_sessions_table', 1),
(5, '2026_09_05_180243_create_password_reset_tokens_table', 1),
(6, '2026_09_10_010000_create_categories_table', 1),
(7, '2026_09_10_010001_create_cars_table', 1),
(8, '2026_09_11_000001_create_locations_table', 1),
(9, '2026_09_11_000002_create_payments_table', 1),
(10, '2026_09_11_000003_create_reservations_table', 1),
(11, '2026_09_11_000004_add_location_id_to_cars_table', 1),
(12, '2026_09_12_000001_add_reservation_id_to_payments_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `payments`
--

CREATE TABLE `payments` (
  `id` bigint UNSIGNED NOT NULL,
  `reservation_id` bigint UNSIGNED DEFAULT NULL,
  `code` bigint UNSIGNED NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_code` bigint UNSIGNED NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `payments`
--

INSERT INTO `payments` (`id`, `reservation_id`, `code`, `amount`, `method`, `transaction_code`, `status`, `date`, `created_at`, `updated_at`) VALUES
(1, 1, 9001001, 380000.00, 'Credit Card', 8819201, 'completed', '2026-09-13', '2026-09-13 19:58:42', '2026-09-13 19:58:42'),
(2, 3, 9001002, 840000.00, 'PSE Debit', 8819202, 'completed', '2026-09-13', '2026-09-13 19:58:42', '2026-09-13 19:58:42'),
(3, 5, 9001003, 280000.00, 'Credit Card', 8819203, 'completed', '2026-09-13', '2026-09-13 19:58:42', '2026-09-13 19:58:42'),
(4, 6, 12901216, 780000.00, 'PSE Debit', 78781410, 'completed', '2026-09-13', '2026-09-13 21:21:14', '2026-09-13 21:21:14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservations`
--

CREATE TABLE `reservations` (
  `id` bigint UNSIGNED NOT NULL,
  `code` bigint UNSIGNED NOT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `car_id` bigint UNSIGNED NOT NULL,
  `location_id` bigint UNSIGNED NOT NULL,
  `payment_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `reservations`
--

INSERT INTO `reservations` (`id`, `code`, `state`, `start_date`, `end_date`, `user_id`, `car_id`, `location_id`, `payment_id`, `created_at`, `updated_at`) VALUES
(1, 84920184, 'confirmed', '2026-09-15', '2026-09-19', 3, 1, 1, 1, '2026-09-13 19:58:42', '2026-09-13 19:58:42'),
(2, 84920185, 'pending', '2026-09-23', '2026-09-27', 3, 2, 2, NULL, '2026-09-13 19:58:42', '2026-09-13 19:58:42'),
(3, 73910245, 'confirmed', '2026-09-14', '2026-09-18', 4, 3, 2, 2, '2026-09-13 19:58:42', '2026-09-13 19:58:42'),
(4, 73910246, 'cancelled', '2026-09-03', '2026-09-07', 4, 4, 3, NULL, '2026-09-13 19:58:42', '2026-09-13 19:58:42'),
(5, 19283746, 'confirmed', '2026-09-20', '2026-09-24', 5, 5, 1, 3, '2026-09-13 19:58:42', '2026-09-13 19:58:42'),
(6, 19283747, 'pending', '2026-09-28', '2026-10-01', 5, 6, 3, 4, '2026-09-13 19:58:42', '2026-09-13 21:21:14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`, `created_at`, `updated_at`) VALUES
('F2DVwOv2nwXbktrygi4ag16dI1qvPaW3lDiG3A0Z', 5, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJ1SWhNZFBFZURNOEJkS3I0VVNubE9NZEtBVXBZb240cWRYVE51SUJxIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2NhdGFsb2ciLCJyb3V0ZSI6ImNhdGFsb2cuaW5kZXgifSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjV9', 1789345001, NULL, NULL),
('sgRLjdQWJSfSa5hP0fmDE1gKT0qIM2D7VfiNSQoM', 5, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJ4dHJqaWM1Vlc0eFU0QlRKR21MWFZWU3huV3FOZ0NHNEhWT3RmV25lIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2NhdGFsb2ciLCJyb3V0ZSI6ImNhdGFsb2cuaW5kZXgifSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjUsImxvY2FsZSI6ImVzIn0=', 1789503208, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'customer',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birth_date` date NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `license_number` bigint UNSIGNED NOT NULL,
  `emergency_contact` bigint UNSIGNED NOT NULL,
  `identification_number` bigint UNSIGNED NOT NULL,
  `emergency_contact_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emergency_contact_last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `eps` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `role`, `name`, `last_name`, `birth_date`, `address`, `license_number`, `emergency_contact`, `identification_number`, `emergency_contact_name`, `emergency_contact_last_name`, `eps`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Admin', 'User', '1990-01-01', 'Main Street 123', 12345678, 3001234567, 10203040, 'Emergency', 'Contact', 'Sura', 'admin@safetyrental.com', NULL, '$2y$12$ObpSpBK9pHVrUeT3hXVlqu9UQvUqfKSCh0nlk1jmRT9uBg/L.z6Fa', NULL, '2026-09-13 19:58:41', '2026-09-13 19:58:41'),
(2, 'admin', 'Safety Rental', 'Administrator', '1990-01-01', 'Safety Rental Main Office', 10000001, 3000000001, 1000000001, 'Emergency', 'Contact', 'Test EPS', 'admin@safetyrental.test', '2026-09-13 19:58:42', '$2y$12$Ph3nAEmFeStLd3uATCedL.MB9IhzqfrRKvUv7zShkveuA6DOA17MK', NULL, '2026-09-13 19:58:42', '2026-09-13 19:58:42'),
(3, 'customer', 'Isabella', 'Ocampo', '2000-01-01', 'Urbanizacion laurel', 223300002, 31245676554, 134456600000002, 'Luz', 'Ocampo', 'Sura', 'isa@gmail.com', '2026-09-13 19:58:42', '$2y$12$ATGwlo3/kGbaIfBpa.TZGOEczjppxNFCz9wYAi4gzeXsHAJ3C5nJm', NULL, '2026-09-13 19:58:42', '2026-09-13 19:58:42'),
(4, 'customer', 'Carlos', 'Rueda', '2000-01-01', 'Urbanizacion laureles', 123300002, 33245676554, 134336600000002, 'Alex', 'Ruiz', 'Sura', 'carlos@gmail.com', '2026-09-13 19:58:42', '$2y$12$lDaE2o2OpkfQfP65XuIIO.NdOp.yt1hPIEjpIAFXl.WDKlVrhfbLa', NULL, '2026-09-13 19:58:42', '2026-09-13 19:58:42'),
(5, 'customer', 'Safety Rental', 'Customer', '2000-01-01', 'Customer Test Address', 10000002, 3000000002, 1000000002, 'Customer Emergency', 'Contact', 'Test EPS', 'customer@safetyrental.test', '2026-09-13 19:58:42', '$2y$12$uaXaY/JemAXAjJu3RWuV.O9ZlEbPfdKO5Vg3TCQ1bMQBfO2Z6u71O', NULL, '2026-09-13 19:58:42', '2026-09-13 19:58:42'),
(6, 'customer', 'rio', 'merchan', '2000-04-09', 'Cl. 48 #61-31', 567890, 323421297, 123, 'isa', 'cada', 'sura', 'rio@gmail.com', NULL, '$2y$12$2ICH8kK/at9UOyFHXo4BTOsV4oys2P21G47qAO0SVK0rCB8mACUBW', NULL, '2026-09-13 20:00:39', '2026-09-13 20:00:39');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indices de la tabla `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cars_plate_unique` (`plate`),
  ADD KEY `cars_category_id_foreign` (`category_id`),
  ADD KEY `cars_location_id_foreign` (`location_id`);

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payments_code_unique` (`code`),
  ADD KEY `payments_reservation_id_foreign` (`reservation_id`);

--
-- Indices de la tabla `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reservations_code_unique` (`code`),
  ADD KEY `reservations_user_id_foreign` (`user_id`),
  ADD KEY `reservations_car_id_foreign` (`car_id`),
  ADD KEY `reservations_location_id_foreign` (`location_id`),
  ADD KEY `reservations_payment_id_foreign` (`payment_id`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_license_number_unique` (`license_number`),
  ADD UNIQUE KEY `users_identification_number_unique` (`identification_number`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cars`
--
ALTER TABLE `cars`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cars`
--
ALTER TABLE `cars`
  ADD CONSTRAINT `cars_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `cars_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_reservation_id_foreign` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_car_id_foreign` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `reservations_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `reservations_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `reservations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
