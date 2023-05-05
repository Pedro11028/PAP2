-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 20-Abr-2023 às 17:52
-- Versão do servidor: 10.4.21-MariaDB
-- versão do PHP: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `papbd`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `avaliacoes`
--

CREATE TABLE `avaliacoes` (
  `Id_avaliacao` int(11) NOT NULL,
  `Id_utilizador` int(11) DEFAULT NULL,
  `Id_quizz` int(11) DEFAULT NULL,
  `pontuacao` int(11) DEFAULT NULL,
  `texto` varchar(250) DEFAULT NULL,
  `num_likes` int(11) DEFAULT NULL,
  `num_deslikes` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `perguntasquizz`
--

CREATE TABLE `perguntasquizz` (
  `Id_pergunta` int(11) NOT NULL,
  `Id_quizz` int(11) NOT NULL,
  `questao` varchar(250) DEFAULT NULL,
  `respostaCorreta` varchar(250) DEFAULT NULL,
  `resErrada_1` varchar(250) DEFAULT NULL,
  `resErrada_2` varchar(250) DEFAULT NULL,
  `resErrada_3` varchar(250) DEFAULT NULL,
  `imagem` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `quizzes`
--

CREATE TABLE `quizzes` (
  `Id_quizz` int(11) NOT NULL,
  `Id_utilizador` int(11) NOT NULL,
  `nome` varchar(60) DEFAULT NULL,
  `tipo` varchar(40) DEFAULT NULL,
  `Data_criação` date DEFAULT NULL,
  `qualificação` int(11) DEFAULT NULL,
  `quant_avaliacoes` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `utilizadores`
--

CREATE TABLE `utilizadores` (
  `Id_utilizador` int(11) NOT NULL,
  `nome` varchar(60) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `password` varchar(60) DEFAULT NULL,
  `quizzCriados` int(6) DEFAULT 0,
  `pontuacao` int(11) DEFAULT 0,
  `quizzesRealizados` int(6) DEFAULT 0,
  `num_avaliações` int(11) DEFAULT 0,
  `imagemPerfil` varchar(250) NOT NULL,
  `nomeUnico` varchar(20) NOT NULL,
  `Permissao` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `utilizadores`
--

INSERT INTO `utilizadores` (`Id_utilizador`, `nome`, `email`, `password`, `quizzCriados`, `pontuacao`, `quizzesRealizados`, `num_avaliações`, `imagemPerfil`, `nomeUnico`, `Permissao`) VALUES
(1, 'Pedro Oliveira', 'pedro@gmail.com', '12345678', 0, 200, 0, 0, 'img/testes.jpg', 'pedr0siris', 1),
(22, 'bbb bbb', 'aaa@aaa.com', 'qwas1234', 0, 200, 0, 0, 'img/perfilPadrao.png', 'aaa', 0),
(23, 'aaa', 'aaa@bbb.com', '12345678', 0, 0, 0, 0, 'img/perfilPadrao.png', 'bbb aaa', 0),
(25, 'Pedro Oliveira', 'pedro@aaa.com', '12345678', 0, 200, 0, 0, 'img/perfilPadrao.png', 'Pedraaa', 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `avaliacoes`
--
ALTER TABLE `avaliacoes`
  ADD PRIMARY KEY (`Id_avaliacao`),
  ADD KEY `Id_utilizador` (`Id_utilizador`),
  ADD KEY `Id_quizz` (`Id_quizz`);

--
-- Índices para tabela `perguntasquizz`
--
ALTER TABLE `perguntasquizz`
  ADD PRIMARY KEY (`Id_pergunta`,`Id_quizz`),
  ADD KEY `Id_quizz` (`Id_quizz`);

--
-- Índices para tabela `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`Id_quizz`,`Id_utilizador`),
  ADD KEY `Id_utilizador` (`Id_utilizador`);

--
-- Índices para tabela `utilizadores`
--
ALTER TABLE `utilizadores`
  ADD PRIMARY KEY (`Id_utilizador`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `avaliacoes`
--
ALTER TABLE `avaliacoes`
  MODIFY `Id_avaliacao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `perguntasquizz`
--
ALTER TABLE `perguntasquizz`
  MODIFY `Id_pergunta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `Id_quizz` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `utilizadores`
--
ALTER TABLE `utilizadores`
  MODIFY `Id_utilizador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `avaliacoes`
--
ALTER TABLE `avaliacoes`
  ADD CONSTRAINT `avaliacoes_ibfk_1` FOREIGN KEY (`Id_utilizador`) REFERENCES `utilizadores` (`Id_utilizador`),
  ADD CONSTRAINT `avaliacoes_ibfk_2` FOREIGN KEY (`Id_quizz`) REFERENCES `quizzes` (`Id_quizz`);

--
-- Limitadores para a tabela `perguntasquizz`
--
ALTER TABLE `perguntasquizz`
  ADD CONSTRAINT `perguntasquizz_ibfk_1` FOREIGN KEY (`Id_quizz`) REFERENCES `quizzes` (`Id_quizz`);

--
-- Limitadores para a tabela `quizzes`
--
ALTER TABLE `quizzes`
  ADD CONSTRAINT `quizzes_ibfk_1` FOREIGN KEY (`Id_utilizador`) REFERENCES `utilizadores` (`Id_utilizador`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
