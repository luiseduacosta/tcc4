-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 02/11/2025 às 03:44
-- Versão do servidor: 10.11.13-MariaDB-0ubuntu0.24.04.1
-- Versão do PHP: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `tcc.ess`
--
DROP DATABASE IF EXISTS `tcc.ess`;
CREATE DATABASE IF NOT EXISTS `tcc.ess` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `tcc.ess`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `agendamentotccs`
--

DROP TABLE IF EXISTS `agendamentotccs`;
CREATE TABLE `agendamentotccs` (
  `id` int(11) NOT NULL,
  `estudante_id` int(11) NOT NULL,
  `docente_id` int(11) NOT NULL,
  `banca1` int(11) NOT NULL,
  `banca2` int(11) NOT NULL,
  `data` date NOT NULL,
  `horario` time NOT NULL,
  `sala` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `convidado` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `titulo` varchar(180) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `avaliacao` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Agendamentos das bancas de TCC';

-- --------------------------------------------------------

--
-- Estrutura para tabela `alunos`
--

DROP TABLE IF EXISTS `alunos`;
CREATE TABLE `alunos` (
  `id` int(4) NOT NULL,
  `nome` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `registro` int(9) NOT NULL DEFAULT 0,
  `codigo_telefone` tinyint(2) NOT NULL DEFAULT 21,
  `telefone` varchar(9) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `codigo_celular` tinyint(2) NOT NULL DEFAULT 21,
  `celular` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `email` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `cpf` varchar(12) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `identidade` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `orgao` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `nascimento` date DEFAULT NULL,
  `endereco` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `cep` varchar(9) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `municipio` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `bairro` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `observacoes` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Ex tabela alunonovos';

-- --------------------------------------------------------

--
-- Estrutura para tabela `alunos_old`
--

DROP TABLE IF EXISTS `alunos_old`;
CREATE TABLE `alunos_old` (
  `id` int(4) NOT NULL,
  `nome` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `registro` int(9) NOT NULL DEFAULT 0,
  `codigo_telefone` tinyint(2) NOT NULL DEFAULT 21,
  `telefone` varchar(9) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT '0',
  `codigo_celular` tinyint(2) NOT NULL DEFAULT 21,
  `celular` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT '0',
  `email` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `cpf` varchar(12) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `identidade` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `orgao` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `nascimento` date DEFAULT NULL,
  `endereco` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `cep` varchar(9) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `municipio` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `bairro` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `observacoes` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Alunos estagiários';

-- --------------------------------------------------------

--
-- Estrutura para tabela `areaestagios`
--

DROP TABLE IF EXISTS `areaestagios`;
CREATE TABLE `areaestagios` (
  `id` smallint(3) NOT NULL,
  `area` varchar(70) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `areamonografias`
--

DROP TABLE IF EXISTS `areamonografias`;
CREATE TABLE `areamonografias` (
  `id` smallint(3) NOT NULL,
  `area` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Áreas de orientação das monografias';

-- --------------------------------------------------------

--
-- Estrutura para tabela `areamonografias_docentes`
--

DROP TABLE IF EXISTS `areamonografias_docentes`;
CREATE TABLE `areamonografias_docentes` (
  `id` int(3) NOT NULL,
  `docente_id` int(3) DEFAULT NULL,
  `areamonografia_id` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `area_instituicoes`
--

DROP TABLE IF EXISTS `area_instituicoes`;
CREATE TABLE `area_instituicoes` (
  `id` smallint(3) NOT NULL,
  `area` varchar(90) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `atendentes`
--

DROP TABLE IF EXISTS `atendentes`;
CREATE TABLE `atendentes` (
  `id` int(11) NOT NULL,
  `docente_id` int(11) DEFAULT NULL,
  `tae_id` int(11) DEFAULT NULL,
  `nome` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `observacoes` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `avaliacoes`
--

DROP TABLE IF EXISTS `avaliacoes`;
CREATE TABLE `avaliacoes` (
  `id` int(11) NOT NULL,
  `estagiario_id` int(11) NOT NULL,
  `avaliacao1` char(1) NOT NULL,
  `avaliacao2` char(1) NOT NULL,
  `avaliacao3` char(1) NOT NULL,
  `avaliacao4` char(1) NOT NULL,
  `avaliacao5` char(1) NOT NULL,
  `avaliacao6` char(1) NOT NULL,
  `avaliacao7` char(1) NOT NULL,
  `avaliacao8` char(1) NOT NULL,
  `avaliacao9` char(1) NOT NULL,
  `avaliacao9_1` varchar(255) DEFAULT NULL,
  `avaliacao10` char(1) NOT NULL,
  `avaliacao10_1` varchar(255) DEFAULT NULL,
  `avaliacao11` char(1) NOT NULL,
  `avaliacao11_1` varchar(255) DEFAULT NULL,
  `avaliacao12` char(1) NOT NULL,
  `avaliacao12_1` varchar(255) DEFAULT NULL,
  `avaliacao13` char(1) NOT NULL,
  `avaliacao13_1` varchar(255) DEFAULT NULL,
  `avaliacao14` varchar(255) NOT NULL,
  `observacoes` varchar(255) NOT NULL,
  `TIMESTAMP` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Avalição dos estagiarios';

-- --------------------------------------------------------

--
-- Estrutura para tabela `classificamonografias`
--

DROP TABLE IF EXISTS `classificamonografias`;
CREATE TABLE `classificamonografias` (
  `id` int(3) NOT NULL,
  `areamonografia` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Classificação das monografias';

-- --------------------------------------------------------

--
-- Estrutura para tabela `complementos`
--

DROP TABLE IF EXISTS `complementos`;
CREATE TABLE `complementos` (
  `id` int(11) NOT NULL,
  `periodo_especial` varchar(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Tabela para o periódo especial da pandemia 2020';

-- --------------------------------------------------------

--
-- Estrutura para tabela `configuracoes`
--

DROP TABLE IF EXISTS `configuracoes`;
CREATE TABLE `configuracoes` (
  `id` int(11) NOT NULL,
  `mural_periodo_atual` varchar(6) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `curso_turma_atual` smallint(2) NOT NULL,
  `curso_abertura_inscricoes` date NOT NULL,
  `curso_encerramento_inscricoes` date NOT NULL,
  `termo_compromisso_periodo` varchar(6) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `termo_compromisso_inicio` date NOT NULL,
  `termo_compromisso_final` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `demandas`
--

DROP TABLE IF EXISTS `demandas`;
CREATE TABLE `demandas` (
  `id` int(11) NOT NULL,
  `setor` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `datademanda` date NOT NULL,
  `estudante_id` int(11) NOT NULL,
  `atendente_id` int(11) NOT NULL,
  `assunto` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `descripcao` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `diagnostico` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `encaminhamento` varchar(70) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `encerramento` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `dataencerramento` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Demanda inicial de atendimento';

-- --------------------------------------------------------

--
-- Estrutura para tabela `estagiarios`
--

DROP TABLE IF EXISTS `estagiarios`;
CREATE TABLE `estagiarios` (
  `id` int(11) NOT NULL,
  `aluno_id` smallint(6) NOT NULL DEFAULT 0 COMMENT 'id_aluno',
  `registro` int(11) NOT NULL DEFAULT 0,
  `turno` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `nivel` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `tc` smallint(6) NOT NULL DEFAULT 0,
  `tc_solicitacao` date DEFAULT NULL,
  `instituicao_id` smallint(6) NOT NULL DEFAULT 0 COMMENT 'id_instituicao',
  `supervisor_id` smallint(6) DEFAULT NULL COMMENT 'id_supervisor',
  `professor_id` smallint(6) DEFAULT NULL COMMENT 'id_professor',
  `periodo` varchar(6) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `turmaestagio_id` tinyint(4) DEFAULT 0 COMMENT 'id_area',
  `nota` decimal(4,2) DEFAULT 0.00,
  `ch` smallint(6) DEFAULT 0,
  `observacoes` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `complemento_id` int(11) DEFAULT NULL,
  `alunonovo_id` int(11) DEFAULT NULL,
  `ajuste2020` char(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `estagio`
--

DROP TABLE IF EXISTS `estagio`;
CREATE TABLE `estagio` (
  `id` int(4) NOT NULL,
  `area_instituicoes_id` smallint(3) DEFAULT NULL,
  `area` smallint(3) DEFAULT 0,
  `natureza` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `instituicao` varchar(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `cnpj` char(18) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `email` varchar(90) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `url` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `endereco` varchar(105) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `bairro` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `municipio` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `cep` char(9) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `telefone` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `fax` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `beneficio` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `fim_de_semana` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT '0',
  `localInscricao` set('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0',
  `convenio` int(4) NOT NULL,
  `expira` date DEFAULT NULL,
  `seguro` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `avaliacao` set('1','2','3','4','5') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '3',
  `observacoes` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `estudantes`
--

DROP TABLE IF EXISTS `estudantes`;
CREATE TABLE `estudantes` (
  `id` int(4) NOT NULL,
  `nome` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `registro` int(9) NOT NULL DEFAULT 0,
  `codigo_telefone` tinyint(2) NOT NULL DEFAULT 21,
  `telefone` varchar(9) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `codigo_celular` tinyint(2) NOT NULL DEFAULT 21,
  `celular` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `email` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `cpf` varchar(12) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `identidade` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `orgao` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `nascimento` date DEFAULT NULL,
  `endereco` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `cep` varchar(9) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `municipio` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `bairro` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `observacoes` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Tem que ser a mesma que alunos';

-- --------------------------------------------------------

--
-- Estrutura para tabela `folhadeatividades`
--

DROP TABLE IF EXISTS `folhadeatividades`;
CREATE TABLE `folhadeatividades` (
  `id` int(11) NOT NULL,
  `estagiario_id` int(11) NOT NULL,
  `dia` date NOT NULL,
  `inicio` time NOT NULL,
  `final` time NOT NULL,
  `horario` time GENERATED ALWAYS AS (timediff(`final`,`inicio`)) STORED,
  `atividade` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Formulário de atividades';

-- --------------------------------------------------------

--
-- Estrutura para tabela `gruposdepesquisa`
--

DROP TABLE IF EXISTS `gruposdepesquisa`;
CREATE TABLE `gruposdepesquisa` (
  `id` int(11) NOT NULL,
  `sigla` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `grupodepesquisa` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `descricao` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `site` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `diretoriolattes` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `eventos` int(11) DEFAULT NULL,
  `publicacoes` int(11) DEFAULT NULL,
  `observacoes` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `historicos`
--

DROP TABLE IF EXISTS `historicos`;
CREATE TABLE `historicos` (
  `id` int(11) NOT NULL,
  `estudante_id` int(11) NOT NULL,
  `demanda_id` int(11) NOT NULL,
  `datahistorico` date NOT NULL,
  `atendente_id` int(11) NOT NULL,
  `encaminhamento` varchar(70) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `observacao` text CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `inscricoes`
--

DROP TABLE IF EXISTS `inscricoes`;
CREATE TABLE `inscricoes` (
  `id` int(11) NOT NULL,
  `registro` int(9) NOT NULL DEFAULT 0 COMMENT 'aluno_registro',
  `muralestagio_id` smallint(3) NOT NULL DEFAULT 0,
  `data` date NOT NULL DEFAULT '0000-00-00',
  `periodo` char(6) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `alunonovo_id` int(11) NOT NULL,
  `aluno_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `inst_super`
--

DROP TABLE IF EXISTS `inst_super`;
CREATE TABLE `inst_super` (
  `id` int(4) NOT NULL,
  `instituicao_id` smallint(4) NOT NULL DEFAULT 0,
  `supervisor_id` smallint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `monografias`
--

DROP TABLE IF EXISTS `monografias`;
CREATE TABLE `monografias` (
  `id` int(4) NOT NULL,
  `catalogo` int(4) DEFAULT NULL,
  `titulo` varchar(180) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `resumo` varchar(7398) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `data` varchar(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `periodo` varchar(6) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `professor_id` int(3) DEFAULT NULL,
  `co_orienta_id` int(3) DEFAULT NULL,
  `areamonografia_id` int(3) DEFAULT NULL,
  `classificamonografia_id` int(1) DEFAULT NULL,
  `data_defesa` varchar(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `banca1` int(3) DEFAULT NULL,
  `banca2` int(3) DEFAULT NULL,
  `banca3` int(3) DEFAULT NULL,
  `convidado` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `url` varchar(13) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `timestamp` timestamp(6) NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `municipiosrj`
--

DROP TABLE IF EXISTS `municipiosrj`;
CREATE TABLE `municipiosrj` (
  `id` int(2) NOT NULL,
  `municipio` varchar(29) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `população` int(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `mural_estagio`
--

DROP TABLE IF EXISTS `mural_estagio`;
CREATE TABLE `mural_estagio` (
  `id` int(3) NOT NULL,
  `instituicao_id` int(4) DEFAULT NULL,
  `instituicao` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `convenio` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0',
  `vagas` tinyint(3) NOT NULL DEFAULT 0,
  `beneficios` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `final_de_semana` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `cargaHoraria` tinyint(2) DEFAULT 0,
  `requisitos` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `turmaestagio_id` tinyint(2) NOT NULL DEFAULT 0,
  `horario` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `professor_id` tinyint(3) NOT NULL DEFAULT 0,
  `dataSelecao` date DEFAULT NULL,
  `dataInscricao` date DEFAULT NULL,
  `horarioSelecao` varchar(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `localSelecao` varchar(70) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `formaSelecao` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `contato` varchar(70) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `outras` text CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `periodo` varchar(6) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `datafax` date DEFAULT NULL,
  `localInscricao` set('0','1') CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '0',
  `email` varchar(70) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `mural_inscricao`
--

DROP TABLE IF EXISTS `mural_inscricao`;
CREATE TABLE `mural_inscricao` (
  `id` int(11) NOT NULL,
  `registro` int(9) NOT NULL DEFAULT 0 COMMENT 'aluno_registro',
  `muralestagio_id` smallint(3) NOT NULL DEFAULT 0,
  `data` date NOT NULL DEFAULT '0000-00-00',
  `periodo` char(6) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `alunonovo_id` int(11) NOT NULL,
  `aluno_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `professores`
--

DROP TABLE IF EXISTS `professores`;
CREATE TABLE `professores` (
  `id` int(3) NOT NULL,
  `nome` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `cpf` char(12) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `siape` mediumint(10) DEFAULT NULL,
  `datanascimento` date DEFAULT NULL,
  `localnascimento` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `sexo` enum('2','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT '2',
  `ddd_telefone` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '21',
  `telefone` varchar(12) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `ddd_celular` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '21',
  `celular` varchar(12) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `email` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `homepage` varchar(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `redesocial` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `curriculolattes` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `atualizacaolattes` date DEFAULT NULL,
  `curriculosigma` varchar(7) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `pesquisadordgp` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `formacaoprofissional` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `universidadedegraduacao` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `anoformacao` mediumint(4) DEFAULT NULL,
  `mestradoarea` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `mestradouniversidade` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `mestradoanoconclusao` mediumint(4) DEFAULT NULL,
  `doutoradoarea` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `doutoradouniversidade` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `doutoradoanoconclusao` mediumint(4) DEFAULT NULL,
  `dataingresso` date DEFAULT NULL,
  `formaingresso` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `tipocargo` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `categoria` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `regimetrabalho` varchar(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `departamento` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `dataegresso` date DEFAULT NULL,
  `motivoegresso` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `observacoes` text CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `supervisores`
--

DROP TABLE IF EXISTS `supervisores`;
CREATE TABLE `supervisores` (
  `id` int(4) NOT NULL,
  `nome` varchar(70) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `cpf` varchar(12) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0',
  `endereco` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `bairro` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `municipio` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `cep` varchar(9) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `codigo_tel` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '21',
  `telefone` varchar(9) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `codigo_cel` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '21',
  `celular` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `email` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `escola` varchar(70) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ano_formatura` varchar(4) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `cress` int(6) DEFAULT NULL,
  `regiao` tinyint(2) NOT NULL DEFAULT 7,
  `outros_estudos` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `area_curso` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `ano_curso` varchar(4) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `cargo` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `num_inscricao` int(3) DEFAULT NULL,
  `curso_turma` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `observacoes` text CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `taes`
--

DROP TABLE IF EXISTS `taes`;
CREATE TABLE `taes` (
  `id` int(11) NOT NULL,
  `siape` int(11) NOT NULL,
  `nome` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tccestudantes`
--

DROP TABLE IF EXISTS `tccestudantes`;
CREATE TABLE `tccestudantes` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `monografia_id` smallint(5) NOT NULL DEFAULT 0,
  `registro` char(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `turma_estagios`
--

DROP TABLE IF EXISTS `turma_estagios`;
CREATE TABLE `turma_estagios` (
  `id` smallint(3) NOT NULL,
  `area` varchar(70) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` char(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `password` char(80) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `categoria` enum('1','2','3','4') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '1',
  `numero` int(9) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estudante_id` int(11) DEFAULT NULL,
  `supervisor_id` int(11) DEFAULT NULL,
  `docente_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `visita`
--

DROP TABLE IF EXISTS `visita`;
CREATE TABLE `visita` (
  `id` int(11) NOT NULL,
  `instituicao_id` int(11) NOT NULL,
  `data` date NOT NULL,
  `motivo` varchar(256) NOT NULL,
  `responsavel` varchar(50) NOT NULL,
  `descricao` text DEFAULT NULL,
  `avaliacao` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `agendamentotccs`
--
ALTER TABLE `agendamentotccs`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `alunos`
--
ALTER TABLE `alunos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `registro` (`registro`);

--
-- Índices de tabela `alunos_old`
--
ALTER TABLE `alunos_old`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `registro` (`registro`);

--
-- Índices de tabela `areaestagios`
--
ALTER TABLE `areaestagios`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `areamonografias`
--
ALTER TABLE `areamonografias`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `areamonografias_docentes`
--
ALTER TABLE `areamonografias_docentes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `area_instituicoes`
--
ALTER TABLE `area_instituicoes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `atendentes`
--
ALTER TABLE `atendentes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `avaliacoes`
--
ALTER TABLE `avaliacoes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `classificamonografias`
--
ALTER TABLE `classificamonografias`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `complementos`
--
ALTER TABLE `complementos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `configuracoes`
--
ALTER TABLE `configuracoes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `demandas`
--
ALTER TABLE `demandas`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `estagiarios`
--
ALTER TABLE `estagiarios`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `estagio`
--
ALTER TABLE `estagio`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `estudantes`
--
ALTER TABLE `estudantes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `registro` (`registro`);

--
-- Índices de tabela `folhadeatividades`
--
ALTER TABLE `folhadeatividades`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `gruposdepesquisa`
--
ALTER TABLE `gruposdepesquisa`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `historicos`
--
ALTER TABLE `historicos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `demanda_id` (`demanda_id`);

--
-- Índices de tabela `inscricoes`
--
ALTER TABLE `inscricoes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `inst_super`
--
ALTER TABLE `inst_super`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `monografias`
--
ALTER TABLE `monografias`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `municipiosrj`
--
ALTER TABLE `municipiosrj`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `mural_estagio`
--
ALTER TABLE `mural_estagio`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `mural_inscricao`
--
ALTER TABLE `mural_inscricao`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `professores`
--
ALTER TABLE `professores`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `supervisores`
--
ALTER TABLE `supervisores`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `taes`
--
ALTER TABLE `taes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tccestudantes`
--
ALTER TABLE `tccestudantes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Índices de tabela `turma_estagios`
--
ALTER TABLE `turma_estagios`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `visita`
--
ALTER TABLE `visita`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `agendamentotccs`
--
ALTER TABLE `agendamentotccs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `alunos`
--
ALTER TABLE `alunos`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `alunos_old`
--
ALTER TABLE `alunos_old`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `areaestagios`
--
ALTER TABLE `areaestagios`
  MODIFY `id` smallint(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `areamonografias`
--
ALTER TABLE `areamonografias`
  MODIFY `id` smallint(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `area_instituicoes`
--
ALTER TABLE `area_instituicoes`
  MODIFY `id` smallint(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `atendentes`
--
ALTER TABLE `atendentes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `avaliacoes`
--
ALTER TABLE `avaliacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `classificamonografias`
--
ALTER TABLE `classificamonografias`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `complementos`
--
ALTER TABLE `complementos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `configuracoes`
--
ALTER TABLE `configuracoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `demandas`
--
ALTER TABLE `demandas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `estagiarios`
--
ALTER TABLE `estagiarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `estagio`
--
ALTER TABLE `estagio`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `estudantes`
--
ALTER TABLE `estudantes`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `folhadeatividades`
--
ALTER TABLE `folhadeatividades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `gruposdepesquisa`
--
ALTER TABLE `gruposdepesquisa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `historicos`
--
ALTER TABLE `historicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `inscricoes`
--
ALTER TABLE `inscricoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `inst_super`
--
ALTER TABLE `inst_super`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `monografias`
--
ALTER TABLE `monografias`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `municipiosrj`
--
ALTER TABLE `municipiosrj`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `mural_estagio`
--
ALTER TABLE `mural_estagio`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `mural_inscricao`
--
ALTER TABLE `mural_inscricao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `professores`
--
ALTER TABLE `professores`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `supervisores`
--
ALTER TABLE `supervisores`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `taes`
--
ALTER TABLE `taes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tccestudantes`
--
ALTER TABLE `tccestudantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `turma_estagios`
--
ALTER TABLE `turma_estagios`
  MODIFY `id` smallint(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `visita`
--
ALTER TABLE `visita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `historicos`
--
ALTER TABLE `historicos`
  ADD CONSTRAINT `historicos_ibfk_1` FOREIGN KEY (`demanda_id`) REFERENCES `demandas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
