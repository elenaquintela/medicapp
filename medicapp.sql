-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-08-2025 a las 21:45:55
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
  `google_event_id` varchar(128) DEFAULT NULL,
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
(1, 'Paracetamol', NULL, NULL, '2025-08-26 19:35:55', '2025-08-26 19:35:55'),
(2, 'Enantyum', NULL, NULL, '2025-08-26 19:36:53', '2025-08-26 19:36:53');

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
(1, 'paciente1', '1982-11-11', 'F', '2025-08-26 19:35:15', '2025-08-26 19:35:15');

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
(1, 1, '2025-08-26 00:00:00', 0, '2025-08-26 19:35:55', '2025-08-26 19:35:55'),
(2, 1, '2025-08-26 08:00:00', 0, '2025-08-26 19:35:55', '2025-08-26 19:35:55'),
(3, 1, '2025-08-26 16:00:00', 0, '2025-08-26 19:35:55', '2025-08-26 19:35:55'),
(4, 1, '2025-08-27 00:00:00', 0, '2025-08-26 19:35:55', '2025-08-26 19:35:55'),
(5, 1, '2025-08-27 08:00:00', 0, '2025-08-26 19:35:55', '2025-08-26 19:35:55'),
(6, 1, '2025-08-27 16:00:00', 0, '2025-08-26 19:35:55', '2025-08-26 19:35:55'),
(7, 1, '2025-08-28 00:00:00', 0, '2025-08-26 19:35:55', '2025-08-26 19:35:55'),
(8, 1, '2025-08-28 08:00:00', 0, '2025-08-26 19:35:55', '2025-08-26 19:35:55'),
(9, 1, '2025-08-28 16:00:00', 0, '2025-08-26 19:35:55', '2025-08-26 19:35:55'),
(10, 2, '2025-08-26 04:00:00', 0, '2025-08-26 19:36:53', '2025-08-26 19:36:53'),
(11, 2, '2025-08-26 12:00:00', 0, '2025-08-26 19:36:53', '2025-08-26 19:36:53'),
(12, 2, '2025-08-26 20:00:00', 0, '2025-08-26 19:36:53', '2025-08-26 19:36:53'),
(13, 2, '2025-08-27 04:00:00', 0, '2025-08-26 19:36:53', '2025-08-26 19:36:53'),
(14, 2, '2025-08-27 12:00:00', 0, '2025-08-26 19:36:53', '2025-08-26 19:36:53'),
(15, 2, '2025-08-27 20:00:00', 0, '2025-08-26 19:36:53', '2025-08-26 19:36:53'),
(16, 2, '2025-08-28 04:00:00', 0, '2025-08-26 19:36:53', '2025-08-26 19:36:53'),
(17, 2, '2025-08-28 12:00:00', 0, '2025-08-26 19:36:53', '2025-08-26 19:36:53'),
(18, 2, '2025-08-28 20:00:00', 0, '2025-08-26 19:36:53', '2025-08-26 19:36:53');

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
(1, 1, 1, 'Gripe', '2025-08-26', 'activo', '2025-08-26 19:35:15', '2025-08-26 19:35:15', '2025-08-26 19:35:15');

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
(1, 1, 1, 'Dolor', 'comprimidos', 'oral', '1g', 8, 'horas', '2025-08-01 08:00:00', 'Con las comidas', 'activo', NULL, '2025-08-26 19:35:55', '2025-08-26 19:35:55'),
(2, 1, 2, 'Dolor', 'comprimidos', 'oral', '50mg', 8, 'horas', '2025-08-08 12:00:00', NULL, 'activo', NULL, '2025-08-26 19:36:53', '2025-08-26 19:36:53');

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
  `google_oauth_tokens` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre`, `email`, `contrasena`, `rol_global`, `remember_token`, `google_oauth_tokens`, `created_at`, `updated_at`) VALUES
(1, 'proba', 'proba@medicapp.com', '$2y$12$OpeW96yAZNDpswJnsFE5/Oz2rbDoQI4I2K1MylBlJDF7Z3pOd9A0C', 'premium', NULL, NULL, '2025-08-26 19:34:47', '2025-08-26 19:34:52');

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
(1, 1, 'creador', NULL, 'aceptada');

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
  ADD KEY `fk_cita_usuario` (`id_usuario_crea`),
  ADD KEY `idx_cita_google_event` (`google_event_id`);

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
  MODIFY `id_cita` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `informe`
--
ALTER TABLE `informe`
  MODIFY `id_informe` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `medicamento`
--
ALTER TABLE `medicamento`
  MODIFY `id_medicamento` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `id_perfil` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `perfil_invitacion`
--
ALTER TABLE `perfil_invitacion`
  MODIFY `id_invitacion` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `recordatorio`
--
ALTER TABLE `recordatorio`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `tratamiento`
--
ALTER TABLE `tratamiento`
  MODIFY `id_tratamiento` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tratamiento_medicamento`
--
ALTER TABLE `tratamiento_medicamento`
  MODIFY `id_trat_med` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
