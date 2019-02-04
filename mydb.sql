-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 02, 2018 at 08:23 PM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mydb`
--

-- --------------------------------------------------------

--
-- Table structure for table `ajuste`
--

CREATE TABLE `ajuste` (
  `Ajuste_Id` int(11) NOT NULL,
  `Ajuste_Nombre` varchar(100) DEFAULT NULL,
  `Ajuste_Valor` varchar(100) DEFAULT NULL,
  `Ajuste_Descripcion` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ajuste`
--

INSERT INTO `ajuste` (`Ajuste_Id`, `Ajuste_Nombre`, `Ajuste_Valor`, `Ajuste_Descripcion`) VALUES
(1, 'system_name', 'Gestión de Recursos Humanos, ASSE Nueva Helvecia', NULL),
(2, 'version', '1.0.0', NULL),
(3, 'latest_version', NULL, NULL),
(4, 'server_ip', NULL, NULL),
(5, 'minutes_tardy', NULL, NULL),
(6, 'time_format', '0', NULL),
(7, 'date_format', 'yyyy-mm-dd', NULL),
(8, 'leave_earn', '15', 'Minutos'),
(9, 'update_server', NULL, NULL),
(10, 'enable_download', NULL, NULL),
(11, 'client', NULL, NULL),
(12, 'ftp_host', NULL, NULL),
(13, 'ftp_user', NULL, NULL),
(14, 'ftp_pass', NULL, NULL),
(15, 'ftp_folder', NULL, NULL),
(16, 'print_office_head_in_dtr', '1', NULL),
(17, 'minutes_tardy_am_only', '0', NULL),
(18, 'print_overtime_in_dtr', '1', NULL),
(19, 'auto_sixty_days', 'no', 'Establecer 60 días si es licencia de maternidad.'),
(20, 'auto_seven_days', 'no', 'Establecer 7 días si es licencia de paternidad.'),
(21, 'encoded_leave_listing_order', 'DESC', 'Mostrar reportes ordenados ASC o DESC'),
(22, 'message_late', 'yes', 'Enviar mensaje al usuario si llega tarde.'),
(23, 'show_leave_credits_leave_apps', 'yes', 'Mostrar el balance de la licencia en la página de solicitud de licencia.'),
(24, 'show_incomplete_logs', 'yes', 'Mostrar registros incompletos en la asistencia a la vista.'),
(25, 'seconds_user_idle', '7200', 'Segundos antes de cerrar la sesión si el usuario está inactivo.'),
(26, 'delete_records_when_downloading', 'yes', 'Eliminar registros automaticamente al descargarlos.');

-- --------------------------------------------------------

--
-- Table structure for table `archivo`
--

CREATE TABLE `archivo` (
  `Archivo_Id` int(11) NOT NULL,
  `Archivo_Nombre` varchar(45) NOT NULL,
  `Archivo_Size` mediumint(8) NOT NULL,
  `Archivo_Archivo` mediumblob NOT NULL,
  `FK_Reporte_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `autorizacion`
--

CREATE TABLE `autorizacion` (
  `Autorizacion_Id` int(11) NOT NULL,
  `Autorizacion_RegistroEntrada` int(11) NOT NULL,
  `Autorizacion_RegistroSalida` int(11) NOT NULL,
  `Autorizacion_Autorizado` varchar(2) NOT NULL DEFAULT 'NO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `conversacion`
--

CREATE TABLE `conversacion` (
  `Conversacion_Id` int(11) NOT NULL,
  `Conversacion_Usuario_Envia` int(11) NOT NULL,
  `Conversacion_Usuario_Recibe` int(11) NOT NULL,
  `Conversacion_Fecha` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `conversacion`
--

INSERT INTO `conversacion` (`Conversacion_Id`, `Conversacion_Usuario_Envia`, `Conversacion_Usuario_Recibe`, `Conversacion_Fecha`) VALUES
(1, 2, 1, '2017-11-16 16:36:00');

-- --------------------------------------------------------

--
-- Table structure for table `dispositivobiometrico`
--

CREATE TABLE `dispositivobiometrico` (
  `DispositivoBiometrico_Id` int(11) NOT NULL,
  `DispositivoBiometrico_Nombre` varchar(45) NOT NULL,
  `DispositivoBiometrico_Serial` varchar(30) NOT NULL,
  `DispositivoBiometrico_Modelo` varchar(45) NOT NULL,
  `DispositivoBiometrico_Ip` varchar(15) NOT NULL,
  `DispositivoBiometrico_Puerto` varchar(5) NOT NULL,
  `DispositivoBiometrico_Usuario` varchar(45) DEFAULT NULL,
  `DispositivoBiometrico_Password` varchar(45) DEFAULT NULL,
  `Fk_Empresa_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dispositivobiometrico`
--

INSERT INTO `dispositivobiometrico` (`DispositivoBiometrico_Id`, `DispositivoBiometrico_Nombre`, `DispositivoBiometrico_Serial`, `DispositivoBiometrico_Modelo`, `DispositivoBiometrico_Ip`, `DispositivoBiometrico_Puerto`, `DispositivoBiometrico_Usuario`, `DispositivoBiometrico_Password`, `Fk_Empresa_Id`) VALUES
(1, 'Uno', 'asdasd', 'asdasd', '195654d12', '5045', NULL, NULL, 1),
(2, 'Dos', '12312e', 'asdasda', '12312easd', '5045', 'root', 'root', 3),
(3, '12345', '12345', '12345', '12345', '12345', '12345', '12345', 1),
(4, '12312', '1231', '123', '123', '123', '123', '123', 4);

-- --------------------------------------------------------

--
-- Table structure for table `empleado`
--

CREATE TABLE `empleado` (
  `Empleado_Id` int(11) NOT NULL,
  `Empleado_Cedula` varchar(8) NOT NULL,
  `Empleado_Codigo` varchar(10) DEFAULT NULL,
  `Empleado_Nombre` varchar(50) NOT NULL,
  `Empleado_Apelido` varchar(50) NOT NULL,
  `Empleado_Correo` varchar(45) DEFAULT NULL,
  `Empleado_Telefono` varchar(9) DEFAULT NULL,
  `Empleado_FIngreso` date DEFAULT NULL,
  `Empleado_DiferenciaTiempo` time DEFAULT NULL,
  `Empleado_Estado` varchar(8) NOT NULL DEFAULT 'Activo',
  `FK_TipoEmpleado_Id` int(11) DEFAULT NULL,
  `FK_Oficina_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `empleado`
--

INSERT INTO `empleado` (`Empleado_Id`, `Empleado_Cedula`, `Empleado_Codigo`, `Empleado_Nombre`, `Empleado_Apelido`, `Empleado_Correo`, `Empleado_Telefono`, `Empleado_FIngreso`, `Empleado_DiferenciaTiempo`, `Empleado_Estado`, `FK_TipoEmpleado_Id`, `FK_Oficina_Id`) VALUES
(2, '48806420', '1234', 'Matias', 'Fiermarin', 'matiasfiermarin@hotmail.com', '09928227', '1992-10-17', NULL, 'Activo', NULL, 3);

-- --------------------------------------------------------

--
-- Table structure for table `empresa`
--

CREATE TABLE `empresa` (
  `Empresa_Id` int(11) NOT NULL,
  `Empresa_Nombre` varchar(45) NOT NULL,
  `Empresa_Telefono` varchar(9) DEFAULT NULL,
  `Empresa_Estado` varchar(8) NOT NULL DEFAULT 'Activo',
  `Empresa_Ingreso` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `empresa`
--

INSERT INTO `empresa` (`Empresa_Id`, `Empresa_Nombre`, `Empresa_Telefono`, `Empresa_Estado`, `Empresa_Ingreso`) VALUES
(1, 'Empresa 13', '09920121', 'Activo', '2017-07-14'),
(3, 'Empresa3', '099282273', 'Activo', '2017-07-14'),
(4, 'asd', 'asd', 'Activo', '2017-10-25');

-- --------------------------------------------------------

--
-- Table structure for table `feriado`
--

CREATE TABLE `feriado` (
  `Feriado_Id` int(11) NOT NULL,
  `Feriado_Nombre` varchar(20) NOT NULL,
  `Feriado_Coeficiente` varchar(4) NOT NULL,
  `Feriado_Minimo` time NOT NULL,
  `Feriado_Fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `feriado`
--

INSERT INTO `feriado` (`Feriado_Id`, `Feriado_Nombre`, `Feriado_Coeficiente`, `Feriado_Minimo`, `Feriado_Fecha`) VALUES
(1, 'Prueba3', '5', '06:00:00', '2017-10-17'),
(2, 'Prueba2', '5', '02:00:00', '2018-01-01');

-- --------------------------------------------------------

--
-- Table structure for table `grupoperfil`
--

CREATE TABLE `grupoperfil` (
  `FK_GrupoUsuario_Id` int(11) NOT NULL,
  `FK_Perfil_Id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `grupoperfil`
--

INSERT INTO `grupoperfil` (`FK_GrupoUsuario_Id`, `FK_Perfil_Id`) VALUES
(1, 1),
(3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `grupousuario`
--

CREATE TABLE `grupousuario` (
  `GrupoUsuario_Id` int(11) NOT NULL,
  `GrupoUsuario_Nombre` varchar(45) DEFAULT NULL,
  `GrupoUsuario_Descripcion` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `grupousuario`
--

INSERT INTO `grupousuario` (`GrupoUsuario_Id`, `GrupoUsuario_Nombre`, `GrupoUsuario_Descripcion`) VALUES
(1, 'Administrador', 'Prueba12q'),
(3, 'Consulta', 'Consulta'),
(15, '553', '5'),
(16, '21', '2w'),
(17, 'asd', 'asd'),
(18, 'asd', 'ads33');

-- --------------------------------------------------------

--
-- Table structure for table `horario`
--

CREATE TABLE `horario` (
  `Horario_Id` int(11) NOT NULL,
  `Horario_Nombre` varchar(30) NOT NULL,
  `Horario_Entrada` time NOT NULL,
  `Horario_Salida` time NOT NULL,
  `Horario_ComienzoBrake` time DEFAULT NULL,
  `Horario_FinBrake` time DEFAULT NULL,
  `Horario_TiempoTarde` time NOT NULL,
  `Horario_SalidaAntes` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `horariorotativo`
--

CREATE TABLE `horariorotativo` (
  `HorarioRotativo_Id` int(11) NOT NULL,
  `HorarioRotativo_Nombre` varchar(30) NOT NULL,
  `HorarioRotativo_DiaComienzo` varchar(1) NOT NULL,
  `HorarioRotativo_DiasTrabajo` varchar(1) NOT NULL,
  `HorarioRotativo_DiasLibres` varchar(1) NOT NULL,
  `FK_Horario_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `horariosemanal`
--

CREATE TABLE `horariosemanal` (
  `HorarioSemanal_Id` int(11) NOT NULL,
  `HorarioSemanal_Nombre` varchar(45) NOT NULL,
  `HorarioSemanal_Horas` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `licencia`
--

CREATE TABLE `licencia` (
  `Licencia_Id` int(11) NOT NULL COMMENT '\n',
  `Licencia_Ano` int(4) NOT NULL,
  `Licencia_Cantidad` int(3) NOT NULL,
  `Licencia_Observaciones` varchar(45) DEFAULT NULL,
  `FK_TipoLicencia_Id` int(11) NOT NULL,
  `FK_Empleado_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `Log_Id` int(11) NOT NULL,
  `Log_Fecha` varchar(45) NOT NULL,
  `Log_Accion` varchar(45) NOT NULL,
  `Log_Tabla` varchar(45) NOT NULL,
  `Log_Parametro` varchar(45) NOT NULL,
  `Log_Otros` varchar(45) DEFAULT NULL,
  `FK_Usuario_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mensaje`
--

CREATE TABLE `mensaje` (
  `Mensaje_Id` int(11) NOT NULL,
  `Mensaje_Mensaje` varchar(100) NOT NULL,
  `Mensaje_Fecha` datetime NOT NULL,
  `Mensaje_Leido` varchar(1) NOT NULL DEFAULT 'N',
  `Mensaje_Usuario_Envia` int(11) NOT NULL,
  `FK_Conversacion_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mensaje`
--

INSERT INTO `mensaje` (`Mensaje_Id`, `Mensaje_Mensaje`, `Mensaje_Fecha`, `Mensaje_Leido`, `Mensaje_Usuario_Envia`, `FK_Conversacion_Id`) VALUES
(1, 'Prueba', '2017-11-14 00:00:00', 'N', 2, 1),
(2, 'Hola', '2017-11-14 15:33:00', 'N', 1, 1),
(3, 'Juasw', '2017-11-14 17:02:15', 'N', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `Menu_Id` int(11) NOT NULL,
  `Menu_PadreId` int(3) DEFAULT NULL,
  `Menu_Descripcion` varchar(45) DEFAULT NULL,
  `Menu_Posicion` varchar(45) DEFAULT NULL,
  `Menu_Habilitado` int(1) DEFAULT NULL,
  `Menu_URL` varchar(45) DEFAULT NULL,
  `Menu_Icono` varchar(45) DEFAULT NULL,
  `Menu_FormularioAsociado` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`Menu_Id`, `Menu_PadreId`, `Menu_Descripcion`, `Menu_Posicion`, `Menu_Habilitado`, `Menu_URL`, `Menu_Icono`, `Menu_FormularioAsociado`) VALUES
(1, 0, 'Inicio', '1', 1, NULL, 'icon-dashboard', '0'),
(2, 0, 'Gestiones', '2', 1, NULL, 'icon-glass', '0'),
(3, 2, 'Alta Sector', '1', 1, 'sector/create', NULL, '1'),
(4, 2, 'BMC Sector', '2', 1, 'sector/index', NULL, '1'),
(5, 2, 'Alta Feriado', '3', 1, 'feriado/create', NULL, '1'),
(6, 2, 'BMC Feriado', '4', 1, 'feriado/index', NULL, '1'),
(7, 2, 'Alta Licencia', '5', 1, 'licencia/create', NULL, '1'),
(8, 2, 'BMC Licencia', '6', 1, 'licencia/index', NULL, '1'),
(9, 0, 'Horarios', '3', 1, NULL, 'icon-time', '0'),
(10, 9, 'Alta Horario Diario', '1', 1, 'diario/create', NULL, '1'),
(11, 9, 'BMC Horario Diario', '2', 1, 'diario/index', NULL, '1'),
(12, 9, 'Alta Horario Semanal', '3', 1, 'semanal/create', NULL, '1'),
(13, 9, 'BMC Horario Semanal', '4', 1, 'semanal/index', NULL, '1'),
(14, 0, 'Turnos', '4', 1, NULL, 'icon-cogs', '0'),
(15, 14, 'Alta Turno Fijo', '1', 1, 'turnofijo/create', NULL, '1'),
(16, 14, 'BMC Turno Fijo', '2', 1, 'turnofijo/index', NULL, '1'),
(17, 14, 'Alta Turno Rotativo', '3', 1, 'turnorotativo/create', NULL, '1'),
(18, 14, 'BMC Turno Rotativo', '4', 1, 'turnorotativo/index', NULL, '1'),
(19, 14, 'Asignar Turno', '5', 1, 'turno/create', NULL, '1'),
(20, 14, 'BMC Turno Asignado', '6', 1, 'turno/index', NULL, '1'),
(21, 0, 'Reportes', '5', 1, NULL, 'icon-print', '0'),
(22, 21, 'Faltas', '1', 1, 'reporte/faltas', NULL, '1'),
(23, 21, 'Llegadas Tarde', '2', 1, 'reporte/llegadastarde', NULL, '1'),
(24, 21, 'Horas Trabajadas', '3', 1, 'reporte/horastrabajadas', NULL, '1'),
(25, 21, 'Entradas y Salidas', '4', 1, 'reporte/entradasysalidas', NULL, '1'),
(26, 21, 'Horas Nocturnas', '5', 1, 'reporte/horasnocturnas', NULL, '1'),
(27, 21, 'Empleados', '6', 1, 'reporte/empleados', NULL, '1'),
(28, 21, 'Quien Trabajo', '7', 1, 'reporte/quientrabajo', NULL, '1'),
(29, 0, 'Personal', '6', 1, NULL, 'icon-user', '0'),
(30, 29, 'Alta Empleado', '1', 1, 'empleado/create', NULL, '1'),
(31, 29, 'BMC Empleado', '2', 1, 'empleado/index', NULL, '1'),
(32, 29, 'Libres Concedidos', '3', 1, 'libres/create', NULL, '1'),
(33, 29, 'Medicas', '4', 1, 'medicas/create', NULL, '1'),
(34, 29, 'Cargar Licencia', '5', 1, 'licencia/cargar', NULL, '1'),
(35, 29, 'Asignar Licencia', '6', 1, 'licencia/asignar', NULL, '1'),
(36, 29, 'Ficha', '7', 1, 'empleado/ficha', NULL, '1'),
(37, 29, 'Autorizacion Horas Extras', '8', 1, NULL, NULL, '1'),
(38, 0, 'Registros', '7', 1, NULL, 'icon-file-alt', '0'),
(39, 38, 'Descargar Registros', '1', 1, NULL, NULL, '1'),
(40, 38, 'Registro Manual', '2', 1, NULL, NULL, '1'),
(41, 38, 'Editar Registro', '3', 1, NULL, NULL, '1'),
(42, 38, 'Registrar Horas Diarias', '4', 1, NULL, NULL, '1'),
(43, 38, 'Registrar Horas Semanales', '5', 1, NULL, NULL, '1'),
(44, 38, 'Registrar Horas Rotativos', '6', 1, NULL, NULL, '1'),
(45, 0, 'Auditoria', '8', 1, NULL, 'icon-folder-open', '0'),
(46, 0, 'Configuracion', '9', 1, NULL, 'icon-wrench', '0'),
(47, 46, 'Ajustes', '1', 1, 'ajustes/index', NULL, '1'),
(48, 46, 'Usuarios', '2', 1, 'create', NULL, '1'),
(49, 46, 'BMC Usuario', '3', 1, 'index', NULL, '1'),
(50, 46, 'Grupo Usuarios', '4', 1, NULL, NULL, '1'),
(51, 46, 'Modulos', '5', 1, NULL, NULL, '1'),
(52, 46, 'Cambiar Contraseña', '6', 1, NULL, NULL, '1'),
(53, 46, 'Tipos Usuarios', '7', 1, NULL, NULL, '1'),
(54, 46, 'Permisos Usuarios', '8', 1, NULL, NULL, '1'),
(55, 1, 'Inico', '1', 1, 'inicio/index', NULL, '1');

-- --------------------------------------------------------

--
-- Table structure for table `migracion`
--

CREATE TABLE `migracion` (
  `Migracion_Id` int(11) NOT NULL,
  `Migracion_Version` varchar(5) DEFAULT NULL,
  `Migracion_Fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `modulo`
--

CREATE TABLE `modulo` (
  `Modulo_Id` int(11) NOT NULL,
  `Modulo_Nombre` varchar(45) DEFAULT NULL,
  `Modulo_Descripcion` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `modulo`
--

INSERT INTO `modulo` (`Modulo_Id`, `Modulo_Nombre`, `Modulo_Descripcion`) VALUES
(1, 'perfil', 'Administrador del Sistema'),
(2, 'Gestiones', 'Prueba');

-- --------------------------------------------------------

--
-- Table structure for table `modulomenu`
--

CREATE TABLE `modulomenu` (
  `FK_Modulo_Id` int(11) NOT NULL,
  `FK_Menu_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `modulomenu`
--

INSERT INTO `modulomenu` (`FK_Modulo_Id`, `FK_Menu_Id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(1, 14),
(1, 15),
(1, 16),
(1, 17),
(1, 18),
(1, 19),
(1, 20),
(1, 21),
(1, 22),
(1, 23),
(1, 24),
(1, 25),
(1, 26),
(1, 27),
(1, 28),
(1, 29),
(1, 30),
(1, 31),
(1, 32),
(1, 33),
(1, 34),
(1, 35),
(1, 36),
(1, 37),
(1, 38),
(1, 39),
(1, 40),
(1, 41),
(1, 42),
(1, 43),
(1, 44),
(1, 45),
(1, 46),
(1, 47),
(1, 48),
(1, 49),
(1, 50),
(1, 51),
(1, 52),
(1, 53),
(1, 54),
(1, 55);

-- --------------------------------------------------------

--
-- Table structure for table `oficina`
--

CREATE TABLE `oficina` (
  `Oficina_Id` int(11) NOT NULL,
  `Oficina_Nombre` varchar(45) NOT NULL,
  `Oficina_Descripcion` varchar(45) DEFAULT NULL,
  `Oficina_Codigo` varchar(5) DEFAULT NULL,
  `Oficina_Estado` varchar(8) NOT NULL DEFAULT 'Activo',
  `FK_Sucursal_Id` int(11) NOT NULL,
  `FK_DispositivoBiometrico_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `oficina`
--

INSERT INTO `oficina` (`Oficina_Id`, `Oficina_Nombre`, `Oficina_Descripcion`, `Oficina_Codigo`, `Oficina_Estado`, `FK_Sucursal_Id`, `FK_DispositivoBiometrico_Id`) VALUES
(2, '233', '33', '333', 'Activo', 2, 1),
(3, 'Prueba', '35465', '5614', 'Activo', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `perfil`
--

CREATE TABLE `perfil` (
  `Perfil_Id` int(11) NOT NULL,
  `Perfil_Nombre` varchar(45) NOT NULL,
  `Perfil_Descripcion` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `perfil`
--

INSERT INTO `perfil` (`Perfil_Id`, `Perfil_Nombre`, `Perfil_Descripcion`) VALUES
(1, 'Administrador', 'Administrador del Sistema'),
(2, 'Consulta', 'Perfil de Consulta');

-- --------------------------------------------------------

--
-- Table structure for table `perfilmodulo`
--

CREATE TABLE `perfilmodulo` (
  `FK_Perfil_Id` int(11) NOT NULL,
  `FK_Modulo_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `perfilmodulo`
--

INSERT INTO `perfilmodulo` (`FK_Perfil_Id`, `FK_Modulo_Id`) VALUES
(1, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `permiso`
--

CREATE TABLE `permiso` (
  `Permiso_Id` int(11) NOT NULL,
  `Permiso_Nombre` varchar(45) NOT NULL,
  `Permiso_Habilita` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permiso`
--

INSERT INTO `permiso` (`Permiso_Id`, `Permiso_Nombre`, `Permiso_Habilita`) VALUES
(1, 'Alta', 1),
(2, 'Baja', 1),
(3, 'Modificar', 1),
(4, 'Imprimir', 1),
(5, 'Consulta', 1),
(6, 'Ejecutar', 1);

-- --------------------------------------------------------

--
-- Table structure for table `permiso_perfil`
--

CREATE TABLE `permiso_perfil` (
  `FK_Perfil_Id` int(11) NOT NULL,
  `FK_Permiso_Id` int(11) NOT NULL,
  `PermisoPerfil_Habilita` varchar(1) DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permiso_perfil`
--

INSERT INTO `permiso_perfil` (`FK_Perfil_Id`, `FK_Permiso_Id`, `PermisoPerfil_Habilita`) VALUES
(1, 1, 'S'),
(1, 2, 'S'),
(1, 3, 'S'),
(1, 4, 'S'),
(1, 5, 'S'),
(1, 6, 'S'),
(2, 1, 'N'),
(2, 2, 'N'),
(2, 3, 'N'),
(2, 4, 'N'),
(2, 5, 'S'),
(2, 6, 'N');

-- --------------------------------------------------------

--
-- Table structure for table `preguntas`
--

CREATE TABLE `preguntas` (
  `Pregunta_Id` int(11) NOT NULL,
  `Pregunta_Nombre` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `preguntas`
--

INSERT INTO `preguntas` (`Pregunta_Id`, `Pregunta_Nombre`) VALUES
(1, 'Prueba');

-- --------------------------------------------------------

--
-- Table structure for table `recurso`
--

CREATE TABLE `recurso` (
  `Recurso_Id` int(11) NOT NULL,
  `Recurso_Controlador` varchar(45) NOT NULL,
  `Recurso_Accion` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `recurso`
--

INSERT INTO `recurso` (`Recurso_Id`, `Recurso_Controlador`, `Recurso_Accion`) VALUES
(13, 'login', 'index", "logout');

-- --------------------------------------------------------

--
-- Table structure for table `registros`
--

CREATE TABLE `registros` (
  `Registro_Id` int(11) NOT NULL,
  `Registro_Hora` datetime NOT NULL,
  `Registro_Fecha` date NOT NULL,
  `Registro_TipoMarca` varchar(8) NOT NULL,
  `Registro_Comentarios` varchar(45) DEFAULT NULL,
  `Registro_Registrado` varchar(2) NOT NULL DEFAULT 'NO',
  `Registro_Tipo` varchar(15) DEFAULT NULL,
  `FK_Empleado_Cedula` varchar(8) NOT NULL,
  `FK_DispositivoBiometrico_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `reporte`
--

CREATE TABLE `reporte` (
  `Reporte_Id` int(11) NOT NULL,
  `Reporte_Fecha` date NOT NULL,
  `Reporte_Asunto` varchar(30) NOT NULL,
  `Reporte_Descripcion` varchar(100) NOT NULL,
  `Reporte_Importancia` varchar(1) NOT NULL,
  `FK_Usuario_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sesion`
--

CREATE TABLE `sesion` (
  `Sesion_Id` int(11) NOT NULL,
  `Sesion_Equipo` varchar(45) NOT NULL,
  `Sesion_Fecha` date NOT NULL,
  `Sesion_Hora` time NOT NULL,
  `FK_Usuario_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sucursal`
--

CREATE TABLE `sucursal` (
  `Sucursal_Id` int(11) NOT NULL,
  `Sucursal_Nombre` varchar(45) DEFAULT NULL,
  `Sucursal_Descripcion` varchar(45) DEFAULT NULL,
  `FK_Empresa_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sucursal`
--

INSERT INTO `sucursal` (`Sucursal_Id`, `Sucursal_Nombre`, `Sucursal_Descripcion`, `FK_Empresa_Id`) VALUES
(1, 'Prueba133', 'Prueba2323', 1),
(2, 'Prueba2', 'Prueba2', 3),
(3, 'ggggggggggg', 'ggggg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tipoempleado`
--

CREATE TABLE `tipoempleado` (
  `TipoEmpleado_Id` int(11) NOT NULL,
  `TipoEmpleado_Nombre` varchar(45) NOT NULL,
  `TipoEmpleado_Descripcion` varchar(45) DEFAULT NULL,
  `FK_TipoHorario_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tipohorario`
--

CREATE TABLE `tipohorario` (
  `TipoHorario_Id` int(11) NOT NULL,
  `TipoHorario_Nombre` varchar(45) NOT NULL,
  `TipoHorario_Descripcion` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tipolicencia`
--

CREATE TABLE `tipolicencia` (
  `TipoLicencia_Id` int(11) NOT NULL,
  `TipoLicencia_Nombre` varchar(25) NOT NULL,
  `TipoLicencia_Descripcion` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `trabaja`
--

CREATE TABLE `trabaja` (
  `Trabaja_Id` int(11) NOT NULL,
  `Trabaja_FechaInicio` date NOT NULL,
  `Trabaja_FechaFin` date NOT NULL,
  `FK_HorarioRotativo_Id` int(11) DEFAULT NULL,
  `FK_Turno_Id` int(11) DEFAULT NULL,
  `FK_HorarioSemanal_Id` int(11) DEFAULT NULL,
  `FK_Empleado_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `turno`
--

CREATE TABLE `turno` (
  `Turno_Id` int(11) NOT NULL,
  `Turno_Nombre` varchar(30) NOT NULL,
  `Turno_Lunes` varchar(1) NOT NULL,
  `Turno_Martes` varchar(1) NOT NULL,
  `Turno_Miercoles` varchar(1) NOT NULL,
  `Turno_Jueves` varchar(1) NOT NULL,
  `Turno_Viernes` varchar(1) NOT NULL,
  `Turno_Sabado` varchar(1) NOT NULL,
  `Turno_Domingo` varchar(1) NOT NULL,
  `FK_Horario_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `Usuario_Id` int(11) NOT NULL,
  `Usuario_Nombre` varchar(45) NOT NULL,
  `Usuario_Apellido` varchar(45) NOT NULL,
  `Usuario_FechaAlta` date NOT NULL,
  `Usuario_Estado` varchar(8) NOT NULL DEFAULT 'Activo',
  `Usuario_Observaciones` varchar(45) DEFAULT NULL,
  `Usuario_FechaBaja` date DEFAULT NULL,
  `Usuario_Usuario` varchar(45) NOT NULL,
  `Usuario_Password` varchar(45) NOT NULL,
  `Usuario_Respuesta` varchar(45) DEFAULT NULL,
  `FK_GrupoUsuario_Id` int(11) NOT NULL,
  `FK_Pregunta_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`Usuario_Id`, `Usuario_Nombre`, `Usuario_Apellido`, `Usuario_FechaAlta`, `Usuario_Estado`, `Usuario_Observaciones`, `Usuario_FechaBaja`, `Usuario_Usuario`, `Usuario_Password`, `Usuario_Respuesta`, `FK_GrupoUsuario_Id`, `FK_Pregunta_Id`) VALUES
(1, 'Matias', 'Fiermarin', '2017-09-01', 'Alta', 'Administrador', NULL, 'admin', 'fiermarin', '1', 1, 1),
(2, 'Prueba', 'Prueba', '2017-09-12', 'Alta', 'Usuario Consulta', NULL, 'consulta', 'prueba', '1', 3, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ajuste`
--
ALTER TABLE `ajuste`
  ADD PRIMARY KEY (`Ajuste_Id`);

--
-- Indexes for table `archivo`
--
ALTER TABLE `archivo`
  ADD PRIMARY KEY (`Archivo_Id`),
  ADD KEY `fk_ARCHIVO_REPORTE1_idx` (`FK_Reporte_Id`);

--
-- Indexes for table `autorizacion`
--
ALTER TABLE `autorizacion`
  ADD PRIMARY KEY (`Autorizacion_Id`),
  ADD KEY `FK_RegistroEntrada_idx` (`Autorizacion_RegistroEntrada`),
  ADD KEY `FK_RegistroSalida_idx` (`Autorizacion_RegistroSalida`);

--
-- Indexes for table `conversacion`
--
ALTER TABLE `conversacion`
  ADD PRIMARY KEY (`Conversacion_Id`);

--
-- Indexes for table `dispositivobiometrico`
--
ALTER TABLE `dispositivobiometrico`
  ADD PRIMARY KEY (`DispositivoBiometrico_Id`),
  ADD KEY `fk_DISPOSITIVOBIOMETRICO_EMPRESA1_idx` (`Fk_Empresa_Id`);

--
-- Indexes for table `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`Empleado_Id`),
  ADD UNIQUE KEY `Empleado_Cedula_UNIQUE` (`Empleado_Cedula`),
  ADD UNIQUE KEY `Empleado_Codigo_UNIQUE` (`Empleado_Codigo`),
  ADD KEY `fk_EMPLEADO_TIPOEMPLEADO1_idx` (`FK_TipoEmpleado_Id`),
  ADD KEY `fk_EMPLEADO_OFICINA1_idx` (`FK_Oficina_Id`);

--
-- Indexes for table `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`Empresa_Id`);

--
-- Indexes for table `feriado`
--
ALTER TABLE `feriado`
  ADD PRIMARY KEY (`Feriado_Id`);

--
-- Indexes for table `grupoperfil`
--
ALTER TABLE `grupoperfil`
  ADD PRIMARY KEY (`FK_GrupoUsuario_Id`,`FK_Perfil_Id`),
  ADD KEY `FK_Perfil_Id_idx` (`FK_Perfil_Id`);

--
-- Indexes for table `grupousuario`
--
ALTER TABLE `grupousuario`
  ADD PRIMARY KEY (`GrupoUsuario_Id`);

--
-- Indexes for table `horario`
--
ALTER TABLE `horario`
  ADD PRIMARY KEY (`Horario_Id`);

--
-- Indexes for table `horariorotativo`
--
ALTER TABLE `horariorotativo`
  ADD PRIMARY KEY (`HorarioRotativo_Id`),
  ADD KEY `fk_HORARIOROTATIVO_HORARIO1_idx` (`FK_Horario_Id`);

--
-- Indexes for table `horariosemanal`
--
ALTER TABLE `horariosemanal`
  ADD PRIMARY KEY (`HorarioSemanal_Id`);

--
-- Indexes for table `licencia`
--
ALTER TABLE `licencia`
  ADD PRIMARY KEY (`Licencia_Id`),
  ADD KEY `fk_LICENCIA_TIPOLICENCIA1_idx` (`FK_TipoLicencia_Id`),
  ADD KEY `fk_LICENCIA_EMPLEADO1_idx` (`FK_Empleado_Id`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`Log_Id`),
  ADD KEY `fk_LOG_USUARIO1_idx` (`FK_Usuario_Id`);

--
-- Indexes for table `mensaje`
--
ALTER TABLE `mensaje`
  ADD PRIMARY KEY (`Mensaje_Id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`Menu_Id`);

--
-- Indexes for table `migracion`
--
ALTER TABLE `migracion`
  ADD PRIMARY KEY (`Migracion_Id`);

--
-- Indexes for table `modulo`
--
ALTER TABLE `modulo`
  ADD PRIMARY KEY (`Modulo_Id`);

--
-- Indexes for table `modulomenu`
--
ALTER TABLE `modulomenu`
  ADD PRIMARY KEY (`FK_Modulo_Id`,`FK_Menu_Id`),
  ADD KEY `fk_MODULOMENU_MODULO1_idx` (`FK_Modulo_Id`),
  ADD KEY `fk_MODULOMENU_MENU1_idx` (`FK_Menu_Id`);

--
-- Indexes for table `oficina`
--
ALTER TABLE `oficina`
  ADD PRIMARY KEY (`Oficina_Id`),
  ADD KEY `fk_OFICINA_SUCURSAL1_idx` (`FK_Sucursal_Id`),
  ADD KEY `fk_OFICINA_DISPOSITIVOBIOMETRICO1_idx` (`FK_DispositivoBiometrico_Id`);

--
-- Indexes for table `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`Perfil_Id`);

--
-- Indexes for table `perfilmodulo`
--
ALTER TABLE `perfilmodulo`
  ADD PRIMARY KEY (`FK_Perfil_Id`,`FK_Modulo_Id`),
  ADD KEY `fk_PERFIL_has_MODULO_MODULO1_idx` (`FK_Modulo_Id`),
  ADD KEY `fk_PERFIL_has_MODULO_PERFIL1_idx` (`FK_Perfil_Id`);

--
-- Indexes for table `permiso`
--
ALTER TABLE `permiso`
  ADD PRIMARY KEY (`Permiso_Id`);

--
-- Indexes for table `permiso_perfil`
--
ALTER TABLE `permiso_perfil`
  ADD PRIMARY KEY (`FK_Perfil_Id`,`FK_Permiso_Id`),
  ADD KEY `fk_PERFIL_has_PERMISOUSUARIO_PERMISOUSUARIO1_idx` (`FK_Permiso_Id`),
  ADD KEY `fk_PERFIL_has_PERMISOUSUARIO_PERFIL1_idx` (`FK_Perfil_Id`);

--
-- Indexes for table `preguntas`
--
ALTER TABLE `preguntas`
  ADD PRIMARY KEY (`Pregunta_Id`);

--
-- Indexes for table `recurso`
--
ALTER TABLE `recurso`
  ADD PRIMARY KEY (`Recurso_Id`);

--
-- Indexes for table `registros`
--
ALTER TABLE `registros`
  ADD PRIMARY KEY (`Registro_Id`),
  ADD KEY `fk_REGISTROS_EMPLEADO1_idx` (`FK_Empleado_Cedula`),
  ADD KEY `fk_REGISTROS_DISPOSITIVOBIOMETRICO1_idx` (`FK_DispositivoBiometrico_Id`);

--
-- Indexes for table `reporte`
--
ALTER TABLE `reporte`
  ADD PRIMARY KEY (`Reporte_Id`),
  ADD KEY `fk_REPORTE_USUARIO1_idx` (`FK_Usuario_Id`);

--
-- Indexes for table `sesion`
--
ALTER TABLE `sesion`
  ADD PRIMARY KEY (`Sesion_Id`),
  ADD KEY `fk_SESION_USUARIO1_idx` (`FK_Usuario_Id`);

--
-- Indexes for table `sucursal`
--
ALTER TABLE `sucursal`
  ADD PRIMARY KEY (`Sucursal_Id`),
  ADD KEY `fk_SUCURSAL_EMPRESA1_idx` (`FK_Empresa_Id`);

--
-- Indexes for table `tipoempleado`
--
ALTER TABLE `tipoempleado`
  ADD PRIMARY KEY (`TipoEmpleado_Id`),
  ADD KEY `fk_TIPOEMPLEADO_TIPOHORARIO1_idx` (`FK_TipoHorario_Id`);

--
-- Indexes for table `tipohorario`
--
ALTER TABLE `tipohorario`
  ADD PRIMARY KEY (`TipoHorario_Id`);

--
-- Indexes for table `tipolicencia`
--
ALTER TABLE `tipolicencia`
  ADD PRIMARY KEY (`TipoLicencia_Id`);

--
-- Indexes for table `trabaja`
--
ALTER TABLE `trabaja`
  ADD PRIMARY KEY (`Trabaja_Id`),
  ADD KEY `fk_Trabaja_HORARIOROTATIVO1_idx` (`FK_HorarioRotativo_Id`),
  ADD KEY `fk_Trabaja_TURNO1_idx` (`FK_Turno_Id`),
  ADD KEY `fk_Trabaja_HORARIOSEMANAL1_idx` (`FK_HorarioSemanal_Id`),
  ADD KEY `fk_Trabaja_EMPLEADO1_idx` (`FK_Empleado_Id`);

--
-- Indexes for table `turno`
--
ALTER TABLE `turno`
  ADD PRIMARY KEY (`Turno_Id`),
  ADD KEY `fk_TURNOS_HORARIOS_idx` (`FK_Horario_Id`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`Usuario_Id`),
  ADD UNIQUE KEY `Usuario_Usuario_UNIQUE` (`Usuario_Usuario`),
  ADD KEY `fk_USUARIO_GRUPOUSUARIO1_idx` (`FK_GrupoUsuario_Id`),
  ADD KEY `fk_USUARIO_PREGUNTAS1_idx` (`FK_Pregunta_Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ajuste`
--
ALTER TABLE `ajuste`
  MODIFY `Ajuste_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `archivo`
--
ALTER TABLE `archivo`
  MODIFY `Archivo_Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `conversacion`
--
ALTER TABLE `conversacion`
  MODIFY `Conversacion_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `dispositivobiometrico`
--
ALTER TABLE `dispositivobiometrico`
  MODIFY `DispositivoBiometrico_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `empleado`
--
ALTER TABLE `empleado`
  MODIFY `Empleado_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `empresa`
--
ALTER TABLE `empresa`
  MODIFY `Empresa_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `feriado`
--
ALTER TABLE `feriado`
  MODIFY `Feriado_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `grupousuario`
--
ALTER TABLE `grupousuario`
  MODIFY `GrupoUsuario_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `horario`
--
ALTER TABLE `horario`
  MODIFY `Horario_Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `horariorotativo`
--
ALTER TABLE `horariorotativo`
  MODIFY `HorarioRotativo_Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `horariosemanal`
--
ALTER TABLE `horariosemanal`
  MODIFY `HorarioSemanal_Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `licencia`
--
ALTER TABLE `licencia`
  MODIFY `Licencia_Id` int(11) NOT NULL AUTO_INCREMENT COMMENT '\n';
--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `Log_Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mensaje`
--
ALTER TABLE `mensaje`
  MODIFY `Mensaje_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `Menu_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;
--
-- AUTO_INCREMENT for table `modulo`
--
ALTER TABLE `modulo`
  MODIFY `Modulo_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `oficina`
--
ALTER TABLE `oficina`
  MODIFY `Oficina_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `perfil`
--
ALTER TABLE `perfil`
  MODIFY `Perfil_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `permiso`
--
ALTER TABLE `permiso`
  MODIFY `Permiso_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `preguntas`
--
ALTER TABLE `preguntas`
  MODIFY `Pregunta_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `recurso`
--
ALTER TABLE `recurso`
  MODIFY `Recurso_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `registros`
--
ALTER TABLE `registros`
  MODIFY `Registro_Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `reporte`
--
ALTER TABLE `reporte`
  MODIFY `Reporte_Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sesion`
--
ALTER TABLE `sesion`
  MODIFY `Sesion_Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sucursal`
--
ALTER TABLE `sucursal`
  MODIFY `Sucursal_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tipoempleado`
--
ALTER TABLE `tipoempleado`
  MODIFY `TipoEmpleado_Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tipohorario`
--
ALTER TABLE `tipohorario`
  MODIFY `TipoHorario_Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tipolicencia`
--
ALTER TABLE `tipolicencia`
  MODIFY `TipoLicencia_Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `trabaja`
--
ALTER TABLE `trabaja`
  MODIFY `Trabaja_Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `turno`
--
ALTER TABLE `turno`
  MODIFY `Turno_Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `Usuario_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `archivo`
--
ALTER TABLE `archivo`
  ADD CONSTRAINT `fk_ARCHIVO_REPORTE1` FOREIGN KEY (`FK_Reporte_Id`) REFERENCES `reporte` (`Reporte_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `autorizacion`
--
ALTER TABLE `autorizacion`
  ADD CONSTRAINT `FK_RegistroEntrada` FOREIGN KEY (`Autorizacion_RegistroEntrada`) REFERENCES `registros` (`Registro_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_RegistroSalida` FOREIGN KEY (`Autorizacion_RegistroSalida`) REFERENCES `registros` (`Registro_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `dispositivobiometrico`
--
ALTER TABLE `dispositivobiometrico`
  ADD CONSTRAINT `fk_DISPOSITIVOBIOMETRICO_EMPRESA1` FOREIGN KEY (`Fk_Empresa_Id`) REFERENCES `empresa` (`Empresa_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `empleado`
--
ALTER TABLE `empleado`
  ADD CONSTRAINT `fk_EMPLEADO_OFICINA1` FOREIGN KEY (`FK_Oficina_Id`) REFERENCES `oficina` (`Oficina_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `horariorotativo`
--
ALTER TABLE `horariorotativo`
  ADD CONSTRAINT `fk_HORARIOROTATIVO_HORARIO1` FOREIGN KEY (`FK_Horario_Id`) REFERENCES `horario` (`Horario_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `licencia`
--
ALTER TABLE `licencia`
  ADD CONSTRAINT `fk_LICENCIA_EMPLEADO1` FOREIGN KEY (`FK_Empleado_Id`) REFERENCES `empleado` (`Empleado_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_LICENCIA_TIPOLICENCIA1` FOREIGN KEY (`FK_TipoLicencia_Id`) REFERENCES `tipolicencia` (`TipoLicencia_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `log`
--
ALTER TABLE `log`
  ADD CONSTRAINT `fk_LOG_USUARIO1` FOREIGN KEY (`FK_Usuario_Id`) REFERENCES `usuario` (`Usuario_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `modulomenu`
--
ALTER TABLE `modulomenu`
  ADD CONSTRAINT `fk_MODULOMENU_MENU1` FOREIGN KEY (`FK_Menu_Id`) REFERENCES `menu` (`Menu_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_MODULOMENU_MODULO1` FOREIGN KEY (`FK_Modulo_Id`) REFERENCES `modulo` (`Modulo_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `oficina`
--
ALTER TABLE `oficina`
  ADD CONSTRAINT `fk_OFICINA_DISPOSITIVOBIOMETRICO1` FOREIGN KEY (`FK_DispositivoBiometrico_Id`) REFERENCES `dispositivobiometrico` (`DispositivoBiometrico_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_OFICINA_SUCURSAL1` FOREIGN KEY (`FK_Sucursal_Id`) REFERENCES `sucursal` (`Sucursal_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `perfilmodulo`
--
ALTER TABLE `perfilmodulo`
  ADD CONSTRAINT `fk_PERFIL_has_MODULO_MODULO1` FOREIGN KEY (`FK_Modulo_Id`) REFERENCES `modulo` (`Modulo_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_PERFIL_has_MODULO_PERFIL1` FOREIGN KEY (`FK_Perfil_Id`) REFERENCES `perfil` (`Perfil_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `permiso_perfil`
--
ALTER TABLE `permiso_perfil`
  ADD CONSTRAINT `fk_PERFIL_has_PERMISOUSUARIO_PERFIL1` FOREIGN KEY (`FK_Perfil_Id`) REFERENCES `perfil` (`Perfil_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_PERFIL_has_PERMISOUSUARIO_PERMISOUSUARIO1` FOREIGN KEY (`FK_Permiso_Id`) REFERENCES `permiso` (`Permiso_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `registros`
--
ALTER TABLE `registros`
  ADD CONSTRAINT `fk_REGISTROS_DISPOSITIVOBIOMETRICO1` FOREIGN KEY (`FK_DispositivoBiometrico_Id`) REFERENCES `dispositivobiometrico` (`DispositivoBiometrico_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_REGISTROS_EMPLEADO1` FOREIGN KEY (`FK_Empleado_Cedula`) REFERENCES `empleado` (`Empleado_Cedula`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `reporte`
--
ALTER TABLE `reporte`
  ADD CONSTRAINT `fk_REPORTE_USUARIO1` FOREIGN KEY (`FK_Usuario_Id`) REFERENCES `usuario` (`Usuario_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `sesion`
--
ALTER TABLE `sesion`
  ADD CONSTRAINT `fk_SESION_USUARIO1` FOREIGN KEY (`FK_Usuario_Id`) REFERENCES `usuario` (`Usuario_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `sucursal`
--
ALTER TABLE `sucursal`
  ADD CONSTRAINT `fk_SUCURSAL_EMPRESA1` FOREIGN KEY (`FK_Empresa_Id`) REFERENCES `empresa` (`Empresa_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tipoempleado`
--
ALTER TABLE `tipoempleado`
  ADD CONSTRAINT `fk_TIPOEMPLEADO_TIPOHORARIO1` FOREIGN KEY (`FK_TipoHorario_Id`) REFERENCES `tipohorario` (`TipoHorario_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `trabaja`
--
ALTER TABLE `trabaja`
  ADD CONSTRAINT `fk_Trabaja_EMPLEADO1` FOREIGN KEY (`FK_Empleado_Id`) REFERENCES `empleado` (`Empleado_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Trabaja_HORARIOROTATIVO1` FOREIGN KEY (`FK_HorarioRotativo_Id`) REFERENCES `horariorotativo` (`HorarioRotativo_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Trabaja_HORARIOSEMANAL1` FOREIGN KEY (`FK_HorarioSemanal_Id`) REFERENCES `horariosemanal` (`HorarioSemanal_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Trabaja_TURNO1` FOREIGN KEY (`FK_Turno_Id`) REFERENCES `turno` (`Turno_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `turno`
--
ALTER TABLE `turno`
  ADD CONSTRAINT `fk_TURNOS_HORARIOS` FOREIGN KEY (`FK_Horario_Id`) REFERENCES `horario` (`Horario_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_USUARIO_GRUPOUSUARIO1` FOREIGN KEY (`FK_GrupoUsuario_Id`) REFERENCES `grupousuario` (`GrupoUsuario_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_USUARIO_PREGUNTAS1` FOREIGN KEY (`FK_Pregunta_Id`) REFERENCES `preguntas` (`Pregunta_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
