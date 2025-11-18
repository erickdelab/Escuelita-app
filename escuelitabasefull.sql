-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-11-2025 a las 22:05:11
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

INSERT INTO `alumnos` (`n_control`, `id_carrera`, `nombre`, `s_nombre`, `ap_pat`, `ap_mat`, `fech_nac`, `genero`, `FKid_carrera`, `situacion`, `semestre`, `promedio_general`, `created_at`, `updated_at`) VALUES
('123', NULL, 'juan', 'Pablo', 'Escobar', 'Sultan', '2002-07-08', 'M', 8, 'Vigente', 2, 97.96, '2025-10-24 00:53:58', '2025-10-31 02:10:03'),
('19222128', NULL, 'Andrés', 'Manuel', 'Pérez', 'Fernández', '2000-12-01', 'M', 1, 'Vigente', 3, 89.00, NULL, '2025-10-31 02:54:10'),
('19222164', NULL, 'Juan', 'Diego', 'Soria', 'Lopez', '2001-12-21', 'M', 8, 'Vigente', 3, 78.90, '2025-10-15 05:36:09', '2025-10-29 04:30:59'),
('19222168', NULL, 'José', 'Antonio', 'Hernández', 'Vargas', '1999-07-20', 'M', 1, 'Vigente', 1, 50.00, NULL, '2025-10-29 04:05:49'),
('19233245', NULL, 'Ricardo', 'Eduardo', 'Castillo', 'Mendoza', '2000-02-03', 'M', 1, 'Egresado', 11, 89.00, NULL, '2025-11-05 10:03:40'),
('20212178', NULL, 'Elena', 'Isabel', 'Ramírez', 'Díaz', '2001-08-18', 'F', 2, 'Baja', 10, NULL, NULL, '2025-10-15 04:53:48'),
('20222165', NULL, 'Pedro', 'Luis', 'García', 'Sánchez', '2000-01-10', 'M', 1, 'Vigente', 10, 80.00, NULL, '2025-10-29 00:58:20'),
('20222166', NULL, 'Juan', 'Carlos', 'Perez', 'Lopez', '2000-09-12', 'M', 2, 'Vigente', 4, NULL, '2025-10-15 04:55:30', '2025-10-15 10:37:14'),
('20222286', NULL, 'Lucía', 'Fernanda', 'Rodríguez', 'Torres', '2001-03-15', 'F', 7, 'Vigente', 2, NULL, NULL, NULL),
('20232012', NULL, 'Laura', 'María', 'Gómez', 'Ramírez', '2002-04-05', 'F', 1, 'Vigente', 10, 89.00, NULL, '2025-10-29 00:58:39'),
('20242234', NULL, 'Miguel', 'Ángel', 'Torres', 'Ramírez', '2002-06-12', 'M', 1, 'Vigente', 8, 70.00, NULL, '2025-10-29 00:59:03'),
('20243321', NULL, 'Valeria', '', 'Jiménez', 'Ortega', '2001-11-09', 'F', 7, 'Vigente', 2, NULL, NULL, NULL),
('20246678', NULL, 'Andrea', 'Carolina', 'Vargas', 'Jiménez', '2002-03-21', 'F', 3, 'Vigente', 10, NULL, NULL, NULL),
('20248890', NULL, 'Mariana', '', 'Romero', 'García', '2001-07-30', 'F', 8, 'Vigente', 9, NULL, NULL, NULL),
('20250012', NULL, 'Patricia', 'Elena', 'Herrera', 'Torres', '2002-09-19', 'F', 1, 'Vigente', 8, 87.00, NULL, '2025-10-29 01:07:04'),
('20254412', NULL, 'Daniela', 'Fernanda', 'Soto', 'Pérez', '2002-08-27', 'F', 2, 'Vigente', 8, NULL, NULL, NULL),
('21122177', NULL, 'Sofía', '', 'Ortiz', 'Mendoza', '2003-02-14', 'F', 4, 'Vigente', 2, NULL, NULL, NULL),
('21222198', NULL, 'Marta', 'Patricia', 'López', 'Morales', '2000-11-30', 'F', 9, 'Vigente', 8, NULL, NULL, NULL),
('21245567', NULL, 'Juan', '', 'Rivas', 'Torres', '2001-05-15', 'M', 9, 'Vigente', 9, NULL, NULL, NULL),
('21249901', NULL, 'Sergio', 'Andrés', 'Molina', 'Sánchez', '2003-01-05', 'M', 10, 'Vigente', 6, NULL, NULL, NULL),
('22143199', NULL, 'Diego', '', 'Martínez', 'Gómez', '2002-05-25', 'M', 5, 'Baja', 6, NULL, NULL, NULL),
('22147789', NULL, 'Fernando', 'Luis', 'Delgado', 'López', '2000-12-11', 'M', 6, 'Baja', 7, NULL, NULL, NULL),
('22153201', NULL, 'Carla', 'Emilia', 'Hernández', 'Lopez', '2001-09-22', 'M', 10, 'Vigente', 6, NULL, NULL, '2025-10-02 09:55:15'),
('22160001', NULL, 'Alejandro', 'David', 'García', 'López', '2001-03-14', 'M', 1, 'Vigente', 3, 78.32, NULL, '2025-10-29 04:04:56'),
('22160002', NULL, 'Beatriz', 'Elena', 'Ramírez', 'Torres', '2002-07-21', 'F', 2, 'Vigente', 3, NULL, NULL, NULL),
('22160003', NULL, 'Javier', 'Andrés', 'Hernández', 'Gómez', '2000-11-19', 'M', 3, 'Egresado', 11, NULL, NULL, NULL),
('22160004', NULL, 'Carolina', 'María', 'Sánchez', 'Martínez', '2003-01-25', 'F', 4, 'Vigente', 2, NULL, NULL, NULL),
('22160005', NULL, 'Luis', 'Fernando', 'Cruz', 'Domínguez', '2001-04-12', 'M', 5, 'Baja', 4, NULL, NULL, NULL),
('22160006', NULL, 'Gabriela', 'Isabel', 'Jiménez', 'Pérez', '2002-02-08', 'F', 6, 'Vigente', 7, NULL, NULL, NULL),
('22160007', NULL, 'Héctor', 'Manuel', 'Ortega', 'Santos', '2000-10-30', 'M', 7, 'Vigente', 10, NULL, NULL, NULL),
('22160008', NULL, 'Natalia', 'Fernanda', 'Vega', 'Ramírez', '2003-03-09', 'F', 8, 'Vigente', 1, 89.00, NULL, '2025-11-05 10:04:20'),
('22160009', NULL, 'Oscar', 'Antonio', 'Morales', 'Hernández', '1999-06-22', 'M', 9, 'Egresado', 11, NULL, NULL, NULL),
('22160010', NULL, 'Patricia', 'Lucía', 'Castillo', 'Flores', '2001-05-13', 'F', 10, 'Vigente', 8, NULL, NULL, NULL),
('22160011', NULL, 'Ricardo', 'Emilio', 'López', 'García', '2002-09-28', 'M', 1, 'Vigente', 6, NULL, NULL, NULL),
('22160012', NULL, 'Sofía', 'Valeria', 'Fernández', 'Rojas', '2000-12-06', 'F', 2, 'Baja', 7, NULL, NULL, NULL),
('22160013', NULL, 'Tomás', 'Adrián', 'Mendoza', 'Torres', '2001-08-19', 'M', 3, 'Vigente', 9, NULL, NULL, NULL),
('22160014', NULL, 'Daniela', 'Paola', 'Martínez', 'Cruz', '2002-04-02', 'F', 4, 'Vigente', 5, NULL, NULL, NULL),
('22160015', NULL, 'Ignacio', 'Carlos', 'Hernández', 'Ramírez', '2001-11-27', 'M', 5, 'Vigente', 3, NULL, NULL, NULL),
('22160016', NULL, 'Laura', 'Patricia', 'Pérez', 'Domínguez', '2000-01-15', 'F', 6, 'Egresado', 11, NULL, NULL, NULL),
('22160017', NULL, 'Diego', 'Alejandro', 'Gómez', 'Santos', '2002-07-08', 'M', 7, 'Vigente', 4, NULL, NULL, NULL),
('22160018', NULL, 'Mariana', 'Carolina', 'Vargas', 'Luna', '2003-10-03', 'F', 8, 'Vigente', 2, NULL, NULL, NULL),
('22160019', NULL, 'Andrés', 'Roberto', 'Flores', 'Mendoza', '2001-06-29', 'M', 9, 'Baja', 6, NULL, NULL, NULL),
('22160020', NULL, 'Elena', 'Beatriz', 'Ramírez', 'Ortega', '2002-03-11', 'F', 10, 'Vigente', 7, NULL, NULL, NULL),
('22160021', NULL, 'Mateo', 'Julián', 'Sánchez', 'Ríos', '2001-09-23', 'M', 1, 'Vigente', 10, NULL, NULL, NULL),
('22160022', NULL, 'Camila', 'Fernanda', 'Cruz', 'Pérez', '2000-05-04', 'F', 2, 'Egresado', 11, NULL, NULL, NULL),
('22160023', NULL, 'Pablo', 'Enrique', 'Domínguez', 'Gómez', '2002-02-19', 'M', 3, 'Vigente', 8, NULL, NULL, NULL),
('22160024', NULL, 'Valeria', 'Marisol', 'López', 'Martínez', '2003-12-20', 'F', 4, 'Vigente', 2, 89.00, NULL, '2025-10-31 01:24:02'),
('22160025', NULL, 'Roberto', 'Emilio', 'Hernández', 'Vega', '2000-08-15', 'M', 5, 'Baja', 6, NULL, NULL, NULL),
('22160026', NULL, 'Daniel', 'Adrián', 'Mendoza', 'Torres', '2001-07-27', 'M', 6, 'Vigente', 9, NULL, NULL, NULL),
('22160027', NULL, 'Lucía', 'Elena', 'Gómez', 'Sánchez', '2002-06-05', 'F', 7, 'Vigente', 3, NULL, NULL, NULL),
('22160028', NULL, 'Felipe', 'Eduardo', 'Rojas', 'López', '1999-12-14', 'M', 8, 'Egresado', 11, NULL, NULL, NULL),
('22160029', NULL, 'Carla', 'Isabel', 'Santos', 'Flores', '2003-09-17', 'F', 9, 'Vigente', 1, NULL, NULL, NULL),
('22160030', NULL, 'Hugo', 'Manuel', 'Luna', 'Morales', '2000-11-03', 'M', 10, 'Vigente', 7, NULL, NULL, NULL),
('22160031', NULL, 'Isabel', 'Andrea', 'Ramírez', 'Vega', '2001-03-29', 'F', 1, 'Vigente', 6, 80.00, NULL, '2025-10-29 04:26:58'),
('22160032', NULL, 'Fernando', 'José', 'Pérez', 'Torres', '2002-01-18', 'M', 2, 'Baja', 5, NULL, NULL, NULL),
('22160033', NULL, 'Mónica', 'Elena', 'Ortega', 'Cruz', '2001-09-14', 'F', 3, 'Vigente', 9, NULL, NULL, NULL),
('22160034', NULL, 'Raúl', 'David', 'Sánchez', 'Martínez', '2003-02-06', 'M', 4, 'Vigente', 2, NULL, NULL, NULL),
('22160035', NULL, 'Ángela', 'María', 'Gómez', 'Fernández', '2002-07-02', 'F', 5, 'Vigente', 4, NULL, NULL, NULL),
('22160036', NULL, 'Jorge', 'Ignacio', 'Domínguez', 'Rivas', '2000-04-10', 'M', 6, 'Egresado', 11, NULL, NULL, NULL),
('22160037', NULL, 'Diana', 'Patricia', 'Flores', 'Ramírez', '2001-10-28', 'F', 7, 'Vigente', 8, NULL, NULL, NULL),
('22160038', NULL, 'Santiago', 'Alejandro', 'Torres', 'Hernández', '2002-08-16', 'M', 8, 'Vigente', 7, NULL, NULL, NULL),
('22160039', NULL, 'Ana', 'Lucía', 'Martínez', 'Ortega', '2000-05-07', 'F', 9, 'Vigente', 5, NULL, NULL, '2025-10-15 12:36:18'),
('22160040', NULL, 'Cristian', 'Antonio', 'Pérez', 'Gómez', '2003-03-25', 'M', 10, 'Vigente', 3, NULL, NULL, NULL),
('22160041', NULL, 'Marisol', 'Valeria', 'López', 'Santos', '2002-09-12', 'F', 1, 'Vigente', 6, NULL, NULL, NULL),
('22160042', NULL, 'Álvaro', 'Roberto', 'Ramírez', 'Domínguez', '2001-06-01', 'M', 2, 'Vigente', 10, NULL, NULL, NULL),
('22160043', NULL, 'Estefanía', 'Andrea', 'Sánchez', 'Flores', '2000-07-08', 'F', 3, 'Vigente', 8, NULL, NULL, NULL),
('22160044', NULL, 'Rodrigo', 'Manuel', 'Cruz', 'Mendoza', '2001-05-16', 'M', 4, 'Baja', 7, NULL, NULL, NULL),
('22160045', NULL, 'Teresa', 'Isabel', 'Ortega', 'Luna', '2003-10-21', 'F', 5, 'Vigente', 2, NULL, NULL, NULL),
('22160046', NULL, 'Ángel', 'David', 'Gómez', 'Ramírez', '2002-12-19', 'M', 6, 'Vigente', 9, NULL, NULL, NULL),
('22160047', NULL, 'Verónica', 'Carolina', 'Hernández', 'Santos', '2000-02-24', 'F', 7, 'Egresado', 11, NULL, NULL, NULL),
('22160048', NULL, 'Adrián', 'Tomás', 'Morales', 'García', '2001-11-30', 'M', 8, 'Vigente', 7, NULL, NULL, NULL),
('22160049', NULL, 'Lorena', 'Fernanda', 'Rivas', 'López', '2002-04-18', 'F', 9, 'Vigente', 4, NULL, NULL, NULL),
('22160050', NULL, 'Emilio', 'Javier', 'Martínez', 'Ortega', '2003-08-13', 'M', 10, 'Vigente', 3, NULL, NULL, NULL),
('2221212', NULL, 'Carlos', 'Tobon', 'Chat', 'Gpt', '1990-08-12', 'M', 1, 'Vigente', 1, 100.00, '2025-10-29 00:26:46', '2025-11-05 10:03:56'),
('9999999', NULL, 'Juan', NULL, 'Perez', 'Lopez', '2000-02-02', 'Masculino', 10, 'Vigente', 2, NULL, NULL, NULL);

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
(21, '123', 1, 'Primera', '2025-10-29 02:03:31', '2025-10-29 02:03:31'),
(23, '123', 4, 'Especial', '2025-10-31 02:24:44', '2025-10-31 02:24:44'),
(25, '123', 2, 'Primera', '2025-11-05 10:53:08', '2025-11-05 10:53:08'),
(26, '123', 1238, 'Primera', '2025-11-07 00:52:00', '2025-11-07 00:52:00'),
(27, '123', 5, 'Primera', '2025-11-07 04:15:10', '2025-11-07 04:15:10'),
(29, '22160007', 1237, 'Primera', '2025-11-12 02:35:10', '2025-11-12 02:35:10');

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
(5, 'Administración', 'CAMOTO1', NULL, '2025-11-19 02:50:40');

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
(1, '19222128', 'TICS101', 'AGODIC25', 34.00, 'Repite', 'CAMOTO1', 1, '2025-11-19 03:01:59', '2025-11-19 03:01:59');

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
('erick@erick|127.0.0.1', 'i:1;', 1763487787),
('erick@erick|127.0.0.1:timer', 'i:1763487786;', 1763487787);

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
(1, 22, 34.00, 42.00, 25.00, 35.00, 34.00, '2025-11-19 03:01:53', '2025-11-19 03:01:53');

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
(1, 'TICS101', 'CAMOTO1', 3, 12, 'M-J', '09:00:00', NULL, '2025-11-18 23:48:59'),
(2, 'TICS102', 'CAMOTO1', 3, 12, NULL, NULL, NULL, '2025-11-12 13:29:58'),
(3, 'AE101', 'PROF003', 2, 11, NULL, NULL, NULL, '2025-11-12 13:19:03'),
(4, 'TICS104', 'PROF004', 2, 11, NULL, NULL, NULL, '2025-11-12 12:34:51'),
(5, 'TICS101', 'PROF005', 3, 12, NULL, NULL, NULL, NULL),
(6, 'TICS102', 'PROF006', 3, 12, NULL, NULL, NULL, NULL),
(7, 'TICS103', 'PROF007', 4, 12, NULL, NULL, NULL, NULL),
(8, 'TICS104', 'PROF008', 10, 12, NULL, NULL, NULL, '2025-10-31 03:03:09'),
(9, 'TICS101', 'PROF009', 5, 11, NULL, NULL, NULL, NULL),
(10, 'AE101', 'PROF009', 10, 12, NULL, NULL, '2025-10-24 23:44:23', '2025-10-31 03:02:22'),
(1237, 'TICS102', 'PROF010', 10, 11, NULL, NULL, '2025-11-05 04:35:05', '2025-11-05 04:35:05'),
(1238, 'AE101', 'PROF003', 1, 12, NULL, NULL, '2025-11-07 00:51:07', '2025-11-07 00:51:07'),
(1245, 'AE101', 'CAMOTO1', 10, 11, NULL, NULL, '2025-11-12 07:00:25', '2025-11-12 12:08:16'),
(1246, 'ETRO104', 'PROF002', 8, 12, NULL, NULL, '2025-11-12 11:50:55', '2025-11-18 23:48:40');

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
(52, 1, 'AE101', 'CAMOTO1', 3, 2, '09:00:00', '11:00:00', '2025-11-15 02:32:27', '2025-11-15 02:32:27'),
(53, 1, 'AE101', 'CAMOTO1', 3, 4, '09:00:00', '11:00:00', '2025-11-15 02:32:27', '2025-11-15 02:32:27'),
(54, 1, 'AE101', 'CAMOTO1', 3, 5, '10:00:00', '11:00:00', '2025-11-15 02:32:27', '2025-11-15 02:32:27');

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
  `nombre` varchar(30) DEFAULT NULL,
  `credito` int(11) DEFAULT NULL,
  `cadena` tinyint(1) DEFAULT NULL,
  `materia_estado` varchar(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `materias`
--

INSERT INTO `materias` (`cod_materia`, `nombre`, `credito`, `cadena`, `materia_estado`, `created_at`, `updated_at`) VALUES
('AE101', 'Marketing', 5, 2, 'Activa', NULL, '2025-11-12 02:28:19'),
('AE102', 'Recursos Humanos', 5, 1, 'Activa', NULL, '2025-11-12 02:28:25'),
('AE103', 'Gestión de Proyectos', 5, 1, 'Activa', NULL, '2025-11-12 02:28:31'),
('AE104', 'Planeación Estratégica', 5, 1, 'Activa', NULL, '2025-11-12 02:28:39'),
('ARQ101', 'Diseño Arquitectónico', 4, 1, 'Activa', NULL, NULL),
('ARQ102', 'Urbanismo', 4, 1, 'Activa', NULL, NULL),
('ARQ103', 'Materiales de Construcción', 4, 1, 'Activa', NULL, NULL),
('ARQ104', 'Historia de la Arquitectura', 4, 1, 'Activa', NULL, NULL),
('CIV101', 'Topografía', 4, 1, 'Activa', NULL, NULL),
('CIV102', 'Estructuras I', 4, 1, 'Activa', NULL, NULL),
('CIV103', 'Hidráulica', 4, 1, 'Activa', NULL, NULL),
('CIV104', 'Geotecnia', 4, 1, 'Activa', NULL, NULL),
('ELE101', 'Circuitos Eléctricos', 4, 1, 'Activa', NULL, NULL),
('ELE102', 'Electrónica I', 4, 1, 'Activa', NULL, NULL),
('ELE103', 'Máquinas Eléctricas', 4, 1, 'Activa', NULL, NULL),
('ELE104', 'Sistemas de Control', 4, 1, 'Activa', NULL, NULL),
('ETRO101', 'Electrónica Digital', 4, 1, 'Activa', NULL, NULL),
('ETRO102', 'Microcontroladores', 4, 1, 'Activa', NULL, NULL),
('ETRO103', 'Sistemas Embebidos', 4, 1, 'Activa', NULL, NULL),
('ETRO104', 'Señales y Sistemas', 4, 1, 'Activa', NULL, NULL),
('GE101', 'Administración', 4, 1, 'Activa', NULL, NULL),
('GE102', 'Economía', 4, 1, 'Activa', NULL, NULL),
('GE103', 'Contabilidad', 4, 1, 'Activa', NULL, NULL),
('GE104', 'Finanzas', 4, 1, 'Activa', NULL, NULL),
('INDU101', 'Procesos de Manufactura', 4, 1, 'Activa', NULL, NULL),
('INDU102', 'Diseño Industrial', 4, 1, 'Activa', NULL, NULL),
('INDU103', 'Control de Calidad', 4, 1, 'Activa', NULL, NULL),
('INDU104', 'Materiales Industriales', 4, 1, 'Activa', NULL, NULL),
('MEC101', 'Mecanica I', 4, 1, 'Activa', NULL, NULL),
('MEC102', 'Termodinámica', 4, 1, 'Activa', NULL, NULL),
('MEC103', 'Mecanica de Fluidos', 4, 1, 'Activa', NULL, NULL),
('MEC104', 'Resistencia de Materiales', 4, 1, 'Activa', NULL, NULL),
('PSIC001', 'Psicología I', 5, 1, 'Activa', '2025-11-07 00:48:53', '2025-11-07 00:48:53'),
('QUI101', 'Química General', 4, 1, 'Activa', NULL, NULL),
('QUI102', 'Química Orgánica', 4, 1, 'Activa', NULL, NULL),
('QUI103', 'Química Analítica', 4, 1, 'Activa', NULL, NULL),
('QUI104', 'Bioquímica', 4, 1, 'Activa', NULL, NULL),
('TICS101', 'Fundamentos de Programación', 4, 1, 'Activa', NULL, NULL),
('TICS102', 'Redes I', 5, 1, 'Activa', NULL, '2025-11-12 02:29:00'),
('TICS103', 'Base de Datos', 5, 1, 'Activa', NULL, '2025-11-12 02:29:11'),
('TICS104', 'Ciberseguridad', 4, 1, 'Activa', NULL, NULL),
('visc12', 'visc', 5, 2, 'Baja', '2025-11-12 02:27:18', '2025-11-12 02:27:47');

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
(5, '2025_11_18_202902_create_boletas_table', 2);

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
(7, 'Enero-Junio', 2023, 'ENEJUN23', 0, '2025-10-30 18:04:07', '2025-10-30 18:04:07'),
(8, 'Agosto-Diciembre', 2023, 'AGODIC23', 0, '2025-10-30 18:04:07', '2025-10-31 00:25:05'),
(9, 'Enero-Junio', 2024, 'ENEJUN24', 0, '2025-10-30 18:04:07', '2025-10-31 00:24:53'),
(10, 'Agosto-Diciembre', 2024, 'AGODIC24', 0, '2025-10-30 18:04:07', '2025-10-31 00:24:59'),
(11, 'Enero-Junio', 2025, 'ENEJUN25', 1, '2025-10-30 18:04:07', '2025-11-12 01:23:44'),
(12, 'Agosto-Diciembre', 2025, 'AGODIC25', 1, '2025-10-30 18:04:07', '2025-10-30 18:04:07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesores`
--

CREATE TABLE `profesores` (
  `n_trabajador` varchar(30) NOT NULL,
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

INSERT INTO `profesores` (`n_trabajador`, `nombre`, `s_nombre`, `ap_materno`, `ap_paterno`, `correo_institucional`, `FKcod_area`, `situacion`, `created_at`, `updated_at`) VALUES
('CAMOTO1', 'Carlos', NULL, 'Torres', 'Moran', 'Torres@carlos', 15, 'Vigente', '2025-10-17 01:57:25', '2025-11-05 10:54:45'),
('ERDELO1', 'Erick', 'Alberto', 'Lopez', 'De La Barrera', 'erick@ehhe', 12, 'Vigente', '2025-10-17 02:41:54', '2025-10-17 02:42:14'),
('JINAJU1', 'Jimmy', 'Baraquiel', 'Juarez', 'Navarrete', 'jimmy@jimmy.com', 2, 'Vigente', '2025-11-05 07:02:23', '2025-11-05 07:02:23'),
('PROF001', 'Juan', NULL, 'Gómez', 'Pérez', 'jc.perez@itp.edu', 4, 'Vigente', NULL, '2025-10-24 01:26:04'),
('PROF002', 'María', 'Elena', 'Sánchez', 'López', 'me.lopez@escuela.edu', 1, 'Vigente', NULL, NULL),
('PROF003', 'José', 'Antonio', 'Torres', 'Ramírez', 'ja.ramirez@escuela.edu', 2, 'Vigente', NULL, NULL),
('PROF004', 'Marta', 'Patricia', 'Díaz', 'García', 'mp.garcia@escuela.edu', 2, 'Vigente', NULL, NULL),
('PROF005', 'Fernando', 'Luis', 'Morales', 'Hernández', 'fl.hernandez@escuela.edu', 3, 'Vigente', NULL, NULL),
('PROF006', 'Laura', 'María', 'Jiménez', 'Vargas', 'lm.vargas@escuela.edu', 3, 'En Asignación', NULL, '2025-10-17 01:33:16'),
('PROF007', 'Ricardo', 'Eduardo', 'Pérez', 'Soto', 're.soto@escuela.edu', 1, 'Vigente', NULL, '2025-10-29 01:09:36'),
('PROF008', 'Elena', 'Isabel', 'Mendoza', 'Ortiz', 'ei.ortiz@escuela.edu', 4, 'Vigente', NULL, NULL),
('PROF009', 'Diego', '', 'Gómez', 'Martínez', 'd.martinez@escuela.edu', 5, 'Vigente', NULL, NULL),
('PROF010', 'Andrea', 'Carolina', 'García', 'Romero', 'ac.romero@escuela.edu', 2, 'Vigente', NULL, '2025-10-29 01:09:56');

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
('0UkhUs6IIWO4liE7QifBrVCQ9Wsz7kV3WuDGfHjb', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:145.0) Gecko/20100101 Firefox/145.0', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiRkRiMXk2MUI3aG1kNm9CdnZGb3l1VnRrdnRoQ2owUW1SdURHVzBoWSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQwOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvZ3J1cG9zLzEvY2FsaWZpY2FyIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjQ6ImF1dGgiO2E6MTp7czoyMToicGFzc3dvcmRfY29uZmlybWVkX2F0IjtpOjE3NjM0OTg2ODk7fX0=', 1763499720);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'eric', 'erick@erick.com', NULL, '$2y$12$MqLiNKSb4KOIPyyX3rR14.W431KKi.uFtx286WOMUh5C70SSaMW.6', NULL, '2025-10-15 11:45:59', '2025-10-15 11:45:59'),
(2, 'eric', 'eric@eric.com', NULL, '$2y$12$K2nLkcV6MSYICuauCapV7u1Fe5UalLZWC7WLgkvC3v92nSUDEIaa.', NULL, '2025-10-16 22:51:39', '2025-10-16 22:51:39'),
(3, 'carlos', 'carlos@gmail.com', NULL, '$2y$12$r/7muLckfOikwQKsdfwUVeNkMAijJz.fHp1GNeq2DBjatHyMKibj6', NULL, '2025-10-24 00:24:04', '2025-10-24 00:24:04');

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
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `boletas`
--
ALTER TABLE `boletas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `calificaciones_grupo`
--
ALTER TABLE `calificaciones_grupo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `boletas`
--
ALTER TABLE `boletas`
  ADD CONSTRAINT `boletas_n_control_foreign` FOREIGN KEY (`n_control`) REFERENCES `alumnos` (`n_control`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
