-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-08-2025 a las 12:35:06
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

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel_cache_5c785c036466adea360111aa28563bfd556b5fba', 'i:1;', 1755105386),
('laravel_cache_5c785c036466adea360111aa28563bfd556b5fba:timer', 'i:1755105386;', 1755105386),
('laravel_cache_c1dfd96eea8cc2b62785275bca38ac261256e278', 'i:1;', 1755105269),
('laravel_cache_c1dfd96eea8cc2b62785275bca38ac261256e278:timer', 'i:1755105269;', 1755105269),
('laravel_cache_proba@proba.com|127.0.0.1', 'i:1;', 1755099521),
('laravel_cache_proba@proba.com|127.0.0.1:timer', 'i:1755099521;', 1755099521);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cita`
--

CREATE TABLE `cita` (
  `id_cita` int(10) UNSIGNED NOT NULL,
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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `informe`
--

CREATE TABLE `informe` (
  `id_informe` int(10) UNSIGNED NOT NULL,
  `id_usuario` int(10) UNSIGNED NOT NULL,
  `id_perfil` int(10) UNSIGNED NOT NULL,
  `id_tratamiento` int(10) UNSIGNED DEFAULT NULL,
  `rango_inicio` date NOT NULL,
  `rango_fin` date NOT NULL,
  `ruta_pdf` varchar(255) NOT NULL,
  `ts_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `informe`
--

INSERT INTO `informe` (`id_informe`, `id_usuario`, `id_perfil`, `id_tratamiento`, `rango_inicio`, `rango_fin`, `ruta_pdf`, `ts_creacion`) VALUES
(3, 4, 5, 6, '2025-08-12', '2025-08-14', 'informes/informe_5_t6_20250814_112429.pdf', '2025-08-14 09:24:31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicamento`
--

CREATE TABLE `medicamento` (
  `id_medicamento` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(120) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `id_cima` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `medicamento`
--

INSERT INTO `medicamento` (`id_medicamento`, `nombre`, `descripcion`, `id_cima`, `created_at`, `updated_at`) VALUES
(1, 'Paracetamol', NULL, NULL, '2025-08-11 16:17:17', '2025-08-11 16:17:17'),
(2, 'Insulina', NULL, NULL, '2025-08-11 16:46:20', '2025-08-11 16:46:20'),
(3, 'medicacion1', NULL, NULL, '2025-08-12 17:21:43', '2025-08-12 17:21:43'),
(4, 'Lupisan', NULL, NULL, '2025-08-12 17:22:09', '2025-08-12 17:22:09'),
(5, 'medicacion4', NULL, NULL, '2025-08-14 10:33:16', '2025-08-14 10:33:16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

CREATE TABLE `notificacion` (
  `id_notif` bigint(20) UNSIGNED NOT NULL,
  `id_usuario_dest` int(10) UNSIGNED NOT NULL,
  `id_perfil` int(10) UNSIGNED DEFAULT NULL,
  `categoria` enum('toma','cita','perfil','otro') NOT NULL,
  `titulo` varchar(120) NOT NULL,
  `mensaje` varchar(255) DEFAULT NULL,
  `ts_programada` datetime NOT NULL,
  `leida` tinyint(1) DEFAULT 0,
  `ts_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil`
--

CREATE TABLE `perfil` (
  `id_perfil` int(10) UNSIGNED NOT NULL,
  `nombre_paciente` varchar(80) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `sexo` enum('F','M','NB','O') NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `perfil`
--

INSERT INTO `perfil` (`id_perfil`, `nombre_paciente`, `fecha_nacimiento`, `sexo`, `created_at`, `updated_at`) VALUES
(5, 'paciente1', '1988-07-07', 'F', '2025-08-12 17:05:20', '2025-08-12 17:05:20'),
(6, 'paciente1', '1989-08-08', 'F', '2025-08-12 17:18:36', '2025-08-12 17:18:36'),
(14, 'paciente2', '2001-06-06', 'F', '2025-08-13 17:09:09', '2025-08-13 17:09:09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil_invitacion`
--

CREATE TABLE `perfil_invitacion` (
  `id_invitacion` int(10) UNSIGNED NOT NULL,
  `id_perfil` int(10) UNSIGNED NOT NULL,
  `id_usuario_invitador` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `estado` enum('pendiente','aceptada','revocada','expirada') NOT NULL DEFAULT 'pendiente',
  `expires_at` datetime DEFAULT NULL,
  `accepted_at` datetime DEFAULT NULL,
  `id_usuario_invitado` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `perfil_invitacion`
--

INSERT INTO `perfil_invitacion` (`id_invitacion`, `id_perfil`, `id_usuario_invitador`, `email`, `token`, `estado`, `expires_at`, `accepted_at`, `id_usuario_invitado`, `created_at`, `updated_at`) VALUES
(1, 5, 4, 'a23elenaqb@iessanclemente.net', 'ZMK3FJ7uYWunvP5Iu3rH1BtDPLJpbXMcCFd6xpSWbWtO1yk6', 'aceptada', '2025-08-20 18:54:02', '2025-08-13 19:05:09', 6, '2025-08-13 16:54:02', '2025-08-13 17:05:09'),
(2, 5, 4, 'proba3@proba.com', 'vx0BlX3xWN7vUQ8BFu6cRBcDWA8BH6ZePPMffr0JoDi7b6Gc', 'aceptada', '2025-08-20 19:12:52', '2025-08-13 19:15:39', NULL, '2025-08-13 17:12:52', '2025-08-13 17:15:39');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recordatorio`
--

CREATE TABLE `recordatorio` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_trat_med` int(10) UNSIGNED NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `tomado` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `recordatorio`
--

INSERT INTO `recordatorio` (`id`, `id_trat_med`, `fecha_hora`, `tomado`, `created_at`, `updated_at`) VALUES
(55, 5, '2025-08-12 01:00:00', 0, '2025-08-12 17:05:52', '2025-08-12 17:05:52'),
(56, 5, '2025-08-12 09:00:00', 0, '2025-08-12 17:05:52', '2025-08-12 17:05:52'),
(57, 5, '2025-08-12 17:00:00', 0, '2025-08-12 17:05:52', '2025-08-12 17:05:52'),
(58, 5, '2025-08-13 01:00:00', 0, '2025-08-12 17:05:52', '2025-08-13 18:59:20'),
(59, 5, '2025-08-13 09:00:00', 0, '2025-08-12 17:05:52', '2025-08-12 17:05:52'),
(60, 5, '2025-08-13 17:00:00', 0, '2025-08-12 17:05:52', '2025-08-12 17:05:52'),
(61, 5, '2025-08-14 01:00:00', 0, '2025-08-12 17:05:52', '2025-08-12 17:05:52'),
(62, 5, '2025-08-14 09:00:00', 0, '2025-08-12 17:05:52', '2025-08-12 17:05:52'),
(63, 5, '2025-08-14 17:00:00', 0, '2025-08-12 17:05:52', '2025-08-12 17:05:52'),
(66, 6, '2025-08-12 02:00:00', 0, '2025-08-12 17:18:58', '2025-08-12 17:18:58'),
(67, 6, '2025-08-12 11:00:00', 0, '2025-08-12 17:18:58', '2025-08-12 17:18:58'),
(68, 6, '2025-08-12 20:00:00', 0, '2025-08-12 17:18:58', '2025-08-12 17:18:58'),
(69, 6, '2025-08-13 05:00:00', 0, '2025-08-12 17:18:58', '2025-08-12 17:18:58'),
(70, 6, '2025-08-13 14:00:00', 0, '2025-08-12 17:18:58', '2025-08-12 17:18:58'),
(71, 6, '2025-08-13 23:00:00', 0, '2025-08-12 17:18:58', '2025-08-12 17:18:58'),
(72, 6, '2025-08-14 08:00:00', 0, '2025-08-12 17:18:58', '2025-08-12 17:18:58'),
(73, 6, '2025-08-14 17:00:00', 0, '2025-08-12 17:18:58', '2025-08-12 17:18:58'),
(74, 7, '2025-08-12 05:06:00', 0, '2025-08-12 17:19:19', '2025-08-12 17:19:19'),
(75, 7, '2025-08-12 13:06:00', 0, '2025-08-12 17:19:19', '2025-08-12 17:19:19'),
(76, 7, '2025-08-12 21:06:00', 0, '2025-08-12 17:19:19', '2025-08-12 17:19:19'),
(77, 7, '2025-08-13 05:06:00', 0, '2025-08-12 17:19:19', '2025-08-12 17:19:19'),
(78, 7, '2025-08-13 13:06:00', 0, '2025-08-12 17:19:19', '2025-08-12 17:19:19'),
(79, 7, '2025-08-13 21:06:00', 0, '2025-08-12 17:19:19', '2025-08-12 17:19:19'),
(80, 7, '2025-08-14 05:06:00', 0, '2025-08-12 17:19:19', '2025-08-12 17:19:19'),
(81, 7, '2025-08-14 13:06:00', 0, '2025-08-12 17:19:19', '2025-08-12 17:19:19'),
(162, 5, '2025-08-15 01:00:00', 0, '2025-08-13 15:38:42', '2025-08-13 15:38:42'),
(163, 5, '2025-08-15 09:00:00', 0, '2025-08-13 15:38:42', '2025-08-13 15:38:42'),
(164, 5, '2025-08-15 17:00:00', 0, '2025-08-13 15:38:42', '2025-08-13 15:38:42'),
(165, 16, '2025-08-13 06:03:00', 0, '2025-08-13 17:09:28', '2025-08-13 17:09:28'),
(166, 16, '2025-08-13 13:03:00', 0, '2025-08-13 17:09:28', '2025-08-13 17:09:28'),
(167, 16, '2025-08-13 20:03:00', 0, '2025-08-13 17:09:28', '2025-08-13 17:09:28'),
(168, 16, '2025-08-14 03:03:00', 0, '2025-08-13 17:09:28', '2025-08-13 17:09:28'),
(169, 16, '2025-08-14 10:03:00', 0, '2025-08-13 17:09:28', '2025-08-13 17:09:28'),
(170, 16, '2025-08-14 17:03:00', 0, '2025-08-13 17:09:28', '2025-08-13 17:09:28'),
(171, 16, '2025-08-15 00:03:00', 0, '2025-08-13 17:09:28', '2025-08-13 17:09:28'),
(172, 16, '2025-08-15 07:03:00', 0, '2025-08-13 17:09:28', '2025-08-13 17:09:28'),
(173, 16, '2025-08-15 14:03:00', 0, '2025-08-13 17:09:28', '2025-08-13 17:09:28'),
(192, 5, '2025-08-16 01:00:00', 0, '2025-08-14 09:24:08', '2025-08-14 09:24:08'),
(193, 5, '2025-08-16 09:00:00', 0, '2025-08-14 09:24:08', '2025-08-14 09:24:08'),
(204, 17, '2025-08-14 03:55:00', 0, '2025-08-14 10:33:16', '2025-08-14 10:33:16'),
(205, 17, '2025-08-14 15:55:00', 0, '2025-08-14 10:33:16', '2025-08-14 10:33:16'),
(206, 17, '2025-08-15 03:55:00', 0, '2025-08-14 10:33:16', '2025-08-14 10:33:16'),
(207, 17, '2025-08-15 15:55:00', 0, '2025-08-14 10:33:16', '2025-08-14 10:33:16'),
(208, 17, '2025-08-16 03:55:00', 0, '2025-08-14 10:33:16', '2025-08-14 10:33:16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tratamiento`
--

CREATE TABLE `tratamiento` (
  `id_tratamiento` int(10) UNSIGNED NOT NULL,
  `id_perfil` int(10) UNSIGNED NOT NULL,
  `id_usuario_creador` int(10) UNSIGNED DEFAULT NULL,
  `causa` varchar(150) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `estado` enum('activo','archivado') DEFAULT 'activo',
  `ts_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tratamiento`
--

INSERT INTO `tratamiento` (`id_tratamiento`, `id_perfil`, `id_usuario_creador`, `causa`, `fecha_inicio`, `estado`, `ts_creacion`, `created_at`, `updated_at`) VALUES
(6, 5, 4, 'Catarro', '2025-08-12', 'activo', '2025-08-12 17:05:21', '2025-08-12 17:05:21', '2025-08-12 17:05:21'),
(7, 6, 5, 'Gota', '2025-08-12', 'activo', '2025-08-12 17:18:36', '2025-08-12 17:18:36', '2025-08-12 17:18:36'),
(17, 14, 6, 'Diabetes', '2025-08-13', 'activo', '2025-08-13 17:09:09', '2025-08-13 17:09:09', '2025-08-13 17:09:09'),
(18, 5, NULL, 'Bronquitis', '2025-08-14', 'activo', '2025-08-14 10:32:29', '2025-08-14 10:32:29', '2025-08-14 10:32:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tratamiento_medicamento`
--

CREATE TABLE `tratamiento_medicamento` (
  `id_trat_med` int(10) UNSIGNED NOT NULL,
  `id_tratamiento` int(10) UNSIGNED NOT NULL,
  `id_medicamento` int(10) UNSIGNED NOT NULL,
  `indicacion` varchar(120) NOT NULL,
  `presentacion` enum('comprimidos','jarabe','gotas','inyeccion','pomada','parche','polvo','spray','otro') NOT NULL,
  `via` enum('oral','topica','nasal','ocular','otica','intravenosa','intramuscular','subcutanea','rectal','inhalatoria','otro') NOT NULL,
  `dosis` varchar(50) NOT NULL,
  `pauta_intervalo` smallint(5) UNSIGNED NOT NULL,
  `pauta_unidad` enum('horas','dias','semanas','meses') NOT NULL,
  `fecha_hora_inicio` datetime DEFAULT NULL,
  `observaciones` varchar(255) DEFAULT NULL,
  `estado` enum('activo','archivado') DEFAULT 'activo',
  `sustituido_por` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tratamiento_medicamento`
--

INSERT INTO `tratamiento_medicamento` (`id_trat_med`, `id_tratamiento`, `id_medicamento`, `indicacion`, `presentacion`, `via`, `dosis`, `pauta_intervalo`, `pauta_unidad`, `fecha_hora_inicio`, `observaciones`, `estado`, `sustituido_por`, `created_at`, `updated_at`) VALUES
(5, 6, 1, 'Dolor', 'comprimidos', 'oral', '1g', 8, 'horas', '2025-08-10 09:00:00', NULL, 'activo', NULL, '2025-08-12 17:05:52', '2025-08-12 17:05:52'),
(6, 7, 1, 'Tiroides', 'comprimidos', 'oral', '1g', 9, 'horas', '2025-06-06 08:00:00', NULL, 'activo', NULL, '2025-08-12 17:18:58', '2025-08-12 17:18:58'),
(7, 7, 1, 'Control azucar', 'comprimidos', 'oral', '23mg', 8, 'horas', '2025-07-07 05:06:00', NULL, 'activo', NULL, '2025-08-12 17:19:19', '2025-08-12 17:19:19'),
(16, 17, 2, 'Náuseas', 'comprimidos', 'oral', '1mg', 7, 'horas', '2025-02-22 03:03:00', NULL, 'activo', NULL, '2025-08-13 17:09:28', '2025-08-13 17:09:28'),
(17, 18, 5, 'Tos', 'inyeccion', 'intravenosa', '1mg', 12, 'horas', '2025-04-04 15:55:00', NULL, 'activo', NULL, '2025-08-14 10:33:16', '2025-08-14 10:33:16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `email` varchar(120) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `rol_global` enum('estandar','premium') DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre`, `email`, `contrasena`, `rol_global`, `remember_token`, `created_at`, `updated_at`) VALUES
(4, 'proba4', 'proba4@proba.com', '$2y$12$1/WTKNueLY/JWwxwHg8oP.XzrM2vVz1B1D6X6EQWuBuAiXbb7RWZy', 'premium', NULL, '2025-08-12 17:05:04', '2025-08-14 09:26:05'),
(5, 'proba5', 'proba5@proba.com', '$2y$12$bNMdEXw1mDijreUW/ZKcr.4doP9GDWDG3Kb.3r/1kM7ZXrneyRAGu', 'premium', NULL, '2025-08-12 17:18:21', '2025-08-12 17:18:25'),
(6, 'elena', 'a23elenaqb@iessanclemente.net', '$2y$12$Yn/YhgXoOkIMyzq5A.sQwOHy/oXTR.GvR1bG3jtTSoyrDZHvvVk9u', 'premium', NULL, '2025-08-13 17:05:09', '2025-08-13 17:08:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_perfil`
--

CREATE TABLE `usuario_perfil` (
  `id_usuario` int(10) UNSIGNED NOT NULL,
  `id_perfil` int(10) UNSIGNED NOT NULL,
  `rol_en_perfil` enum('creador','invitado') NOT NULL,
  `fecha_inv` datetime DEFAULT NULL,
  `estado` enum('pendiente','aceptada','cancelada') DEFAULT 'aceptada'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuario_perfil`
--

INSERT INTO `usuario_perfil` (`id_usuario`, `id_perfil`, `rol_en_perfil`, `fecha_inv`, `estado`) VALUES
(4, 5, 'creador', NULL, 'aceptada'),
(5, 6, 'creador', NULL, 'aceptada'),
(6, 5, 'invitado', '2025-08-13 19:05:09', 'aceptada'),
(6, 14, 'creador', NULL, 'aceptada');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `cita`
--
ALTER TABLE `cita`
  ADD PRIMARY KEY (`id_cita`),
  ADD KEY `fk_cita_perfil` (`id_perfil`),
  ADD KEY `fk_cita_usuario` (`id_usuario_crea`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `informe`
--
ALTER TABLE `informe`
  ADD PRIMARY KEY (`id_informe`),
  ADD KEY `fk_inf_usuario` (`id_usuario`),
  ADD KEY `fk_inf_perfil` (`id_perfil`),
  ADD KEY `fk_inf_trat` (`id_tratamiento`);

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
-- Indices de la tabla `medicamento`
--
ALTER TABLE `medicamento`
  ADD PRIMARY KEY (`id_medicamento`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `notificacion`
--
ALTER TABLE `notificacion`
  ADD PRIMARY KEY (`id_notif`),
  ADD KEY `fk_notif_usuario` (`id_usuario_dest`),
  ADD KEY `fk_notif_perfil` (`id_perfil`);

--
-- Indices de la tabla `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`id_perfil`);

--
-- Indices de la tabla `perfil_invitacion`
--
ALTER TABLE `perfil_invitacion`
  ADD PRIMARY KEY (`id_invitacion`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `idx_perfil_email_estado` (`id_perfil`,`email`,`estado`),
  ADD KEY `fk_pi_invitador` (`id_usuario_invitador`),
  ADD KEY `fk_pi_invitado` (`id_usuario_invitado`);

--
-- Indices de la tabla `recordatorio`
--
ALTER TABLE `recordatorio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_trat_med` (`id_trat_med`);

--
-- Indices de la tabla `tratamiento`
--
ALTER TABLE `tratamiento`
  ADD PRIMARY KEY (`id_tratamiento`),
  ADD KEY `fk_trat_perfil` (`id_perfil`),
  ADD KEY `fk_trat_usuario` (`id_usuario_creador`);

--
-- Indices de la tabla `tratamiento_medicamento`
--
ALTER TABLE `tratamiento_medicamento`
  ADD PRIMARY KEY (`id_trat_med`),
  ADD KEY `fk_tm_trat` (`id_tratamiento`),
  ADD KEY `fk_tm_medic` (`id_medicamento`),
  ADD KEY `fk_tm_subs` (`sustituido_por`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `usuario_perfil`
--
ALTER TABLE `usuario_perfil`
  ADD PRIMARY KEY (`id_usuario`,`id_perfil`),
  ADD KEY `fk_up_perfil` (`id_perfil`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cita`
--
ALTER TABLE `cita`
  MODIFY `id_cita` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `informe`
--
ALTER TABLE `informe`
  MODIFY `id_informe` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `medicamento`
--
ALTER TABLE `medicamento`
  MODIFY `id_medicamento` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `notificacion`
--
ALTER TABLE `notificacion`
  MODIFY `id_notif` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `perfil`
--
ALTER TABLE `perfil`
  MODIFY `id_perfil` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `perfil_invitacion`
--
ALTER TABLE `perfil_invitacion`
  MODIFY `id_invitacion` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `recordatorio`
--
ALTER TABLE `recordatorio`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=209;

--
-- AUTO_INCREMENT de la tabla `tratamiento`
--
ALTER TABLE `tratamiento`
  MODIFY `id_tratamiento` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `tratamiento_medicamento`
--
ALTER TABLE `tratamiento_medicamento`
  MODIFY `id_trat_med` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  ADD CONSTRAINT `fk_inf_trat` FOREIGN KEY (`id_tratamiento`) REFERENCES `tratamiento` (`id_tratamiento`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_inf_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `notificacion`
--
ALTER TABLE `notificacion`
  ADD CONSTRAINT `fk_notif_perfil` FOREIGN KEY (`id_perfil`) REFERENCES `perfil` (`id_perfil`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_notif_usuario` FOREIGN KEY (`id_usuario_dest`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `perfil_invitacion`
--
ALTER TABLE `perfil_invitacion`
  ADD CONSTRAINT `fk_pi_invitado` FOREIGN KEY (`id_usuario_invitado`) REFERENCES `usuario` (`id_usuario`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_pi_invitador` FOREIGN KEY (`id_usuario_invitador`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_pi_perfil` FOREIGN KEY (`id_perfil`) REFERENCES `perfil` (`id_perfil`) ON DELETE CASCADE;

--
-- Filtros para la tabla `recordatorio`
--
ALTER TABLE `recordatorio`
  ADD CONSTRAINT `recordatorio_ibfk_1` FOREIGN KEY (`id_trat_med`) REFERENCES `tratamiento_medicamento` (`id_trat_med`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tratamiento`
--
ALTER TABLE `tratamiento`
  ADD CONSTRAINT `fk_trat_perfil` FOREIGN KEY (`id_perfil`) REFERENCES `perfil` (`id_perfil`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_trat_usuario` FOREIGN KEY (`id_usuario_creador`) REFERENCES `usuario` (`id_usuario`) ON DELETE SET NULL;

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
