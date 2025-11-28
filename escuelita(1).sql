-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-11-2025 a las 19:49:29
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
-- Base de datos: `escuelita`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

CREATE TABLE `alumnos` (
  `n_control` varchar(9) NOT NULL,
  `contraseña` varchar(255) DEFAULT NULL,
  `id_carrera` bigint(20) UNSIGNED DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `s_nombre` varchar(30) DEFAULT NULL,
  `ap_pat` varchar(30) DEFAULT NULL,
  `ap_mat` varchar(30) DEFAULT NULL,
  `fech_nac` date DEFAULT NULL,
  `genero` varchar(9) DEFAULT NULL,
  `FKid_carrera` int(11) DEFAULT NULL,
  `situacion` varchar(10) DEFAULT NULL,
  `semestre` int(2) DEFAULT NULL,
  `promedio_general` decimal(5,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`n_control`, `contraseña`, `id_carrera`, `nombre`, `s_nombre`, `ap_pat`, `ap_mat`, `fech_nac`, `genero`, `FKid_carrera`, `situacion`, `semestre`, `promedio_general`, `created_at`, `updated_at`) VALUES
('012345678', NULL, NULL, 'Melisa', 'Lian', 'Sanchez', 'Sanchez', '2000-01-01', 'M', 1, 'Vigente', 1, NULL, '2025-11-28 11:12:29', '2025-11-28 11:12:29'),
('091234', '091234', NULL, 'Jimmy', 'Baraquiel', 'Valenzuela', 'Álvarez', '2000-11-21', 'M', 1, 'Vigente', 1, 100.00, '2025-11-19 03:48:30', '2025-11-26 02:09:51'),
('123', '123', NULL, 'juan', 'Pablo', 'Escobar', 'Sultan', '2002-07-08', 'M', 8, 'Vigente', 2, 97.96, '2025-10-24 00:53:58', '2025-10-31 02:10:03'),
('19222128', '19222128', NULL, 'Andrés', 'Manuel', 'Pérez', 'Fernández', '2000-12-01', 'M', 1, 'Vigente', 3, 89.00, NULL, '2025-10-31 02:54:10'),
('19222164', '19222164', NULL, 'Juan', 'Diego', 'Soria', 'Lopez', '2001-12-21', 'M', 8, 'Vigente', 3, 78.90, '2025-10-15 05:36:09', '2025-10-29 04:30:59'),
('19222168', '19222168', NULL, 'José', 'Antonio', 'Hernández', 'Vargas', '1999-07-20', 'M', 1, 'Vigente', 1, 50.00, NULL, '2025-10-29 04:05:49'),
('19233245', '19233245', NULL, 'Ricardo', 'Eduardo', 'Castillo', 'Mendoza', '2000-02-03', 'M', 1, 'Egresado', 11, 89.00, NULL, '2025-11-05 10:03:40'),
('20212178', '20212178', NULL, 'Elena', 'Isabel', 'Ramírez', 'Díaz', '2001-08-18', 'F', 2, 'Baja', 10, NULL, NULL, '2025-10-15 04:53:48'),
('20222165', '20222165', NULL, 'Pedro', 'Luis', 'García', 'Sánchez', '2000-01-10', 'M', 1, 'Vigente', 3, 80.00, NULL, '2025-11-29 00:44:58'),
('20222166', '20222166', NULL, 'Juan', 'Carlos', 'Perez', 'Lopez', '2000-09-12', 'M', 2, 'Vigente', 4, NULL, '2025-10-15 04:55:30', '2025-10-15 10:37:14'),
('20222286', '20222286', NULL, 'Lucía', 'Fernanda', 'Rodríguez', 'Torres', '2001-03-15', 'F', 7, 'Vigente', 2, NULL, NULL, NULL),
('20232012', '20232012', NULL, 'Laura', 'María', 'Gómez', 'Ramírez', '2002-04-05', 'F', 1, 'Vigente', 10, 89.00, NULL, '2025-10-29 00:58:39'),
('20242234', '20242234', NULL, 'Miguel', 'Ángel', 'Torres', 'Ramírez', '2002-06-12', 'M', 1, 'Vigente', 8, 70.00, NULL, '2025-10-29 00:59:03'),
('20243321', '20243321', NULL, 'Valeria', '', 'Jiménez', 'Ortega', '2001-11-09', 'F', 7, 'Vigente', 2, NULL, NULL, NULL),
('20246678', '20246678', NULL, 'Andrea', 'Carolina', 'Vargas', 'Jiménez', '2002-03-21', 'F', 3, 'Vigente', 10, NULL, NULL, NULL),
('20248890', '20248890', NULL, 'Mariana', '', 'Romero', 'García', '2001-07-30', 'F', 8, 'Vigente', 9, NULL, NULL, NULL),
('20250012', '20250012', NULL, 'Patricia', 'Elena', 'Herrera', 'Torres', '2002-09-19', 'F', 1, 'Vigente', 8, 87.00, NULL, '2025-10-29 01:07:04'),
('20254412', '20254412', NULL, 'Daniela', 'Fernanda', 'Soto', 'Pérez', '2002-08-27', 'F', 2, 'Vigente', 8, NULL, NULL, NULL),
('21122177', '21122177', NULL, 'Sofía', '', 'Ortiz', 'Mendoza', '2003-02-14', 'F', 4, 'Vigente', 2, NULL, NULL, NULL),
('21222198', '21222198', NULL, 'Marta', 'Patricia', 'López', 'Morales', '2000-11-30', 'F', 9, 'Vigente', 8, NULL, NULL, NULL),
('21245567', '21245567', NULL, 'Juan', '', 'Rivas', 'Torres', '2001-05-15', 'M', 9, 'Vigente', 9, NULL, NULL, NULL),
('21249901', '21249901', NULL, 'Sergio', 'Andrés', 'Molina', 'Sánchez', '2003-01-05', 'M', 10, 'Vigente', 6, NULL, NULL, NULL),
('22143199', '22143199', NULL, 'Diego', '', 'Martínez', 'Gómez', '2002-05-25', 'M', 5, 'Baja', 6, NULL, NULL, NULL),
('22147789', '22147789', NULL, 'Fernando', 'Luis', 'Delgado', 'López', '2000-12-11', 'M', 6, 'Baja', 7, NULL, NULL, NULL),
('22153201', '22153201', NULL, 'Carla', 'Emilia', 'Hernández', 'Lopez', '2001-09-22', 'M', 10, 'Vigente', 6, NULL, NULL, '2025-10-02 09:55:15'),
('22160001', '22160001', NULL, 'Alejandro', 'David', 'García', 'López', '2001-03-14', 'M', 1, 'Vigente', 3, 78.32, NULL, '2025-10-29 04:04:56'),
('22160002', '22160002', NULL, 'Beatriz', 'Elena', 'Ramírez', 'Torres', '2002-07-21', 'F', 2, 'Vigente', 3, NULL, NULL, NULL),
('22160003', '22160003', NULL, 'Javier', 'Andrés', 'Hernández', 'Gómez', '2000-11-19', 'M', 3, 'Egresado', 11, NULL, NULL, NULL),
('22160004', '22160004', NULL, 'Carolina', 'María', 'Sánchez', 'Martínez', '2003-01-25', 'F', 4, 'Vigente', 2, NULL, NULL, NULL),
('22160005', '22160005', NULL, 'Luis', 'Fernando', 'Cruz', 'Domínguez', '2001-04-12', 'M', 5, 'Baja', 4, NULL, NULL, NULL),
('22160006', '22160006', NULL, 'Gabriela', 'Isabel', 'Jiménez', 'Pérez', '2002-02-08', 'F', 6, 'Vigente', 7, NULL, NULL, NULL),
('22160007', '22160007', NULL, 'Héctor', 'Manuel', 'Ortega', 'Santos', '2000-10-30', 'M', 7, 'Vigente', 10, NULL, NULL, NULL),
('22160008', '22160008', NULL, 'Natalia', 'Fernanda', 'Vega', 'Ramírez', '2003-03-09', 'F', 8, 'Vigente', 1, 89.00, NULL, '2025-11-05 10:04:20'),
('22160009', '22160009', NULL, 'Oscar', 'Antonio', 'Morales', 'Hernández', '1999-06-22', 'M', 9, 'Egresado', 11, NULL, NULL, NULL),
('22160010', '22160010', NULL, 'Patricia', 'Lucía', 'Castillo', 'Flores', '2001-05-13', 'F', 10, 'Vigente', 8, NULL, NULL, NULL),
('22160011', '22160011', NULL, 'Ricardo', 'Emilio', 'López', 'García', '2002-09-28', 'M', 1, 'Vigente', 6, NULL, NULL, NULL),
('22160012', '22160012', NULL, 'Sofía', 'Valeria', 'Fernández', 'Rojas', '2000-12-06', 'F', 2, 'Baja', 7, NULL, NULL, NULL),
('22160013', '22160013', NULL, 'Tomás', 'Adrián', 'Mendoza', 'Torres', '2001-08-19', 'M', 3, 'Vigente', 9, NULL, NULL, NULL),
('22160014', '22160014', NULL, 'Daniela', 'Paola', 'Martínez', 'Cruz', '2002-04-02', 'F', 4, 'Vigente', 5, NULL, NULL, NULL),
('22160015', '22160015', NULL, 'Ignacio', 'Carlos', 'Hernández', 'Ramírez', '2001-11-27', 'M', 5, 'Vigente', 3, NULL, NULL, NULL),
('22160016', '22160016', NULL, 'Laura', 'Patricia', 'Pérez', 'Domínguez', '2000-01-15', 'F', 6, 'Egresado', 11, NULL, NULL, NULL),
('22160017', '22160017', NULL, 'Diego', 'Alejandro', 'Gómez', 'Santos', '2002-07-08', 'M', 7, 'Vigente', 4, NULL, NULL, NULL),
('22160018', '22160018', NULL, 'Mariana', 'Carolina', 'Vargas', 'Luna', '2003-10-03', 'F', 8, 'Vigente', 2, NULL, NULL, NULL),
('22160019', '22160019', NULL, 'Andrés', 'Roberto', 'Flores', 'Mendoza', '2001-06-29', 'M', 9, 'Baja', 6, NULL, NULL, NULL),
('22160020', '22160020', NULL, 'Elena', 'Beatriz', 'Ramírez', 'Ortega', '2002-03-11', 'F', 10, 'Vigente', 7, NULL, NULL, NULL),
('22160021', '22160021', NULL, 'Mateo', 'Julián', 'Sánchez', 'Ríos', '2001-09-23', 'M', 1, 'Vigente', 10, NULL, NULL, NULL),
('22160022', '22160022', NULL, 'Camila', 'Fernanda', 'Cruz', 'Pérez', '2000-05-04', 'F', 2, 'Egresado', 11, NULL, NULL, NULL),
('22160023', '22160023', NULL, 'Pablo', 'Enrique', 'Domínguez', 'Gómez', '2002-02-19', 'M', 3, 'Vigente', 8, NULL, NULL, NULL),
('22160024', '22160024', NULL, 'Valeria', 'Marisol', 'López', 'Martínez', '2003-12-20', 'F', 4, 'Vigente', 2, 89.00, NULL, '2025-10-31 01:24:02'),
('22160025', '22160025', NULL, 'Roberto', 'Emilio', 'Hernández', 'Vega', '2000-08-15', 'M', 5, 'Baja', 6, NULL, NULL, NULL),
('22160026', '22160026', NULL, 'Daniel', 'Adrián', 'Mendoza', 'Torres', '2001-07-27', 'M', 6, 'Vigente', 9, NULL, NULL, NULL),
('22160027', '22160027', NULL, 'Lucía', 'Elena', 'Gómez', 'Sánchez', '2002-06-05', 'F', 7, 'Vigente', 3, NULL, NULL, NULL),
('22160028', '22160028', NULL, 'Felipe', 'Eduardo', 'Rojas', 'López', '1999-12-14', 'M', 8, 'Egresado', 11, NULL, NULL, NULL),
('22160029', '22160029', NULL, 'Carla', 'Isabel', 'Santos', 'Flores', '2003-09-17', 'F', 9, 'Vigente', 1, NULL, NULL, NULL),
('22160030', '22160030', NULL, 'Hugo', 'Manuel', 'Luna', 'Morales', '2000-11-03', 'M', 10, 'Vigente', 7, NULL, NULL, NULL),
('22160031', '22160031', NULL, 'Isabel', 'Andrea', 'Ramírez', 'Vega', '2001-03-29', 'F', 1, 'Vigente', 6, 80.00, NULL, '2025-10-29 04:26:58'),
('22160032', '22160032', NULL, 'Fernando', 'José', 'Pérez', 'Torres', '2002-01-18', 'M', 2, 'Baja', 5, NULL, NULL, NULL),
('22160033', '22160033', NULL, 'Mónica', 'Elena', 'Ortega', 'Cruz', '2001-09-14', 'F', 3, 'Vigente', 9, NULL, NULL, NULL),
('22160034', '22160034', NULL, 'Raúl', 'David', 'Sánchez', 'Martínez', '2003-02-06', 'M', 4, 'Vigente', 2, NULL, NULL, NULL),
('22160035', '22160035', NULL, 'Ángela', 'María', 'Gómez', 'Fernández', '2002-07-02', 'F', 5, 'Vigente', 4, NULL, NULL, NULL),
('22160036', '22160036', NULL, 'Jorge', 'Ignacio', 'Domínguez', 'Rivas', '2000-04-10', 'M', 6, 'Egresado', 11, NULL, NULL, NULL),
('22160037', '22160037', NULL, 'Diana', 'Patricia', 'Flores', 'Ramírez', '2001-10-28', 'F', 7, 'Vigente', 8, NULL, NULL, NULL),
('22160038', '22160038', NULL, 'Santiago', 'Alejandro', 'Torres', 'Hernández', '2002-08-16', 'M', 8, 'Vigente', 7, NULL, NULL, NULL),
('22160039', '22160039', NULL, 'Ana', 'Lucía', 'Martínez', 'Ortega', '2000-05-07', 'F', 9, 'Vigente', 5, NULL, NULL, '2025-10-15 12:36:18'),
('22160040', '22160040', NULL, 'Cristian', 'Antonio', 'Pérez', 'Gómez', '2003-03-25', 'M', 10, 'Vigente', 3, NULL, NULL, NULL),
('22160041', '22160041', NULL, 'Marisol', 'Valeria', 'López', 'Santos', '2002-09-12', 'F', 1, 'Vigente', 6, NULL, NULL, NULL),
('22160042', '22160042', NULL, 'Álvaro', 'Roberto', 'Ramírez', 'Domínguez', '2001-06-01', 'M', 2, 'Vigente', 10, NULL, NULL, NULL),
('22160043', '22160043', NULL, 'Estefanía', 'Andrea', 'Sánchez', 'Flores', '2000-07-08', 'F', 3, 'Vigente', 8, NULL, NULL, NULL),
('22160044', '22160044', NULL, 'Rodrigo', 'Manuel', 'Cruz', 'Mendoza', '2001-05-16', 'M', 4, 'Baja', 7, NULL, NULL, NULL),
('22160045', '22160045', NULL, 'Teresa', 'Isabel', 'Ortega', 'Luna', '2003-10-21', 'F', 5, 'Vigente', 2, NULL, NULL, NULL),
('22160046', '22160046', NULL, 'Ángel', 'David', 'Gómez', 'Ramírez', '2002-12-19', 'M', 6, 'Vigente', 9, NULL, NULL, NULL),
('22160047', '22160047', NULL, 'Verónica', 'Carolina', 'Hernández', 'Santos', '2000-02-24', 'F', 7, 'Egresado', 11, NULL, NULL, NULL),
('22160048', '22160048', NULL, 'Adrián', 'Tomás', 'Morales', 'García', '2001-11-30', 'M', 8, 'Vigente', 7, NULL, NULL, NULL),
('22160049', '22160049', NULL, 'Lorena', 'Fernanda', 'Rivas', 'López', '2002-04-18', 'F', 9, 'Vigente', 4, NULL, NULL, NULL),
('22160050', '22160050', NULL, 'Emilio', 'Javier', 'Martínez', 'Ortega', '2003-08-13', 'M', 10, 'Vigente', 3, NULL, NULL, NULL),
('2221212', '2221212', NULL, 'Carlos', 'Tobon', 'Chat', 'Gpt', '1990-08-12', 'M', 1, 'Vigente', 1, 100.00, '2025-10-29 00:26:46', '2025-11-05 10:03:56'),
('9999999', '9999999', NULL, 'Juan', NULL, 'Perez', 'Lopez', '2000-02-02', 'Masculino', 10, 'Vigente', 2, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno_grupo`
--

CREATE TABLE `alumno_grupo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `n_control` varchar(9) NOT NULL COMMENT 'FK a alumnos.n_control',
  `id_grupo` int(11) NOT NULL COMMENT 'FK a grupos.id_grupo',
  `oportunidad` varchar(20) NOT NULL DEFAULT 'Primera',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alumno_grupo`
--

INSERT INTO `alumno_grupo` (`id`, `n_control`, `id_grupo`, `oportunidad`, `created_at`, `updated_at`) VALUES
(4, '22160041', 8, 'Primera', NULL, NULL),
(17, '123', 3, 'Primera', '2025-10-28 22:36:43', '2025-10-28 22:36:43'),
(19, '123', 8, 'Primera', '2025-10-29 01:17:41', '2025-10-29 01:17:41'),
(26, '123', 1238, 'Primera', '2025-11-07 00:52:00', '2025-11-07 00:52:00'),
(27, '123', 5, 'Primera', '2025-11-07 04:15:10', '2025-11-07 04:15:10'),
(29, '22160007', 1237, 'Primera', '2025-11-12 02:35:10', '2025-11-12 02:35:10'),
(61, '091234', 1250, 'Primera', '2025-11-28 00:55:48', '2025-11-28 00:55:48'),
(66, '012345678', 1, 'Primera', '2025-11-28 11:53:34', '2025-11-28 11:53:34'),
(67, '19222128', 2, 'Primera', '2025-11-29 00:42:47', '2025-11-29 00:42:47'),
(68, '19222168', 1, 'Primera', '2025-11-29 00:43:19', '2025-11-29 00:43:19'),
(69, '20222165', 1, 'Primera', '2025-11-29 00:43:43', '2025-11-29 00:43:43'),
(70, '20242234', 1, 'Primera', '2025-11-29 00:44:01', '2025-11-29 00:44:01'),
(71, '22160011', 1, 'Primera', '2025-11-29 00:44:17', '2025-11-29 00:44:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areas`
--

CREATE TABLE `areas` (
  `cod_area` int(11) NOT NULL,
  `area` varchar(30) DEFAULT NULL,
  `jefe_area` varchar(30) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `areas`
--

INSERT INTO `areas` (`cod_area`, `area`, `jefe_area`, `created_at`, `updated_at`) VALUES
(1, 'Tecnologías de la Información', 'PROF007', NULL, '2025-11-19 02:49:53'),
(2, 'Ingeniería Industrial', 'PROF009', NULL, '2025-11-19 02:50:22'),
(3, 'Ingeniería Mecánica', 'PROF008', NULL, '2025-11-19 02:50:27'),
(4, 'Ingeniería Eléctrica', 'PROF010', NULL, '2025-11-19 02:50:32'),
(5, 'Administración', 'CAMOTO1', NULL, '2025-11-19 02:50:40'),
(6, 'Salud', 'ERDELO2', '2025-11-19 03:39:44', '2025-11-19 03:39:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aulas`
--

CREATE TABLE `aulas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `capacidad` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `aulas`
--

INSERT INTO `aulas` (`id`, `nombre`, `capacidad`, `created_at`, `updated_at`) VALUES
(3, '1A', 30, '2025-11-12 02:23:47', '2025-11-12 02:23:47'),
(5, '1B', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(6, '1C', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(7, '2A', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(8, '2B', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(9, '2C', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(10, '3A', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(11, '3B', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(12, '3C', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(13, '4A', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(14, '4B', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(15, '4C', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(16, '5A', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(17, '5B', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(18, '5C', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(19, '6A', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(20, '6B', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(21, '6C', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(22, '7A', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(23, '7B', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(24, '7C', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(25, '8A', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(26, '8B', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(27, '8C', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(28, '9A', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(29, '9B', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(30, '9C', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(31, '10A', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(32, '10B', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(33, '10C', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(34, '11A', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(35, '11B', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(36, '11C', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(37, '12A', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(38, '12B', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(39, '12C', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(40, '13A', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(41, '13B', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(42, '13C', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(43, '14A', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(44, '14B', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(45, '14C', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(46, '15A', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(47, '15B', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(48, '15C', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(49, '16A', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(50, '16B', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(51, '16C', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(52, '17A', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(53, '17B', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(54, '17C', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(55, '18A', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(56, '18B', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(57, '18C', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(58, '19A', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(59, '19B', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(60, '19C', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(61, '20A', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(62, '20B', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41'),
(63, '20C', 30, '2025-11-12 07:27:41', '2025-11-12 07:27:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `boletas`
--

CREATE TABLE `boletas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `n_control` varchar(9) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `cod_materia` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `periodo` varchar(20) NOT NULL,
  `calificacion` decimal(5,2) DEFAULT NULL,
  `oportunidad` varchar(20) NOT NULL,
  `n_trabajador` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_grupo` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `boletas`
--

INSERT INTO `boletas` (`id`, `n_control`, `cod_materia`, `periodo`, `calificacion`, `oportunidad`, `n_trabajador`, `id_grupo`, `created_at`, `updated_at`) VALUES
(1, '19222128', 'TICS101', 'AGODIC25', 34.00, 'Repite', 'CAMOTO1', 1, '2025-11-19 03:01:59', '2025-11-19 03:01:59'),
(2, '123', 'TICS101', 'AGODIC25', 67.50, 'Aprobada', 'CAMOTO1', 1, '2025-11-19 03:28:47', '2025-11-19 03:28:47'),
(7, '19222128', 'TICS101', 'AGODIC25', 72.50, 'Primera', 'CAMOTO1', 1, '2025-11-21 05:56:44', '2025-11-21 05:56:44'),
(15, '091234', 'TICS101', 'AGODIC25', 80.00, 'Primera', 'CAMOTO1', 1, '2025-11-21 06:25:25', '2025-11-21 06:25:25'),
(16, '123', 'TICS102', 'AGODIC25', 0.00, 'Aprobada', 'CAMOTO1', 2, '2025-11-21 06:26:26', '2025-11-21 06:26:26'),
(20, '091234', 'TICS210', 'AGODIC25', 100.00, 'Primera', 'CAMOTO1', 1248, '2025-11-26 02:51:53', '2025-11-26 02:51:53'),
(21, '091234', 'AE101', 'ENEJUN25', 90.00, 'Primera', 'PROF003', 3, '2025-11-28 00:32:09', '2025-11-28 00:32:09'),
(23, '123', 'TICS104', 'ENEJUN25', 75.00, 'Especial', 'PROF004', 4, '2025-11-28 00:46:32', '2025-11-28 00:46:32'),
(24, '091234', 'TICS102', 'AGODIC24', 70.00, 'Primera', 'CAMOTO1', 2, '2025-11-28 00:50:34', '2025-11-28 00:50:34');

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
-- Estructura de tabla para la tabla `calificaciones_grupo`
--

CREATE TABLE `calificaciones_grupo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `alumno_grupo_id` bigint(20) UNSIGNED NOT NULL,
  `u1` decimal(5,2) DEFAULT NULL,
  `u2` decimal(5,2) DEFAULT NULL,
  `u3` decimal(5,2) DEFAULT NULL,
  `u4` decimal(5,2) DEFAULT NULL,
  `promedio` decimal(5,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `calificaciones_grupo`
--

INSERT INTO `calificaciones_grupo` (`id`, `alumno_grupo_id`, `u1`, `u2`, `u3`, `u4`, `promedio`, `created_at`, `updated_at`) VALUES
(1, 22, 34.00, 42.00, 25.00, 35.00, 34.00, '2025-11-19 03:01:53', '2025-11-19 03:01:53'),
(2, 21, 90.00, 60.00, 60.00, 60.00, 67.50, '2025-11-19 03:09:41', '2025-11-19 03:28:03'),
(3, 25, 89.00, 0.00, 0.00, 0.00, 0.00, '2025-11-19 03:35:16', '2025-11-21 06:26:10'),
(4, 31, 50.00, 50.00, 10.00, 50.00, 40.00, '2025-11-19 03:52:00', '2025-11-19 03:52:11'),
(5, 32, 19.00, 19.00, 70.00, 100.00, 52.00, '2025-11-19 03:54:41', '2025-11-19 03:54:51'),
(6, 35, 70.00, 70.00, 70.00, 70.00, 70.00, '2025-11-21 05:28:57', '2025-11-21 05:30:06'),
(7, 36, 90.00, 50.02, 40.00, 12.00, 48.01, '2025-11-21 05:33:31', '2025-11-21 05:48:29'),
(8, 37, 100.00, 90.00, 60.00, 90.00, 85.00, '2025-11-21 05:49:17', '2025-11-21 05:49:17'),
(9, 30, 70.00, 70.00, 70.00, 80.00, 72.50, '2025-11-21 05:50:51', '2025-11-21 05:56:35'),
(10, 38, 60.00, 80.00, 80.00, 80.00, 0.00, '2025-11-21 05:59:32', '2025-11-21 05:59:32'),
(11, 39, 2.00, 2.00, 2.00, 2.00, 0.00, '2025-11-21 06:01:17', '2025-11-21 06:01:17'),
(12, 40, 3.00, 5.00, 5.00, 5.00, 0.00, '2025-11-21 06:01:44', '2025-11-21 06:01:44'),
(13, 41, 12.00, 34.00, 7.00, 7.00, 0.00, '2025-11-21 06:19:18', '2025-11-21 06:19:18'),
(14, 42, 6.00, 6.00, 6.00, 6.00, 0.00, '2025-11-21 06:19:41', '2025-11-21 06:19:41'),
(15, 43, 9.00, 7.00, 7.00, 7.00, 0.00, '2025-11-21 06:20:07', '2025-11-21 06:20:07'),
(16, 44, 80.00, 80.00, 80.00, 80.00, 80.00, '2025-11-21 06:25:21', '2025-11-21 06:25:21'),
(17, 47, 100.00, 45.00, 5.00, 4.00, 0.00, '2025-11-21 06:26:37', '2025-11-21 06:26:37'),
(18, 48, 12.00, 54.00, 54.00, 54.00, 0.00, '2025-11-21 06:27:04', '2025-11-21 06:27:04'),
(19, 49, 100.00, 100.00, 78.00, 9.00, 0.00, '2025-11-21 06:27:32', '2025-11-21 06:27:32'),
(20, 50, 100.00, 100.00, 100.00, 100.00, 100.00, '2025-11-26 02:51:50', '2025-11-26 02:51:50'),
(21, 17, 80.00, 80.00, NULL, NULL, NULL, '2025-11-27 23:49:35', '2025-11-27 23:49:35'),
(22, 52, 90.00, 80.00, NULL, NULL, NULL, '2025-11-28 00:13:41', '2025-11-28 00:13:41'),
(23, 54, 90.00, 90.00, 90.00, 90.00, 90.00, '2025-11-28 00:32:06', '2025-11-28 00:32:06'),
(24, 58, 90.00, 100.00, 90.00, 90.00, 92.50, '2025-11-28 00:46:15', '2025-11-28 00:46:15'),
(25, 23, 70.00, 70.00, 70.00, 90.00, 75.00, '2025-11-28 00:46:29', '2025-11-28 00:46:29'),
(26, 59, 70.00, 70.00, 70.00, 70.00, 70.00, '2025-11-28 00:50:31', '2025-11-28 00:50:31'),
(27, 61, 80.00, 95.00, 70.00, 72.00, 79.25, '2025-11-28 05:35:15', '2025-11-28 05:35:53'),
(28, 66, 70.00, 70.00, NULL, NULL, NULL, '2025-11-28 23:19:40', '2025-11-29 00:13:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carreras`
--

CREATE TABLE `carreras` (
  `id_carrera` int(11) NOT NULL,
  `nombre_carrera` varchar(30) DEFAULT NULL,
  `num_edif` varchar(20) DEFAULT NULL,
  `capacidad` varchar(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carreras`
--

INSERT INTO `carreras` (`id_carrera`, `nombre_carrera`, `num_edif`, `capacidad`, `created_at`, `updated_at`) VALUES
(1, 'TICS', '36', '240', NULL, NULL),
(2, 'Industrial', '45', '300', NULL, '2025-10-24 00:52:29'),
(3, 'Mecanica', '42', '300', NULL, NULL),
(4, 'Electrica', '44', '100', NULL, NULL),
(5, 'Electronica', '45', '100', NULL, NULL),
(6, 'Gestion Empresarial', '4', '100', NULL, NULL),
(7, 'Administracion Empresarial', '53', '100', NULL, NULL),
(8, 'Arquitectura', '46', '200', NULL, NULL),
(9, 'Quimica', '47', '150', NULL, '2025-11-12 01:33:21'),
(10, 'Civil', '48', '120', NULL, NULL);

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
-- Estructura de tabla para la tabla `grupos`
--

CREATE TABLE `grupos` (
  `id_grupo` int(11) NOT NULL,
  `cod_materia` varchar(30) DEFAULT NULL,
  `n_trabajador` varchar(30) DEFAULT NULL,
  `semestre` int(11) DEFAULT NULL,
  `periodo_id` int(11) DEFAULT NULL,
  `patron` varchar(10) DEFAULT NULL,
  `hora_inicio` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `grupos`
--

INSERT INTO `grupos` (`id_grupo`, `cod_materia`, `n_trabajador`, `semestre`, `periodo_id`, `patron`, `hora_inicio`, `created_at`, `updated_at`) VALUES
(1, 'TICS101', 'CAMOTO1', 3, 12, 'L-M', '09:00:00', NULL, '2025-11-29 00:13:30'),
(2, 'TICS102', 'CAMOTO1', 3, 10, 'L-M', '07:00:00', NULL, '2025-11-29 00:08:40'),
(3, 'AE101', 'PROF003', 2, 11, 'L-M', '07:00:00', NULL, '2025-11-19 03:30:28'),
(5, 'TICS101', 'PROF005', 3, 12, NULL, NULL, NULL, NULL),
(6, 'TICS102', 'PROF006', 3, 12, NULL, NULL, NULL, NULL),
(7, 'TICS103', 'PROF010', 4, 12, 'M-J', '11:00:00', NULL, '2025-11-28 00:57:21'),
(8, 'TICS104', 'PROF008', 10, 12, 'L-M', '07:00:00', NULL, '2025-11-29 00:42:23'),
(9, 'TICS101', 'PROF009', 5, 11, NULL, NULL, NULL, NULL),
(10, 'AE101', 'PROF009', 10, 12, NULL, NULL, '2025-10-24 23:44:23', '2025-10-31 03:02:22'),
(1237, 'TICS102', 'PROF010', 10, 11, NULL, NULL, '2025-11-05 04:35:05', '2025-11-05 04:35:05'),
(1238, 'AE101', 'PROF003', 1, 12, NULL, NULL, '2025-11-07 00:51:07', '2025-11-07 00:51:07'),
(1245, 'AE101', 'CAMOTO1', 10, 11, 'L-M', '11:00:00', '2025-11-12 07:00:25', '2025-11-29 00:47:53'),
(1246, 'ETRO104', 'PROF002', 8, 12, NULL, NULL, '2025-11-12 11:50:55', '2025-11-18 23:48:40'),
(1247, 'TICS204', 'ERDELO1', 7, 11, 'M-J', '11:00:00', '2025-11-19 03:45:14', '2025-11-26 03:15:07'),
(1248, 'TICS210', 'CAMOTO1', 2, 12, 'M-J', '09:00:00', '2025-11-26 02:18:58', '2025-11-29 00:48:26'),
(1249, 'AE101', 'JINAJU1', 1, 11, 'L-M', '07:00:00', '2025-11-28 00:31:03', '2025-11-29 00:17:58'),
(1250, 'TICS251', 'PROF007', 9, 12, 'M-J', '11:00:00', '2025-11-28 00:53:18', '2025-11-28 00:55:32'),
(1251, 'TICS222', 'PROF005', 4, 8, 'L-M', '13:00:00', '2025-11-28 01:30:38', '2025-11-28 01:30:56');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historials`
--

CREATE TABLE `historials` (
  `id` int(11) NOT NULL,
  `calificacion` int(11) DEFAULT NULL,
  `FKn_control` varchar(9) DEFAULT NULL,
  `FK_materia` varchar(30) DEFAULT NULL,
  `FK_prof` varchar(30) DEFAULT NULL,
  `periodo` varchar(10) DEFAULT NULL,
  `oportunidad` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historials`
--

INSERT INTO `historials` (`id`, `calificacion`, `FKn_control`, `FK_materia`, `FK_prof`, `periodo`, `oportunidad`, `created_at`, `updated_at`) VALUES
(1, 78, '20222165', 'TICS101', 'PROF001', '2024-1', 'Aprobada', NULL, NULL),
(2, 85, '20222286', 'TICS102', 'PROF002', '2024-1', 'Especial', NULL, '2025-10-24 04:31:09'),
(3, 92, '19222168', 'TICS103', 'PROF003', '2024-1', 'Aprobada', NULL, NULL),
(4, 68, '21222198', 'TICS104', 'PROF004', '2024-1', 'Reprobada', NULL, NULL),
(5, 55, '22143199', 'TICS101', 'PROF005', '2024-1', 'Repite', NULL, NULL),
(6, 80, '20212178', 'TICS102', 'PROF006', '2024-1', 'Especial', NULL, NULL),
(7, 73, '19222128', 'TICS103', 'PROF007', '2024-1', 'Aprobada', NULL, NULL),
(8, 90, '20232012', 'TICS104', 'PROF008', '2024-1', 'En curso', NULL, NULL),
(9, 66, '22153201', 'TICS101', 'PROF009', '2024-1', 'Reprobada', NULL, NULL),
(10, 77, '21122177', 'TICS102', 'PROF010', '2024-1', 'Aprobada', NULL, NULL),
(11, 84, '20242234', 'TICS103', 'PROF001', '2024-1', 'Repite', NULL, NULL),
(12, 69, '20243321', 'TICS104', 'PROF002', '2024-1', 'Especial', NULL, NULL),
(13, 91, '19233245', 'TICS101', 'PROF003', '2024-1', 'Aprobada', NULL, NULL),
(14, 58, '20254412', 'TICS102', 'PROF004', '2024-1', 'Reprobada', NULL, NULL),
(15, 82, '21245567', 'TICS103', 'PROF005', '2024-1', 'En curso', NULL, NULL),
(16, 75, '20246678', 'TICS104', 'PROF006', '2024-1', 'Aprobada', NULL, NULL),
(17, 63, '22147789', 'TICS101', 'PROF007', '2024-1', 'Repite', NULL, NULL),
(18, 88, '20248890', 'TICS102', 'PROF008', '2024-1', 'En curso', NULL, NULL),
(19, 95, '21249901', 'TICS103', 'PROF009', '2024-1', 'Aprobada', NULL, NULL),
(20, 71, '20250012', 'TICS104', 'PROF010', '2024-1', 'Especial', NULL, NULL),
(21, 83, '22160001', 'TICS101', 'PROF001', '2024-1', 'Aprobada', NULL, NULL),
(22, 72, '22160002', 'TICS102', 'PROF002', '2024-1', 'Reprobada', NULL, NULL),
(23, 90, '22160003', 'TICS103', 'PROF003', '2024-1', 'En curso', NULL, NULL),
(24, 65, '22160004', 'TICS104', 'PROF004', '2024-1', 'Especial', NULL, NULL),
(25, 78, '22160005', 'TICS101', 'PROF005', '2024-1', 'Repite', NULL, NULL),
(26, 87, '22160006', 'TICS102', 'PROF006', '2024-1', 'Aprobada', NULL, NULL),
(27, 91, '22160007', 'TICS103', 'PROF007', '2024-1', 'Aprobada', NULL, NULL),
(28, 54, '22160008', 'TICS104', 'PROF008', '2024-1', 'Reprobada', NULL, NULL),
(29, 76, '22160009', 'TICS101', 'PROF009', '2024-1', 'Especial', NULL, NULL),
(30, 88, '22160010', 'TICS102', 'PROF010', '2024-1', 'Aprobada', NULL, NULL),
(31, 70, '22160011', 'TICS103', 'PROF001', '2024-1', 'Reprobada', NULL, NULL),
(32, 92, '22160012', 'TICS104', 'PROF002', '2024-1', 'Aprobada', NULL, NULL),
(33, 84, '22160013', 'TICS101', 'PROF003', '2024-1', 'Aprobada', NULL, NULL),
(34, 77, '22160014', 'TICS102', 'PROF004', '2024-1', 'Repite', NULL, NULL),
(35, 89, '22160015', 'TICS103', 'PROF005', '2024-1', 'En curso', NULL, NULL),
(36, 66, '22160016', 'TICS104', 'PROF006', '2024-1', 'Reprobada', NULL, NULL),
(37, 95, '22160017', 'TICS101', 'PROF007', '2024-1', 'Aprobada', NULL, NULL),
(38, 74, '22160018', 'TICS102', 'PROF008', '2024-1', 'Especial', NULL, NULL),
(39, 81, '22160019', 'TICS103', 'PROF009', '2024-1', 'Aprobada', NULL, NULL),
(40, 68, '22160020', 'TICS104', 'PROF010', '2024-1', 'Reprobada', NULL, NULL),
(41, 93, '22160021', 'TICS101', 'PROF001', '2024-1', 'Aprobada', NULL, NULL),
(42, 79, '22160022', 'TICS102', 'PROF002', '2024-1', 'Especial', NULL, NULL),
(43, 85, '22160023', 'TICS103', 'PROF003', '2024-1', 'Aprobada', NULL, NULL),
(44, 73, '22160024', 'TICS104', 'PROF004', '2024-1', 'Repite', NULL, NULL),
(45, 91, '22160025', 'TICS101', 'PROF005', '2024-1', 'Aprobada', NULL, NULL),
(46, 64, '22160026', 'TICS102', 'PROF006', '2024-1', 'Reprobada', NULL, NULL),
(47, 86, '22160027', 'TICS103', 'PROF007', '2024-1', 'Aprobada', NULL, NULL),
(48, 75, '22160028', 'TICS104', 'PROF008', '2024-1', 'En curso', NULL, NULL),
(49, 82, '22160029', 'TICS101', 'PROF009', '2024-1', 'Aprobada', NULL, NULL),
(50, 67, '22160030', 'TICS102', 'PROF010', '2024-1', 'Reprobada', NULL, NULL),
(51, 88, '22160031', 'TICS103', 'PROF001', '2024-1', 'Aprobada', NULL, NULL),
(52, 71, '22160032', 'TICS104', 'PROF002', '2024-1', 'Especial', NULL, NULL),
(53, 94, '22160033', 'TICS101', 'PROF003', '2024-1', 'Aprobada', NULL, NULL),
(54, 62, '22160034', 'TICS102', 'PROF004', '2024-1', 'Reprobada', NULL, NULL),
(55, 80, '22160035', 'TICS103', 'PROF005', '2024-1', 'Repite', NULL, NULL),
(56, 89, '22160036', 'TICS104', 'PROF006', '2024-1', 'Aprobada', NULL, NULL),
(57, 78, '22160037', 'TICS101', 'PROF007', '2024-1', 'En curso', NULL, NULL),
(58, 96, '22160038', 'TICS102', 'PROF008', '2024-1', 'Aprobada', NULL, NULL),
(59, 63, '22160039', 'TICS103', 'PROF009', '2024-1', 'Reprobada', NULL, NULL),
(60, 85, '22160040', 'TICS104', 'PROF010', '2024-1', 'Aprobada', NULL, NULL),
(61, 72, '22160041', 'TICS101', 'PROF001', '2024-1', 'Especial', NULL, NULL),
(62, 90, '22160042', 'TICS102', 'PROF002', '2024-1', 'Aprobada', NULL, NULL),
(63, 76, '22160043', 'TICS103', 'PROF003', '2024-1', 'Repite', NULL, NULL),
(64, 83, '22160044', 'TICS104', 'PROF004', '2024-1', 'Aprobada', NULL, NULL),
(65, 69, '22160045', 'TICS101', 'PROF005', '2024-1', 'Reprobada', NULL, NULL),
(66, 92, '22160046', 'TICS102', 'PROF006', '2024-1', 'Aprobada', NULL, NULL),
(67, 81, '22160047', 'TICS103', 'PROF007', '2024-1', 'Aprobada', NULL, NULL),
(68, 74, '22160048', 'TICS104', 'PROF008', '2024-1', 'Especial', NULL, NULL),
(69, 88, '22160049', 'TICS101', 'PROF009', '2024-1', 'Aprobada', NULL, NULL),
(70, 66, '22160050', 'TICS102', 'PROF010', '2024-1', 'Reprobada', NULL, NULL),
(76, NULL, '19222128', 'TICS101', 'PROF001', '2024-1', 'Especial', '2025-10-15 03:30:56', '2025-10-15 03:30:56');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

CREATE TABLE `horarios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `grupo_id` bigint(20) UNSIGNED NOT NULL,
  `materia_id` varchar(255) NOT NULL,
  `profesore_id` varchar(255) NOT NULL,
  `aula_id` bigint(20) UNSIGNED NOT NULL,
  `dia_semana` tinyint(4) NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `horarios`
--

INSERT INTO `horarios` (`id`, `grupo_id`, `materia_id`, `profesore_id`, `aula_id`, `dia_semana`, `hora_inicio`, `hora_fin`, `created_at`, `updated_at`) VALUES
(8, 1247, 'TICS666', 'ERDELO1', 5, 2, '11:00:00', '13:00:00', '2025-11-19 03:50:00', '2025-11-19 03:50:00'),
(9, 1247, 'TICS666', 'ERDELO1', 5, 4, '11:00:00', '13:00:00', '2025-11-19 03:50:00', '2025-11-19 03:50:00'),
(10, 1247, 'TICS666', 'ERDELO1', 5, 5, '12:00:00', '13:00:00', '2025-11-19 03:50:00', '2025-11-19 03:50:00'),
(23, 7, 'TICS103', 'PROF010', 9, 2, '11:00:00', '13:00:00', '2025-11-28 00:57:26', '2025-11-28 00:57:26'),
(24, 7, 'TICS103', 'PROF010', 9, 4, '11:00:00', '13:00:00', '2025-11-28 00:57:26', '2025-11-28 00:57:26'),
(25, 7, 'TICS103', 'PROF010', 9, 5, '12:00:00', '13:00:00', '2025-11-28 00:57:26', '2025-11-28 00:57:26'),
(26, 1250, 'TICS251', 'PROF007', 6, 2, '11:00:00', '13:00:00', '2025-11-28 01:19:51', '2025-11-28 01:19:51'),
(27, 1250, 'TICS251', 'PROF007', 6, 4, '11:00:00', '13:00:00', '2025-11-28 01:19:51', '2025-11-28 01:19:51'),
(28, 1250, 'TICS251', 'PROF007', 6, 5, '12:00:00', '13:00:00', '2025-11-28 01:19:51', '2025-11-28 01:19:51'),
(29, 1251, 'TICS222', 'PROF005', 7, 1, '13:00:00', '15:00:00', '2025-11-28 01:31:01', '2025-11-28 01:31:01'),
(30, 1251, 'TICS222', 'PROF005', 7, 3, '13:00:00', '15:00:00', '2025-11-28 01:31:01', '2025-11-28 01:31:01'),
(31, 1251, 'TICS222', 'PROF005', 7, 5, '13:00:00', '14:00:00', '2025-11-28 01:31:01', '2025-11-28 01:31:01'),
(86, 2, 'TICS102', 'CAMOTO1', 31, 1, '07:00:00', '09:00:00', '2025-11-29 00:08:40', '2025-11-29 00:08:40'),
(87, 2, 'TICS102', 'CAMOTO1', 31, 3, '07:00:00', '09:00:00', '2025-11-29 00:08:40', '2025-11-29 00:08:40'),
(88, 2, 'TICS102', 'CAMOTO1', 31, 5, '07:00:00', '08:00:00', '2025-11-29 00:08:40', '2025-11-29 00:08:40'),
(89, 1, 'TICS101', 'CAMOTO1', 31, 1, '09:00:00', '11:00:00', '2025-11-29 00:13:30', '2025-11-29 00:13:30'),
(90, 1, 'TICS101', 'CAMOTO1', 31, 3, '09:00:00', '11:00:00', '2025-11-29 00:13:30', '2025-11-29 00:13:30'),
(91, 1, 'TICS101', 'CAMOTO1', 31, 5, '09:00:00', '10:00:00', '2025-11-29 00:13:30', '2025-11-29 00:13:30'),
(101, 1249, 'AE101', 'JINAJU1', 33, 1, '07:00:00', '09:00:00', '2025-11-29 00:37:01', '2025-11-29 00:37:01'),
(102, 1249, 'AE101', 'JINAJU1', 33, 3, '07:00:00', '09:00:00', '2025-11-29 00:37:01', '2025-11-29 00:37:01'),
(103, 1249, 'AE101', 'JINAJU1', 33, 5, '07:00:00', '08:00:00', '2025-11-29 00:37:01', '2025-11-29 00:37:01'),
(104, 8, 'TICS104', 'PROF008', 30, 1, '07:00:00', '09:00:00', '2025-11-29 00:42:23', '2025-11-29 00:42:23'),
(105, 8, 'TICS104', 'PROF008', 30, 3, '07:00:00', '09:00:00', '2025-11-29 00:42:23', '2025-11-29 00:42:23'),
(106, 8, 'TICS104', 'PROF008', 30, 5, '07:00:00', '08:00:00', '2025-11-29 00:42:23', '2025-11-29 00:42:23'),
(107, 1245, 'AE101', 'CAMOTO1', 35, 1, '11:00:00', '13:00:00', '2025-11-29 00:47:53', '2025-11-29 00:47:53'),
(108, 1245, 'AE101', 'CAMOTO1', 35, 3, '11:00:00', '13:00:00', '2025-11-29 00:47:53', '2025-11-29 00:47:53'),
(109, 1245, 'AE101', 'CAMOTO1', 35, 5, '11:00:00', '12:00:00', '2025-11-29 00:47:53', '2025-11-29 00:47:53'),
(110, 1248, 'TICS210', 'CAMOTO1', 31, 2, '09:00:00', '11:00:00', '2025-11-29 00:48:26', '2025-11-29 00:48:26'),
(111, 1248, 'TICS210', 'CAMOTO1', 31, 4, '09:00:00', '11:00:00', '2025-11-29 00:48:26', '2025-11-29 00:48:26'),
(112, 1248, 'TICS210', 'CAMOTO1', 31, 5, '10:00:00', '11:00:00', '2025-11-29 00:48:26', '2025-11-29 00:48:26');

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
-- Estructura de tabla para la tabla `materias`
--

CREATE TABLE `materias` (
  `cod_materia` varchar(30) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `semestre` int(2) DEFAULT NULL,
  `credito` int(11) DEFAULT NULL,
  `cadena` tinyint(1) DEFAULT NULL,
  `materia_estado` varchar(10) DEFAULT NULL,
  `prerrequisito` varchar(30) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `materias`
--

INSERT INTO `materias` (`cod_materia`, `nombre`, `semestre`, `credito`, `cadena`, `materia_estado`, `prerrequisito`, `created_at`, `updated_at`) VALUES
('AE101', 'Marketing', NULL, 5, 2, 'Activa', NULL, NULL, '2025-11-12 02:28:19'),
('AE102', 'Recursos Humanos', NULL, 5, 1, 'Activa', NULL, NULL, '2025-11-12 02:28:25'),
('AE103', 'Gestión de Proyectos', NULL, 5, 1, 'Activa', NULL, NULL, '2025-11-12 02:28:31'),
('AE104', 'Planeación Estratégica', NULL, 5, 1, 'Activa', NULL, NULL, '2025-11-12 02:28:39'),
('ARQ101', 'Diseño Arquitectónico', NULL, 4, 1, 'Activa', NULL, NULL, NULL),
('ARQ102', 'Urbanismo', NULL, 4, 1, 'Activa', NULL, NULL, NULL),
('ARQ103', 'Materiales de Construcción', NULL, 4, 1, 'Activa', NULL, NULL, NULL),
('ARQ104', 'Historia de la Arquitectura', NULL, 4, 1, 'Activa', NULL, NULL, NULL),
('CIV101', 'Topografía', NULL, 4, 1, 'Activa', NULL, NULL, NULL),
('CIV102', 'Estructuras I', NULL, 4, 1, 'Activa', NULL, NULL, NULL),
('CIV103', 'Hidráulica', NULL, 4, 1, 'Activa', NULL, NULL, NULL),
('CIV104', 'Geotecnia', NULL, 4, 1, 'Activa', NULL, NULL, NULL),
('ELE101', 'Circuitos Eléctricos', NULL, 4, 1, 'Activa', NULL, NULL, NULL),
('ELE102', 'Electrónica I', NULL, 4, 1, 'Activa', NULL, NULL, NULL),
('ELE103', 'Máquinas Eléctricas', NULL, 4, 1, 'Activa', NULL, NULL, NULL),
('ELE104', 'Sistemas de Control', NULL, 4, 1, 'Activa', NULL, NULL, NULL),
('ETRO101', 'Electrónica Digital', NULL, 4, 1, 'Activa', NULL, NULL, NULL),
('ETRO102', 'Microcontroladores', NULL, 4, 1, 'Activa', NULL, NULL, NULL),
('ETRO103', 'Sistemas Embebidos', NULL, 4, 1, 'Activa', NULL, NULL, NULL),
('ETRO104', 'Señales y Sistemas', NULL, 4, 1, 'Activa', NULL, NULL, NULL),
('GE101', 'Administración', NULL, 4, 1, 'Activa', NULL, NULL, NULL),
('GE102', 'Economía', NULL, 4, 1, 'Activa', NULL, NULL, NULL),
('GE103', 'Contabilidad', NULL, 4, 1, 'Activa', NULL, NULL, NULL),
('GE104', 'Finanzas', NULL, 4, 1, 'Activa', NULL, NULL, NULL),
('INDU101', 'Procesos de Manufactura', NULL, 4, 1, 'Activa', NULL, NULL, NULL),
('INDU102', 'Diseño Industrial', NULL, 4, 1, 'Activa', NULL, NULL, NULL),
('INDU103', 'Control de Calidad', NULL, 4, 1, 'Activa', NULL, NULL, NULL),
('INDU104', 'Materiales Industriales', NULL, 4, 1, 'Activa', NULL, NULL, NULL),
('MEC101', 'Mecanica I', NULL, 4, 1, 'Activa', NULL, NULL, NULL),
('MEC102', 'Termodinámica', NULL, 4, 1, 'Activa', NULL, NULL, NULL),
('MEC103', 'Mecanica de Fluidos', NULL, 4, 1, 'Activa', NULL, NULL, NULL),
('MEC104', 'Resistencia de Materiales', NULL, 4, 1, 'Activa', NULL, NULL, NULL),
('PSIC001', 'Psicología I', NULL, 5, 1, 'Activa', NULL, '2025-11-07 00:48:53', '2025-11-07 00:48:53'),
('QUI101', 'Química General', NULL, 4, 1, 'Activa', NULL, NULL, NULL),
('QUI102', 'Química Orgánica', NULL, 4, 1, 'Activa', NULL, NULL, NULL),
('QUI103', 'Química Analítica', NULL, 4, 1, 'Activa', NULL, NULL, NULL),
('QUI104', 'Bioquímica', NULL, 4, 1, 'Activa', NULL, NULL, NULL),
('TICS101', 'Fundamentos de Programación', 1, 5, 1, 'Activa', NULL, NULL, '2025-11-25 18:50:27'),
('TICS102', 'Redes I', 4, 5, 2, 'Activa', NULL, NULL, '2025-11-12 02:29:00'),
('TICS103', 'Base de Datos', 4, 5, 5, 'Activa', 'TICS211', NULL, '2025-11-12 02:29:11'),
('TICS104', 'Ciberseguridad', 8, 5, 2, 'Activa', NULL, NULL, '2025-11-25 18:50:27'),
('TICS201', 'Cálculo Diferencial', 1, 5, 3, 'Activa', NULL, '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS204', 'Matemáticas Discretas I', 1, 5, 5, 'Activa', NULL, '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS205', 'Taller de Ética', 1, 4, NULL, 'Activa', NULL, '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS206', 'Fundamentos de Investigación', 1, 4, 7, 'Activa', NULL, '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS208', 'Introducción a las TICs', 1, 3, 2, 'Activa', NULL, '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS209', 'Cálculo Integral', 2, 5, 3, 'Activa', 'TICS201', '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS210', 'Programación Orientada a Objetos', 2, 5, 1, 'Activa', 'TICS101', '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS211', 'Matemáticas Discretas II', 2, 5, 5, 'Activa', 'TICS204', '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS212', 'Álgebra Lineal', 2, 5, 3, 'Activa', NULL, '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS213', 'Contabilidad y Costos', 2, 5, 6, 'Activa', NULL, '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS214', 'Probabilidad y Estadística', 2, 5, 7, 'Activa', NULL, '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS215', 'Matemáticas Aplicadas a Comunicaciones', 3, 4, 3, 'Activa', 'TICS209', '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS216', 'Estructuras de Datos', 3, 5, 1, 'Activa', 'TICS210', '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS217', 'Matemáticas para la Toma de Decisiones', 3, 5, 7, 'Activa', NULL, '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS218', 'Desarrollo Sustentable', 3, 5, NULL, 'Activa', NULL, '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS219', 'Electricidad y Magnetismo', 3, 4, 4, 'Activa', NULL, '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS220', 'Fundamentos de Redes', 4, 5, NULL, 'Activa', NULL, '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS221', 'Análisis de Señales y Sistemas de Comunicación', 4, 5, 3, 'Activa', 'TICS215', '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS222', 'Fundamentos de Bases de Datos', 4, 5, NULL, 'Activa', NULL, '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS223', 'Sistemas Operativos I', 4, 4, NULL, 'Activa', NULL, '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS224', 'Desarrollo de Emprendedores', 3, 5, 6, 'Activa', NULL, '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS225', 'Circuitos Eléctricos y Electrónicos', 4, 5, 4, 'Activa', 'TICS219', '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS226', 'Redes de Computadoras', 5, 5, 2, 'Activa', 'TICS220', '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS227', 'Telecomunicaciones', 5, 5, 2, 'Activa', NULL, '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS228', 'Taller de Bases de Datos', 5, 4, 5, 'Activa', 'TICS103', '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS229', 'Programación II', 5, 5, NULL, 'Activa', 'TICS216', '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS230', 'Sistemas Operativos II', 5, 5, NULL, 'Activa', NULL, '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS231', 'Arquitectura de Computadoras', 5, 4, 4, 'Activa', 'TICS225', '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS232', 'Redes Emergentes', 6, 5, NULL, 'Activa', NULL, '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS233', 'Actividades Complementarias', 6, 5, NULL, 'Activa', NULL, '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS234', 'Tecnologías Inalámbricas', 6, 4, 2, 'Activa', 'TICS226', '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS235', 'Bases de Datos Distribuidas', 6, 5, NULL, 'Activa', 'TICS228', '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS236', 'Programación Web', 6, 5, 1, 'Activa', 'TICS229', '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS237', 'Ingeniería de Software', 6, 4, 5, 'Activa', 'TICS228', '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS238', 'Interacción Humano-Computadora', 4, 4, NULL, 'Activa', NULL, '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS239', 'Administración y Seguridad de Redes', 7, 5, 2, 'Activa', 'TICS226', '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS240', 'Taller de Investigación I', 7, 4, 7, 'Activa', 'TICS206', '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS241', 'Negocios Electrónicos I', 7, 4, 6, 'Activa', NULL, '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS242', 'Desarrollo de Aplicaciones Móviles', 7, 5, 1, 'Activa', 'TICS236', '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS243', 'Taller de Ingeniería de Software', 7, 4, 5, 'Activa', 'TICS237', '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS244', 'Administración Gerencial', 8, 4, 6, 'Activa', NULL, '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS245', 'Servicio Social', 7, 10, NULL, 'Activa', NULL, '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS246', 'Taller de Investigación II', 8, 4, 7, 'Activa', 'TICS240', '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS247', 'Sistemas Web con Oracle', 8, 5, 1, 'Activa', 'TICS252', '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS248', 'Fundamentos de Internet de las Cosas', 8, 5, 4, 'Activa', 'TICS231', '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS250', 'Cubos OLAP Inteligencia Empresarial', 8, 5, NULL, 'Activa', NULL, '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS251', 'Internet de las Cosas Avanzado', 9, 5, 4, 'Activa', 'TICS248', '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS252', 'Programación de Aplicaciones en Ambientes Distribuidos', 9, 5, 1, 'Activa', NULL, '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS253', 'Auditoría Tecnológica de la Información', 8, 4, NULL, 'Activa', NULL, '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS254', 'Ingeniería del Conocimiento', 9, 4, 5, 'Activa', NULL, '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS255', 'Negocios Electrónicos II', 8, 4, 6, 'Activa', NULL, '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS256', 'Administración de Proyectos', 9, 5, 6, 'Activa', NULL, '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS257', 'Residencia Profesional', 9, 10, NULL, 'Activa', NULL, '2025-11-25 18:50:27', '2025-11-25 18:50:27'),
('TICS666', 'Inteligencia Artificial', 9, 5, NULL, 'Activa', NULL, '2025-11-19 03:41:47', '2025-11-19 03:41:47'),
('visc12', 'visc', NULL, 5, 2, 'Baja', NULL, '2025-11-12 02:27:18', '2025-11-12 02:27:47');

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_10_02_013114_create_areas_table', 1),
(5, '2025_11_18_202902_create_boletas_table', 2),
(6, '2025_10_23_190826_add_id_carrera_to_alumnos_table', 3),
(7, '2025_10_30_180544_create_periodos_table', 4),
(8, '2025_11_06_171948_create_aulas_table', 5),
(9, '2025_11_06_172121_create_horarios_table', 6),
(10, '2025_11_11_220745_add_patron_and_hora_inicio_to_grupos_table', 7),
(11, '2025_11_12_061528_remove_patron_from_horarios_table', 8),
(12, '2025_11_27_221752_create_permission_tables', 8),
(13, '2025_11_27_222440_add_profile_fields_to_users_table', 9),
(14, '2025_11_27_224640_add_links_to_users_table', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 4),
(2, 'App\\Models\\User', 5),
(3, 'App\\Models\\User', 6),
(3, 'App\\Models\\User', 7),
(3, 'App\\Models\\User', 8),
(3, 'App\\Models\\User', 9),
(3, 'App\\Models\\User', 10),
(3, 'App\\Models\\User', 11),
(3, 'App\\Models\\User', 12),
(3, 'App\\Models\\User', 13),
(3, 'App\\Models\\User', 14),
(3, 'App\\Models\\User', 15),
(3, 'App\\Models\\User', 16),
(3, 'App\\Models\\User', 17),
(3, 'App\\Models\\User', 18),
(3, 'App\\Models\\User', 19),
(3, 'App\\Models\\User', 20),
(3, 'App\\Models\\User', 21),
(3, 'App\\Models\\User', 22),
(3, 'App\\Models\\User', 23),
(3, 'App\\Models\\User', 24),
(3, 'App\\Models\\User', 25),
(3, 'App\\Models\\User', 26),
(3, 'App\\Models\\User', 27),
(3, 'App\\Models\\User', 28),
(3, 'App\\Models\\User', 29),
(3, 'App\\Models\\User', 30),
(3, 'App\\Models\\User', 31),
(3, 'App\\Models\\User', 32),
(3, 'App\\Models\\User', 33),
(3, 'App\\Models\\User', 34),
(3, 'App\\Models\\User', 35),
(3, 'App\\Models\\User', 36),
(3, 'App\\Models\\User', 37),
(3, 'App\\Models\\User', 38),
(3, 'App\\Models\\User', 39),
(3, 'App\\Models\\User', 40),
(3, 'App\\Models\\User', 41),
(3, 'App\\Models\\User', 42),
(3, 'App\\Models\\User', 43),
(3, 'App\\Models\\User', 44),
(3, 'App\\Models\\User', 45),
(3, 'App\\Models\\User', 46),
(3, 'App\\Models\\User', 47),
(3, 'App\\Models\\User', 48),
(3, 'App\\Models\\User', 49),
(3, 'App\\Models\\User', 50),
(3, 'App\\Models\\User', 51),
(3, 'App\\Models\\User', 52),
(3, 'App\\Models\\User', 53),
(3, 'App\\Models\\User', 54),
(3, 'App\\Models\\User', 55),
(3, 'App\\Models\\User', 56),
(3, 'App\\Models\\User', 57),
(3, 'App\\Models\\User', 58),
(3, 'App\\Models\\User', 59),
(3, 'App\\Models\\User', 60),
(3, 'App\\Models\\User', 61),
(3, 'App\\Models\\User', 62),
(3, 'App\\Models\\User', 63),
(3, 'App\\Models\\User', 64),
(3, 'App\\Models\\User', 65),
(3, 'App\\Models\\User', 66),
(3, 'App\\Models\\User', 67),
(3, 'App\\Models\\User', 68),
(3, 'App\\Models\\User', 69),
(3, 'App\\Models\\User', 70),
(3, 'App\\Models\\User', 71),
(3, 'App\\Models\\User', 72),
(3, 'App\\Models\\User', 73),
(3, 'App\\Models\\User', 74),
(3, 'App\\Models\\User', 75),
(3, 'App\\Models\\User', 76),
(3, 'App\\Models\\User', 77),
(3, 'App\\Models\\User', 78),
(3, 'App\\Models\\User', 79),
(3, 'App\\Models\\User', 80),
(3, 'App\\Models\\User', 81),
(3, 'App\\Models\\User', 82),
(3, 'App\\Models\\User', 83),
(3, 'App\\Models\\User', 84);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `periodos`
--

CREATE TABLE `periodos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `periodo_nombre` varchar(255) NOT NULL,
  `anio` int(11) NOT NULL,
  `codigo_periodo` varchar(255) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `periodos`
--

INSERT INTO `periodos` (`id`, `periodo_nombre`, `anio`, `codigo_periodo`, `activo`, `created_at`, `updated_at`) VALUES
(1, 'Enero-Junio', 2020, 'ENEJUN20', 0, '2025-10-30 18:04:07', '2025-10-30 18:04:07'),
(2, 'Agosto-Diciembre', 2020, 'AGODIC20', 0, '2025-10-30 18:04:07', '2025-10-30 18:04:07'),
(3, 'Enero-Junio', 2021, 'ENEJUN21', 0, '2025-10-30 18:04:07', '2025-10-30 18:04:07'),
(4, 'Agosto-Diciembre', 2021, 'AGODIC21', 0, '2025-10-30 18:04:07', '2025-10-30 18:04:07'),
(5, 'Enero-Junio', 2022, 'ENEJUN22', 0, '2025-10-30 18:04:07', '2025-10-30 18:04:07'),
(6, 'Agosto-Diciembre', 2022, 'AGODIC22', 0, '2025-10-30 18:04:07', '2025-10-30 18:04:07'),
(7, 'Enero-Junio', 2023, 'ENEJUN23', 1, '2025-10-30 18:04:07', '2025-11-28 00:35:22'),
(8, 'Agosto-Diciembre', 2023, 'AGODIC23', 1, '2025-10-30 18:04:07', '2025-11-28 00:35:53'),
(9, 'Enero-Junio', 2024, 'ENEJUN24', 1, '2025-10-30 18:04:07', '2025-11-28 00:35:05'),
(10, 'Agosto-Diciembre', 2024, 'AGODIC24', 1, '2025-10-30 18:04:07', '2025-11-28 00:35:13'),
(11, 'Enero-Junio', 2025, 'ENEJUN25', 1, '2025-10-30 18:04:07', '2025-11-12 01:23:44'),
(12, 'Agosto-Diciembre', 2025, 'AGODIC25', 1, '2025-10-30 18:04:07', '2025-10-30 18:04:07'),
(13, 'Enero-Junio', 2026, 'ENEJUN26', 0, '2025-11-19 03:44:16', '2025-11-19 03:44:16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'ver todo', 'web', '2025-11-28 04:30:34', '2025-11-28 04:30:34'),
(2, 'calificar', 'web', '2025-11-28 04:30:34', '2025-11-28 04:30:34'),
(3, 'ver propias calificaciones', 'web', '2025-11-28 04:30:34', '2025-11-28 04:30:34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesores`
--

CREATE TABLE `profesores` (
  `n_trabajador` varchar(30) NOT NULL,
  `contraseña` varchar(255) DEFAULT NULL,
  `nombre` varchar(30) DEFAULT NULL,
  `s_nombre` varchar(30) DEFAULT NULL,
  `ap_materno` varchar(30) DEFAULT NULL,
  `ap_paterno` varchar(30) DEFAULT NULL,
  `correo_institucional` varchar(30) DEFAULT NULL,
  `FKcod_area` int(11) DEFAULT NULL,
  `situacion` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `profesores`
--

INSERT INTO `profesores` (`n_trabajador`, `contraseña`, `nombre`, `s_nombre`, `ap_materno`, `ap_paterno`, `correo_institucional`, `FKcod_area`, `situacion`, `created_at`, `updated_at`) VALUES
('CAMOTO1', 'CAMOTO1', 'Carlos', NULL, 'Torres', 'Moran', 'Torres@carlos', 1, 'Vigente', '2025-10-17 01:57:25', '2025-11-28 11:16:29'),
('ERDELO1', 'ERDELO1', 'Erick', 'Alberto', 'Lopez', 'De La Barrera', 'erick@ehhe', 12, 'Vigente', '2025-10-17 02:41:54', '2025-10-17 02:42:14'),
('JINAJU1', 'JINAJU1', 'Jimmy', 'Baraquiel', 'Juarez', 'Navarrete', 'jimmy@jimmy.com', 2, 'Vigente', '2025-11-05 07:02:23', '2025-11-05 07:02:23'),
('PROF001', 'PROF001', 'Juan', NULL, 'Gómez', 'Pérez', 'jc.perez@itp.edu', 4, 'Vigente', NULL, '2025-10-24 01:26:04'),
('PROF002', 'PROF002', 'María', 'Elena', 'Sánchez', 'López', 'me.lopez@escuela.edu', 1, 'Vigente', NULL, NULL),
('PROF003', 'PROF003', 'José', 'Antonio', 'Torres', 'Ramírez', 'ja.ramirez@escuela.edu', 2, 'Vigente', NULL, NULL),
('PROF004', 'PROF004', 'Marta', 'Patricia', 'Díaz', 'García', 'mp.garcia@escuela.edu', 2, 'Vigente', NULL, NULL),
('PROF005', 'PROF005', 'Fernando', 'Luis', 'Morales', 'Hernández', 'fl.hernandez@escuela.edu', 3, 'Vigente', NULL, NULL),
('PROF006', 'PROF006', 'Laura', 'María', 'Jiménez', 'Vargas', 'lm.vargas@escuela.edu', 3, 'En Asignación', NULL, '2025-10-17 01:33:16'),
('PROF007', 'PROF007', 'Ricardo', 'Eduardo', 'Pérez', 'Soto', 're.soto@escuela.edu', 1, 'Vigente', NULL, '2025-10-29 01:09:36'),
('PROF008', 'PROF008', 'Elena', 'Isabel', 'Mendoza', 'Ortiz', 'ei.ortiz@escuela.edu', 4, 'Vigente', NULL, NULL),
('PROF009', 'PROF009', 'Diego', '', 'Gómez', 'Martínez', 'd.martinez@escuela.edu', 5, 'Vigente', NULL, NULL),
('PROF010', 'PROF010', 'Andrea', 'Carolina', 'García', 'Romero', 'ac.romero@escuela.edu', 2, 'Vigente', NULL, '2025-10-29 01:09:56'),
('ERDELO2', 'ERDELO2', 'Erick', 'Alberto', 'Lopez', 'De La Barrera', 'erickdelab@gmail.com', 1, 'Vigente', '2025-11-19 03:38:31', '2025-11-19 03:38:31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2025-11-28 04:30:34', '2025-11-28 04:30:34'),
(2, 'profesor', 'web', '2025-11-28 04:30:34', '2025-11-28 04:30:34'),
(3, 'alumno', 'web', '2025-11-28 04:30:34', '2025-11-28 04:30:34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(2, 2),
(3, 1),
(3, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('ehmdXW2pehiAEi7djDnYHCLptfTcUHHp4BPfJv0Q', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:145.0) Gecko/20100101 Firefox/145.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWXMxOGdMRmZlV3E5WUFpdmczakZlNXJyZWs5U0d4SnVuY3RYeGpreiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyODoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2dydXBvcyI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI4OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvZ3J1cG9zIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1764349418),
('FSJhITCdocMPCEHqI0R8VgLXbR0kvSE8EtPBiuXo', 4, '192.168.100.15', 'Mozilla/5.0 (Android 12; Mobile; rv:145.0) Gecko/145.0 Firefox/145.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiakx4ZktSNmxVdnF6YWh2aUVOYVlIZEhYTHkxQWZwNE9GbnVmdG1iYSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xOTIuMTY4LjEwMC4xMS9ncnVwb3MvMTI0OCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjQ7czo0OiJhdXRoIjthOjE6e3M6MjE6InBhc3N3b3JkX2NvbmZpcm1lZF9hdCI7aToxNzY0MzU1NjI2O319', 1764355719),
('MsnYHqnB8JriHXSmJzAfeewjFgBBclozufNeJgwt', 5, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:145.0) Gecko/20100101 Firefox/145.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiWERwbklubEFrUEhLSUZXdGZpOUVrZUdpa0R3S0p1N0ZOS21KcEpwWSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC90ZWFjaGVyL2dydXBvcy8xIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NTtzOjQ6ImF1dGgiO2E6MTp7czoyMToicGFzc3dvcmRfY29uZmlybWVkX2F0IjtpOjE3NjQzNTU1NTc7fX0=', 1764355758),
('th1m6Xi0GbMsxTSQYGfBpkhswmGqOa50AStm0bkG', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:145.0) Gecko/20100101 Firefox/145.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoib0VkRENaT2MwdHJRa1FuZm15bENkeVlQMmNNbEJVemlSWnQzNVNndyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1764349419);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `n_control_link` varchar(255) DEFAULT NULL,
  `n_trabajador_link` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `n_control_link`, `n_trabajador_link`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'eric', 'erick@erick.com', NULL, NULL, NULL, '$2y$12$MqLiNKSb4KOIPyyX3rR14.W431KKi.uFtx286WOMUh5C70SSaMW.6', NULL, '2025-10-15 11:45:59', '2025-10-15 11:45:59'),
(2, 'eric', 'eric@eric.com', NULL, NULL, NULL, '$2y$12$K2nLkcV6MSYICuauCapV7u1Fe5UalLZWC7WLgkvC3v92nSUDEIaa.', NULL, '2025-10-16 22:51:39', '2025-10-16 22:51:39'),
(3, 'carlos', 'carlos@gmail.com', NULL, NULL, NULL, '$2y$12$r/7muLckfOikwQKsdfwUVeNkMAijJz.fHp1GNeq2DBjatHyMKibj6', NULL, '2025-10-24 00:24:04', '2025-10-24 00:24:04'),
(4, 'admin', 'admin@admin.com', NULL, NULL, NULL, '$2y$12$ciCsW0rDIhZWksdwX1ILLeQXrYUa1ARw42hs05CTBx.XvjcDtwRXK', NULL, '2025-11-21 01:03:39', '2025-11-28 06:38:20'),
(5, 'Carlos Torres Moran', 'Torres@carlos', NULL, 'CAMOTO1', NULL, '$2y$12$GZR3blFwxgBbP0twhjVqouGay.UPtPXOPGbPojrLj7tBxTHWPCB0W', NULL, '2025-11-28 04:47:59', '2025-11-28 04:47:59'),
(6, 'Jimmy Valenzuela', '091234@tecnm.mx', '091234', NULL, NULL, '$2y$12$GIrgl6j5RvgF6VTcaZhs9uxq.QzU0uMisQmU0C7ioXXcxULUiuJZq', NULL, '2025-11-28 04:48:00', '2025-11-28 07:06:33'),
(7, 'Hola El', '000111@tecnm.mx', '000111', NULL, NULL, '$2y$12$F/M6QImvuXFmP.ycRcvPT.YL6FB78KSIzXowKsDl9VALumJ/aL6aG', NULL, '2025-11-28 06:24:39', '2025-11-28 06:38:21'),
(8, 'juan Escobar', '123@tecnm.mx', '123', NULL, NULL, '$2y$12$mBJY8thCuDDSfqCVYhGj7eozVrl.fnz76Mvmhu4FtTc3U.REtvATq', NULL, '2025-11-28 06:24:39', '2025-11-28 06:38:22'),
(9, 'Andrés Pérez', '19222128@tecnm.mx', '19222128', NULL, NULL, '$2y$12$rqo56DktFGrHBQyMGH33vO6LvHaae81o8oJ5xqPga8rxWuoR.VMPW', NULL, '2025-11-28 06:24:40', '2025-11-28 06:38:23'),
(10, 'Juan Soria', '19222164@tecnm.mx', '19222164', NULL, NULL, '$2y$12$8Z2KZ8F2eDaj9LxFL1apteApu6Wrl4h4B59ZFAzMptJzOCH1dNeJO', NULL, '2025-11-28 06:24:40', '2025-11-28 06:38:23'),
(11, 'José Hernández', '19222168@tecnm.mx', '19222168', NULL, NULL, '$2y$12$HfinuV1sSjPxO5ndNyHH/OTFxuPk7JfNTYz0pOk/kp72VI1qn7w9i', NULL, '2025-11-28 06:24:41', '2025-11-28 06:38:23'),
(12, 'Ricardo Castillo', '19233245@tecnm.mx', '19233245', NULL, NULL, '$2y$12$Y/Z.fqxeIgUpPYj2p4urQ.BQw.ohaQGcsypUdv7bXshTQ/GlHj7E.', NULL, '2025-11-28 06:24:41', '2025-11-28 06:38:24'),
(13, 'Elena Ramírez', '20212178@tecnm.mx', '20212178', NULL, NULL, '$2y$12$BW2zpffqaEXK6.eUJykplOmSop59DtAJJHF22rWjxHTuJZmpZ.v86', NULL, '2025-11-28 06:24:41', '2025-11-28 06:38:24'),
(14, 'Pedro García', '20222165@tecnm.mx', '20222165', NULL, NULL, '$2y$12$9QQkjwpywXpmVy5HRT7nf.uWjyGLfyx53uVRfraS0j/MS5hO4spxi', NULL, '2025-11-28 06:24:42', '2025-11-28 06:38:25'),
(15, 'Juan Perez', '20222166@tecnm.mx', '20222166', NULL, NULL, '$2y$12$mOuFeCe4GX/Bv9JJvy.IV.zjylz/96HW.OFaujPOvLMl9070.puVK', NULL, '2025-11-28 06:24:42', '2025-11-28 06:38:25'),
(16, 'Lucía Rodríguez', '20222286@tecnm.mx', '20222286', NULL, NULL, '$2y$12$yh5o0SR6gjImhNaC7xYvQeysK1sJucTWs56He1JWyPv9dMcWk.Zm.', NULL, '2025-11-28 06:24:43', '2025-11-28 06:38:26'),
(17, 'Laura Gómez', '20232012@tecnm.mx', '20232012', NULL, NULL, '$2y$12$DDhFSQi1Aw/Drxq3xULZ6uDwFyB3.EAJVFKFLYz9XOdcCAupDz2Le', NULL, '2025-11-28 06:24:43', '2025-11-28 06:38:26'),
(18, 'Miguel Torres', '20242234@tecnm.mx', '20242234', NULL, NULL, '$2y$12$PKcUIclXcD5ifQ1hTyj7ZOsrayCIchH21/.fMQjqGjWTN7653Yqse', NULL, '2025-11-28 06:24:43', '2025-11-28 06:38:27'),
(19, 'Valeria Jiménez', '20243321@tecnm.mx', '20243321', NULL, NULL, '$2y$12$rXJ5S4crHbx6qKATC3XwV./XEshbk7.LfdsItFyEsscwW3Sr5hwf6', NULL, '2025-11-28 06:24:44', '2025-11-28 06:38:27'),
(20, 'Andrea Vargas', '20246678@tecnm.mx', '20246678', NULL, NULL, '$2y$12$qJHYydNgi6SDQ3duSUJaq.Jkekh5RZiGIH9T.Adc2ZlzeadWbPt1q', NULL, '2025-11-28 06:24:44', '2025-11-28 06:38:27'),
(21, 'Mariana Romero', '20248890@tecnm.mx', '20248890', NULL, NULL, '$2y$12$dbE4XJZdDCT64IcRW83jkeHETc5nWqIdE2IMBneE8fbX3CzQeB0fm', NULL, '2025-11-28 06:24:44', '2025-11-28 06:38:28'),
(22, 'Patricia Herrera', '20250012@tecnm.mx', '20250012', NULL, NULL, '$2y$12$x9NTg93F9iblWQ72T.1bXeCDw0CjNi0WcBuLkxHFq6MKXW7BRvHc2', NULL, '2025-11-28 06:24:45', '2025-11-28 06:38:28'),
(23, 'Daniela Soto', '20254412@tecnm.mx', '20254412', NULL, NULL, '$2y$12$3dPKVS6eRvOExs8tW3YU4uM1QQo2MOjjpmIgo1huWk6r6MQWW/JoO', NULL, '2025-11-28 06:24:45', '2025-11-28 06:38:29'),
(24, 'Sofía Ortiz', '21122177@tecnm.mx', '21122177', NULL, NULL, '$2y$12$Ii6sJ9rJhyxfA0IsLckG..hj1.4nEqTmf.494g6eA6H9XSi6.b7gO', NULL, '2025-11-28 06:24:46', '2025-11-28 06:38:29'),
(25, 'Marta López', '21222198@tecnm.mx', '21222198', NULL, NULL, '$2y$12$Yhhslwsg/8ky2esg3.AJ/OmEUw7pP4KDgW1Z1kmAAyA9mfEYRvMCe', NULL, '2025-11-28 06:24:46', '2025-11-28 06:38:29'),
(26, 'Juan Rivas', '21245567@tecnm.mx', '21245567', NULL, NULL, '$2y$12$zXTJKxoIKjCnKgoMlTQH0OptdFx9/yxzSqCsF0Var3KlHJ0QIt7Eq', NULL, '2025-11-28 06:24:47', '2025-11-28 06:38:30'),
(27, 'Sergio Molina', '21249901@tecnm.mx', '21249901', NULL, NULL, '$2y$12$m5FxQXOnSzElNJNB9IfCn.kwrSQ4g9ldDXh9zjA5hiY77/TkL4q7C', NULL, '2025-11-28 06:24:47', '2025-11-28 06:38:30'),
(28, 'Diego Martínez', '22143199@tecnm.mx', '22143199', NULL, NULL, '$2y$12$.iYF62lRlRKRiINFGUeXce1/8/2A.J8Wn4gJl.Ql5gEABrCI1uB5a', NULL, '2025-11-28 06:24:48', '2025-11-28 06:38:31'),
(29, 'Fernando Delgado', '22147789@tecnm.mx', '22147789', NULL, NULL, '$2y$12$rogHHdTFm2Q9Jb8wFQZ38eUHII4hgqQwaCLF26LS.dZRIE9TYgu3e', NULL, '2025-11-28 06:24:49', '2025-11-28 06:38:31'),
(30, 'Carla Hernández', '22153201@tecnm.mx', '22153201', NULL, NULL, '$2y$12$vEHnl9Sg0VfkEpMRuxrs9uIAd5HyuLj/qk0RG/BnhiblufJd58qUW', NULL, '2025-11-28 06:24:49', '2025-11-28 06:38:31'),
(31, 'Alejandro García', '22160001@tecnm.mx', '22160001', NULL, NULL, '$2y$12$JI/5y20YyeOhEO2g4BY8JujpP78EFn4HjdR4llLeXkGc4K7UmG3Ma', NULL, '2025-11-28 06:24:50', '2025-11-28 06:38:32'),
(32, 'Beatriz Ramírez', '22160002@tecnm.mx', '22160002', NULL, NULL, '$2y$12$VALfkL1dA32bbrAuekwK8.MA9E205UEtMEbQ6wTiSgdMvmD/535Q.', NULL, '2025-11-28 06:24:50', '2025-11-28 06:38:32'),
(33, 'Javier Hernández', '22160003@tecnm.mx', '22160003', NULL, NULL, '$2y$12$B1I5IAJlhpMU3ejzUABqVeroS.IkJHrXn8TQDWb3tKrw8iBbyg5Km', NULL, '2025-11-28 06:24:51', '2025-11-28 06:38:32'),
(34, 'Carolina Sánchez', '22160004@tecnm.mx', '22160004', NULL, NULL, '$2y$12$MRkRgyNsUhPKvHOB.AKQ.uvHX8hWrG2PW/xBWlkPU0rQMUHeUbnyq', NULL, '2025-11-28 06:24:51', '2025-11-28 06:38:33'),
(35, 'Luis Cruz', '22160005@tecnm.mx', '22160005', NULL, NULL, '$2y$12$ITx3zQzIP/ItBlYYrEGJTu9rvC19Notk99MjNWJkum1b.JnRfmiay', NULL, '2025-11-28 06:24:51', '2025-11-28 06:38:33'),
(36, 'Gabriela Jiménez', '22160006@tecnm.mx', '22160006', NULL, NULL, '$2y$12$RNVBjW5DEnc3k04mjFNmL.oZA6dogtSX2JVgyJmTCQDLPjbWmKa3.', NULL, '2025-11-28 06:24:52', '2025-11-28 06:38:34'),
(37, 'Héctor Ortega', '22160007@tecnm.mx', '22160007', NULL, NULL, '$2y$12$jTYYJd/HhSXUMtlXN9UxOeTmkxFZVexrRkTROD1Zjetv4yWrYIsNa', NULL, '2025-11-28 06:24:52', '2025-11-28 06:38:34'),
(38, 'Natalia Vega', '22160008@tecnm.mx', '22160008', NULL, NULL, '$2y$12$zoqYdoPjNuO1h4E1d2u9duEEx4sR6z2az14hWRK9PKeHK7cPjI8ke', NULL, '2025-11-28 06:24:53', '2025-11-28 06:38:34'),
(39, 'Oscar Morales', '22160009@tecnm.mx', '22160009', NULL, NULL, '$2y$12$.HyD.5WU5cq1gjs5V6tO5uW7/SVYT5AZfjAt2FCqfnpZewADamyES', NULL, '2025-11-28 06:24:53', '2025-11-28 06:38:35'),
(40, 'Patricia Castillo', '22160010@tecnm.mx', '22160010', NULL, NULL, '$2y$12$Q43Rp1ag9eYnZaMST2Zj.O0YbOtAtUBGznwqjEQaROReM.uZToQAi', NULL, '2025-11-28 06:24:53', '2025-11-28 06:38:35'),
(41, 'Ricardo López', '22160011@tecnm.mx', '22160011', NULL, NULL, '$2y$12$MKdO2MosD5AD44ASUulX.u0IVrwqP5KxfqERz0plW4BGRBL7DMXZW', NULL, '2025-11-28 06:24:54', '2025-11-28 06:38:35'),
(42, 'Sofía Fernández', '22160012@tecnm.mx', '22160012', NULL, NULL, '$2y$12$b5JUHpOF9978.xp0lTg1jucfygzjPIZHTz/Wm8dYde48pnXr8cQYm', NULL, '2025-11-28 06:24:54', '2025-11-28 06:38:36'),
(43, 'Tomás Mendoza', '22160013@tecnm.mx', '22160013', NULL, NULL, '$2y$12$x9KnpMl8VjkxgCwHWgJ9YexTeBzpOts6Hy3Mc3sTOjqC7P3VhUQx2', NULL, '2025-11-28 06:24:55', '2025-11-28 06:38:36'),
(44, 'Daniela Martínez', '22160014@tecnm.mx', '22160014', NULL, NULL, '$2y$12$gyrs.0C8..Il8iQ7HywPzO5YgMSSpVZvEy3oWZjjQNSdq9ly9ti2y', NULL, '2025-11-28 06:24:55', '2025-11-28 06:38:37'),
(45, 'Ignacio Hernández', '22160015@tecnm.mx', '22160015', NULL, NULL, '$2y$12$t7e5YeUktvavxj2HzUr9yOeizwttiYs/M3cfh8z/vOeEdMJjiyyH2', NULL, '2025-11-28 06:24:56', '2025-11-28 06:38:37'),
(46, 'Laura Pérez', '22160016@tecnm.mx', '22160016', NULL, NULL, '$2y$12$6im.K6Jj9ZTNZpGhi7Kj2u9sS9ZOZqCp2SVcRUm6ttm17d8sOWowe', NULL, '2025-11-28 06:24:56', '2025-11-28 06:38:38'),
(47, 'Diego Gómez', '22160017@tecnm.mx', '22160017', NULL, NULL, '$2y$12$nJ7BLjkIgChb10y55Zgg7OOthJ/czjwlo2HOeCEiBm5kSEh7fHGiW', NULL, '2025-11-28 06:24:57', '2025-11-28 06:38:38'),
(48, 'Mariana Vargas', '22160018@tecnm.mx', '22160018', NULL, NULL, '$2y$12$I8K3YXioyg.M64F2Xo6wFuDte/tiwj0u80W6uzZgtUWwIzpebGgUm', NULL, '2025-11-28 06:24:57', '2025-11-28 06:38:39'),
(49, 'Andrés Flores', '22160019@tecnm.mx', '22160019', NULL, NULL, '$2y$12$zaDd5zAD11Cbo32ct62souIQFiNAGwy8dAAhBVPcrmxJ0U7q0iJWK', NULL, '2025-11-28 06:24:57', '2025-11-28 06:38:39'),
(50, 'Elena Ramírez', '22160020@tecnm.mx', '22160020', NULL, NULL, '$2y$12$D7gR7xJn80CjXvZVBK2TeenKW590OfUlAxbcL8yeodVzGKH7GNIni', NULL, '2025-11-28 06:24:58', '2025-11-28 06:38:39'),
(51, 'Mateo Sánchez', '22160021@tecnm.mx', '22160021', NULL, NULL, '$2y$12$6eMaQkfXbPDt3BmKtBv4HOG3fCSGy.E86xMyl1IS732NJA0/9dQKS', NULL, '2025-11-28 06:24:58', '2025-11-28 06:38:40'),
(52, 'Camila Cruz', '22160022@tecnm.mx', '22160022', NULL, NULL, '$2y$12$cGWKCvcIU6a8xSg93188Suidf7h.0wJSUkFanM0pi9TxI.c6YW./W', NULL, '2025-11-28 06:24:59', '2025-11-28 06:38:40'),
(53, 'Pablo Domínguez', '22160023@tecnm.mx', '22160023', NULL, NULL, '$2y$12$/et1.3qvLaQZPKrECAt2q.qdV7aoCxUmSng6/FUX.MjlP1S1UcSN.', NULL, '2025-11-28 06:24:59', '2025-11-28 06:38:41'),
(54, 'Valeria López', '22160024@tecnm.mx', '22160024', NULL, NULL, '$2y$12$AkB034CYUPr.BPxXvXexlO4xlEcyaihHS4U9Kq6cj/LWXxjv3YP5K', NULL, '2025-11-28 06:24:59', '2025-11-28 06:38:41'),
(55, 'Roberto Hernández', '22160025@tecnm.mx', '22160025', NULL, NULL, '$2y$12$3O/4YaPf9svZ2MZHjXefYO5QOdtJhq9oRE7J1tSGQ/hWlEY1BttjK', NULL, '2025-11-28 06:25:00', '2025-11-28 06:38:42'),
(56, 'Daniel Mendoza', '22160026@tecnm.mx', '22160026', NULL, NULL, '$2y$12$t3UUnjnnpDQ2ncDhs44RJ.wMhkcPy3KwkVPr7YL6hR3C4Pn59u2eu', NULL, '2025-11-28 06:25:00', '2025-11-28 06:38:42'),
(57, 'Lucía Gómez', '22160027@tecnm.mx', '22160027', NULL, NULL, '$2y$12$eZrW2zrpBVnsmtqRvt3p5.aDbQytDTkoHA1Jtx48ovFdyzsC9T8Ze', NULL, '2025-11-28 06:25:01', '2025-11-28 06:38:43'),
(58, 'Felipe Rojas', '22160028@tecnm.mx', '22160028', NULL, NULL, '$2y$12$J2RNTNepmT2S9d9knvhc8ecDkqksAfqNsDrkA1VNP/Joy1JLtufUe', NULL, '2025-11-28 06:25:01', '2025-11-28 06:38:43'),
(59, 'Carla Santos', '22160029@tecnm.mx', '22160029', NULL, NULL, '$2y$12$J7x3sd0/kxej3Ltgybm/ZO2LzVDlSR0joLRY60KWQrjT0uR23XPL.', NULL, '2025-11-28 06:25:01', '2025-11-28 06:38:44'),
(60, 'Hugo Luna', '22160030@tecnm.mx', '22160030', NULL, NULL, '$2y$12$YeOCndjpJQvIKUfs/gxf0.RKWKYIL48YJZC5NPlEGuqTTDlswFyA6', NULL, '2025-11-28 06:25:02', '2025-11-28 06:38:44'),
(61, 'Isabel Ramírez', '22160031@tecnm.mx', '22160031', NULL, NULL, '$2y$12$2xjoA7HAuGjnhFjHHpjQf.v0xbW0pCST2DpPsru1Xnm63Vs8v7NZK', NULL, '2025-11-28 06:25:02', '2025-11-28 06:38:44'),
(62, 'Fernando Pérez', '22160032@tecnm.mx', '22160032', NULL, NULL, '$2y$12$1ZoKKXEzo1a7G5893IF10eMmBKV1EbtXG81vKPahupyncdUrxF65u', NULL, '2025-11-28 06:25:02', '2025-11-28 06:38:45'),
(63, 'Mónica Ortega', '22160033@tecnm.mx', '22160033', NULL, NULL, '$2y$12$mWXc8m5m7OUYe96qB0vGxeqddFBLHOx55ednYyE6YQxzpJ3HjsUVK', NULL, '2025-11-28 06:25:03', '2025-11-28 06:38:45'),
(64, 'Raúl Sánchez', '22160034@tecnm.mx', '22160034', NULL, NULL, '$2y$12$9c10YwyHrhTrDzqOadHL3uAMtAmVu/hdHEpMtRocUsNgluDMxp6PO', NULL, '2025-11-28 06:25:03', '2025-11-28 06:38:46'),
(65, 'Ángela Gómez', '22160035@tecnm.mx', '22160035', NULL, NULL, '$2y$12$oHS3YX09Lagz8KNKCMR5/u1in3nzS4T4eSwcFXc.Ul.CL47ZBEMRW', NULL, '2025-11-28 06:25:04', '2025-11-28 06:38:46'),
(66, 'Jorge Domínguez', '22160036@tecnm.mx', '22160036', NULL, NULL, '$2y$12$2rmB/OiJ5FiyhVJWdvayEOhal8r3Hv7uquHZsXcGKldbpO2tHl34K', NULL, '2025-11-28 06:25:04', '2025-11-28 06:38:46'),
(67, 'Diana Flores', '22160037@tecnm.mx', '22160037', NULL, NULL, '$2y$12$Rtw2IrlnF./URL2V2HN5COb.yi6Q9NbBhAXYzqf5jQyGJTMHxVeZq', NULL, '2025-11-28 06:25:04', '2025-11-28 06:38:47'),
(68, 'Santiago Torres', '22160038@tecnm.mx', '22160038', NULL, NULL, '$2y$12$FBmqkvbyPWh/7vLkn5maDeIH9SlMKaSOSGkkr57QuNq0DK8lNZM/i', NULL, '2025-11-28 06:25:05', '2025-11-28 06:38:47'),
(69, 'Ana Martínez', '22160039@tecnm.mx', '22160039', NULL, NULL, '$2y$12$X8S4ZHC90gxQRFq0019gY.DwgqJKAzVHxRT/UKzQO4dMP9f3jP2jW', NULL, '2025-11-28 06:25:05', '2025-11-28 06:38:48'),
(70, 'Cristian Pérez', '22160040@tecnm.mx', '22160040', NULL, NULL, '$2y$12$wiXnzO5NS4TKxh6x0WCN2.dzjx3DIrLpCJzMkU0vee6OlCTcixKJm', NULL, '2025-11-28 06:25:06', '2025-11-28 06:38:48'),
(71, 'Marisol López', '22160041@tecnm.mx', '22160041', NULL, NULL, '$2y$12$nWFO.K99xbfD1F1ZKJ.gRuTRuHCrybtYvIvh489Mfapqo/VJhA97W', NULL, '2025-11-28 06:25:06', '2025-11-28 06:38:48'),
(72, 'Álvaro Ramírez', '22160042@tecnm.mx', '22160042', NULL, NULL, '$2y$12$RYFENsV9eNySZo5QtzNEBeEceD1YI6lItF3bNB9zJD0CZ/ZVrw7bm', NULL, '2025-11-28 06:25:07', '2025-11-28 06:38:49'),
(73, 'Estefanía Sánchez', '22160043@tecnm.mx', '22160043', NULL, NULL, '$2y$12$QuQopGeLmlr6EosXWo9Muuc9hrjmJ3YrulgT.j18m.rfSO7Xqh2U.', NULL, '2025-11-28 06:25:07', '2025-11-28 06:38:49'),
(74, 'Rodrigo Cruz', '22160044@tecnm.mx', '22160044', NULL, NULL, '$2y$12$zQqH2nuabWY5oyP9qLfoE.FJJxg.0bn2pnW8RdNfmc03koSmTSKdC', NULL, '2025-11-28 06:25:07', '2025-11-28 06:38:50'),
(75, 'Teresa Ortega', '22160045@tecnm.mx', '22160045', NULL, NULL, '$2y$12$784/hJItDc0WTyBOuAwNiOyCBkszJoF9M/BVySwX19FtJu1aHGQi6', NULL, '2025-11-28 06:25:08', '2025-11-28 06:38:50'),
(76, 'Ángel Gómez', '22160046@tecnm.mx', '22160046', NULL, NULL, '$2y$12$6mZ9eeG6df3/D3tapioMyOE96bR/On5ro32A7lnaY2.FcN66FnVqy', NULL, '2025-11-28 06:25:08', '2025-11-28 06:38:50'),
(77, 'Verónica Hernández', '22160047@tecnm.mx', '22160047', NULL, NULL, '$2y$12$rUevJtpH8RNsl7ZCMBiwbuak7ZIVJNzohLcHCodih2R2Pa5pnXud.', NULL, '2025-11-28 06:25:09', '2025-11-28 06:38:51'),
(78, 'Adrián Morales', '22160048@tecnm.mx', '22160048', NULL, NULL, '$2y$12$50nmzI6b3amSmns1k9gHfuGQoKRZvTZJ.88X8OHlJtfaYn38UkFq.', NULL, '2025-11-28 06:25:09', '2025-11-28 06:38:51'),
(79, 'Lorena Rivas', '22160049@tecnm.mx', '22160049', NULL, NULL, '$2y$12$ff3WUCS0obLbFt7Jk9gsNOhn1hlBJ7r71v9SSjUAF0fDa5k.FFikK', NULL, '2025-11-28 06:25:10', '2025-11-28 06:38:52'),
(80, 'Emilio Martínez', '22160050@tecnm.mx', '22160050', NULL, NULL, '$2y$12$KeGR258rTdJfvlmTf2ZHW.eJY5FMPol.AKYiH37VpZEq769ezkNzK', NULL, '2025-11-28 06:25:10', '2025-11-28 06:38:52'),
(81, 'Carlos Chat', '2221212@tecnm.mx', '2221212', NULL, NULL, '$2y$12$EXG.8X5hdGWptDfCSXQXcehDl8BRM3K0PDapL3DFZa0S0bJF7KKn2', NULL, '2025-11-28 06:25:10', '2025-11-28 06:38:52'),
(82, 'Juan Perez', '9999999@tecnm.mx', '9999999', NULL, NULL, '$2y$12$fopoN4Un5H55UfSOMyXfg.knWQ5nJmAsZj4RbGoUIGG7yMtBLnHh6', NULL, '2025-11-28 06:25:11', '2025-11-28 06:38:53'),
(83, 'Alumno Prueba', 'prueba@alumno.com', '1111', NULL, NULL, '$2y$12$nfky0sgp5jbJURe4JZmbPuQqAQuf.r.CvWpKuV5Y6abcvJcUjIcJm', NULL, '2025-11-28 06:32:50', '2025-11-28 06:32:50'),
(84, 'Melisa Sanchez', '012345678@tecnm.mx', '012345678', NULL, NULL, '$2y$12$9xMO1jhZd74OZrdkRqPY7OQ.osf7KpNA1tPCA583zjJuWDu8DyPCu', NULL, '2025-11-28 11:12:29', '2025-11-28 11:12:29');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`n_control`),
  ADD KEY `FKid_carrera` (`FKid_carrera`);

--
-- Indices de la tabla `alumno_grupo`
--
ALTER TABLE `alumno_grupo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `alumno_grupo_unique` (`n_control`,`id_grupo`),
  ADD KEY `alumno_grupo_n_control_foreign` (`n_control`),
  ADD KEY `alumno_grupo_id_grupo_foreign` (`id_grupo`),
  ADD KEY `idx_alumno_grupo_oportunidad` (`oportunidad`);

--
-- Indices de la tabla `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`cod_area`),
  ADD UNIQUE KEY `jefe_area` (`jefe_area`);

--
-- Indices de la tabla `aulas`
--
ALTER TABLE `aulas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `boletas`
--
ALTER TABLE `boletas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `boletas_n_control_foreign` (`n_control`);

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
-- Indices de la tabla `calificaciones_grupo`
--
ALTER TABLE `calificaciones_grupo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `calificaciones_grupo_fk_index` (`alumno_grupo_id`);

--
-- Indices de la tabla `carreras`
--
ALTER TABLE `carreras`
  ADD PRIMARY KEY (`id_carrera`),
  ADD UNIQUE KEY `nombre_carrera` (`nombre_carrera`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD PRIMARY KEY (`id_grupo`);

--
-- Indices de la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD PRIMARY KEY (`id`);

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
-- Indices de la tabla `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`cod_materia`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indices de la tabla `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `periodos`
--
ALTER TABLE `periodos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indices de la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

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
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_n_control_link_index` (`n_control_link`),
  ADD KEY `users_n_trabajador_link_index` (`n_trabajador_link`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alumno_grupo`
--
ALTER TABLE `alumno_grupo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT de la tabla `areas`
--
ALTER TABLE `areas`
  MODIFY `cod_area` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `boletas`
--
ALTER TABLE `boletas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `calificaciones_grupo`
--
ALTER TABLE `calificaciones_grupo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `carreras`
--
ALTER TABLE `carreras`
  MODIFY `id_carrera` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `grupos`
--
ALTER TABLE `grupos`
  MODIFY `id_grupo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1252;

--
-- AUTO_INCREMENT de la tabla `horarios`
--
ALTER TABLE `horarios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `periodos`
--
ALTER TABLE `periodos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `boletas`
--
ALTER TABLE `boletas`
  ADD CONSTRAINT `boletas_n_control_foreign` FOREIGN KEY (`n_control`) REFERENCES `alumnos` (`n_control`) ON DELETE CASCADE;

--
-- Filtros para la tabla `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
