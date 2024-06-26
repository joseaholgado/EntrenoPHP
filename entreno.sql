-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: db
-- Tiempo de generación: 09-11-2023 a las 10:19:18
-- Versión del servidor: 8.1.0
-- Versión de PHP: 8.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */
/*!40101 SET NAMES utf8mb4 */

--
-- Base de datos: `entrenamientos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Musculo`
--
  CREATE TABLE `musculo` (
    idMusculo INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    imagen_musculo VARCHAR(200)
);

--
-- Volcado de datos para la tabla `musculo`
--
INSERT INTO musculo (nombre, imagen_musculo) VALUES 
    ('Pecho', './img/pecho.jpg'),
    ('Dorsales', './img/dorsales.jpg'),
    ('Hombros', './img/hombros.jpg'),
    ('Piernas', './img/piernas.png'),
    ('Brazos', './img/brazos.jpg');
  

--
-- Estructura de tabla para la tabla `entrenamiento`
--
CREATE TABLE `entrenamiento` (
  `idEntrenamiento` INT NOT NULL,
  `nombre` VARCHAR(255) NOT NULL,
  `musculo_id` INT NOT NULL, -- Cambié el nombre de la columna para reflejar que es una clave externa
  `explicacion` TEXT NOT NULL,
  `imagen_ejercicio` VARCHAR(255) DEFAULT NULL,
  `dificultad` DECIMAL(10, 6) NOT NULL,
  FOREIGN KEY (`musculo_id`) REFERENCES `musculo`(`idMusculo`) -- Cambié el nombre de la columna referenciada
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `entrenamiento`
--
INSERT INTO `entrenamiento` (`idEntrenamiento`, `nombre`, `musculo_id`, `explicacion`, `imagen_ejercicio`, `dificultad`) VALUES
(1, 'Flexiones', 1,
'1-Colócate en posición de plancha, manos ligeramente más anchas que los hombros, cuerpo recto.
2-Baja tu cuerpo hacia el suelo doblando los codos.
3-Empuja el suelo para volver a la posición inicial.', 'https://www.entrenamientos.com/media/cache/exercise_375/uploads/exercise/flexiones-de-brazos-init-pos-8882.png', 4.000000),
(2, 'Dominadas', 2, 
'1-Agarra una barra con las palmas mirando hacia adelante, ligeramente más anchas que los hombros.
2-Levántate con los brazos extendidos.
3-Jala tu cuerpo hacia arriba, doblando los codos hasta que el mentón esté sobre la barra.
4-Baja controladamente hasta la posición inicial.', 'https://i.blogs.es/d9578d/dominadas/650_1200.jpg', 4.100000),
(3, 'Press Militar', 3,
'1-Comienza de pie con los pies a la altura de los hombros, sosteniendo una barra a la altura de los hombros con las palmas mirando hacia adelante.
2-Empuja la barra hacia arriba extendiendo los brazos, manteniendo el núcleo comprometido.
3-Baja la barra lentamente hacia la posición inicial, evitando arquear la espalda.', 'https://mundoentrenamiento.com/wp-content/uploads/2019/06/press-militar-con-mancuernas.webp', 6.40000),
(4, 'Sentadilla libre', 4, 
'1-Comienza de pie, con los pies a la anchura de los hombros o un poco más separados, y la barra apoyada sobre los hombros o sostenida detrás de la cabeza.
2-Desciende flexionando las rodillas y las caderas, manteniendo la espalda recta y el pecho hacia arriba.
3-Baja hasta que tus muslos estén aproximadamente paralelos al suelo o hasta donde sea cómodo para ti.
4-Vuelve a la posición inicial empujando con los talones y extendiendo las caderas.', 'https://eresfitness.com/wp-content/uploads/11971105-Squat-m_Thighs_max.webp', 6.200000),
(5, 'Peso Muerto', 4,
'1-Empieza de pie frente a la barra con los pies a la anchura de los hombros y la barra sobre el mediopié.
2-Agáchate para agarrar la barra con las manos separadas al ancho de los hombros y las palmas mirando hacia ti.
3-Manteniendo la espalda recta y el pecho hacia arriba, levanta la barra estirando las piernas y extendiendo las caderas.
4-Baja la barra de manera controlada, manteniendo la espalda recta, flexionando las caderas y las rodillas.', 'https://fitgeneration.es/wp-content/uploads/2023/04/Peso-muerto-3-1024x495.png', 8.400000),
(6, 'Curl de biceps', 5,
'1-Comienza de pie, con los pies a la anchura de los hombros, sosteniendo una mancuerna o barra con las palmas hacia adelante, los brazos extendidos hacia abajo y los codos cerca del cuerpo.
2-Levanta el peso flexionando los codos, acercando la mancuerna hacia los hombros.
3-Mantén los codos pegados al cuerpo y evita balancear el torso.
4-Baja el peso controladamente a la posición inicial, manteniendo la tensión en los bíceps.', 'https://www.entrenamientos.com/media/cache/exercise_375/uploads/exercise/curl-de-biceps-de-pie-con-mancuernas-agarre-en-pronacion-init-pos-2023.png', 3.700000),
(7, 'Katana extensions en polea.', 5, 
'1-Comienza ajustando una polea alta con una cuerda en el gimnasio.
2-Agarra la cuerda con ambas manos, manteniendo los codos cerca del cuerpo y las palmas hacia abajo.
3-Mantén una postura firme y una ligera inclinación hacia adelante desde la cadera para estabilizar tu cuerpo.
4-Extiende los codos hacia abajo y hacia atrás, llevando las manos hacia el suelo manteniendo los brazos cerca de tu cuerpo.
5-Contrayendo los tríceps, regresa lentamente a la posición inicial, controlando el movimiento.', 'https://www.mipielsana.com/wp-content/uploads/2012/12/One-Arm-Standing-Overhead-Cable-Tricep-Extension-900x600.jpg', 4.500000),
(8, 'Subidas a un step/escalón', 4,
'1-Comienza de pie frente al step con los pies a la anchura de los hombros.
2-Coloca un pie en el step, presionando con el talón para levantar tu cuerpo hacia arriba.
3-Sube el segundo pie para unirlo al primero en la parte superior del step.
4-Baja un pie y luego el otro de vuelta al suelo, manteniendo un ritmo constante.', 'https://s3.abcstatics.com/media/bienestar/2020/03/23/subida-escalon-k7PE--510x287@abc.jpg', 1.000000);
(9, 'Aperturas con mancuernas', 1,
'1-Acuéstate en un banco plano con una mancuerna en cada mano, brazos extendidos hacia arriba.
2-Baja los brazos hacia los lados manteniendo una ligera flexión en los codos.
3-Regresa a la posición inicial.', 'https://i.blogs.es/5c0b8f/aperturas/450_1000.webp', 3.800000),
(10, 'Flexiones diamante', 1,
'1-Adopta la posición de flexión con las manos juntas formando un triángulo debajo del pecho.
2-Baja el cuerpo manteniendo los codos cerca del torso.
3-Regresa a la posición inicial.', 'https://qph.cf2.quoracdn.net/main-qimg-b2a29dfa09efd332ce2ada8498454ceb-lq', 4.200000),
(11, 'Remo con barra', 2,
'1-Inclínate hacia adelante con la espalda recta, agarra la barra con las palmas mirando hacia abajo y los brazos extendidos.
2-Lleva la barra hacia el abdomen manteniendo los codos pegados al cuerpo.
3-Baja la barra de manera controlada.', 'https://www.entrenamientos.com/media/cache/exercise_375/uploads/exercise/remo-con-barra-de-pie-init-pos-6237.png', 5.000000),
(12, 'Peso muerto rumano', 4,
'1-Sujeta una barra con las manos separadas a la altura de los hombros, piernas casi rectas.
2-Inclínate desde las caderas manteniendo la espalda recta.
3-Baja la barra hacia las espinillas manteniendo las piernas ligeramente flexionadas.
4-Regresa a la posición inicial.', 'https://i.ytimg.com/vi/UU6AS_iHPyI/maxresdefault.jpg', 6.300000),
(13, 'Elevaciones laterales con mancuernas', 3,
'1-De pie, con una mancuerna en cada mano, levanta los brazos hacia los lados.
2-Baja los brazos controladamente.', 'https://eresfitness.com/wp-content/uploads/2019/09/Elevaciones-laterales-con-mancuernas.jpg.webp', 4.500000),
(14, 'Press Arnold', 3,
'1-Sentado con mancuernas en las manos, brazos a la altura de los hombros, palmas mirándote.
2-Levanta las mancuernas y gira las muñecas para llevarlas arriba.
3-Baja las mancuernas y gira las muñecas de regreso a la posición inicial.', 'https://eresfitness.com/wp-content/uploads/21371105-Dumbbell-Arnold-Press_Shoulders_max.webp', 5.800000);
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `pass` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(150) NOT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `email`, `pass`, `nombre`, `apellido`, `foto`) VALUES
(1, 'jose@prueba.com', '$2y$10$MjW5SzYG8duxBEwUWEN4.uMGPVZN1QtAFU/G18aydkvu8RtoMQS46', 'jose', 'prueba', NULL);


--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `idUsuario` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `pass` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(150) NOT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


--
-- Índices para tablas volcadas
--

INSERT INTO `administrador` (`idUsuario`, `email`, `pass`, `nombre`, `apellido`, `foto`) VALUES
(1, 'admin@prueba.com', '$2y$10$MjW5SzYG8duxBEwUWEN4.uMGPVZN1QtAFU/G18aydkvu8RtoMQS46', 'admin', 'pruebote', NULL);

--
-- Indices de la tabla `entrenamiento`
--
ALTER TABLE `entrenamiento`
  ADD PRIMARY KEY (`idEntrenamiento`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`),
  ADD UNIQUE KEY `email` (`email`);

  --
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`idUsuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `entrenamiento`
--
ALTER TABLE `entrenamiento`
  MODIFY `idEntrenamiento` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

--
-- AUTO_INCREMENT de la tabla `administrador`
--
ALTER TABLE `administrador`
  MODIFY `idUsuario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
