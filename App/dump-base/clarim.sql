-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 10, 2020 at 11:23 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `clarim`
--

-- --------------------------------------------------------

--
-- Table structure for table `campeonato`
--

CREATE TABLE `campeonato` (
  `id` int(11) NOT NULL,
  `nome` varchar(80) NOT NULL,
  `finalizado` int(11) NOT NULL DEFAULT 0,
  `regulamento` text DEFAULT NULL,
  `estilo` int(11) NOT NULL DEFAULT 0,
  `qtd_times` int(11) DEFAULT NULL,
  `times_cadastrados` int(11) NOT NULL,
  `fase_inicial` int(11) DEFAULT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `campeonato_finalizado`
--

CREATE TABLE `campeonato_finalizado` (
  `id` int(11) NOT NULL,
  `id_campeonato` int(11) NOT NULL,
  `id_time_camp` int(11) NOT NULL,
  `data_finalizado` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cam_ativo`
--

CREATE TABLE `cam_ativo` (
  `id` int(11) NOT NULL,
  `id_campeonato` int(11) NOT NULL,
  `id_time` int(11) NOT NULL,
  `vitorias` int(11) NOT NULL DEFAULT 0,
  `derrotas` int(11) NOT NULL DEFAULT 0,
  `empates` int(11) NOT NULL DEFAULT 0,
  `pontuacao` int(11) NOT NULL,
  `saldo_gol` int(11) NOT NULL,
  `gol_pro` int(11) NOT NULL,
  `gol_contra` int(11) NOT NULL,
  `cartao_ver` int(11) NOT NULL,
  `cartao_amer` int(11) NOT NULL,
  `eliminado` int(11) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `contato`
--

CREATE TABLE `contato` (
  `id` int(11) NOT NULL,
  `nome` varchar(80) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefone` varchar(60) NOT NULL,
  `assunto` varchar(60) NOT NULL,
  `mensagem` text NOT NULL,
  `visualizada` int(11) NOT NULL DEFAULT 0,
  `respondida` int(11) NOT NULL DEFAULT 0,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `id_user_check` int(11) NOT NULL,
  `title` varchar(65) NOT NULL,
  `time1` varchar(60) NOT NULL,
  `time2` varchar(60) NOT NULL,
  `gol_time1` int(11) DEFAULT NULL,
  `gol_time2` int(11) DEFAULT NULL,
  `id_horario` int(11) NOT NULL,
  `data` datetime NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fases`
--

CREATE TABLE `fases` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `qtd_jogos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fases`
--

INSERT INTO `fases` (`id`, `nome`, `qtd_jogos`) VALUES
(1, '1º fase', 16),
(2, 'Oitavas de final', 8),
(3, 'Quartas de final', 4),
(4, 'Semi-Final', 2),
(5, 'Final', 1);

-- --------------------------------------------------------

--
-- Table structure for table `horarios`
--

CREATE TABLE `horarios` (
  `id` int(11) NOT NULL,
  `horario` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `horarios`
--

INSERT INTO `horarios` (`id`, `horario`) VALUES
(1, '21:00'),
(2, '22:00'),
(3, '23:00'),
(4, '00:00');

-- --------------------------------------------------------

--
-- Table structure for table `jogos`
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

-- --------------------------------------------------------

--
-- Table structure for table `jogo_mata`
--

CREATE TABLE `jogo_mata` (
  `id` int(11) NOT NULL,
  `id_time1` int(11) NOT NULL,
  `id_time2` int(11) DEFAULT NULL,
  `resultado` int(11) DEFAULT NULL,
  `id_fase` int(11) NOT NULL,
  `id_campeonato` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `perfil`
--

CREATE TABLE `perfil` (
  `id` int(11) NOT NULL,
  `nome` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `perfil`
--

INSERT INTO `perfil` (`id`, `nome`) VALUES
(1, 'Administrador'),
(2, 'Padrao');

-- --------------------------------------------------------

--
-- Table structure for table `perfil_permissao`
--

CREATE TABLE `perfil_permissao` (
  `id` int(11) NOT NULL,
  `id_perfil` int(11) NOT NULL,
  `id_permissao` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `perfil_permissao`
--

INSERT INTO `perfil_permissao` (`id`, `id_perfil`, `id_permissao`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 2, 2),
(10, 1, 9),
(11, 2, 3),
(12, 1, 10),
(13, 2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `permissao`
--

CREATE TABLE `permissao` (
  `id` int(11) NOT NULL,
  `descricao` varchar(65) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permissao`
--

INSERT INTO `permissao` (`id`, `descricao`) VALUES
(1, 'dashboard'),
(2, 'agenda'),
(3, 'list_campeonato'),
(4, 'listar_jogos'),
(5, 'list_mensagens'),
(6, 'list_times'),
(7, 'list_usuario'),
(8, 'list_video'),
(9, 'list_camp_finalizado'),
(10, 'acoes');

-- --------------------------------------------------------

--
-- Table structure for table `solicitacao_senha`
--

CREATE TABLE `solicitacao_senha` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `resetado` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `time`
--

CREATE TABLE `time` (
  `id` int(11) NOT NULL,
  `time` varchar(80) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nome` varchar(80) NOT NULL,
  `email` varchar(220) NOT NULL,
  `senha` varchar(60) NOT NULL DEFAULT '12345678',
  `primeiro_acesso` int(1) NOT NULL DEFAULT 0,
  `id_perfil` int(11) NOT NULL,
  `id_time` int(11) DEFAULT NULL,
  `creditos` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `email`, `senha`, `primeiro_acesso`, `id_perfil`, `id_time`, `creditos`) VALUES
(1, 'san', 'san@teste.com', 'b6991377dec961ac0273d38d7b8bd609', 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `id` int(11) NOT NULL,
  `nome` varchar(60) NOT NULL,
  `link` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_hourevent` (`id_horario`),
  ADD KEY `id_user_check` (`id_user_check`);

--
-- Indexes for table `fases`
--
ALTER TABLE `fases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `horarios`
--
ALTER TABLE `horarios`
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
-- Indexes for table `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `perfil_permissao`
--
ALTER TABLE `perfil_permissao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_perfizzaco` (`id_perfil`),
  ADD KEY `fk_permicaozao` (`id_permissao`);

--
-- Indexes for table `permissao`
--
ALTER TABLE `permissao`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `solicitacao_senha`
--
ALTER TABLE `solicitacao_senha`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_userSenha` (`id_usuario`);

--
-- Indexes for table `time`
--
ALTER TABLE `time`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_perfiluser` (`id_perfil`),
  ADD KEY `fk_usertime` (`id_time`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `campeonato_finalizado`
--
ALTER TABLE `campeonato_finalizado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cam_ativo`
--
ALTER TABLE `cam_ativo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `contato`
--
ALTER TABLE `contato`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `fases`
--
ALTER TABLE `fases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `horarios`
--
ALTER TABLE `horarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jogos`
--
ALTER TABLE `jogos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jogo_mata`
--
ALTER TABLE `jogo_mata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `perfil`
--
ALTER TABLE `perfil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `perfil_permissao`
--
ALTER TABLE `perfil_permissao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `permissao`
--
ALTER TABLE `permissao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `solicitacao_senha`
--
ALTER TABLE `solicitacao_senha`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `time`
--
ALTER TABLE `time`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `campeonato`
--
ALTER TABLE `campeonato`
  ADD CONSTRAINT `fk_fase` FOREIGN KEY (`fase_inicial`) REFERENCES `fases` (`id`);

--
-- Constraints for table `campeonato_finalizado`
--
ALTER TABLE `campeonato_finalizado`
  ADD CONSTRAINT `fk_cm` FOREIGN KEY (`id_campeonato`) REFERENCES `campeonato` (`id`),
  ADD CONSTRAINT `fk_tm` FOREIGN KEY (`id_time_camp`) REFERENCES `time` (`id`);

--
-- Constraints for table `cam_ativo`
--
ALTER TABLE `cam_ativo`
  ADD CONSTRAINT `cam_ativo_ibfk_1` FOREIGN KEY (`id_campeonato`) REFERENCES `campeonato` (`id`),
  ADD CONSTRAINT `cam_ativo_ibfk_2` FOREIGN KEY (`id_time`) REFERENCES `time` (`id`);

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`id_user_check`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `fk_hourevent` FOREIGN KEY (`id_horario`) REFERENCES `horarios` (`id`);

--
-- Constraints for table `jogos`
--
ALTER TABLE `jogos`
  ADD CONSTRAINT `fk_cp` FOREIGN KEY (`Id_campeonato`) REFERENCES `campeonato` (`id`),
  ADD CONSTRAINT `fk_tm1` FOREIGN KEY (`id_time1`) REFERENCES `time` (`id`),
  ADD CONSTRAINT `fk_tm1j` FOREIGN KEY (`id_time1`) REFERENCES `time` (`id`),
  ADD CONSTRAINT `fk_tm2j` FOREIGN KEY (`id_time2`) REFERENCES `time` (`id`);

--
-- Constraints for table `jogo_mata`
--
ALTER TABLE `jogo_mata`
  ADD CONSTRAINT `fk_cp1` FOREIGN KEY (`id_campeonato`) REFERENCES `campeonato` (`id`),
  ADD CONSTRAINT `fk_fasejm` FOREIGN KEY (`id_fase`) REFERENCES `fases` (`id`),
  ADD CONSTRAINT `fk_tm1jm` FOREIGN KEY (`id_time1`) REFERENCES `time` (`id`),
  ADD CONSTRAINT `fk_tm2jm` FOREIGN KEY (`id_time2`) REFERENCES `time` (`id`);

--
-- Constraints for table `perfil_permissao`
--
ALTER TABLE `perfil_permissao`
  ADD CONSTRAINT `fk_perfizzaco` FOREIGN KEY (`id_perfil`) REFERENCES `perfil` (`id`),
  ADD CONSTRAINT `fk_permicaozao` FOREIGN KEY (`id_permissao`) REFERENCES `permissao` (`id`);

--
-- Constraints for table `solicitacao_senha`
--
ALTER TABLE `solicitacao_senha`
  ADD CONSTRAINT `fk_userSenha` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`);

--
-- Constraints for table `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_perfiluser` FOREIGN KEY (`id_perfil`) REFERENCES `perfil` (`id`),
  ADD CONSTRAINT `fk_usertime` FOREIGN KEY (`id_time`) REFERENCES `time` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
