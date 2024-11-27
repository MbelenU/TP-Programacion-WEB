-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-11-2024 a las 06:44:37
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
-- Base de datos: `mydb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno`
--

CREATE TABLE `alumno` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `apellido` varchar(45) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `dni` varchar(45) NOT NULL,
  `ruta_cv` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `alumno`
--

INSERT INTO `alumno` (`id`, `id_usuario`, `nombre`, `apellido`, `descripcion`, `dni`, `ruta_cv`) VALUES
(1, 2, 'pepe', 'Torres', 'Estudiante de desarrollo de software', '40543786', NULL),
(2, 4, 'Gonzalo', ' Fuentes', 'UX/UI Designer', '39542678', NULL),
(3, 6, 'Juan', 'Sein', 'Logistica', '41396078', NULL),
(4, 8, 'Maria', 'Ursino', 'Community Manager', '42132432', NULL),
(5, 9, 'Clara', 'Vallejos', 'Estudiante de recursos humanos', '41234556', NULL),
(6, 7, 'Maia', 'Lopez', 'Consultora ERP', '38254638', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carreras`
--

CREATE TABLE `carreras` (
  `id` int(11) NOT NULL,
  `nombre_carrera` varchar(45) NOT NULL,
  `nombre_univ` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `carreras`
--

INSERT INTO `carreras` (`id`, `nombre_carrera`, `nombre_univ`) VALUES
(1, 'Desarrollo de Software', 'Universidad Nacional'),
(2, 'Logistica', 'Universidad Nacional'),
(3, 'Despachante de Aduana', 'Universidad Nacional');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carreras_alumnos`
--

CREATE TABLE `carreras_alumnos` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_carrera` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `carreras_alumnos`
--

INSERT INTO `carreras_alumnos` (`id`, `id_usuario`, `id_carrera`) VALUES
(1, 2, 1),
(2, 6, 2),
(3, 4, 1),
(4, 9, 3),
(5, 8, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresas`
--

CREATE TABLE `empresas` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `razon_social` varchar(45) NOT NULL,
  `cuit` varchar(45) NOT NULL,
  `mail_corporativo` varchar(255) DEFAULT NULL,
  `telefono_corporativo` varchar(255) DEFAULT NULL,
  `sitio_web` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `empresas`
--

INSERT INTO `empresas` (`id`, `id_usuario`, `razon_social`, `cuit`, `mail_corporativo`, `telefono_corporativo`, `sitio_web`, `descripcion`) VALUES
(1, 3, 'Coca Cola', '30-12411231-2', 'RRHH@cocacola', '2222', 'www.coca-cola.com', 'Distribuidora de gaseosas'),
(2, 10, 'Google', '', 'recursoshumanos@google.com', '1111', 'www.google.com', 'Empresa IT'),
(3, 5, 'Penta', '30-12354629-3', 'penta@consulting.com', '1123456789', 'www.penta.com', 'Consultoría ERP');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados_postulacion`
--

CREATE TABLE `estados_postulacion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `estados_postulacion`
--

INSERT INTO `estados_postulacion` (`id`, `nombre`) VALUES
(1, 'Recibido'),
(2, 'En evaluacion'),
(3, 'Reclutado'),
(4, 'Finalizado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados_publicacion`
--

CREATE TABLE `estados_publicacion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `estados_publicacion`
--

INSERT INTO `estados_publicacion` (`id`, `nombre`) VALUES
(1, 'Abierta'),
(2, 'Finalizada'),
(3, 'Deshabilitada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_eventos`
--

CREATE TABLE `estado_eventos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `estado_eventos`
--

INSERT INTO `estado_eventos` (`id`, `nombre`) VALUES
(1, 'Abierto'),
(2, 'Cerrado'),
(3, 'Suspendido'),
(4, 'Finalizado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE `eventos` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_estadoeventos` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `fecha` datetime NOT NULL,
  `tipo` varchar(20) DEFAULT NULL,
  `creditos` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `eventos`
--

INSERT INTO `eventos` (`id`, `id_usuario`, `id_estadoeventos`, `nombre`, `descripcion`, `fecha`, `tipo`, `creditos`) VALUES
(1, 1, 4, 'Apoyo Materia EDA I', 'Apoyo universitario para la materia estructura de Datos y Algoritmos I', '2024-12-09 09:00:00', 'Tutorias', 2),
(2, 1, 1, 'Lenguaje de Señas', 'Breve introducción al lenguaje de señas.', '2024-11-29 19:39:52', 'Capacitacion', 1),
(3, 1, 1, 'Charla Deep Web', 'Charla para conocer más sobre la Deep Web', '2024-11-29 10:00:00', 'Capacitacion', 1),
(4, 1, 1, 'Tutoría Matematicas III', 'Tutoría Matematicas III', '2024-12-16 07:00:00', 'Tutorias', 1),
(5, 1, 1, 'Tutoria Ciberseguridad', 'Tutoria para la materia ciberseguridad', '2024-12-17 17:30:00', 'Tutorias', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habilidades`
--

CREATE TABLE `habilidades` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `habilidades`
--

INSERT INTO `habilidades` (`id`, `descripcion`) VALUES
(1, 'CSS'),
(2, 'JAVASCRIPT'),
(3, 'BASE DE DATOS'),
(4, 'HTML'),
(5, 'PHP');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habilidades_alumnos`
--

CREATE TABLE `habilidades_alumnos` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_habilidad` int(11) DEFAULT NULL,
  `nivel_grado` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `habilidades_alumnos`
--

INSERT INTO `habilidades_alumnos` (`id`, `id_usuario`, `id_habilidad`, `nivel_grado`) VALUES
(1, 2, 4, 3),
(2, 2, 1, 4),
(3, 4, 1, 5),
(4, 6, 3, 4),
(5, 8, 3, 5),
(6, 9, 2, 2),
(7, 6, 5, 5),
(8, 4, 5, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habilidades_publicaciones`
--

CREATE TABLE `habilidades_publicaciones` (
  `id` int(11) NOT NULL,
  `id_habilidad` int(11) NOT NULL,
  `id_publicacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `habilidades_publicaciones`
--

INSERT INTO `habilidades_publicaciones` (`id`, `id_habilidad`, `id_publicacion`) VALUES
(1, 4, 1),
(2, 1, 1),
(3, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jornadas`
--

CREATE TABLE `jornadas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `jornadas`
--

INSERT INTO `jornadas` (`id`, `nombre`) VALUES
(1, 'FullTime'),
(2, 'PartTime');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias`
--

CREATE TABLE `materias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `detalle` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `materias`
--

INSERT INTO `materias` (`id`, `nombre`, `detalle`) VALUES
(1, 'introduccion Software', 'Inicial de Software 1° Año'),
(2, 'Base de Datos I', 'Introduccion a SQL'),
(3, 'Matematica I', 'Introduccion a Matematica Universitaria'),
(4, 'Ingles I', 'Nivelacion inicial de Ingles'),
(5, 'Ingenieria de Software', 'Introduccion a la Ingenieria (2° Año de Softw'),
(6, 'Estructura de Datos y Algoritmos', 'Logica de la Programacion');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias_aprobadas`
--

CREATE TABLE `materias_aprobadas` (
  `id` int(11) NOT NULL,
  `id_alumno` int(11) DEFAULT NULL,
  `id_materia` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `materias_aprobadas`
--

INSERT INTO `materias_aprobadas` (`id`, `id_alumno`, `id_materia`) VALUES
(1, 1, 2),
(11, 1, 3),
(2, 1, 4),
(10, 2, 4),
(4, 2, 5),
(5, 3, 3),
(8, 3, 6),
(6, 4, 2),
(7, 4, 6),
(3, 5, 5),
(9, 5, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias_requeridas`
--

CREATE TABLE `materias_requeridas` (
  `id` int(11) NOT NULL,
  `id_materia` int(11) NOT NULL,
  `id_publicacionesempleos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `materias_requeridas`
--

INSERT INTO `materias_requeridas` (`id`, `id_materia`, `id_publicacionesempleos`) VALUES
(1, 3, 3),
(2, 2, 3),
(3, 5, 6),
(4, 6, 6),
(5, 1, 5),
(6, 4, 2),
(7, 1, 4),
(8, 5, 1),
(9, 6, 1),
(10, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modalidades`
--

CREATE TABLE `modalidades` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `modalidades`
--

INSERT INTO `modalidades` (`id`, `descripcion`) VALUES
(1, 'Presencial'),
(2, 'HomeOffice'),
(3, 'Hibrido');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `descripcion` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `notificaciones`
--

INSERT INTO `notificaciones` (`id`, `id_usuario`, `descripcion`) VALUES
(1, 2, 'Se ha creado un nuevo evento: Tutoría Matematicas III'),
(2, 8, 'Se ha creado un nuevo evento: Tutoría Matematicas III'),
(3, 9, 'Se ha creado un nuevo evento: Tutoría Matematicas III'),
(4, 4, 'Se ha creado un nuevo evento: Tutoría Matematicas III'),
(5, 6, 'Se ha creado un nuevo evento: Tutoría Matematicas III'),
(6, 7, 'Se ha creado un nuevo evento: Tutoría Matematicas III'),
(7, 2, 'Se ha creado un nuevo evento: Tutoria Ciberseguridad'),
(8, 8, 'Se ha creado un nuevo evento: Tutoria Ciberseguridad'),
(9, 9, 'Se ha creado un nuevo evento: Tutoria Ciberseguridad'),
(10, 4, 'Se ha creado un nuevo evento: Tutoria Ciberseguridad'),
(11, 6, 'Se ha creado un nuevo evento: Tutoria Ciberseguridad'),
(12, 7, 'Se ha creado un nuevo evento: Tutoria Ciberseguridad'),
(13, 1, 'El alumno pepe Torres se suscribió al evento \'Tutoria Ciberseguridad\'.'),
(14, 2, 'Tu postulación para el puesto \'Programador Frontend\' está en evaluación.'),
(15, 2, 'Fuiste reclutado para el puesto \'Programador Frontend\'.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id`, `nombre`) VALUES
(1, 'Alta Usuario'),
(2, 'Baja Usuario'),
(3, 'Bloquear Usuario'),
(4, 'Desbloquear Usuario'),
(5, 'Cambiar contraseña'),
(6, 'Buscar Usuario'),
(7, 'Visualizar Usuarios'),
(8, 'Listar Habilidades'),
(9, 'Eliminar Habilidades'),
(10, 'Editar Habilidades'),
(11, 'Crear Habilidades'),
(12, 'Visualizar Eventos'),
(13, 'Listar Inscriptos Eventos'),
(14, 'Anular Suscripcion Eventos'),
(15, 'Editar Eventos'),
(16, 'Eliminar Eventos'),
(17, 'Publicar Eventos'),
(18, 'Visualizar Carreras'),
(19, 'Editar Carreras'),
(20, 'Eliminar Carreras'),
(21, 'Visualizar Plan de Estudio'),
(22, 'Editar Plan de Estudio'),
(23, 'Eliminar Plan de Estudio'),
(24, 'Cargar Plan de Estudio'),
(25, 'Listar Alumnos'),
(26, 'Listar Materias Aprobadas'),
(27, 'Visualizar Postulaciones'),
(28, 'Tratar Postulaciones'),
(29, 'Generar reporte Postulaciones'),
(30, 'Editar Empleo'),
(31, 'Publicar Empleo'),
(32, 'Visualizar Perfil'),
(33, 'Reclutar Perfil'),
(34, 'Editar Perfil'),
(35, 'Auto-asignar Habilidades'),
(36, 'Visualizar Empleos'),
(37, 'Enviar solicitud Empleo'),
(38, 'Listar Empleos'),
(39, 'Suscribir a Evento'),
(40, 'Cancelar solicitud Empleo'),
(41, 'Visualizar solicitud Empleos'),
(42, 'Registrar Usuario'),
(43, 'Visualizar Habilidades'),
(44, 'Visualizar Notificaciones'),
(45, 'Postular a Empleo'),
(46, 'Visualizar Publicaciones'),
(47, 'Visualizar Publicacion'),
(48, 'Visualizar Alumno'),
(49, 'Generar reporte Publicaciones');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `planes_materias`
--

CREATE TABLE `planes_materias` (
  `id` int(11) NOT NULL,
  `id_planestudio` int(11) NOT NULL,
  `id_materia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `planes_materias`
--

INSERT INTO `planes_materias` (`id`, `id_planestudio`, `id_materia`) VALUES
(1, 2, 2),
(2, 1, 6),
(3, 3, 3),
(4, 4, 3),
(5, 5, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plan_estudio`
--

CREATE TABLE `plan_estudio` (
  `id` int(11) NOT NULL,
  `id_carrera` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `plan_estudio`
--

INSERT INTO `plan_estudio` (`id`, `id_carrera`, `nombre`) VALUES
(1, 1, 'Plan 2016 Desarrollo de Software'),
(2, 1, 'Plan 2020 Desarrollo de Software'),
(3, 2, 'Plan 2016 Logistica'),
(4, 2, 'Plan 2020 Logistica'),
(5, 3, 'Plan 2016 Despacho de Aduana'),
(6, 3, 'Plan 2020 Despacho de Aduana');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `postulaciones`
--

CREATE TABLE `postulaciones` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_publicacionesempleos` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `id_estadopostulacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `postulaciones`
--

INSERT INTO `postulaciones` (`id`, `id_usuario`, `id_publicacionesempleos`, `fecha`, `id_estadopostulacion`) VALUES
(1, 2, 1, '2024-11-27', 3),
(3, 4, 4, '2024-11-27', 1),
(4, 9, 5, '2024-11-27', 1),
(5, 2, 6, '2024-11-27', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicaciones_empleos`
--

CREATE TABLE `publicaciones_empleos` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_estadopublicacion` int(11) NOT NULL,
  `id_jornada` int(11) NOT NULL,
  `id_modalidad` int(11) NOT NULL,
  `puesto_ofrecido` varchar(45) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `ubicacion` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `publicaciones_empleos`
--

INSERT INTO `publicaciones_empleos` (`id`, `id_usuario`, `id_estadopublicacion`, `id_jornada`, `id_modalidad`, `puesto_ofrecido`, `descripcion`, `fecha`, `ubicacion`) VALUES
(1, 3, 1, 2, 1, 'Programador Frontend', 'Buscamos un programador frontend para sumarse a nuestro equipo', '2024-10-31', 'San Isidro'),
(2, 3, 1, 2, 2, 'Guía Turístico/a', 'Acompañamiento de turistas, explicación de puntos turísticos, organización de itinerarios.', '2024-11-15', 'CABA'),
(3, 3, 1, 1, 1, 'Analista Financiero/a jr', 'Análisis de datos financieros, generación de informes de rendimiento, presupuesto.', '2024-11-19', 'Ezeiza'),
(4, 3, 3, 1, 1, 'Diseñador/a Gráfico/a', 'Creación de piezas visuales para campañas, branding, diseño de materiales gráficos.', '2024-11-19', 'Lanus'),
(5, 3, 1, 2, 3, 'Pasante de Recursos Humanos', 'Implementación de políticas y estrategias.', '2024-11-19', 'Lomas'),
(6, 3, 1, 1, 2, 'Desarrollador de Software', 'Desarrollador Fullstack Senior', '2024-11-20', 'CABA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id`, `nombre`) VALUES
(1, 'Administrador'),
(2, 'Alumno'),
(3, 'Empresa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles_permisos`
--

CREATE TABLE `roles_permisos` (
  `id` int(11) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `id_permiso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `roles_permisos`
--

INSERT INTO `roles_permisos` (`id`, `id_rol`, `id_permiso`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 1, 9),
(10, 1, 10),
(11, 1, 11),
(12, 1, 12),
(13, 1, 13),
(14, 1, 14),
(15, 1, 15),
(16, 1, 16),
(17, 1, 17),
(18, 1, 18),
(19, 1, 19),
(20, 1, 20),
(21, 1, 21),
(22, 1, 22),
(23, 1, 23),
(24, 1, 24),
(25, 1, 25),
(26, 1, 26),
(27, 3, 27),
(28, 3, 28),
(29, 3, 29),
(30, 3, 30),
(31, 3, 31),
(32, 3, 32),
(33, 3, 33),
(34, 3, 34),
(35, 2, 35),
(36, 2, 34),
(37, 1, 34),
(38, 2, 36),
(39, 2, 37),
(40, 2, 38),
(41, 2, 39),
(42, 2, 40),
(43, 2, 41),
(44, 2, 12),
(45, 2, 26),
(46, 1, 42),
(47, 1, 31),
(48, 1, 43),
(49, 1, 44),
(50, 2, 32),
(51, 2, 27),
(52, 2, 44),
(53, 3, 46),
(54, 1, 46),
(55, 1, 47),
(56, 3, 47),
(57, 3, 48),
(58, 1, 5),
(59, 2, 5),
(60, 1, 5),
(61, 1, 46),
(62, 1, 29),
(63, 1, 47),
(64, 1, 30),
(65, 1, 49),
(66, 3, 49);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles_usuario`
--

CREATE TABLE `roles_usuario` (
  `id` int(11) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `roles_usuario`
--

INSERT INTO `roles_usuario` (`id`, `id_rol`, `id_usuario`) VALUES
(1, 2, 2),
(2, 3, 3),
(3, 1, 1),
(4, 2, 8),
(5, 2, 9),
(6, 3, 10),
(8, 2, 4),
(9, 2, 6),
(10, 2, 7),
(11, 3, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `suscripciones`
--

CREATE TABLE `suscripciones` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_evento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `suscripciones`
--

INSERT INTO `suscripciones` (`id`, `id_usuario`, `id_evento`) VALUES
(1, 2, 3),
(2, 2, 1),
(3, 2, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `clave` varchar(45) NOT NULL,
  `mail` varchar(45) DEFAULT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `direccion` varchar(45) DEFAULT NULL,
  `foto_perfil` varchar(200) DEFAULT NULL,
  `de_baja` varchar(1) NOT NULL COMMENT 's/n',
  `google_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `clave`, `mail`, `telefono`, `direccion`, `foto_perfil`, `de_baja`, `google_id`) VALUES
(1, 'eperez', '123', 'admin@gmail.com', '1523432112', 'Lamadrid 123', 'fotoperfil.png', 'N', NULL),
(2, 'mtorres', '123', 'alumno@gmail.com', '1523432114', 'French 912', 'profile_6740d5dbc1c8b8.65466844.jpg', 'N', NULL),
(3, 'ggomez', '123', 'empresa@gmail.com', '1111', '9 de Julio 5674', 'fotoempresa.jpg', 'N', NULL),
(4, 'gfuentes', '1234', 'gfuentes@mail.com', '123312312', 'CABA', NULL, 'N', NULL),
(5, 'Belen', 'penta123', 'penta@consulting.com', '1231231', 'CABA', NULL, 'N', NULL),
(6, 'jsein', '123', 'jsein@gmail.com', '123456', 'Calle 123', NULL, 'N', NULL),
(7, 'mlopez', '123', 'maia@mail.com', '1231231', 'CABA', NULL, 'N', NULL),
(8, 'mursino', '123', 'murss@mail.com', '1122345678', 'CABA', NULL, 'N', NULL),
(9, 'cvallejs', '123', 'cvalle@mail.com', '1125678945', 'CABA', NULL, 'N', NULL),
(10, 'cdiaz', '123', 'cdiaz@mail.com', '1175836473', 'CABA', NULL, 'N', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumno`
--
ALTER TABLE `alumno`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Alumno_Usuario1_idx` (`id_usuario`);

--
-- Indices de la tabla `carreras`
--
ALTER TABLE `carreras`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `carreras_alumnos`
--
ALTER TABLE `carreras_alumnos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `CarAlum_Carrera_idx` (`id_carrera`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Empresa_Usuario1_idx` (`id_usuario`);

--
-- Indices de la tabla `estados_postulacion`
--
ALTER TABLE `estados_postulacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estados_publicacion`
--
ALTER TABLE `estados_publicacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estado_eventos`
--
ALTER TABLE `estado_eventos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Evento_EstadoEvento1_idx` (`id_estadoeventos`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `habilidades`
--
ALTER TABLE `habilidades`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `habilidades_alumnos`
--
ALTER TABLE `habilidades_alumnos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_idHabilidad` (`id_habilidad`),
  ADD KEY `id_usuario` (`id_usuario`) USING BTREE;

--
-- Indices de la tabla `habilidades_publicaciones`
--
ALTER TABLE `habilidades_publicaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `HabReq_Habilidad_idx` (`id_habilidad`),
  ADD KEY `HabPub_Publicacion_idx` (`id_publicacion`);

--
-- Indices de la tabla `jornadas`
--
ALTER TABLE `jornadas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `materias_aprobadas`
--
ALTER TABLE `materias_aprobadas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_alumno` (`id_alumno`,`id_materia`),
  ADD KEY `id_materia` (`id_materia`);

--
-- Indices de la tabla `materias_requeridas`
--
ALTER TABLE `materias_requeridas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `MatEmpleo_Materia_idx` (`id_materia`),
  ADD KEY `MatReq_Publicacion_idx` (`id_publicacionesempleos`);

--
-- Indices de la tabla `modalidades`
--
ALTER TABLE `modalidades`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_id_usuario` (`id_usuario`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `planes_materias`
--
ALTER TABLE `planes_materias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `PlanMateria_PlanCarrera_idx` (`id_planestudio`),
  ADD KEY `PlanMateria_Materia_idx` (`id_materia`);

--
-- Indices de la tabla `plan_estudio`
--
ALTER TABLE `plan_estudio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Carrera_PlanCarrera_idx` (`id_carrera`);

--
-- Indices de la tabla `postulaciones`
--
ALTER TABLE `postulaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Postulacion_Publicacion_idx` (`id_publicacionesempleos`),
  ADD KEY `fk_Postulacion_EstadoPostulacion1_idx` (`id_estadopostulacion`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `publicaciones_empleos`
--
ALTER TABLE `publicaciones_empleos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_PubliciacionEmpleo_EstadoPublicacion1_idx` (`id_estadopublicacion`),
  ADD KEY `Publicacion_Jornada_idx` (`id_jornada`),
  ADD KEY `Publicacion_Modalidad_idx` (`id_modalidad`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles_permisos`
--
ALTER TABLE `roles_permisos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rolesxpermisos_permiso` (`id_permiso`),
  ADD KEY `rolesxpermisos_rol` (`id_rol`);

--
-- Indices de la tabla `roles_usuario`
--
ALTER TABLE `roles_usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rolesxusuario_rol` (`id_rol`),
  ADD KEY `rolesxusuario_usuario` (`id_usuario`);

--
-- Indices de la tabla `suscripciones`
--
ALTER TABLE `suscripciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `AlumEvento_Evento_idx` (`id_evento`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `google_id` (`google_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alumno`
--
ALTER TABLE `alumno`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `carreras`
--
ALTER TABLE `carreras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `carreras_alumnos`
--
ALTER TABLE `carreras_alumnos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `empresas`
--
ALTER TABLE `empresas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `estados_postulacion`
--
ALTER TABLE `estados_postulacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `estados_publicacion`
--
ALTER TABLE `estados_publicacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `estado_eventos`
--
ALTER TABLE `estado_eventos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `habilidades`
--
ALTER TABLE `habilidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `habilidades_alumnos`
--
ALTER TABLE `habilidades_alumnos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `habilidades_publicaciones`
--
ALTER TABLE `habilidades_publicaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `jornadas`
--
ALTER TABLE `jornadas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `materias`
--
ALTER TABLE `materias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `materias_aprobadas`
--
ALTER TABLE `materias_aprobadas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `materias_requeridas`
--
ALTER TABLE `materias_requeridas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `modalidades`
--
ALTER TABLE `modalidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `planes_materias`
--
ALTER TABLE `planes_materias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `plan_estudio`
--
ALTER TABLE `plan_estudio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `postulaciones`
--
ALTER TABLE `postulaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `publicaciones_empleos`
--
ALTER TABLE `publicaciones_empleos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `roles_permisos`
--
ALTER TABLE `roles_permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT de la tabla `roles_usuario`
--
ALTER TABLE `roles_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `suscripciones`
--
ALTER TABLE `suscripciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alumno`
--
ALTER TABLE `alumno`
  ADD CONSTRAINT `fk_Alumno_Usuario1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `carreras_alumnos`
--
ALTER TABLE `carreras_alumnos`
  ADD CONSTRAINT `CarAlum_Carrera` FOREIGN KEY (`id_carrera`) REFERENCES `carreras` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `empresas`
--
ALTER TABLE `empresas`
  ADD CONSTRAINT `fk_Empresa_Usuario1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD CONSTRAINT `Evento_EstadoEvento` FOREIGN KEY (`id_estadoeventos`) REFERENCES `estado_eventos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `habilidades_alumnos`
--
ALTER TABLE `habilidades_alumnos`
  ADD CONSTRAINT `habilidades_alumnos_ibfk_2` FOREIGN KEY (`id_habilidad`) REFERENCES `habilidades` (`id`);

--
-- Filtros para la tabla `habilidades_publicaciones`
--
ALTER TABLE `habilidades_publicaciones`
  ADD CONSTRAINT `HabPub_Habilidad` FOREIGN KEY (`id_habilidad`) REFERENCES `habilidades` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `HabPub_Publicacion` FOREIGN KEY (`id_publicacion`) REFERENCES `publicaciones_empleos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `materias_aprobadas`
--
ALTER TABLE `materias_aprobadas`
  ADD CONSTRAINT `materias_aprobadas_ibfk_1` FOREIGN KEY (`id_alumno`) REFERENCES `alumno` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `materias_aprobadas_ibfk_2` FOREIGN KEY (`id_materia`) REFERENCES `materias` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `materias_requeridas`
--
ALTER TABLE `materias_requeridas`
  ADD CONSTRAINT `MatEmpleo_Materia` FOREIGN KEY (`id_materia`) REFERENCES `materias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `MatReq_Publicacion` FOREIGN KEY (`id_publicacionesempleos`) REFERENCES `publicaciones_empleos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD CONSTRAINT `fk_id_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `planes_materias`
--
ALTER TABLE `planes_materias`
  ADD CONSTRAINT `PlanMateria_Materia` FOREIGN KEY (`id_materia`) REFERENCES `materias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `PlanMateria_PlanCarrera` FOREIGN KEY (`id_planestudio`) REFERENCES `plan_estudio` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `plan_estudio`
--
ALTER TABLE `plan_estudio`
  ADD CONSTRAINT `Carrera_PlanEstudio` FOREIGN KEY (`id_carrera`) REFERENCES `carreras` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `postulaciones`
--
ALTER TABLE `postulaciones`
  ADD CONSTRAINT `Postulacion_EstadoPostulacion` FOREIGN KEY (`id_estadopostulacion`) REFERENCES `estados_postulacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `Postulacion_Publicacion` FOREIGN KEY (`id_publicacionesempleos`) REFERENCES `publicaciones_empleos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `publicaciones_empleos`
--
ALTER TABLE `publicaciones_empleos`
  ADD CONSTRAINT `Publicacion_Jornada` FOREIGN KEY (`id_jornada`) REFERENCES `jornadas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `Publicacion_Modalidad` FOREIGN KEY (`id_modalidad`) REFERENCES `modalidades` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `PubliciacionEmpleo_EstadoPublicacion` FOREIGN KEY (`id_estadopublicacion`) REFERENCES `estados_publicacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `roles_permisos`
--
ALTER TABLE `roles_permisos`
  ADD CONSTRAINT `rolesxpermisos_permiso` FOREIGN KEY (`id_permiso`) REFERENCES `permisos` (`id`),
  ADD CONSTRAINT `rolesxpermisos_rol` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id`);

--
-- Filtros para la tabla `roles_usuario`
--
ALTER TABLE `roles_usuario`
  ADD CONSTRAINT `rolesxusuario_rol` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id`),
  ADD CONSTRAINT `rolesxusuario_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `suscripciones`
--
ALTER TABLE `suscripciones`
  ADD CONSTRAINT `Suscripcion_Evento` FOREIGN KEY (`id_evento`) REFERENCES `eventos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
