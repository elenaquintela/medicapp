-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-05-2025 a las 21:16:14
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `medicapp`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cita`
--

DROP TABLE IF EXISTS `cita`;
CREATE TABLE IF NOT EXISTS `cita` (
  `id_cita` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_perfil` int(10) UNSIGNED NOT NULL,
  `id_usuario_crea` int(10) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time DEFAULT NULL,
  `motivo` varchar(150) NOT NULL,
  `ubicacion` varchar(120) NOT NULL,
  `especialidad` varchar(80) DEFAULT NULL,
  `recordatorio` tinyint(1) DEFAULT 1,
  `observaciones` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_cita`),
  KEY `fk_cita_perfil` (`id_perfil`),
  KEY `fk_cita_usuario` (`id_usuario_crea`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cita`
--

INSERT INTO `cita` (`id_cita`, `id_perfil`, `id_usuario_crea`, `fecha`, `hora_inicio`, `hora_fin`, `motivo`, `ubicacion`, `especialidad`, `recordatorio`, `observaciones`, `created_at`, `updated_at`) VALUES
(1, 26, 29, '2025-05-30', '15:31:00', NULL, 'Consulta', 'CHUS', 'Dermatología', 0, 'PROBA', '2025-05-28 10:31:35', '2025-05-30 12:38:53'),
(2, 27, 29, '2025-06-25', '10:32:00', NULL, 'Renovación de alta', 'Centro de salud de Fontiñas', 'Medicina de familia', 0, NULL, '2025-05-28 10:32:34', '2025-05-28 10:32:34'),
(3, 26, 29, '2025-06-06', '17:18:00', NULL, 'Consulta', 'CHUS', 'Medicina de familia', 0, NULL, '2025-05-28 10:33:04', '2025-05-28 10:33:04'),
(7, 35, 39, '2025-06-20', '09:16:00', NULL, 'Consulta', 'Centro de salud de Fontiñas', 'Digestivo', 0, 'fggdg', '2025-05-30 16:16:35', '2025-05-30 16:18:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `informe`
--

DROP TABLE IF EXISTS `informe`;
CREATE TABLE IF NOT EXISTS `informe` (
  `id_informe` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_usuario` int(10) UNSIGNED NOT NULL,
  `id_perfil` int(10) UNSIGNED NOT NULL,
  `tipo` enum('tratamientos','citas') NOT NULL,
  `rango_inicio` date NOT NULL,
  `rango_fin` date NOT NULL,
  `ruta_pdf` varchar(255) NOT NULL,
  `ts_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_informe`),
  KEY `fk_inf_usuario` (`id_usuario`),
  KEY `fk_inf_perfil` (`id_perfil`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicamento`
--

DROP TABLE IF EXISTS `medicamento`;
CREATE TABLE IF NOT EXISTS `medicamento` (
  `id_medicamento` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(120) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `id_cima` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_medicamento`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `medicamento`
--

INSERT INTO `medicamento` (`id_medicamento`, `nombre`, `descripcion`, `id_cima`, `created_at`, `updated_at`) VALUES
(1, 'medicacion2', NULL, NULL, '2025-05-09 08:32:46', '2025-05-09 08:32:46'),
(2, 'Insulina', NULL, NULL, '2025-05-09 08:46:49', '2025-05-09 08:46:49'),
(3, 'medicacion4', NULL, NULL, '2025-05-09 09:05:18', '2025-05-09 09:05:18'),
(4, 'medicacion1', NULL, NULL, '2025-05-09 09:10:27', '2025-05-09 09:10:27'),
(5, 'Paracetamol', NULL, NULL, '2025-05-09 09:42:38', '2025-05-09 09:42:38'),
(6, 'medicacion gota', NULL, NULL, '2025-05-09 12:52:50', '2025-05-09 12:52:50'),
(7, 'Eutirox', NULL, NULL, '2025-05-09 12:56:07', '2025-05-09 12:56:07'),
(8, 'Lupisan', NULL, NULL, '2025-05-09 14:02:18', '2025-05-09 14:02:18'),
(9, 'Ibuprofeno', NULL, NULL, '2025-05-29 07:45:15', '2025-05-29 07:45:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificacion`
--

DROP TABLE IF EXISTS `notificacion`;
CREATE TABLE IF NOT EXISTS `notificacion` (
  `id_notif` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_usuario_dest` int(10) UNSIGNED NOT NULL,
  `id_perfil` int(10) UNSIGNED DEFAULT NULL,
  `categoria` enum('toma','cita','perfil','otro') NOT NULL,
  `titulo` varchar(120) NOT NULL,
  `mensaje` varchar(255) DEFAULT NULL,
  `ts_programada` datetime NOT NULL,
  `leida` tinyint(1) DEFAULT 0,
  `ts_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_notif`),
  KEY `fk_notif_usuario` (`id_usuario_dest`),
  KEY `fk_notif_perfil` (`id_perfil`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil`
--

DROP TABLE IF EXISTS `perfil`;
CREATE TABLE IF NOT EXISTS `perfil` (
  `id_perfil` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre_paciente` varchar(80) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `sexo` enum('F','M','NB','O') NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_perfil`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `perfil`
--

INSERT INTO `perfil` (`id_perfil`, `nombre_paciente`, `fecha_nacimiento`, `sexo`, `created_at`, `updated_at`) VALUES
(1, 'paciente1', '1987-06-09', 'F', '2025-05-09 07:28:30', '2025-05-09 07:28:30'),
(2, 'paciente2', '2018-06-27', 'F', '2025-05-09 07:32:19', '2025-05-09 07:32:19'),
(3, 'paciente3', '2025-05-14', 'M', '2025-05-09 07:49:42', '2025-05-09 07:49:42'),
(4, 'paciente4', '2015-06-19', 'F', '2025-05-09 07:53:39', '2025-05-09 07:53:39'),
(5, 'paciente2', '2014-02-13', 'F', '2025-05-09 08:02:37', '2025-05-09 08:02:37'),
(6, 'paciente8', '2015-06-23', 'F', '2025-05-09 08:17:10', '2025-05-09 08:17:10'),
(7, 'paciente1', '2012-06-05', 'F', '2025-05-09 08:27:29', '2025-05-09 08:27:29'),
(8, 'paciente5', '2009-05-18', 'F', '2025-05-09 08:31:43', '2025-05-09 08:31:43'),
(9, 'paciente7', '1996-02-13', 'M', '2025-05-09 08:46:18', '2025-05-09 08:46:18'),
(10, 'paciente8', '2025-05-21', 'F', '2025-05-09 09:05:05', '2025-05-09 09:05:05'),
(11, 'paciente1', '2023-07-06', 'F', '2025-05-09 09:10:16', '2025-05-09 09:10:16'),
(12, 'paciente3', '2025-05-06', 'M', '2025-05-09 09:18:01', '2025-05-09 09:18:01'),
(13, 'paciente2', '2025-05-06', 'M', '2025-05-09 09:42:08', '2025-05-09 09:42:08'),
(14, 'paciente22', '2024-12-05', 'M', '2025-05-09 12:08:39', '2025-05-09 12:08:39'),
(15, 'paciente23', '2024-04-19', 'NB', '2025-05-09 12:52:07', '2025-05-09 12:52:07'),
(16, 'Rosario', '1960-01-08', 'F', '2025-05-09 12:55:17', '2025-05-09 12:55:17'),
(17, 'paciente3', '2024-12-13', 'M', '2025-05-09 14:02:01', '2025-05-09 14:02:01'),
(18, 'paciente8', '2024-05-06', 'F', '2025-05-09 14:18:56', '2025-05-09 14:18:56'),
(19, 'Fulano', '1991-02-12', 'NB', '2025-05-09 15:22:09', '2025-05-09 15:22:09'),
(20, 'Rosario', '2024-06-06', 'F', '2025-05-09 15:24:10', '2025-05-09 15:24:10'),
(21, 'paciente24', '1991-09-23', 'M', '2025-05-19 09:51:54', '2025-05-19 09:51:54'),
(22, 'paciente8', '1968-03-09', 'F', '2025-05-19 09:54:07', '2025-05-19 09:54:07'),
(23, 'paciente3', '1975-05-04', 'F', '2025-05-19 10:19:43', '2025-05-19 10:19:43'),
(24, 'yutyuit', '1996-04-05', 'F', '2025-05-19 10:21:41', '2025-05-19 10:21:41'),
(25, 'paciente1', '1987-04-04', 'F', '2025-05-26 08:41:36', '2025-05-26 08:41:36'),
(26, 'paciente8', '1977-05-05', 'F', '2025-05-26 11:15:41', '2025-05-26 11:15:41'),
(27, 'paciente2', '1984-07-07', 'M', '2025-05-26 11:16:44', '2025-05-26 11:16:44'),
(28, 'paciente1', '1976-11-24', 'M', '2025-05-29 07:44:20', '2025-05-29 07:44:20'),
(29, 'paciente2', '1954-03-09', 'F', '2025-05-30 09:25:17', '2025-05-30 09:25:17'),
(30, 'paciente1', '1967-12-09', 'F', '2025-05-30 14:35:01', '2025-05-30 14:35:01'),
(31, 'paciente1', '1978-03-31', 'M', '2025-05-30 15:18:32', '2025-05-30 15:18:32'),
(32, 'paciente2', '1990-03-05', 'F', '2025-05-30 15:27:49', '2025-05-30 15:27:49'),
(33, 'paciente1', '1999-09-09', 'F', '2025-05-30 15:35:29', '2025-05-30 15:35:29'),
(34, 'paciente1', '1900-09-09', 'F', '2025-05-30 15:45:45', '2025-05-30 15:45:45'),
(35, 'paciente1', '1999-08-08', 'F', '2025-05-30 15:58:54', '2025-05-30 15:58:54');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tratamiento`
--

DROP TABLE IF EXISTS `tratamiento`;
CREATE TABLE IF NOT EXISTS `tratamiento` (
  `id_tratamiento` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_perfil` int(10) UNSIGNED NOT NULL,
  `causa` varchar(150) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `estado` enum('activo','archivado') DEFAULT 'activo',
  `ts_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_tratamiento`),
  KEY `fk_trat_perfil` (`id_perfil`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tratamiento`
--

INSERT INTO `tratamiento` (`id_tratamiento`, `id_perfil`, `causa`, `fecha_inicio`, `estado`, `ts_creacion`, `created_at`, `updated_at`) VALUES
(1, 2, 'Catarro', '2025-05-09', 'activo', '2025-05-09 09:32:19', '2025-05-09 07:32:19', '2025-05-09 07:32:19'),
(2, 3, 'Diabetes', '2025-05-09', 'activo', '2025-05-09 09:49:42', '2025-05-09 07:49:42', '2025-05-09 07:49:42'),
(3, 4, 'Diabetes', '2025-05-09', 'activo', '2025-05-09 09:53:39', '2025-05-09 07:53:39', '2025-05-09 07:53:39'),
(4, 5, 'Diabetes', '2025-05-09', 'activo', '2025-05-09 10:02:37', '2025-05-09 08:02:37', '2025-05-09 08:02:37'),
(5, 6, 'Diabetes', '2025-05-09', 'activo', '2025-05-09 10:17:10', '2025-05-09 08:17:10', '2025-05-09 08:17:10'),
(6, 7, 'Diabetes', '2025-05-09', 'activo', '2025-05-09 10:27:29', '2025-05-09 08:27:29', '2025-05-09 08:27:29'),
(7, 8, 'Catarro', '2025-05-09', 'activo', '2025-05-09 10:31:43', '2025-05-09 08:31:43', '2025-05-09 08:31:43'),
(8, 9, 'Diabetes', '2025-05-09', 'activo', '2025-05-09 10:46:18', '2025-05-09 08:46:18', '2025-05-09 08:46:18'),
(9, 10, 'Diabetes', '2025-05-09', 'activo', '2025-05-09 11:05:05', '2025-05-09 09:05:05', '2025-05-09 09:05:05'),
(10, 11, 'Catarro', '2025-05-09', 'activo', '2025-05-09 11:10:16', '2025-05-09 09:10:16', '2025-05-09 09:10:16'),
(11, 12, 'Catarro', '2025-05-09', 'activo', '2025-05-09 11:18:01', '2025-05-09 09:18:01', '2025-05-09 09:18:01'),
(12, 13, 'Catarro', '2025-05-09', 'activo', '2025-05-09 11:42:08', '2025-05-09 09:42:08', '2025-05-09 09:42:08'),
(13, 14, 'Diabetes', '2025-05-09', 'activo', '2025-05-09 14:08:39', '2025-05-09 12:08:39', '2025-05-09 12:08:39'),
(14, 15, 'Gota', '2025-05-09', 'activo', '2025-05-09 14:52:07', '2025-05-09 12:52:07', '2025-05-09 12:52:07'),
(15, 16, 'Hipotiroidismo', '2025-05-09', 'activo', '2025-05-09 14:55:17', '2025-05-09 12:55:17', '2025-05-09 12:55:17'),
(16, 17, 'Lupus', '2025-05-09', 'activo', '2025-05-09 16:02:01', '2025-05-09 14:02:01', '2025-05-09 14:02:01'),
(17, 18, 'Hipotiroidismo', '2025-05-09', 'activo', '2025-05-09 16:18:56', '2025-05-09 14:18:56', '2025-05-09 14:18:56'),
(19, 18, 'Diabetes', '2025-05-09', 'activo', '2025-05-09 17:14:27', '2025-05-09 15:14:27', '2025-05-09 15:14:27'),
(20, 17, 'Catarro', '2025-05-09', 'activo', '2025-05-09 17:15:04', '2025-05-09 15:15:04', '2025-05-09 15:15:04'),
(21, 19, 'Lupus', '2025-05-09', 'activo', '2025-05-09 17:22:09', '2025-05-09 15:22:09', '2025-05-09 15:22:09'),
(22, 20, 'Catarro', '2025-05-09', 'activo', '2025-05-09 17:24:10', '2025-05-09 15:24:10', '2025-05-09 15:24:10'),
(23, 19, 'Hipotiroidismo', '2025-05-09', 'activo', '2025-05-09 17:24:54', '2025-05-09 15:24:54', '2025-05-09 15:24:54'),
(24, 21, 'Bronquitis', '2025-05-19', 'activo', '2025-05-19 11:51:54', '2025-05-19 09:51:54', '2025-05-19 09:51:54'),
(25, 21, 'Catarro', '2025-05-19', 'activo', '2025-05-19 11:52:51', '2025-05-19 09:52:51', '2025-05-19 09:52:51'),
(26, 22, 'Diabetes', '2025-05-19', 'activo', '2025-05-19 11:54:07', '2025-05-19 09:54:07', '2025-05-19 09:54:07'),
(27, 23, 'Catarro', '2025-05-19', 'activo', '2025-05-19 12:19:43', '2025-05-19 10:19:43', '2025-05-19 10:19:43'),
(28, 24, 'Hipotiroidismo', '2025-05-19', 'activo', '2025-05-19 12:21:41', '2025-05-19 10:21:41', '2025-05-19 10:21:41'),
(29, 25, 'Diabetes', '2025-05-26', 'activo', '2025-05-26 10:41:36', '2025-05-26 08:41:36', '2025-05-26 08:41:36'),
(30, 26, 'Catarro', '2025-05-26', 'activo', '2025-05-26 13:15:41', '2025-05-26 11:15:41', '2025-05-26 11:15:41'),
(31, 27, 'Lupus', '2025-05-26', 'activo', '2025-05-26 13:16:44', '2025-05-26 11:16:44', '2025-05-26 11:16:44'),
(32, 27, 'Gota', '2025-05-26', 'activo', '2025-05-26 13:17:18', '2025-05-26 11:17:18', '2025-05-26 11:17:18'),
(33, 26, 'Bronquitis', '2025-05-28', 'activo', '2025-05-28 12:49:31', '2025-05-28 10:49:31', '2025-05-28 10:49:31'),
(34, 28, 'Catarro', '2025-05-29', 'activo', '2025-05-29 09:44:20', '2025-05-29 07:44:20', '2025-05-29 07:44:20'),
(35, 28, 'Diabetes', '2025-05-29', 'activo', '2025-05-29 10:56:35', '2025-05-29 08:56:35', '2025-05-29 08:56:35'),
(36, 29, 'Lupus', '2025-05-30', 'activo', '2025-05-30 11:25:18', '2025-05-30 09:25:18', '2025-05-30 09:25:18'),
(37, 30, 'Catarro', '2025-05-30', 'activo', '2025-05-30 16:35:01', '2025-05-30 14:35:01', '2025-05-30 14:35:01'),
(38, 31, 'Catarro', '2025-05-30', 'activo', '2025-05-30 17:18:32', '2025-05-30 15:18:32', '2025-05-30 15:18:32'),
(39, 32, 'Lupus', '2025-05-30', 'activo', '2025-05-30 17:27:49', '2025-05-30 15:27:49', '2025-05-30 15:27:49'),
(40, 33, 'Catarro', '2025-05-30', 'activo', '2025-05-30 17:35:29', '2025-05-30 15:35:29', '2025-05-30 15:35:29'),
(41, 34, 'Catarro', '2025-05-30', 'activo', '2025-05-30 17:45:45', '2025-05-30 15:45:45', '2025-05-30 15:45:45'),
(42, 35, 'Catarro', '2025-05-30', 'activo', '2025-05-30 17:58:54', '2025-05-30 15:58:54', '2025-05-30 15:58:54'),
(43, 35, 'Lupus', '2025-05-30', 'activo', '2025-05-30 18:11:16', '2025-05-30 16:11:16', '2025-05-30 16:11:16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tratamiento_medicamento`
--

DROP TABLE IF EXISTS `tratamiento_medicamento`;
CREATE TABLE IF NOT EXISTS `tratamiento_medicamento` (
  `id_trat_med` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_tratamiento` int(10) UNSIGNED NOT NULL,
  `id_medicamento` int(10) UNSIGNED NOT NULL,
  `indicacion` varchar(120) NOT NULL,
  `presentacion` enum('comprimidos','jarabe','gotas','inyeccion','pomada','parche','polvo','spray','otro') NOT NULL,
  `via` enum('oral','topica','nasal','ocular','otica','intravenosa','intramuscular','subcutanea','rectal','inhalatoria','otro') NOT NULL,
  `dosis` varchar(50) NOT NULL,
  `pauta_intervalo` smallint(5) UNSIGNED NOT NULL,
  `pauta_unidad` enum('horas','dias','semanas','meses') NOT NULL,
  `observaciones` varchar(255) DEFAULT NULL,
  `estado` enum('activo','archivado') DEFAULT 'activo',
  `sustituido_por` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_trat_med`),
  KEY `fk_tm_trat` (`id_tratamiento`),
  KEY `fk_tm_medic` (`id_medicamento`),
  KEY `fk_tm_subs` (`sustituido_por`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tratamiento_medicamento`
--

INSERT INTO `tratamiento_medicamento` (`id_trat_med`, `id_tratamiento`, `id_medicamento`, `indicacion`, `presentacion`, `via`, `dosis`, `pauta_intervalo`, `pauta_unidad`, `observaciones`, `estado`, `sustituido_por`, `created_at`, `updated_at`) VALUES
(1, 7, 1, 'Náuseas', 'inyeccion', 'intravenosa', '1mg', 1, 'dias', 'Brazo izquierdo', 'activo', NULL, '2025-05-09 08:32:46', '2025-05-09 08:32:46'),
(2, 8, 2, 'Control azucar', 'inyeccion', 'intravenosa', '1mg', 1, 'dias', 'Ayunas', 'activo', NULL, '2025-05-09 08:46:49', '2025-05-09 08:46:49'),
(3, 9, 3, 'Náuseas', 'comprimidos', 'oral', '1mg', 2, 'horas', 'fyhrteyrtyrtyu', 'activo', NULL, '2025-05-09 09:05:18', '2025-05-09 09:05:18'),
(4, 10, 4, 'Náuseas', 'comprimidos', 'oral', '1mg', 2, 'horas', 'dfsdfgsdgs', 'activo', NULL, '2025-05-09 09:10:27', '2025-05-09 09:10:27'),
(5, 11, 3, 'Náuseas', 'comprimidos', 'intramuscular', '23mg', 3, 'horas', 'gjhfjfgjjf', 'activo', NULL, '2025-05-09 09:18:14', '2025-05-09 09:18:14'),
(6, 12, 5, 'Dolor', 'comprimidos', 'oral', '1g', 8, 'horas', 'En ayunas', 'activo', NULL, '2025-05-09 09:42:38', '2025-05-09 09:42:38'),
(7, 13, 2, 'Control azucar', 'inyeccion', 'intravenosa', '1mg', 1, 'dias', NULL, 'activo', NULL, '2025-05-09 12:09:04', '2025-05-09 12:09:04'),
(8, 14, 6, 'Dolor', 'pomada', 'rectal', '1g', 1, 'dias', 'PEC', 'activo', NULL, '2025-05-09 12:52:50', '2025-05-09 12:52:50'),
(9, 15, 7, 'Tiroides', 'comprimidos', 'oral', '50mg', 1, 'dias', 'En ayunas', 'activo', NULL, '2025-05-09 12:56:07', '2025-05-09 12:56:07'),
(10, 16, 8, 'Dolor', 'comprimidos', 'oral', '1g', 3, 'horas', NULL, 'activo', NULL, '2025-05-09 14:02:18', '2025-05-09 14:02:18'),
(11, 17, 7, 'Tiroides', 'comprimidos', 'oral', '50mg', 1, 'dias', '30 min antes del desayuno', 'activo', NULL, '2025-05-09 14:19:33', '2025-05-09 14:19:33'),
(13, 19, 2, 'Control azucar', 'inyeccion', 'intravenosa', '1g', 1, 'dias', 'hjhkgjkygjk', 'activo', NULL, '2025-05-09 15:14:45', '2025-05-09 15:14:45'),
(14, 20, 5, 'Dolor', 'comprimidos', 'oral', '1g', 8, 'horas', 'Después de las comidas', 'activo', NULL, '2025-05-09 15:15:29', '2025-05-09 15:15:29'),
(15, 20, 3, 'Mucosidad', 'jarabe', 'nasal', '23mg', 1, 'dias', NULL, 'activo', NULL, '2025-05-09 15:15:54', '2025-05-09 15:15:54'),
(16, 21, 8, 'Dolor', 'pomada', 'rectal', '1g', 2, 'horas', 'PEC, en ayunas', 'activo', NULL, '2025-05-09 15:23:04', '2025-05-09 15:23:04'),
(17, 22, 5, 'Náuseas', 'comprimidos', 'oral', '1g', 4, 'horas', NULL, 'activo', NULL, '2025-05-09 15:24:22', '2025-05-09 15:24:22'),
(18, 23, 7, 'Tiroides', 'comprimidos', 'oral', '50mg', 1, 'dias', '30min antes de desayuno', 'activo', NULL, '2025-05-09 15:25:23', '2025-05-09 15:25:23'),
(19, 24, 3, 'Tos', 'spray', 'inhalatoria', '25mg', 12, 'horas', NULL, 'activo', NULL, '2025-05-19 09:52:34', '2025-05-19 09:52:34'),
(20, 25, 5, 'Dolor', 'comprimidos', 'oral', '1g', 12, 'horas', NULL, 'activo', NULL, '2025-05-19 09:53:04', '2025-05-19 09:53:04'),
(21, 26, 5, 'Dolor', 'comprimidos', 'oral', '1g', 12, 'horas', NULL, 'activo', NULL, '2025-05-19 09:54:17', '2025-05-19 09:54:17'),
(22, 27, 5, 'Náuseas', 'comprimidos', 'oral', '23mg', 3, 'horas', NULL, 'activo', NULL, '2025-05-19 10:19:51', '2025-05-19 10:19:51'),
(23, 28, 2, 'Control azucar', 'comprimidos', 'oral', '50mg', 3, 'horas', NULL, 'activo', NULL, '2025-05-19 10:21:49', '2025-05-19 10:21:49'),
(24, 29, 5, 'Dolor', 'comprimidos', 'oral', '1g', 8, 'horas', NULL, 'activo', NULL, '2025-05-26 08:41:53', '2025-05-26 08:41:53'),
(25, 30, 5, 'Dolor', 'comprimidos', 'oral', '1g', 5, 'horas', 'dfsgsdg', 'activo', NULL, '2025-05-26 11:15:52', '2025-05-26 11:15:52'),
(26, 31, 8, 'Náuseas', 'spray', 'nasal', '50mg', 4, 'horas', 'tyjiykg', 'activo', NULL, '2025-05-26 11:17:06', '2025-05-26 11:17:06'),
(27, 32, 4, 'Mucosidad', 'comprimidos', 'oral', '1g', 8, 'horas', 'fjhfgfj', 'activo', NULL, '2025-05-26 11:17:37', '2025-05-26 11:17:37'),
(28, 33, 5, 'Náuseas', 'comprimidos', 'oral', '50mg', 3, 'horas', NULL, 'activo', NULL, '2025-05-28 10:49:43', '2025-05-28 10:49:43'),
(29, 34, 5, 'Dolor', 'comprimidos', 'oral', '1g', 8, 'horas', NULL, 'activo', NULL, '2025-05-29 07:44:39', '2025-05-29 07:44:39'),
(30, 34, 9, 'Dolor', 'comprimidos', 'oral', '600mg', 8, 'horas', NULL, 'activo', NULL, '2025-05-29 07:45:15', '2025-05-29 07:45:15'),
(31, 36, 8, 'Tos', 'inyeccion', 'intravenosa', '1mg', 1, 'dias', NULL, 'activo', NULL, '2025-05-30 09:25:45', '2025-05-30 09:25:45'),
(32, 37, 5, 'Dolor', 'comprimidos', 'oral', '1g', 3, 'horas', NULL, 'activo', NULL, '2025-05-30 14:38:19', '2025-05-30 14:38:19'),
(33, 38, 5, 'Dolor', 'comprimidos', 'oral', '1g', 8, 'horas', NULL, 'activo', NULL, '2025-05-30 15:18:44', '2025-05-30 15:18:44'),
(34, 38, 7, 'Tiroides', 'comprimidos', 'oral', '50mg', 1, 'dias', NULL, 'activo', NULL, '2025-05-30 15:19:01', '2025-05-30 15:19:01'),
(35, 39, 8, 'Control azucar', 'comprimidos', 'oral', '1mg', 4, 'horas', NULL, 'activo', NULL, '2025-05-30 15:28:01', '2025-05-30 15:28:01'),
(36, 40, 5, 'Dolor', 'comprimidos', 'oral', '1g', 2, 'horas', NULL, 'activo', NULL, '2025-05-30 15:35:42', '2025-05-30 15:35:42'),
(37, 41, 5, 'Dolor', 'comprimidos', 'oral', '1g', 2, 'horas', NULL, 'activo', NULL, '2025-05-30 15:50:01', '2025-05-30 15:50:01'),
(38, 42, 5, 'Dolor', 'comprimidos', 'oral', '1g', 2, 'horas', NULL, 'activo', NULL, '2025-05-30 15:59:01', '2025-05-30 15:59:01'),
(39, 42, 2, 'Control azucar', 'comprimidos', 'oral', '1mg', 3, 'horas', 'jdfndsiofbnsdf', 'activo', NULL, '2025-05-30 15:59:14', '2025-05-30 15:59:14'),
(40, 43, 2, 'Control azucar', 'comprimidos', 'oral', '23mg', 2, 'horas', NULL, 'activo', NULL, '2025-05-30 16:11:23', '2025-05-30 16:11:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id_usuario` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) NOT NULL,
  `email` varchar(120) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `rol_global` enum('estandar','premium') DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre`, `email`, `contrasena`, `rol_global`, `remember_token`, `created_at`, `updated_at`) VALUES
(6, 'proba4', 'proba4@proba.com', '$2y$12$kJUUX05kaCW67yiiHI1pOuUgqxKYwAY8Wl5nPO.mHfbcoinvNBnEC', 'estandar', NULL, '2025-05-09 07:31:54', '2025-05-09 07:31:54'),
(15, 'proba', 'proba@gmail.com', '$2y$12$6E4G6c1ldlDJWzX.jhKzS.QmhBdaR7L4OzbLfkqaJsV7SDL6hbESK', 'estandar', NULL, '2025-05-09 09:10:00', '2025-05-09 09:10:00'),
(17, 'tytytryr', 'proba7@proba.com', '$2y$12$vpbyqIlx2NkFudb6N4rhIO1cw8DBl.S4xpXSCKWg1bnGb0eyoUOUm', 'estandar', NULL, '2025-05-09 09:18:45', '2025-05-09 09:18:45'),
(20, 'andres', 'proba11@proba.com', '$2y$12$4hbLwJEq4UNk0Fa3l/CbKOFGBMmRWJMqYFryTa0.JdpilO/v6efB6', 'estandar', NULL, '2025-05-09 14:01:32', '2025-05-09 14:01:32'),
(21, 'elenita', 'proba32@proba.com', '$2y$12$wVBNDZD1lsyHHDoJnjVqiOvr9.TE78I.V8x7AxzBrp/uvkXuDYBny', 'estandar', NULL, '2025-05-09 15:21:22', '2025-05-09 15:21:22'),
(22, 'fulanito', 'proba5@proba.com', '$2y$12$t2vrVFY5PbUTjR2DEcptLO/W8.jrXply9rN99o/GLGzukCfSUU/D6', 'estandar', NULL, '2025-05-19 09:53:41', '2025-05-19 09:53:41'),
(29, 'proba', 'proba@proba.com', '$2y$12$4sOQ09sKfWLgbn2ijkO2geQNC57z537fnvK1PUBg2xuBSBRiTcyXe', 'estandar', NULL, '2025-05-26 11:15:21', '2025-05-30 15:07:48'),
(31, 'elena', 'proba12@proba.com', '$2y$12$Xd4q/U/EUz75KgoHs2GuBule6t1sjkQuayMQ1fKmOtbbAKjPSruNG', 'estandar', NULL, '2025-05-30 14:32:48', '2025-05-30 14:34:37'),
(32, 'elena2', 'proba13@proba.com', '$2y$12$lsyFARmD6H94KjZa3.9da.wG826w.S3Ld8mmhkKODLPbNyuATa4iG', NULL, NULL, '2025-05-30 15:11:18', '2025-05-30 15:11:18'),
(33, 'elena3', 'proba14@proba.com', '$2y$12$DsRtilfTwi/ExpcduflW6uEboyVQPQV2PpoZ.lJl8gyymuc2swFbO', 'estandar', NULL, '2025-05-30 15:12:53', '2025-05-30 15:13:03'),
(34, 'novo', 'novo@proba.com', '$2y$12$D0xPKh0UU6w3UcMu.Pr/H.wyMju2ZTzQzvPNlipcXlKi2R23CbWkS', 'estandar', NULL, '2025-05-30 15:18:14', '2025-05-30 15:18:17'),
(35, 'andres', 'andres@proba.com', '$2y$12$DCDM9QpTLcwIgxdGqPVyd.wxVx0p.lUSJPDSOqp4eA3vS69akzXKS', 'premium', NULL, '2025-05-30 15:28:35', '2025-05-30 15:28:37'),
(36, 'elena4', 'proba15@gmail.com', '$2y$12$3ICZz2dPXVmI7.KJwH7wwekzm.zevn7VReBfJ5A9EWyoOLPJ3eLNO', 'estandar', NULL, '2025-05-30 15:35:10', '2025-05-30 15:35:14'),
(37, 'proba', 'proba16@proba.com', '$2y$12$ynsaLVU/gGIHX5hVeu76NuxjuufIdVkTb3PWRum4XFaHPatxBUVaq', NULL, NULL, '2025-05-30 15:38:43', '2025-05-30 15:38:43'),
(38, 'proba', 'proba17@proba.com', '$2y$12$Etb.uQSSHli.8RlNMRhl3uxM7IVheA4jfoWrYHFGRK/Vqzg8T/.w6', 'estandar', NULL, '2025-05-30 15:41:42', '2025-05-30 15:41:48'),
(39, 'elena', 'proba18@proba.com', '$2y$12$C0Rb/C3hMfj2iqd3OnzfJeP5YvrZHov/Mqae9blOEZ2lGsoUs.L3q', 'estandar', NULL, '2025-05-30 15:58:41', '2025-05-30 15:58:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_perfil`
--

DROP TABLE IF EXISTS `usuario_perfil`;
CREATE TABLE IF NOT EXISTS `usuario_perfil` (
  `id_usuario` int(10) UNSIGNED NOT NULL,
  `id_perfil` int(10) UNSIGNED NOT NULL,
  `rol_en_perfil` enum('creador','invitado') NOT NULL,
  `fecha_inv` datetime DEFAULT NULL,
  `estado` enum('pendiente','aceptada','cancelada') DEFAULT 'aceptada',
  PRIMARY KEY (`id_usuario`,`id_perfil`),
  KEY `fk_up_perfil` (`id_perfil`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuario_perfil`
--

INSERT INTO `usuario_perfil` (`id_usuario`, `id_perfil`, `rol_en_perfil`, `fecha_inv`, `estado`) VALUES
(6, 2, 'creador', NULL, 'aceptada'),
(6, 14, 'creador', NULL, 'aceptada'),
(6, 15, 'creador', NULL, 'aceptada'),
(6, 21, 'creador', NULL, 'aceptada'),
(15, 11, 'creador', NULL, 'aceptada'),
(20, 17, 'creador', NULL, 'aceptada'),
(20, 18, 'creador', NULL, 'aceptada'),
(21, 19, 'creador', NULL, 'aceptada'),
(21, 20, 'creador', NULL, 'aceptada'),
(22, 22, 'creador', NULL, 'aceptada'),
(29, 26, 'creador', NULL, 'aceptada'),
(29, 27, 'creador', NULL, 'aceptada'),
(31, 30, 'creador', NULL, 'aceptada'),
(34, 31, 'creador', NULL, 'aceptada'),
(34, 32, 'creador', NULL, 'aceptada'),
(36, 33, 'creador', NULL, 'aceptada'),
(38, 34, 'creador', NULL, 'aceptada'),
(39, 35, 'creador', NULL, 'aceptada');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cita`
--
ALTER TABLE `cita`
  ADD CONSTRAINT `fk_cita_perfil` FOREIGN KEY (`id_perfil`) REFERENCES `perfil` (`id_perfil`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_cita_usuario` FOREIGN KEY (`id_usuario_crea`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `informe`
--
ALTER TABLE `informe`
  ADD CONSTRAINT `fk_inf_perfil` FOREIGN KEY (`id_perfil`) REFERENCES `perfil` (`id_perfil`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_inf_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `notificacion`
--
ALTER TABLE `notificacion`
  ADD CONSTRAINT `fk_notif_perfil` FOREIGN KEY (`id_perfil`) REFERENCES `perfil` (`id_perfil`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_notif_usuario` FOREIGN KEY (`id_usuario_dest`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tratamiento`
--
ALTER TABLE `tratamiento`
  ADD CONSTRAINT `fk_trat_perfil` FOREIGN KEY (`id_perfil`) REFERENCES `perfil` (`id_perfil`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tratamiento_medicamento`
--
ALTER TABLE `tratamiento_medicamento`
  ADD CONSTRAINT `fk_tm_medic` FOREIGN KEY (`id_medicamento`) REFERENCES `medicamento` (`id_medicamento`),
  ADD CONSTRAINT `fk_tm_subs` FOREIGN KEY (`sustituido_por`) REFERENCES `tratamiento_medicamento` (`id_trat_med`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_tm_trat` FOREIGN KEY (`id_tratamiento`) REFERENCES `tratamiento` (`id_tratamiento`) ON DELETE CASCADE;

--
-- Filtros para la tabla `usuario_perfil`
--
ALTER TABLE `usuario_perfil`
  ADD CONSTRAINT `fk_up_perfil` FOREIGN KEY (`id_perfil`) REFERENCES `perfil` (`id_perfil`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_up_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
