-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 13-Jul-2023 às 03:37
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
(29, 338, 65, 'Um quizz rápido, simples e interessante.', 4, 0, 0),
(30, 364, 83, 'Realmente não é algo muito comum de se conhecer, mas não acho que a diffculdade deva estar no difícil e sim no médio', 4, 0, 0),
(31, 366, 83, 'Realmente um pouco difícil mas interessante, não tenho muito conhecimento sobre a história sobre o japão então concordo com o nível de dificuldade.', 3, 0, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `questoes`
--

CREATE TABLE `questoes` (
  `Id_questao` int(11) NOT NULL,
  `Id_quizz` int(11) NOT NULL,
  `nomeQuestao` varchar(25) DEFAULT '',
  `textoQuestao` varchar(2500) DEFAULT NULL,
  `imagem` varchar(300) DEFAULT NULL,
  `tipoQuestao` varchar(25) NOT NULL,
  `mostrarRespostaCorreta` varchar(5) NOT NULL DEFAULT '',
  `mostrarPercentagemEscolhas` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `questoes`
--

INSERT INTO `questoes` (`Id_questao`, `Id_quizz`, `nomeQuestao`, `textoQuestao`, `imagem`, `tipoQuestao`, `mostrarRespostaCorreta`, `mostrarPercentagemEscolhas`) VALUES
(221, 65, 'O que é o sol?', 'O nosso sol é uma estrela?', '/sol.jpeg', 'selecionarResposta', '', 'sim'),
(222, 65, '', 'Que tipo de estrela é o nosso sol?', '', 'textoLivre', '', ''),
(223, 65, 'Terra, tipo de planeta ', 'Que tipo de planeta é a Terra?', '/terra.jpg', 'selecionarResposta', 'sim', ''),
(246, 82, 'Quem colonizou os EUA', 'Quem colonizou os EUA?', '/eua.png', 'selecionarResposta', 'sim', ''),
(247, 82, 'Maior palavra sem vogal', 'A rainha Elizabeth II é parente distante de Vlad, o Empalador.\n\nEsta afirmação é verdadeira ou falsa?', '', 'textoLivre', '', ''),
(248, 82, 'Rei/Rainha de Inglaterra', 'Quem é o atual Rei/Rainha de Inglaterra?', '/CoroaReal2.jpg', 'selecionarResposta', 'sim', ''),
(249, 83, 'Maior espadachim do Japão', 'Quem foi o maior espadachim na história do japão?', '', 'selecionarResposta', '', 'sim'),
(250, 83, '', 'Quem foi o líder militar que unificou o Japão no século XVI?<br>', '', 'textoLivre', '', ''),
(251, 83, '', 'Qual foi a última cidade japonesa a ser vítima de bombas atômicas durante a Segunda Guerra Mundial?', '', 'selecionarResposta', '', ''),
(252, 83, 'Qual período da história ', 'Qual período da história do Japão é conhecido como a \"Era dos Samurais\"?', '/samurai.jpg', 'selecionarResposta', 'sim', 'sim'),
(253, 84, 'Instrumento musical', 'Qual é o instrumento musical mais famoso da cultura da Irlanda?', '', 'selecionarResposta', 'sim', ''),
(255, 84, 'Dança irlandesa', 'Qual é a famosa dança tradicional da Irlanda caracterizada pelos movimentos rápidos dos pés e postura ereta?', '/dancaIrlandesa.jpeg', 'selecionarResposta', '', 'sim'),
(256, 84, 'Símbolo nacional irlandês', 'Qual é o símbolo nacional da Irlanda?', '', 'textoLivre', '', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `quizzes`
--

CREATE TABLE `quizzes` (
  `Id_quizz` int(11) NOT NULL,
  `Id_utilizador` int(11) NOT NULL,
  `nomeQuizz` varchar(40) NOT NULL,
  `DataCriacao` datetime NOT NULL,
  `dificuldade` varchar(30) DEFAULT 'temporario',
  `tema` varchar(150) DEFAULT NULL,
  `imagem` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `quizzes`
--

INSERT INTO `quizzes` (`Id_quizz`, `Id_utilizador`, `nomeQuizz`, `DataCriacao`, `dificuldade`, `tema`, `imagem`) VALUES
(65, 338, 'Estrelas e planetas', '2023-07-11 04:47:11', 'Fácil', 'Tipos de estrelas e planetas', '../BaseDados/Utilizadores/Utilizador_338/Quizzes/Quizz65/ImagemQuizz/imagem.jpg'),
(82, 367, 'Inglaterra e a sua realeza', '2023-07-13 02:22:04', 'Fácil', 'História, Inglês', '../BaseDados/Utilizadores/Utilizador_367/Quizzes/Quizz82/ImagemQuizz/imagem.jpeg'),
(83, 367, 'Japão e a sua história', '2023-07-13 02:42:05', 'Difícil', 'História', '../BaseDados/Utilizadores/Utilizador_367/Quizzes/Quizz83/ImagemQuizz/imagem.jpeg'),
(84, 364, 'Curiosidades sobre a Irlanda', '2023-07-13 03:01:25', 'Médio', 'Cultura', '../BaseDados/Utilizadores/Utilizador_364/Quizzes/Quizz84/ImagemQuizz/imagem.png');

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

--
-- Extraindo dados da tabela `quizzes_respondidos`
--

INSERT INTO `quizzes_respondidos` (`Id_quizzRespondido`, `Id_utilizador`, `Id_quizz`, `valorAdquirido`) VALUES
(2, 338, 65, 100),
(5, 364, 83, 100),
(6, 366, 83, 100);

-- --------------------------------------------------------

--
-- Estrutura da tabela `respostas`
--

CREATE TABLE `respostas` (
  `Id_resposta` int(11) NOT NULL,
  `Id_questao` int(11) NOT NULL,
  `respostaQuizz` varchar(2500) DEFAULT NULL,
  `valorResposta` varchar(10) NOT NULL DEFAULT '0',
  `vezesSelecionada` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `respostas`
--

INSERT INTO `respostas` (`Id_resposta`, `Id_questao`, `respostaQuizz`, `valorResposta`, `vezesSelecionada`) VALUES
(1563, 221, 'sim', 'true', 0),
(1564, 221, 'não\n', 'false', 0),
(1565, 222, 'estrela anã', 'true', 0),
(1566, 223, 'Planeta gasoso', 'false', 0),
(1567, 223, 'Planeta rochoso', 'true', 0),
(1622, 248, 'Rainha Elizabeth II', 'false', 0),
(1623, 248, 'Rei Charles III', 'true', 0),
(1624, 248, 'Rainha Anne Elizabeth', 'false', 0),
(1625, 246, 'Inglaterra', 'true', 0),
(1626, 246, 'Irlanda', 'false', 0),
(1627, 247, 'verdadeira ', 'true', 0),
(1628, 247, 'Verdadeira ', 'true', 0),
(1629, 247, 'falsa', 'true', 0),
(1630, 247, 'Falsa', 'true', 0),
(1631, 249, 'Miyamoto Musashi', 'true', 0),
(1632, 249, 'Hirohito', 'false', 0),
(1633, 249, 'Levi Ackerman', 'false', 0),
(1634, 250, 'Toyotomi Hideyoshi', 'true', 0),
(1635, 251, 'Tóquio', 'false', 0),
(1636, 251, 'Hiroshima', 'false', 0),
(1637, 251, 'Nagasaki', 'true', 0),
(1638, 251, 'Osaka', 'false', 0),
(1639, 252, 'Período Kamakura', 'false', 0),
(1640, 252, 'Período Sengoku', 'true', 0),
(1641, 253, 'Gaita de foles', 'true', 0),
(1642, 253, 'Violino', 'false', 0),
(1643, 253, 'Bandolim', 'false', 0),
(1648, 255, 'Reel irlandês', 'true', 0),
(1649, 255, 'Jig irlandesa', 'false', 0),
(1650, 256, 'Harpa', 'true', 0),
(1651, 256, 'harpa', 'true', 0);

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
  `pontuacao` int(11) DEFAULT 0,
  `permissao` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `utilizadores`
--

INSERT INTO `utilizadores` (`Id_utilizador`, `nomeCompleto`, `nomeUnico`, `email`, `password`, `imagemPerfil`, `pontuacao`, `permissao`) VALUES
(338, 'Pedro Oliveira', 'Pedr0siris', 'pedro@gmail.com', 'qaws1234', 'img/avatar5.gif', 700, 'admin'),
(363, 'aaa aaa', 'aaa', 'aaa@aaa.com', 'aaaaaaaa', 'img/perfilPadrao.png', 0, 'utilizador'),
(364, 'Nuno Mourinho', 'MisterBoss', 'nuno@gmail.com', 'qaws1234', '../BaseDados/Utilizadores/Utilizador_364/natal.jpeg', 325, 'utilizador'),
(366, 'asd asd', 'asd', 'asd@asd.com', 'asdasdasd', 'img/perfilPadrao.png', 100, 'utilizador'),
(367, 'Filipe Marques', 'FipMique', 'filipe@gmail.com', 'qaws1234', 'img/perfilPadrao.png', 0, 'utilizador');

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
  MODIFY `Id_avaliacao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de tabela `questoes`
--
ALTER TABLE `questoes`
  MODIFY `Id_questao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=257;

--
-- AUTO_INCREMENT de tabela `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `Id_quizz` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT de tabela `quizzes_respondidos`
--
ALTER TABLE `quizzes_respondidos`
  MODIFY `Id_quizzRespondido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `respostas`
--
ALTER TABLE `respostas`
  MODIFY `Id_resposta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1652;

--
-- AUTO_INCREMENT de tabela `utilizadores`
--
ALTER TABLE `utilizadores`
  MODIFY `Id_utilizador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=372;

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
