-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 15-Jun-2023 às 00:38
-- Versão do servidor: 10.4.27-MariaDB
-- versão do PHP: 8.2.0

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
  `gosto` int(11) NOT NULL DEFAULT 0,
  `naoGosto` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `avaliacao`
--

INSERT INTO `avaliacao` (`Id_avaliacao`, `Id_utilizador`, `Id_quizz`, `textoAvaliacao`, `nota`, `gosto`, `naoGosto`) VALUES
(21, 338, 57, '[value-6]', 4, 0, 0),
(23, 363, 57, '[value-4]', 3, 0, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `noficacoes`
--

CREATE TABLE `noficacoes` (
  `Id_notificacao` int(11) NOT NULL,
  `Id_utilizador` int(11) NOT NULL,
  `texto` varchar(250) DEFAULT NULL,
  `tipo` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `questoes`
--

CREATE TABLE `questoes` (
  `Id_questao` int(11) NOT NULL,
  `Id_quizz` int(11) NOT NULL,
  `nomeQuestao` varchar(60) DEFAULT '',
  `textoQuestao` varchar(2500) DEFAULT NULL,
  `imagem` varchar(300) DEFAULT NULL,
  `tipoQuestao` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `questoes`
--

INSERT INTO `questoes` (`Id_questao`, `Id_quizz`, `nomeQuestao`, `textoQuestao`, `imagem`, `tipoQuestao`) VALUES
(205, 57, 'Bom dia', 'dfgdfgdfg', '/1673467850954.png', 'mostrarAcerto'),
(207, 59, '', 'Bom dia', '', 'escreverResposta');

-- --------------------------------------------------------

--
-- Estrutura da tabela `quizzes`
--

CREATE TABLE `quizzes` (
  `Id_quizz` int(11) NOT NULL,
  `Id_utilizador` int(11) NOT NULL,
  `nomeQuizz` varchar(40) NOT NULL,
  `DataCriacao` datetime NOT NULL,
  `escolaridade` varchar(30) DEFAULT 'temporario',
  `tema` varchar(150) DEFAULT NULL,
  `imagem` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `quizzes`
--

INSERT INTO `quizzes` (`Id_quizz`, `Id_utilizador`, `nomeQuizz`, `DataCriacao`, `escolaridade`, `tema`, `imagem`) VALUES
(57, 338, 'Bom dia', '2023-06-14 07:01:25', 'Indiferente', 'Bom dia', '../BaseDados/Utilizadores/Utilizador_338/Quizzes/Quizz57/ImagemQuizz/1673467858757.png'),
(59, 363, 'Bom dia', '2023-06-14 08:11:49', 'Indiferente', 'Bom dia', '../BaseDados/Utilizadores/Utilizador_363/Quizzes/Quizz59/ImagemQuizz/1673467855528.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `quizzes_respondidos`
--

CREATE TABLE `quizzes_respondidos` (
  `Id_quizzRespondido` int(11) NOT NULL,
  `Id_utilizador` int(11) NOT NULL,
  `Id_quizz` int(11) NOT NULL,
  `valorAdquirido` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `respostas`
--

CREATE TABLE `respostas` (
  `Id_resposta` int(11) NOT NULL,
  `Id_questao` int(11) NOT NULL,
  `respostaQuizz` varchar(2500) DEFAULT NULL,
  `valorResposta` varchar(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `respostas`
--

INSERT INTO `respostas` (`Id_resposta`, `Id_questao`, `respostaQuizz`, `valorResposta`) VALUES
(1511, 205, 'dfg', 'false'),
(1512, 205, 'fgdfgdfg', 'true'),
(1514, 207, 'Bom dia', 'true');

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
  `imagemPerfil` varchar(300) DEFAULT NULL,
  `dataBan` date DEFAULT NULL,
  `pontuacao` int(11) DEFAULT 0,
  `permissao` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `utilizadores`
--

INSERT INTO `utilizadores` (`Id_utilizador`, `nomeCompleto`, `nomeUnico`, `email`, `password`, `imagemPerfil`, `dataBan`, `pontuacao`, `permissao`) VALUES
(338, 'Pedro Oliveira', 'Pedr0siris', 'pedro@gmail.com', 'qaws1234', 'img/avatar5.gif', NULL, 700, 'utilizador'),
(363, 'aaa aaa', 'aaa', 'aaa@aaa.com', 'aaaaaa', 'img/perfilPadrao.png', NULL, 0, 'utilizador');

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
  MODIFY `Id_avaliacao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de tabela `noficacoes`
--
ALTER TABLE `noficacoes`
  MODIFY `Id_notificacao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `questoes`
--
ALTER TABLE `questoes`
  MODIFY `Id_questao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=208;

--
-- AUTO_INCREMENT de tabela `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `Id_quizz` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT de tabela `quizzes_respondidos`
--
ALTER TABLE `quizzes_respondidos`
  MODIFY `Id_quizzRespondido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `respostas`
--
ALTER TABLE `respostas`
  MODIFY `Id_resposta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1515;

--
-- AUTO_INCREMENT de tabela `utilizadores`
--
ALTER TABLE `utilizadores`
  MODIFY `Id_utilizador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=364;

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
