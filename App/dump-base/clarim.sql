-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 03-Ago-2020 às 23:42
-- Versão do servidor: 10.1.37-MariaDB
-- versão do PHP: 7.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `clarim`
--
CREATE DATABASE IF NOT EXISTS `clarim` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `clarim`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `campeonato`
--

CREATE TABLE `campeonato` (
  `id` int(11) NOT NULL,
  `nome` varchar(80) NOT NULL,
  `finalizado` int(11) NOT NULL DEFAULT '0',
  `regulamento` text,
  `estilo` int(11) NOT NULL DEFAULT '0',
  `qtd_times` int(11) DEFAULT NULL,
  `times_cadastrados` int(11) NOT NULL,
  `fase_inicial` int(11) DEFAULT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `campeonato`
--

INSERT INTO `campeonato` (`id`, `nome`, `finalizado`, `regulamento`, `estilo`, `qtd_times`, `times_cadastrados`, `fase_inicial`, `created`) VALUES
(2, 'Campeonato 1', 1, 'campeonato de pontos corridos\r\n', 0, NULL, 2, NULL, '2020-08-01 18:33:49'),
(3, 'campeonato 2', 1, 'este é um teste para ver  se esta indo o mata-mata ', 1, 4, 4, 5, '2020-08-03 21:11:31'),
(4, 'campeonato teste 3', 1, 'teste dafffffffffff', 1, 4, 4, 5, '2020-08-03 21:14:13'),
(5, 'Campeonato pontos corrido edit 1', 1, 'este é um campeonato de pontos corridos é isso ai', 0, NULL, 3, NULL, '2020-08-03 21:16:38'),
(6, 'teste mata 5', 1, 'ffffffffffffffffffffffffffffffff', 1, 4, 4, 5, '2020-08-03 22:14:17');

-- --------------------------------------------------------

--
-- Estrutura da tabela `campeonato_finalizado`
--

CREATE TABLE `campeonato_finalizado` (
  `id` int(11) NOT NULL,
  `id_campeonato` int(11) NOT NULL,
  `id_time_camp` int(11) NOT NULL,
  `data_finalizado` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `campeonato_finalizado`
--

INSERT INTO `campeonato_finalizado` (`id`, `id_campeonato`, `id_time_camp`, `data_finalizado`) VALUES
(1, 2, 1, '2020-08-03 21:20:04'),
(2, 4, 1, '2020-08-03 22:07:42'),
(3, 3, 2, '2020-08-03 22:10:12'),
(4, 5, 1, '2020-08-03 22:14:03'),
(5, 6, 4, '2020-08-03 22:15:32');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cam_ativo`
--

CREATE TABLE `cam_ativo` (
  `id` int(11) NOT NULL,
  `id_campeonato` int(11) NOT NULL,
  `id_time` int(11) NOT NULL,
  `vitorias` int(11) NOT NULL DEFAULT '0',
  `derrotas` int(11) NOT NULL DEFAULT '0',
  `empates` int(11) NOT NULL DEFAULT '0',
  `pontuacao` int(11) NOT NULL,
  `saldo_gol` int(11) NOT NULL,
  `gol_pro` int(11) NOT NULL,
  `gol_contra` int(11) NOT NULL,
  `cartao_ver` int(11) NOT NULL,
  `cartao_amer` int(11) NOT NULL,
  `eliminado` int(11) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `cam_ativo`
--

INSERT INTO `cam_ativo` (`id`, `id_campeonato`, `id_time`, `vitorias`, `derrotas`, `empates`, `pontuacao`, `saldo_gol`, `gol_pro`, `gol_contra`, `cartao_ver`, `cartao_amer`, `eliminado`, `created`) VALUES
(1, 2, 1, 0, 0, 1, 1, 0, 1, 1, 0, 0, 0, '2020-08-01 18:34:05'),
(2, 2, 2, 0, 0, 1, 1, 0, 1, 1, 0, 0, 0, '2020-08-03 21:19:35'),
(3, 3, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-08-03 21:20:16'),
(4, 3, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-08-03 21:20:21'),
(5, 4, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-08-03 21:34:47'),
(6, 4, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-08-03 21:34:51'),
(7, 4, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-08-03 21:36:10'),
(8, 4, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-08-03 21:36:14'),
(9, 5, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-08-03 22:06:56'),
(10, 5, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-08-03 22:06:59'),
(11, 3, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-08-03 22:09:30'),
(12, 3, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-08-03 22:09:33'),
(13, 5, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-08-03 22:14:01'),
(14, 6, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-08-03 22:14:26'),
(15, 6, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-08-03 22:14:29'),
(16, 6, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-08-03 22:14:31'),
(17, 6, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-08-03 22:14:35');

-- --------------------------------------------------------

--
-- Estrutura da tabela `contato`
--

CREATE TABLE `contato` (
  `id` int(11) NOT NULL,
  `nome` varchar(80) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefone` varchar(60) NOT NULL,
  `assunto` varchar(60) NOT NULL,
  `mensagem` text NOT NULL,
  `visualizada` int(11) NOT NULL DEFAULT '0',
  `respondida` int(11) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `fases`
--

CREATE TABLE `fases` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `qtd_jogos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `fases`
--

INSERT INTO `fases` (`id`, `nome`, `qtd_jogos`) VALUES
(1, '1º fase', 16),
(2, 'Oitavas de final', 8),
(3, 'Quartas de final', 4),
(4, 'Semi-Final', 2),
(5, 'Final', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `jogos`
--

CREATE TABLE `jogos` (
  `id` int(11) NOT NULL,
  `id_time1` int(11) NOT NULL,
  `id_time2` int(11) NOT NULL,
  `gol_time1` int(11) NOT NULL,
  `gol_time2` int(11) NOT NULL,
  `data` datetime NOT NULL,
  `Id_campeonato` int(11) NOT NULL,
  `craque_do_jogo` varchar(220) DEFAULT NULL,
  `craque_time1` varchar(60) DEFAULT NULL,
  `craque_time2` varchar(60) DEFAULT NULL,
  `pcraque1` int(11) DEFAULT NULL,
  `pcraque2` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `jogos`
--

INSERT INTO `jogos` (`id`, `id_time1`, `id_time2`, `gol_time1`, `gol_time2`, `data`, `Id_campeonato`, `craque_do_jogo`, `craque_time1`, `craque_time2`, `pcraque1`, `pcraque2`) VALUES
(1, 1, 2, 1, 1, '2020-08-03 21:19:57', 2, '10100', 'Jose de arimatieia', '10100', 11, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `jogo_mata`
--

CREATE TABLE `jogo_mata` (
  `id` int(11) NOT NULL,
  `id_time1` int(11) NOT NULL,
  `id_time2` int(11) DEFAULT NULL,
  `resultado` int(11) DEFAULT NULL,
  `id_fase` int(11) NOT NULL,
  `id_campeonato` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `jogo_mata`
--

INSERT INTO `jogo_mata` (`id`, `id_time1`, `id_time2`, `resultado`, `id_fase`, `id_campeonato`) VALUES
(1, 1, 2, 1, 4, 4),
(2, 3, 4, 3, 4, 4),
(3, 1, 3, 3, 5, 4),
(4, 1, 2, 2, 4, 3),
(5, 4, 3, 4, 4, 3),
(6, 4, 2, 4, 5, 3),
(7, 2, 4, 4, 4, 6),
(8, 3, 1, 3, 4, 6),
(9, 3, 4, 4, 5, 6);

-- --------------------------------------------------------

--
-- Estrutura da tabela `time`
--

CREATE TABLE `time` (
  `id` int(11) NOT NULL,
  `time` varchar(80) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `time`
--

INSERT INTO `time` (`id`, `time`, `created`) VALUES
(1, 'time 1', '2020-08-01 18:33:57'),
(2, 'time 2', '2020-08-03 21:10:39'),
(3, 'time 3', '2020-08-03 21:35:00'),
(4, 'time 4', '2020-08-03 21:35:16');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nome` varchar(80) NOT NULL,
  `email` varchar(220) NOT NULL,
  `senha` varchar(60) NOT NULL DEFAULT '12345678',
  `primeiro_acesso` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `email`, `senha`, `primeiro_acesso`) VALUES
(1, 'san', 'san@teste.com', 'b6991377dec961ac0273d38d7b8bd609', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `videos`
--

CREATE TABLE `videos` (
  `id` int(11) NOT NULL,
  `nome` varchar(60) NOT NULL,
  `link` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `videos`
--

INSERT INTO `videos` (`id`, `nome`, `link`) VALUES
(1, 'organico verão', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/lxhqCcrnTv4\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `campeonato`
--
ALTER TABLE `campeonato`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_fase` (`fase_inicial`);

--
-- Indexes for table `campeonato_finalizado`
--
ALTER TABLE `campeonato_finalizado`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `fk_cm` (`id_campeonato`),
  ADD KEY `fk_tm` (`id_time_camp`);

--
-- Indexes for table `cam_ativo`
--
ALTER TABLE `cam_ativo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_campeonato` (`id_campeonato`),
  ADD KEY `id_time` (`id_time`);

--
-- Indexes for table `contato`
--
ALTER TABLE `contato`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fases`
--
ALTER TABLE `fases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jogos`
--
ALTER TABLE `jogos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tm1j` (`id_time1`),
  ADD KEY `fk_tm2j` (`id_time2`),
  ADD KEY `fk_cp` (`Id_campeonato`);

--
-- Indexes for table `jogo_mata`
--
ALTER TABLE `jogo_mata`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tm1jm` (`id_time1`),
  ADD KEY `fk_tm2jm` (`id_time2`),
  ADD KEY `fk_cp1` (`id_campeonato`),
  ADD KEY `fk_fasejm` (`id_fase`);

--
-- Indexes for table `time`
--
ALTER TABLE `time`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `campeonato`
--
ALTER TABLE `campeonato`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `campeonato_finalizado`
--
ALTER TABLE `campeonato_finalizado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cam_ativo`
--
ALTER TABLE `cam_ativo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `contato`
--
ALTER TABLE `contato`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fases`
--
ALTER TABLE `fases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jogos`
--
ALTER TABLE `jogos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jogo_mata`
--
ALTER TABLE `jogo_mata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `time`
--
ALTER TABLE `time`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `campeonato`
--
ALTER TABLE `campeonato`
  ADD CONSTRAINT `fk_fase` FOREIGN KEY (`fase_inicial`) REFERENCES `fases` (`id`);

--
-- Limitadores para a tabela `campeonato_finalizado`
--
ALTER TABLE `campeonato_finalizado`
  ADD CONSTRAINT `fk_cm` FOREIGN KEY (`id_campeonato`) REFERENCES `campeonato` (`id`),
  ADD CONSTRAINT `fk_tm` FOREIGN KEY (`id_time_camp`) REFERENCES `time` (`id`);

--
-- Limitadores para a tabela `cam_ativo`
--
ALTER TABLE `cam_ativo`
  ADD CONSTRAINT `cam_ativo_ibfk_1` FOREIGN KEY (`id_campeonato`) REFERENCES `campeonato` (`id`),
  ADD CONSTRAINT `cam_ativo_ibfk_2` FOREIGN KEY (`id_time`) REFERENCES `time` (`id`);

--
-- Limitadores para a tabela `jogos`
--
ALTER TABLE `jogos`
  ADD CONSTRAINT `fk_cp` FOREIGN KEY (`Id_campeonato`) REFERENCES `campeonato` (`id`),
  ADD CONSTRAINT `fk_tm1` FOREIGN KEY (`id_time1`) REFERENCES `time` (`id`),
  ADD CONSTRAINT `fk_tm1j` FOREIGN KEY (`id_time1`) REFERENCES `time` (`id`),
  ADD CONSTRAINT `fk_tm2j` FOREIGN KEY (`id_time2`) REFERENCES `time` (`id`);

--
-- Limitadores para a tabela `jogo_mata`
--
ALTER TABLE `jogo_mata`
  ADD CONSTRAINT `fk_cp1` FOREIGN KEY (`id_campeonato`) REFERENCES `campeonato` (`id`),
  ADD CONSTRAINT `fk_fasejm` FOREIGN KEY (`id_fase`) REFERENCES `fases` (`id`),
  ADD CONSTRAINT `fk_tm1jm` FOREIGN KEY (`id_time1`) REFERENCES `time` (`id`),
  ADD CONSTRAINT `fk_tm2jm` FOREIGN KEY (`id_time2`) REFERENCES `time` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
