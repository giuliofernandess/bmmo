-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 26/09/2025 às 20:45
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
-- Estrutura para tabela `agenda`
--

CREATE TABLE `agenda` (
  `id` int(11) NOT NULL,
  `sunday` varchar(1000) NOT NULL,
  `monday` varchar(1000) NOT NULL,
  `tuesday` varchar(1000) NOT NULL,
  `wednesday` varchar(1000) NOT NULL,
  `thursday` varchar(1000) NOT NULL,
  `friday` varchar(1000) NOT NULL,
  `saturday` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `agenda`
--

INSERT INTO `agenda` (`id`, `sunday`, `monday`, `tuesday`, `wednesday`, `thursday`, `friday`, `saturday`) VALUES
(1, 'Folga', 'Tocata', 'Folga', 'Sala aberta', 'Ensaio', 'Tocata', 'Ensaio'),
(2, 'Folga', 'Tocata', 'Folga', 'Sala aberta', 'Ensaio', 'Tocata', 'Folga'),
(3, 'Folga', 'Tocata', 'Folga', 'Sala aberta', 'Ensaio', 'Tocata', 'Ensaio'),
(4, 'Folga', 'Ensaio', 'Folga', 'Sala aberta', 'Ensaio', 'Tocata', 'Folga'),
(5, 'Folga', 'Ensaio', 'Sala aberta', 'Sala aberta', 'Ensaio', 'Tocata', 'Ensaio');

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
  `file` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `musical_scores`
--

INSERT INTO `musical_scores` (`id`, `name`, `instrument`, `bandGroup`, `musicalGenre`, `file`) VALUES
(1, 'Stand By Me', '1 Alto Sax', 'Fanfarra', 'Internacionais', 'profile_68cc49b41d35f3.46631892.pdf'),
(2, 'Stand By Me', '2 Alto Sax', 'Fanfarra', 'Internacionais', 'profile_68cc5174359a84.92695050.pdf');

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

--
-- Despejando dados para a tabela `musicians`
--

INSERT INTO `musicians` (`idMusician`, `name`, `login`, `dateOfBirth`, `instrument`, `bandGroup`, `telephone`, `responsible`, `telephoneOfResponsible`, `neighborhood`, `institution`, `password`) VALUES
(98, 'Giulio', 'giulio123', '2007-06-21', '1 Alto Sax', '', '(85) 98237-6209', 'Leonilde Alves Barbosa Fernandes', '(00) 00000-0000', 'São Marcos', 'Môsa', '12345678'),
(99, 'Jão', 'jao123', '2004-05-21', 'Bumbo', 'Fanfarra', '(00) 00000-0000', '', '', 'Outro', 'Môsa', '12345678');

-- --------------------------------------------------------

--
-- Estrutura para tabela `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `subtitle` varchar(500) NOT NULL,
  `image` varchar(100) NOT NULL,
  `text` varchar(2000) NOT NULL,
  `date` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `news`
--

INSERT INTO `news` (`id`, `title`, `subtitle`, `image`, `text`, `date`) VALUES
(3, 'Jakeline Alves é a nova integrante da banda de música', 'A musicista chega na sede amanhã(29)', 'profile_68b09862ae6237.54746971.jpg', 'Ela chega para substituir seu primo Giulio', '28-08-2025'),
(4, 'Banda de Música recebe novo fardamento', 'A blusa casual gola polo vem pro 7 de setembro', 'profile_68b195f906dcc9.05756967.jpg', 'Estreia na sexta feira (6) de setembro no desfile municipal', '29-08-2025'),
(5, 'Veja o calendário da BMMO no 7 de setembro', 'São 6 tocatas em 4 dias', 'profile_68b97857c76b33.12615076.jpg', '04/09 - Redenção\r\n05/09 - IEMA ( Ocara )\r\n05/09 - Ocara\r\n06/09 - Banabuiú\r\n07/09 - Quixadá\r\n07/09 - Ibicuitinga', '04-09-2025');

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
-- Índices de tabela `agenda`
--
ALTER TABLE `agenda`
  ADD PRIMARY KEY (`id`);

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
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `regency`
--
ALTER TABLE `regency`
  ADD PRIMARY KEY (`login`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `musical_scores`
--
ALTER TABLE `musical_scores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `musicians`
--
ALTER TABLE `musicians`
  MODIFY `idMusician` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT de tabela `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
