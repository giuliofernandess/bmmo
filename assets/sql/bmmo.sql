-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 16/02/2026 às 15:22
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
  `idMusician` int(11) NOT NULL,
  `name` varchar(80) NOT NULL,
  `login` varchar(20) NOT NULL,
  `dateOfBirth` varchar(10) NOT NULL,
  `instrument` varchar(30) NOT NULL,
  `bandGroup` varchar(30) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `responsible` varchar(60) NOT NULL,
  `telephoneOfResponsible` varchar(20) NOT NULL,
  `neighborhood` varchar(40) NOT NULL,
  `institution` varchar(60) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `news`
--

CREATE TABLE `news` (
  `news_id` int(11) NOT NULL,
  `news_title` tinytext NOT NULL,
  `news_subtitle` tinytext NOT NULL,
  `news_image` tinytext NOT NULL,
  `news_description` text NOT NULL,
  `publication_date` date NOT NULL,
  `publication_hour` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `regency`
--

CREATE TABLE `regency` (
  `regency_login` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `regency`
--

INSERT INTO `regency` (`regency_login`, `password`) VALUES
('raul', 'raulanderson');

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
-- Índices de tabela `musical_scores`
--
ALTER TABLE `musical_scores`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `musicians`
--
ALTER TABLE `musicians`
  ADD PRIMARY KEY (`idMusician`);

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
-- AUTO_INCREMENT de tabela `musical_scores`
--
ALTER TABLE `musical_scores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000;

--
-- AUTO_INCREMENT de tabela `musicians`
--
ALTER TABLE `musicians`
  MODIFY `idMusician` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `news`
--
ALTER TABLE `news`
  MODIFY `news_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `repertoire`
--
ALTER TABLE `repertoire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
