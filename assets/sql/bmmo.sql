-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 19/02/2026 às 20:03
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
(4, 'Clarinete'),
(5, 'Sax Alto'),
(6, 'Sax Tenor'),
(7, 'Trompete'),
(8, 'Trompa'),
(9, 'Trombone'),
(10, '1° Clarinete'),
(11, '2° Clarinete'),
(12, '3° Clarinete'),
(13, '1° Sax Alto'),
(14, '2° Sax Alto'),
(15, '3° Sax Alto'),
(16, '1° Sax Tenor'),
(17, '2° Sax Tenor'),
(18, '3° Sax Tenor'),
(19, '1° Trompete'),
(20, '2° Trompete'),
(21, '3° Trompete'),
(22, '1° Trompa'),
(23, '2° Trompa'),
(24, '3° Trompa'),
(25, '1° Trombone'),
(26, '2° Trombone'),
(27, '3° Trombone'),
(28, 'Bombardino'),
(29, 'Tuba'),
(30, 'Percussão'),
(31, 'Caixa'),
(32, 'Prato'),
(33, 'Tarol'),
(34, 'Bumbo');

-- --------------------------------------------------------

--
-- Estrutura para tabela `musical_scores`
--

CREATE TABLE `musical_scores` (
  `music_id` int(11) NOT NULL,
  `music_name` varchar(100) NOT NULL,
  `instrument` int(11) NOT NULL,
  `band_groups` int(11) NOT NULL,
  `musical_genre` varchar(100) NOT NULL,
  `file` tinytext NOT NULL
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
-- Estrutura para tabela `music_group`
--

CREATE TABLE `music_group` (
  `id` int(11) NOT NULL,
  `musical_score` int(11) NOT NULL,
  `band_group` int(11) NOT NULL
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
-- Despejando dados para a tabela `regency`
--

INSERT INTO `regency` (`regency_login`, `password`) VALUES
('raul.anderson', '$2y$10$hZWNXejXKRn4gFOnWMR7pO.ZbDszPJM.clGqi2OsKgp1G.QQNLGqG');

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
  ADD PRIMARY KEY (`music_id`),
  ADD KEY `musical_scores_ibfk_1` (`instrument`),
  ADD KEY `musical_scores_ibfk_2` (`band_groups`);

--
-- Índices de tabela `musicians`
--
ALTER TABLE `musicians`
  ADD PRIMARY KEY (`musician_id`),
  ADD KEY `instrument` (`instrument`),
  ADD KEY `band_group` (`band_group`);

--
-- Índices de tabela `music_group`
--
ALTER TABLE `music_group`
  ADD PRIMARY KEY (`id`),
  ADD KEY `music_group_ibfk_1` (`musical_score`),
  ADD KEY `music_group_ibfk_2` (`band_group`);

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
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `instruments`
--
ALTER TABLE `instruments`
  MODIFY `instrument_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de tabela `musical_scores`
--
ALTER TABLE `musical_scores`
  MODIFY `music_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `musicians`
--
ALTER TABLE `musicians`
  MODIFY `musician_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `music_group`
--
ALTER TABLE `music_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
-- Restrições para tabelas `musical_scores`
--
ALTER TABLE `musical_scores`
  ADD CONSTRAINT `musical_scores_ibfk_1` FOREIGN KEY (`instrument`) REFERENCES `instruments` (`instrument_id`),
  ADD CONSTRAINT `musical_scores_ibfk_2` FOREIGN KEY (`band_groups`) REFERENCES `music_group` (`id`);

--
-- Restrições para tabelas `musicians`
--
ALTER TABLE `musicians`
  ADD CONSTRAINT `musicians_ibfk_1` FOREIGN KEY (`instrument`) REFERENCES `instruments` (`instrument_id`),
  ADD CONSTRAINT `musicians_ibfk_2` FOREIGN KEY (`band_group`) REFERENCES `band_groups` (`group_id`);

--
-- Restrições para tabelas `music_group`
--
ALTER TABLE `music_group`
  ADD CONSTRAINT `music_group_ibfk_1` FOREIGN KEY (`musical_score`) REFERENCES `musical_scores` (`music_id`),
  ADD CONSTRAINT `music_group_ibfk_2` FOREIGN KEY (`band_group`) REFERENCES `band_groups` (`group_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
