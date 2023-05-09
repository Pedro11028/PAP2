-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 08-Maio-2023 às 17:46
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
-- Estrutura da tabela `avaliacao`
--

CREATE TABLE `avaliacao` (
  `Id_avaliacao` int(11) NOT NULL,
  `Id_utilizador` int(11) NOT NULL,
  `Id_quizz` int(11) NOT NULL,
  `textoAvaliacao` varchar(250) DEFAULT NULL,
  `nota` int(1) DEFAULT NULL,
  `gosto` int(11) DEFAULT NULL,
  `naoGosto` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `imagem_questao`
--

CREATE TABLE `imagem_questao` (
  `Id_imagemQuestao` int(11) NOT NULL,
  `Id_questao` int(11) NOT NULL,
  `imagemQuestao` varchar(250) DEFAULT NULL,
  `larguraImagem` varchar(5) DEFAULT NULL,
  `alturaImagem` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `noficacoes`
--

CREATE TABLE `noficacoes` (
  `Id_notificacao` int(11) NOT NULL,
  `Id_utilizador` int(11) NOT NULL,
  `texto` varchar(250) DEFAULT NULL,
  `tipo` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `questoes`
--

CREATE TABLE `questoes` (
  `Id_questao` int(11) NOT NULL,
  `Id_quizz` int(11) NOT NULL,
  `nomeQuestao` varchar(20) DEFAULT NULL,
  `textoQuestao` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `quizzes`
--

CREATE TABLE `quizzes` (
  `Id_quizz` int(11) NOT NULL,
  `Id_utilizador` int(11) NOT NULL,
  `nomeQuizz` varchar(40) DEFAULT NULL,
  `categoria` varchar(40) DEFAULT NULL,
  `escolaridade` varchar(20) DEFAULT NULL,
  `tema` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `quizzes_respondidos`
--

CREATE TABLE `quizzes_respondidos` (
  `Id_quizzRespondido` int(11) NOT NULL,
  `Id_utilizador` int(11) NOT NULL,
  `Id_quizz` int(11) NOT NULL,
  `valorAdquirido` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `respostas`
--

CREATE TABLE `respostas` (
  `Id_resposta` int(11) NOT NULL,
  `Id_questao` int(11) NOT NULL,
  `respostaQuizz` varchar(250) DEFAULT NULL,
  `valorResposta` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `utilizadores`
--

CREATE TABLE `utilizadores` (
  `Id_utilizador` int(11) NOT NULL,
  `nomeCompleto` varchar(60) DEFAULT NULL,
  `nomeUnico` varchar(60) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `password` varchar(120) DEFAULT NULL,
  `imagemPerfil` varchar(250) DEFAULT NULL,
  `dataBan` date DEFAULT NULL,
  `pontuacao` int(11) DEFAULT 0,
  `permissao` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `utilizadores`
--

INSERT INTO `utilizadores` (`Id_utilizador`, `nomeCompleto`, `nomeUnico`, `email`, `password`, `imagemPerfil`, `dataBan`, `pontuacao`, `permissao`) VALUES
(338, 'Pedro Oliveira', 'Pedr0siris', 'pedro@gmail.com', 'qaws1234', 'img/perfilPadrao.png', NULL, 0, 'utilizador'),
(341, 'aaa aaa', 'aaa', 'aaa@aaa.com', 'aaaaaaaa', 'img/perfilPadrao.png', NULL, 0, 'utilizador'),
(342, 'aaa aaa', 'aaabbb', 'aaa@bbb.com', 'aaabbbsa', 'img/perfilPadrao.png', NULL, 0, 'utilizador');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `avaliacao`
--
ALTER TABLE `avaliacao`
  ADD PRIMARY KEY (`Id_avaliacao`,`Id_utilizador`,`Id_quizz`),
  ADD KEY `Id_utilizador` (`Id_utilizador`),
  ADD KEY `Id_quizz` (`Id_quizz`);

--
-- Índices para tabela `imagem_questao`
--
ALTER TABLE `imagem_questao`
  ADD PRIMARY KEY (`Id_imagemQuestao`,`Id_questao`),
  ADD KEY `Id_questao` (`Id_questao`);

--
-- Índices para tabela `noficacoes`
--
ALTER TABLE `noficacoes`
  ADD PRIMARY KEY (`Id_notificacao`,`Id_utilizador`),
  ADD KEY `Id_utilizador` (`Id_utilizador`);

--
-- Índices para tabela `questoes`
--
ALTER TABLE `questoes`
  ADD PRIMARY KEY (`Id_questao`,`Id_quizz`),
  ADD KEY `Id_quizz` (`Id_quizz`);

--
-- Índices para tabela `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`Id_quizz`,`Id_utilizador`),
  ADD KEY `Id_utilizador` (`Id_utilizador`);

--
-- Índices para tabela `quizzes_respondidos`
--
ALTER TABLE `quizzes_respondidos`
  ADD PRIMARY KEY (`Id_quizzRespondido`,`Id_utilizador`,`Id_quizz`),
  ADD KEY `Id_utilizador` (`Id_utilizador`),
  ADD KEY `Id_quizz` (`Id_quizz`);

--
-- Índices para tabela `respostas`
--
ALTER TABLE `respostas`
  ADD PRIMARY KEY (`Id_resposta`,`Id_questao`),
  ADD KEY `Id_questao` (`Id_questao`);

--
-- Índices para tabela `utilizadores`
--
ALTER TABLE `utilizadores`
  ADD PRIMARY KEY (`Id_utilizador`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `avaliacao`
--
ALTER TABLE `avaliacao`
  MODIFY `Id_avaliacao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `imagem_questao`
--
ALTER TABLE `imagem_questao`
  MODIFY `Id_imagemQuestao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `noficacoes`
--
ALTER TABLE `noficacoes`
  MODIFY `Id_notificacao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `questoes`
--
ALTER TABLE `questoes`
  MODIFY `Id_questao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `Id_quizz` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `quizzes_respondidos`
--
ALTER TABLE `quizzes_respondidos`
  MODIFY `Id_quizzRespondido` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `respostas`
--
ALTER TABLE `respostas`
  MODIFY `Id_resposta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `utilizadores`
--
ALTER TABLE `utilizadores`
  MODIFY `Id_utilizador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=343;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `avaliacao`
--
ALTER TABLE `avaliacao`
  ADD CONSTRAINT `avaliacao_ibfk_1` FOREIGN KEY (`Id_utilizador`) REFERENCES `utilizadores` (`Id_utilizador`),
  ADD CONSTRAINT `avaliacao_ibfk_2` FOREIGN KEY (`Id_quizz`) REFERENCES `quizzes` (`Id_quizz`);

--
-- Limitadores para a tabela `imagem_questao`
--
ALTER TABLE `imagem_questao`
  ADD CONSTRAINT `imagem_questao_ibfk_1` FOREIGN KEY (`Id_questao`) REFERENCES `questoes` (`Id_questao`);

--
-- Limitadores para a tabela `noficacoes`
--
ALTER TABLE `noficacoes`
  ADD CONSTRAINT `noficacoes_ibfk_1` FOREIGN KEY (`Id_utilizador`) REFERENCES `utilizadores` (`Id_utilizador`);

--
-- Limitadores para a tabela `questoes`
--
ALTER TABLE `questoes`
  ADD CONSTRAINT `questoes_ibfk_1` FOREIGN KEY (`Id_quizz`) REFERENCES `quizzes` (`Id_quizz`);

--
-- Limitadores para a tabela `quizzes`
--
ALTER TABLE `quizzes`
  ADD CONSTRAINT `quizzes_ibfk_1` FOREIGN KEY (`Id_utilizador`) REFERENCES `utilizadores` (`Id_utilizador`);

--
-- Limitadores para a tabela `quizzes_respondidos`
--
ALTER TABLE `quizzes_respondidos`
  ADD CONSTRAINT `quizzes_respondidos_ibfk_1` FOREIGN KEY (`Id_utilizador`) REFERENCES `utilizadores` (`Id_utilizador`),
  ADD CONSTRAINT `quizzes_respondidos_ibfk_2` FOREIGN KEY (`Id_quizz`) REFERENCES `quizzes` (`Id_quizz`);

--
-- Limitadores para a tabela `respostas`
--
ALTER TABLE `respostas`
  ADD CONSTRAINT `respostas_ibfk_1` FOREIGN KEY (`Id_questao`) REFERENCES `questoes` (`Id_questao`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
