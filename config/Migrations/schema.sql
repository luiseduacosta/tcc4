-- =============================================================================
-- tcc5 -- schema reference
-- =============================================================================
--
-- Source database: ess_apps (MySQL/MariaDB @ localhost), the `default`
-- connection in config/app_local.php.
--
-- ess_apps is shared by five applications: mural5, planejamento5, extensao,
-- tcc5 and balcao. This file lists ONLY the tables tcc5 reads or writes, so it
-- is a strict subset of ess_apps -- it is a reference, not a restore script.
--
-- Regenerate with:
--   mysqldump -h localhost -u root -p --no-data --skip-set-charset \
--     --skip-comments --skip-add-locks ess_apps \
--     agendamentotccs alunos areamonografias areamonografias_docentes \
--     monografias professores tccestudantes users
--
-- -----------------------------------------------------------------------------
-- Owned by tcc5 (TCC / monografias domain)
-- -----------------------------------------------------------------------------
--   monografias               MonografiasTable. FKs: professor_id,
--                             num_co_orienta, areamonografia_id, banca1..banca3
--   tccestudantes             TccestudantesTable. FK monografia_id
--   areamonografias           AreamonografiasTable. Counter cache q_monografia
--   areamonografias_docentes  belongsToMany join, Areamonografias <-> Docentes
--   agendamentotccs           AgendamentotccsTable. TCC defence scheduling
--
-- -----------------------------------------------------------------------------
-- Shared with the other four apps -- treat as read-mostly
-- -----------------------------------------------------------------------------
--   professores               ProfessoresTable AND DocentesTable both map here;
--                             canonical table for teaching staff -- see below
--   alunos                    EstudantesTable, via setTable('alunos')
--   users                     UsersTable, authentication
--
-- -----------------------------------------------------------------------------
-- Deliberately out of scope: the internship (estagio) domain
-- -----------------------------------------------------------------------------
-- `estagiarios`, `instituicoes` and `supervisores` are NOT tcc5 tables -- they
-- belong to the internship application. They are omitted here even though some
-- leftover code still reaches them through the shared connection:
--   ProfessoresController::view()/220  contain: ['Estagiarios' => [...,
--                                      'Instituicoes', 'Supervisores', ...]]
--   ProfessoresTable                   hasMany('Estagiarios')
--   UsersTable                         belongsTo('Supervisores') + existsIn rule
--   UsersController                    fetchTable('Supervisores') lookups and
--                                      redirects to a Supervisores controller
--   EstudantesController               contain('Estagiarios')
--   templates/Professores/view.php     Estagiarios listing and CRUD links
-- None of these have a Table class in src/Model/Table, so CakePHP builds a
-- generic Table at runtime. They resolve only because ess_apps is shared.
--
-- -----------------------------------------------------------------------------
-- `professores` is canonical -- `docentes` is retired
-- -----------------------------------------------------------------------------
-- The legacy `docentes` table is deliberately NOT part of this schema. All
-- teaching-staff data lives in `professores`, which DocentesTable already maps
-- via setTable('professores'). The narrower column set of `professores` is
-- intentional: the academic-CV fields that `docentes` carried (datanascimento,
-- localnascimento, sexo, homepage, redesocial, curriculosigma, pesquisadordgp,
-- formacaoprofissional, universidadedegraduacao, anoformacao, mestrado*,
-- doutorado*, formaingresso, tipocargo, categoria, regimetrabalho) are dropped,
-- and ddd_telefone / ddd_celular are named codigo_telefone / codigo_celular
-- here.
--
-- `professores.status` varchar(10) NOT NULL DEFAULT 'ativo' carries the active/
-- inactive flag ('ativo' / 'inativo').
--
-- The App\Model\Entity\Docente entity and templates/Docentes/* still declare
-- the dropped fields; they resolve to null until that module is trimmed to the
-- column list below.
--
-- AUTO_INCREMENT counters are stripped so regeneration yields no diff noise.
-- =============================================================================

/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `agendamentotccs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `agendamentotccs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `estudante_id` int(11) NOT NULL,
  `docente_id` int(11) NOT NULL,
  `convidado` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `banca1` int(11) NOT NULL,
  `banca2` int(11) NOT NULL,
  `data` date NOT NULL,
  `horario` time NOT NULL,
  `sala` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `titulo` varchar(180) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `avaliacao` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Agendamentos das bancas de TCC';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `alunos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `alunos` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL DEFAULT '',
  `nomesocial` varchar(50) DEFAULT NULL,
  `registro` int(9) NOT NULL DEFAULT 0,
  `codigo_telefone` tinyint(2) NOT NULL DEFAULT 21,
  `telefone` varchar(15) DEFAULT NULL,
  `codigo_celular` tinyint(2) NOT NULL DEFAULT 21,
  `celular` varchar(15) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `cpf` varchar(15) DEFAULT NULL,
  `identidade` varchar(15) DEFAULT NULL,
  `orgao` varchar(30) DEFAULT NULL,
  `nascimento` date DEFAULT NULL,
  `endereco` varchar(50) DEFAULT NULL,
  `cep` varchar(9) DEFAULT NULL,
  `municipio` varchar(30) DEFAULT NULL,
  `bairro` varchar(30) DEFAULT NULL,
  `ingresso` char(6) DEFAULT NULL,
  `turno` varchar(7) DEFAULT NULL,
  `turno_id` smallint(3) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `inscricao_count` int(11) DEFAULT 0,
  `estagiario_count` int(11) NOT NULL DEFAULT 0,
  `observacoes` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `registro` (`registro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `areamonografias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `areamonografias` (
  `id` smallint(3) NOT NULL AUTO_INCREMENT,
  `area` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `q_monografia` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Áreas de orientação das monografias';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `areamonografias_docentes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `areamonografias_docentes` (
  `id` int(3) NOT NULL,
  `docente_id` int(3) DEFAULT NULL,
  `areamonografia_id` int(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `monografias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `monografias` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `catalogo` int(11) NOT NULL,
  `titulo` varchar(160) NOT NULL DEFAULT '',
  `resumo` mediumtext NOT NULL,
  `data` date NOT NULL DEFAULT '0000-00-00',
  `periodo` varchar(6) NOT NULL DEFAULT '',
  `professor_id` smallint(6) NOT NULL DEFAULT 0,
  `num_co_orienta` smallint(6) DEFAULT 0,
  `areamonografia_id` smallint(6) DEFAULT 0,
  `areamonografia` int(4) NOT NULL DEFAULT 0,
  `data_defesa` date NOT NULL,
  `banca1` int(11) NOT NULL,
  `banca2` int(11) NOT NULL,
  `banca3` int(11) NOT NULL,
  `convidado` varchar(70) NOT NULL,
  `url` varchar(15) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `professores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `professores` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL DEFAULT '',
  `cpf` varchar(15) DEFAULT NULL,
  `siape` mediumint(10) DEFAULT NULL,
  `cress` varchar(10) DEFAULT NULL,
  `regiao` varchar(2) DEFAULT NULL,
  `codigo_telefone` tinyint(2) unsigned DEFAULT 21,
  `telefone` varchar(15) DEFAULT NULL,
  `codigo_celular` tinyint(2) unsigned DEFAULT 21,
  `celular` varchar(15) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `curriculolattes` varchar(50) DEFAULT NULL,
  `atualizacaolattes` date DEFAULT NULL,
  `dataingresso` date DEFAULT NULL,
  `departamento` varchar(30) DEFAULT NULL,
  `dataegresso` date DEFAULT NULL,
  `motivoegresso` varchar(100) DEFAULT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'ativo',
  `observacoes` mediumtext DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `estagiarios_count` int(10) unsigned DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tccestudantes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `tccestudantes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `monografia_id` smallint(5) NOT NULL DEFAULT 0,
  `registro` char(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` char(50) DEFAULT NULL,
  `password` char(80) DEFAULT NULL,
  `nome` varchar(128) DEFAULT NULL COMMENT 'Nome do usuário',
  `role` enum('admin','supervisor','professor','aluno') DEFAULT 'aluno',
  `categoria` enum('1','2','3','4') NOT NULL DEFAULT '2',
  `identificacao` int(9) DEFAULT NULL COMMENT 'Registro do aluno, SIAPE do professor ou CRESS do supervisor',
  `entidade_id` int(11) DEFAULT NULL COMMENT 'id da entidade: aluno, professor ou supervisor',
  `ativo` tinyint(1) DEFAULT 1,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `aluno_id` int(11) DEFAULT NULL,
  `supervisor_id` int(11) DEFAULT NULL,
  `professor_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

