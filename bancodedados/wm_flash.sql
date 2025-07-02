-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 22/06/2025 às 17:30
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
-- Banco de dados: `wm_flash`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `funcionarios`
--

CREATE TABLE `funcionarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `telefone` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `funcionarios`
--

INSERT INTO `funcionarios` (`id`, `nome`, `email`, `senha`, `criado_em`, `telefone`) VALUES
(14, 'weverton', 'weverton.araujo@a.ficr.edu.br', '$2y$10$gKcIiSxcwfdOaUI2dFo5Ue724ZJhDtt/OdhN9tCt7BvShsfE./Lri', '2025-06-22 15:15:20', '81988227739'),
(15, 'Maria Gabriela', 'mariagabriela@gmail.com', '$2y$10$DXOuPbH8yeQzoCCfInzzue1aWj6lpaxmptPtHsgTwh/R9KVu4oKDC', '2025-06-22 15:19:25', '81988334456'),
(16, 'ana', 'ana@gmail.com', '$2y$10$Efq6SoxTRF5QkstmWKGk3ewnk9/h1q30gFTFxfC5Bjy.U/yuM5JWK', '2025-06-22 15:20:38', '81988227730'),
(17, 'willams', 'willamsbld8@gmail.com', '$2y$10$3QT8xxiAdq/MKR.H1sDjlOROrXI8NUjevkt2wW59V0ynTzwOSCGnm', '2025-06-22 15:24:25', '81988227739');

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `modelo` varchar(100) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `cor` varchar(50) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `usuario_id` int(11) NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `funcionario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id`, `modelo`, `nome`, `preco`, `quantidade`, `cor`, `descricao`, `usuario_id`, `criado_em`, `funcionario_id`) VALUES
(8, '', 'IPhone 12', 3500.00, 1, 'Azul', 'oioi', 0, '2025-06-22 15:15:52', 14),
(9, '', 'IPhone 15', 7000.00, 5, 'Preto', 'oioi', 0, '2025-06-22 15:16:25', 14),
(10, '', 'IPhone 12', 3500.00, 3, 'Azul', 'oie', 0, '2025-06-22 15:19:51', 15),
(11, '', 'IPhone 13', 4500.00, 5, 'Branco', 'kkkkk', 0, '2025-06-22 15:22:14', 16),
(12, '', 'IPhone 12', 3500.00, 1, 'Azul', 'kkkkk', 0, '2025-06-22 15:25:44', 17),
(13, '', 'IPhone 14', 5500.00, 5, 'Branco', 'oie', 0, '2025-06-22 15:25:59', 17);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
