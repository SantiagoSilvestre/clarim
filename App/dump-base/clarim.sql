-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 27-Jul-2020 às 17:40
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
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `campeonato`
--

INSERT INTO `campeonato` (`id`, `nome`, `finalizado`, `regulamento`, `created`) VALUES
(1, 'Campeonato Teste', 0, 'Este é apenas um teste para ver se o campeonato está salvando', '2020-07-21 00:00:00'),
(2, 'teste 2', 0, NULL, '2020-07-21 00:00:00'),
(6, 'teste 54', 0, 'tasteate ', '2020-07-25 21:14:45');

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
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `cam_ativo`
--

INSERT INTO `cam_ativo` (`id`, `id_campeonato`, `id_time`, `vitorias`, `derrotas`, `empates`, `pontuacao`, `saldo_gol`, `gol_pro`, `gol_contra`, `cartao_ver`, `cartao_amer`, `created`) VALUES
(1, 1, 1, 1, 0, 0, 14, 5, 3, 1, 1, 1, '2020-07-21 00:00:00'),
(2, 1, 2, 1, 0, 0, 14, 5, 3, 1, 1, 1, '2020-07-30 00:00:00');

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

--
-- Extraindo dados da tabela `contato`
--

INSERT INTO `contato` (`id`, `nome`, `email`, `telefone`, `assunto`, `mensagem`, `visualizada`, `respondida`, `created`) VALUES
(3, 'Zeze', 'zeze@zeze.com', '1198666666', 'teste', 'aqui vai a primeira mensagem', 0, 0, '2020-07-24 18:02:49'),
(4, 'teste 2', 'san@gmail.com', 'fasdfdsfaf', 'fasdf', 'fdasdfdasfaffffdasfadsdff', 0, 0, '2020-07-24 18:05:02'),
(5, 'teste', 'san@gmail.com', '11986311912', 'fsdaf', 'f', 1, 0, '2020-07-24 18:14:01'),
(6, 'Silvestre', 'silvestre.santiago306@gmail.com', '98631-1912', 'assunto', '12345678912345.', 1, 1, '2020-07-24 18:22:00'),
(7, 'teste 2', 'san@gmail.com', 'fasdf', 'assunto', 'ffghgfgjkghhj', 1, 1, '2020-07-24 20:57:04'),
(8, 'teste ', 'silvestre.santiago306@gmail.com', 'fsadfsfda', 'assunto', 'fadsfdfasdfsadfdsafsadfsdf', 1, 1, '2020-07-26 17:33:32');

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
(1, 'time 28', '2020-07-21 00:00:00'),
(2, 'time FC', '2020-07-25 00:00:00'),
(3, 'time Da pesada', '2020-07-25 22:28:48');

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
(1, 'san', 'san@teste.com', 'b6991377dec961ac0273d38d7b8bd609', 1),
(2, 'santiago', 'santiago@teste.com.br', 'b6991377dec961ac0273d38d7b8bd609', 1),
(3, 'rogerio', 'rogerio@teste.com', '12345678', 0);

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
(2, 'Poesia 7', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/G4eTjFvp8CU\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>'),
(3, 'Bilhete 2.0', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/XIW95Seof90\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>'),
(5, 'Pitty - Teto de Vidro (Clipe Oficial)', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/hWhl6ijsAXw\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>'),
(6, 'Egoísmo e flow', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/aNkpwj4Vq8U\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>'),
(7, 'Poesia Acústica Paris', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/z6_tNgUEZe4\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `campeonato`
--
ALTER TABLE `campeonato`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `cam_ativo`
--
ALTER TABLE `cam_ativo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contato`
--
ALTER TABLE `contato`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `time`
--
ALTER TABLE `time`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `cam_ativo`
--
ALTER TABLE `cam_ativo`
  ADD CONSTRAINT `cam_ativo_ibfk_1` FOREIGN KEY (`id_campeonato`) REFERENCES `campeonato` (`id`),
  ADD CONSTRAINT `cam_ativo_ibfk_2` FOREIGN KEY (`id_time`) REFERENCES `time` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;