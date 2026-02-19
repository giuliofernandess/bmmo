-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 16/02/2026 às 19:00
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `bmmo`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `band_groups`
--

CREATE TABLE `band_groups` (
  `group_id` int(11) NOT NULL,
  `group_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `band_groups`
--

INSERT INTO `band_groups` (`group_id`, `group_name`) VALUES
(1, 'Banda Principal'),
(2, 'Banda Auxiliar'),
(3, 'Escola de Música'),
(4, 'Fanfarra'),
(5, 'Flauta Doce');

-- --------------------------------------------------------

--
-- Estrutura para tabela `instruments`
--

CREATE TABLE `instruments` (
  `instrument_id` int(11) NOT NULL,
  `instrument_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `instruments`
--

INSERT INTO `instruments` (`instrument_id`, `instrument_name`) VALUES
(1, 'Flauta Doce'),
(2, 'Flauta'),
(3, 'Lira'),
(4, '1° Clarinete'),
(5, '2° Clarinete'),
(6, '3° Clarinete'),
(7, '1° Sax Alto'),
(8, '2° Sax Alto'),
(9, '3° Sax Alto'),
(10, '1° Sax Tenor'),
(11, '2° Sax Tenor'),
(12, '3° Sax Tenor'),
(13, '1° Trompete'),
(14, '2° Trompete'),
(15, '3° Trompete'),
(16, '1° Trompa'),
(17, '2° Trompa'),
(18, '3° Trompa'),
(19, '1° Trombone'),
(20, '2° Trombone'),
(21, '3° Trombone'),
(22, 'Bombardino'),
(23, 'Tuba'),
(24, 'Percussão'),
(25, 'Caixa'),
(26, 'Prato'),
(27, 'Tarol'),
(28, 'Bumbo');

-- --------------------------------------------------------

--
-- Estrutura para tabela `musical_scores`
--

CREATE TABLE `musical_scores` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `instrument` varchar(30) NOT NULL,
  `bandGroup` varchar(30) NOT NULL,
  `musicalGenre` varchar(50) NOT NULL,
  `file` tinytext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `musicians`
--

CREATE TABLE `musicians` (
  `musician_id` int(11) NOT NULL,
  `musician_name` varchar(255) NOT NULL,
  `musician_login` varchar(50) NOT NULL,
  `date_of_birth` date NOT NULL,
  `instrument` int(11) NOT NULL,
  `band_group` int(11) NOT NULL,
  `musician_contact` varchar(50) DEFAULT NULL,
  `responsible_name` varchar(255) DEFAULT NULL,
  `responsible_contact` varchar(50) DEFAULT NULL,
  `neighborhood` varchar(50) NOT NULL,
  `institution` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `news`
--

CREATE TABLE `news` (
  `news_id` int(11) NOT NULL,
  `news_title` varchar(255) NOT NULL,
  `news_subtitle` varchar(255) NOT NULL,
  `news_image` varchar(255) NOT NULL,
  `news_description` text NOT NULL,
  `publication_date` date NOT NULL,
  `publication_hour` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `regency`
--

CREATE TABLE `regency` (
  `regency_login` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `instruments`
--

INSERT INTO `band_groups` (`regency_login`, `password`) VALUES
('raul.anderson', 'Maestro@2026');

-- --------------------------------------------------------

--
-- Estrutura para tabela `repertoire`
--

CREATE TABLE `repertoire` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `date` varchar(30) NOT NULL,
  `hour` varchar(30) NOT NULL,
  `local` varchar(200) NOT NULL,
  `bandGroup` varchar(50) NOT NULL,
  `songs` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `band_groups`
--
ALTER TABLE `band_groups`
  ADD PRIMARY KEY (`group_id`);

--
-- Índices de tabela `instruments`
--
ALTER TABLE `instruments`
  ADD PRIMARY KEY (`instrument_id`);

--
-- Índices de tabela `musical_scores`
--
ALTER TABLE `musical_scores`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `musicians`
--
ALTER TABLE `musicians`
  ADD PRIMARY KEY (`musician_id`),
  ADD KEY `instrument` (`instrument`),
  ADD KEY `band_group` (`band_group`);

--
-- Índices de tabela `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`news_id`);

--
-- Índices de tabela `regency`
--
ALTER TABLE `regency`
  ADD PRIMARY KEY (`regency_login`);

--
-- Índices de tabela `repertoire`
--
ALTER TABLE `repertoire`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `band_groups`
--
ALTER TABLE `band_groups`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `instruments`
--
ALTER TABLE `instruments`
  MODIFY `instrument_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `musical_scores`
--
ALTER TABLE `musical_scores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `musicians`
--
ALTER TABLE `musicians`
  MODIFY `musician_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `news`
--
ALTER TABLE `news`
  MODIFY `news_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `repertoire`
--
ALTER TABLE `repertoire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `musicians`
--
ALTER TABLE `musicians`
  ADD CONSTRAINT `musicians_ibfk_1` FOREIGN KEY (`instrument`) REFERENCES `instruments` (`instrument_id`),
  ADD CONSTRAINT `musicians_ibfk_2` FOREIGN KEY (`band_group`) REFERENCES `band_groups` (`group_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
