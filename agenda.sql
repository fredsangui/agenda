-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 06-Abr-2020 às 22:51
-- Versão do servidor: 10.4.8-MariaDB
-- versão do PHP: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `agenda`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `setores`
--

CREATE TABLE `setores` (
  `setor` int(11) NOT NULL,
  `responsavel` int(11) DEFAULT NULL,
  `email` varchar(64) DEFAULT NULL,
  `nome` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `telefones`
--

CREATE TABLE `telefones` (
  `telefoneid` int(11) NOT NULL,
  `telefone` varchar(32) DEFAULT NULL,
  `usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `telefones`
--

INSERT INTO `telefones` (`telefoneid`, `telefone`, `usuario`) VALUES
(1, '1111111111', 1),
(2, '2222222222', 2),
(3, '3333333333', 3),
(4, '4444444444', 4),
(5, '777777777', 9),
(6, '997655445', 8),
(7, '41229944557', 10);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `usuario` int(11) NOT NULL,
  `senha` varchar(32) DEFAULT NULL,
  `endereco` varchar(128) DEFAULT NULL,
  `nome` varchar(64) DEFAULT NULL,
  `email` varchar(64) DEFAULT NULL,
  `setor` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`usuario`, `senha`, `endereco`, `nome`, `email`, `setor`) VALUES
(1, '202cb962ac59075b964b07152d234b70', NULL, 'admin', NULL, 'teste'),
(2, '202cb962ac59075b964b07152d234b70', 'rua', 'fred', NULL, 'teste'),
(3, '202cb962ac59075b964b07152d234b70', NULL, 'jennifer', NULL, 'teste'),
(4, '202cb962ac59075b964b07152d234b70', NULL, 'juninho', 'jonin@kanoha.jp', 'teste'),
(5, '202cb962ac59075b964b07152d234b70', NULL, 'nao vai funcionar', 'fock@kanoha.jp', 'teste'),
(6, '202cb962ac59075b964b07152d234b70', NULL, 'jao', 'fock@kanoha.jp', 'teste'),
(7, '202cb962ac59075b964b07152d234b70', NULL, 'fred c tell 2', 'jonin@kanoha.jp', 'teste'),
(8, '202cb962ac59075b964b07152d234b70', NULL, 'Ronaldo', 'ronald@penta.com.br', 'teste'),
(9, 'caf1a3dfb505ffed0d024130f58c5cfa', NULL, 'alex', 'alex@teste.com', 'TI'),
(10, '202cb962ac59075b964b07152d234b70', NULL, 'joana', 'jo@teste.com', 'teste');

--
-- Acionadores `usuarios`
--
DELIMITER $$
CREATE TRIGGER `increment_usuario` BEFORE INSERT ON `usuarios` FOR EACH ROW set new.usuario = (SELECT MAX(usuario) from usuarios) + 1
$$
DELIMITER ;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `setores`
--
ALTER TABLE `setores`
  ADD PRIMARY KEY (`setor`);

--
-- Índices para tabela `telefones`
--
ALTER TABLE `telefones`
  ADD PRIMARY KEY (`telefoneid`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usuario`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `setores`
--
ALTER TABLE `setores`
  MODIFY `setor` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `telefones`
--
ALTER TABLE `telefones`
  MODIFY `telefoneid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
