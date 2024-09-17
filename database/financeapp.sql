-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 17/09/2024 às 16:01
-- Versão do servidor: 8.3.0
-- Versão do PHP: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `financeapp`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `transacoes`
--

DROP TABLE IF EXISTS `transacoes`;
CREATE TABLE IF NOT EXISTS `transacoes` (
  `transacao_id` int NOT NULL AUTO_INCREMENT,
  `valor` float NOT NULL,
  `nome_transacao` varchar(30) NOT NULL,
  `data` date NOT NULL,
  `tipo_transacao` tinyint(1) NOT NULL,
  `categoria` varchar(20) DEFAULT NULL,
  `usuario_id` int DEFAULT NULL,
  PRIMARY KEY (`transacao_id`),
  KEY `fk_usuario_id` (`usuario_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `transacoes`
--

INSERT INTO `transacoes` (`transacao_id`, `valor`, `nome_transacao`, `data`, `tipo_transacao`, `categoria`, `usuario_id`) VALUES
(15, 1000, 'salario', '2024-08-21', 1, NULL, NULL),
(8, 100, 'celular', '2024-08-18', 0, NULL, NULL),
(14, 200, 'teste', '2024-08-19', 0, NULL, NULL),
(17, 100, 'carne', '2024-09-17', 0, 'mercado', 3);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `usuario_id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(100) NOT NULL,
  PRIMARY KEY (`usuario_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`usuario_id`, `nome`, `email`, `senha`) VALUES
(1, 'Mark Smith Jr Jr', 'marksmith@gmail.com', '$2y$10$K3GyrJ33FdZo3pMKREGRb.pQ/nZ9lWYWKqHDhQX52XTTt24UbjWge'),
(3, 'Mark Smith 2', 'marksmith2@gmail.com', '$2y$10$Ms91P/yzs.dSp1dW5AeBnuVRzKMT31wKs5ynNRCDUc/Zegyedcf6W');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
