-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 16/08/2025 às 19:28
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
-- Estrutura para tabela `musicians`
--

CREATE TABLE `musicians` (
  `idMusician` int(11) NOT NULL,
  `name` varchar(80) NOT NULL,
  `dateOfBirth` varchar(10) NOT NULL,
  `instrument` varchar(30) NOT NULL,
  `yearOfAdmission` int(4) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `responsible` varchar(60) NOT NULL,
  `telephoneOfResponsible` varchar(20) NOT NULL,
  `neighborhood` varchar(40) NOT NULL,
  `institution` varchar(60) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `regency`
--

CREATE TABLE `regency` (
  `login` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `regency`
--

INSERT INTO `regency` (`login`, `password`) VALUES
('raul', 'raulanderson');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `musicians`
--
ALTER TABLE `musicians`
  ADD PRIMARY KEY (`idMusician`);

--
-- Índices de tabela `regency`
--
ALTER TABLE `regency`
  ADD PRIMARY KEY (`login`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `musicians`
--
ALTER TABLE `musicians`
  MODIFY `idMusician` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
