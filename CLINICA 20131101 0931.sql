-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.5.27


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema `clinica-medica`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `clinica-medica`;
USE `clinica-medica`;

--
-- Structure for table `clinica-medica`.`agenda`
--

DROP TABLE IF EXISTS `clinica-medica`.`agenda`;
CREATE TABLE  `clinica-medica`.`agenda` (
  `ag_agenda` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ag_dataconsulta` date NOT NULL,
  `ag_horainicio` time NOT NULL DEFAULT '00:00:00',
  `ag_paciente` int(10) unsigned NOT NULL,
  `ag_tipoconsulta` char(1) NOT NULL DEFAULT 'C' COMMENT 'C = CONSULTA, R = RECONSULTA',
  `ag_atendido` char(1) NOT NULL DEFAULT '0',
  `ag_horafim` time DEFAULT '00:00:00',
  `ag_convenio` int(10) unsigned DEFAULT NULL,
  `ag_valorconsulta` decimal(10,2) DEFAULT NULL,
  `ag_observacoes` mediumtext,
  PRIMARY KEY (`ag_agenda`),
  KEY `FK_agenda_clientes` (`ag_paciente`),
  KEY `FK_agenda_convenios` (`ag_convenio`),
  CONSTRAINT `FK_agenda_clientes` FOREIGN KEY (`ag_paciente`) REFERENCES `clientes` (`cli_cliente`) ON UPDATE CASCADE,
  CONSTRAINT `FK_agenda_convenios` FOREIGN KEY (`ag_convenio`) REFERENCES `convenios` (`con_convenio`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clinica-medica`.`agenda`
--

/*!40000 ALTER TABLE `agenda` DISABLE KEYS */;
/*!40000 ALTER TABLE `agenda` ENABLE KEYS */;


--
-- Structure for table `clinica-medica`.`aliquotas`
--

DROP TABLE IF EXISTS `clinica-medica`.`aliquotas`;
CREATE TABLE  `clinica-medica`.`aliquotas` (
  `al_aliquota` int(10) unsigned NOT NULL,
  `al_situacaotributaria` int(10) unsigned NOT NULL,
  `al_aliquotanota` double NOT NULL,
  `al_basedecalculo` float NOT NULL,
  `al_descricaoaliquota` varchar(90) NOT NULL,
  `al_aliquotacupon` double NOT NULL,
  `al_situacaotributariacupom` char(1) DEFAULT NULL,
  PRIMARY KEY (`al_aliquota`),
  KEY `FK_aliquotas_situacao` (`al_situacaotributaria`),
  CONSTRAINT `FK_aliquotas_situacao` FOREIGN KEY (`al_situacaotributaria`) REFERENCES `situacoestributarias` (`sit_situacaotributaria`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clinica-medica`.`aliquotas`
--

/*!40000 ALTER TABLE `aliquotas` DISABLE KEYS */;
INSERT INTO `clinica-medica`.`aliquotas` (`al_aliquota`,`al_situacaotributaria`,`al_aliquotanota`,`al_basedecalculo`,`al_descricaoaliquota`,`al_aliquotacupon`,`al_situacaotributariacupom`) VALUES 
 (1,1,17,100,'Tributada',17,'T'),
 (2,4,0,0,'Isento',0,'I'),
 (4,2,17,100,'Substituição',0,'F'),
 (6,3,5,100,'Serviço',5,'S');
/*!40000 ALTER TABLE `aliquotas` ENABLE KEYS */;


--
-- Structure for table `clinica-medica`.`categoriasdemovimentacao`
--

DROP TABLE IF EXISTS `clinica-medica`.`categoriasdemovimentacao`;
CREATE TABLE  `clinica-medica`.`categoriasdemovimentacao` (
  `cat_categoria` int(11) NOT NULL,
  `cat_descricao` varchar(40) NOT NULL,
  `cat_grupo` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`cat_categoria`),
  KEY `FK_categoriasdemovimentacao_grupos` (`cat_grupo`),
  CONSTRAINT `FK_categoriasdemovimentacao_grupos` FOREIGN KEY (`cat_grupo`) REFERENCES `gruposcategorias` (`gcat_grupo`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clinica-medica`.`categoriasdemovimentacao`
--

/*!40000 ALTER TABLE `categoriasdemovimentacao` DISABLE KEYS */;
INSERT INTO `clinica-medica`.`categoriasdemovimentacao` (`cat_categoria`,`cat_descricao`,`cat_grupo`) VALUES 
 (1,'Conta de Luz',2),
 (2,'Condomínio',2),
 (3,'Aluguel',2),
 (4,'Alarme',2),
 (5,'Telefone',2),
 (6,'Mensalidade Bancos',2),
 (7,'Contabilidade',2),
 (8,'Compra em fornecedor',2),
 (9,'Consultas e atendimentos',1),
 (10,'Acerto de caixa',2),
 (11,'Vendas',1),
 (12,'Serviços prestados por terceiros',2),
 (13,'Vale',2),
 (14,'Salário',2),
 (15,'Faxina',2),
 (16,'Gastos gerais',2);
/*!40000 ALTER TABLE `categoriasdemovimentacao` ENABLE KEYS */;


--
-- Structure for table `clinica-medica`.`categoriasdeprodutos`
--

DROP TABLE IF EXISTS `clinica-medica`.`categoriasdeprodutos`;
CREATE TABLE  `clinica-medica`.`categoriasdeprodutos` (
  `catpro_categoriaproduto` int(10) unsigned NOT NULL,
  `catpro_descricao` varchar(80) NOT NULL,
  PRIMARY KEY (`catpro_categoriaproduto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clinica-medica`.`categoriasdeprodutos`
--

/*!40000 ALTER TABLE `categoriasdeprodutos` DISABLE KEYS */;
INSERT INTO `clinica-medica`.`categoriasdeprodutos` (`catpro_categoriaproduto`,`catpro_descricao`) VALUES 
 (1,'Medicamentos');
/*!40000 ALTER TABLE `categoriasdeprodutos` ENABLE KEYS */;


--
-- Structure for table `clinica-medica`.`categoriasdetrabalho`
--

DROP TABLE IF EXISTS `clinica-medica`.`categoriasdetrabalho`;
CREATE TABLE  `clinica-medica`.`categoriasdetrabalho` (
  `cat_categoriatrabalho` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cat_descricao` varchar(200) NOT NULL,
  PRIMARY KEY (`cat_categoriatrabalho`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clinica-medica`.`categoriasdetrabalho`
--

/*!40000 ALTER TABLE `categoriasdetrabalho` DISABLE KEYS */;
INSERT INTO `clinica-medica`.`categoriasdetrabalho` (`cat_categoriatrabalho`,`cat_descricao`) VALUES 
 (1,'Site'),
 (2,'Site + Sistema'),
 (3,'Manutenção (site ou sistema)'),
 (4,'Sistema');
/*!40000 ALTER TABLE `categoriasdetrabalho` ENABLE KEYS */;


--
-- Structure for table `clinica-medica`.`ceps`
--

DROP TABLE IF EXISTS `clinica-medica`.`ceps`;
CREATE TABLE  `clinica-medica`.`ceps` (
  `cep_cep` char(8) NOT NULL,
  `cep_cidade` int(10) unsigned NOT NULL,
  `cep_estado` int(10) unsigned NOT NULL,
  `cep_pais` int(10) unsigned NOT NULL,
  PRIMARY KEY (`cep_cep`),
  KEY `FK_ceps_cidades` (`cep_cidade`,`cep_estado`,`cep_pais`),
  CONSTRAINT `FK_ceps_cidades` FOREIGN KEY (`cep_cidade`, `cep_estado`, `cep_pais`) REFERENCES `cidades` (`cid_cidade`, `cid_estado`, `cid_pais`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clinica-medica`.`ceps`
--

/*!40000 ALTER TABLE `ceps` DISABLE KEYS */;
INSERT INTO `clinica-medica`.`ceps` (`cep_cep`,`cep_cidade`,`cep_estado`,`cep_pais`) VALUES 
 ('95680000',3,1,1),
 ('95670000',4,1,1),
 ('90240002',5,1,1),
 ('87043000',6,5,1),
 ('90240570',7,1,1),
 ('90200310',8,1,1),
 ('81630040',9,5,1),
 ('91060410',10,1,1),
 ('90470430',11,1,1),
 ('06460030',12,2,1),
 ('95780000',13,1,1),
 ('98268000',14,1,1);
/*!40000 ALTER TABLE `ceps` ENABLE KEYS */;


--
-- Structure for table `clinica-medica`.`cidades`
--

DROP TABLE IF EXISTS `clinica-medica`.`cidades`;
CREATE TABLE  `clinica-medica`.`cidades` (
  `cid_cidade` int(10) unsigned NOT NULL,
  `cid_estado` int(10) unsigned NOT NULL,
  `cid_pais` int(10) unsigned NOT NULL,
  `cid_nome` varchar(50) NOT NULL,
  PRIMARY KEY (`cid_cidade`,`cid_estado`,`cid_pais`),
  KEY `FK_cidades_1` (`cid_estado`,`cid_pais`),
  CONSTRAINT `FK_cidades_1` FOREIGN KEY (`cid_estado`, `cid_pais`) REFERENCES `estados` (`est_estado`, `est_pais`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='InnoDB free: 11264 kB';

--
-- Dumping data for table `clinica-medica`.`cidades`
--

/*!40000 ALTER TABLE `cidades` DISABLE KEYS */;
INSERT INTO `clinica-medica`.`cidades` (`cid_cidade`,`cid_estado`,`cid_pais`,`cid_nome`) VALUES 
 (1,1,1,'Canela'),
 (2,1,1,'Gramado'),
 (3,1,1,'Canela'),
 (4,1,1,'Gramado'),
 (5,1,1,'Porto Alegre'),
 (6,5,1,'Maringá'),
 (7,1,1,'Porto Alegre'),
 (8,1,1,'Porto Alegre'),
 (9,5,1,'Curitiba'),
 (10,1,1,'Porto Alegre'),
 (11,1,1,'Porto Alegre'),
 (12,2,1,'São Paulo'),
 (13,1,1,'Montenegro'),
 (14,1,1,'canela');
/*!40000 ALTER TABLE `cidades` ENABLE KEYS */;


--
-- Structure for table `clinica-medica`.`clientes`
--

DROP TABLE IF EXISTS `clinica-medica`.`clientes`;
CREATE TABLE  `clinica-medica`.`clientes` (
  `cli_cliente` int(10) unsigned NOT NULL,
  `cli_razaosocial` varchar(80) DEFAULT NULL,
  `cli_contato` varchar(45) DEFAULT NULL,
  `cli_cpf` varchar(15) DEFAULT NULL,
  `cli_cnpj` varchar(20) DEFAULT NULL,
  `cli_endereco` int(10) unsigned DEFAULT NULL,
  `cli_con_comercial` varchar(15) DEFAULT NULL,
  `cli_con_residencial` varchar(15) DEFAULT NULL,
  `cli_con_celular` varchar(15) DEFAULT NULL,
  `cli_con_email` varchar(45) DEFAULT NULL,
  `cli_observacoes` mediumtext,
  `cli_estahativo` char(1) NOT NULL,
  `cli_tipodepessoa` char(1) NOT NULL,
  `cli_inscricao_rg` varchar(20) DEFAULT NULL,
  `cli_clientedesde` date DEFAULT NULL,
  `cli_datanascimento` date DEFAULT NULL,
  PRIMARY KEY (`cli_cliente`),
  KEY `FK_clientes_end` (`cli_endereco`),
  CONSTRAINT `FK_clientes_end` FOREIGN KEY (`cli_endereco`) REFERENCES `enderecos` (`end_endereco`) ON UPDATE CASCADE,
  CONSTRAINT `FK_clientes_pessoas` FOREIGN KEY (`cli_cliente`) REFERENCES `pessoas` (`pes_pessoa`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `clinica-medica`.`clientes`
--

/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;


--
-- Structure for table `clinica-medica`.`comissoes`
--

DROP TABLE IF EXISTS `clinica-medica`.`comissoes`;
CREATE TABLE  `clinica-medica`.`comissoes` (
  `com_comissao` int(10) unsigned NOT NULL,
  `com_parceiro` int(10) unsigned NOT NULL,
  `com_pedido` int(10) unsigned NOT NULL,
  `com_valor` float NOT NULL,
  `com_datapagamento` date DEFAULT NULL,
  PRIMARY KEY (`com_comissao`),
  KEY `FK_comissoes_pedidos` (`com_pedido`),
  KEY `FK_comissoes_parceiros` (`com_parceiro`),
  CONSTRAINT `FK_comissoes_parceiros` FOREIGN KEY (`com_parceiro`) REFERENCES `parceiros` (`par_parceiro`) ON UPDATE CASCADE,
  CONSTRAINT `FK_comissoes_pedidos` FOREIGN KEY (`com_pedido`) REFERENCES `pedidos` (`ped_pedido`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clinica-medica`.`comissoes`
--

/*!40000 ALTER TABLE `comissoes` DISABLE KEYS */;
/*!40000 ALTER TABLE `comissoes` ENABLE KEYS */;


--
-- Structure for table `clinica-medica`.`condicoespagamento`
--

DROP TABLE IF EXISTS `clinica-medica`.`condicoespagamento`;
CREATE TABLE  `clinica-medica`.`condicoespagamento` (
  `con_condicao` int(10) unsigned NOT NULL,
  `con_descricao` varchar(45) NOT NULL,
  PRIMARY KEY (`con_condicao`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clinica-medica`.`condicoespagamento`
--

/*!40000 ALTER TABLE `condicoespagamento` DISABLE KEYS */;
INSERT INTO `clinica-medica`.`condicoespagamento` (`con_condicao`,`con_descricao`) VALUES 
 (1,'à vista'),
 (2,'à prazo');
/*!40000 ALTER TABLE `condicoespagamento` ENABLE KEYS */;


--
-- Structure for table `clinica-medica`.`contas`
--

DROP TABLE IF EXISTS `clinica-medica`.`contas`;
CREATE TABLE  `clinica-medica`.`contas` (
  `con_conta` int(11) NOT NULL,
  `con_agencia` varchar(10) DEFAULT NULL,
  `con_numeroconta` varchar(15) DEFAULT NULL,
  `con_nome` varchar(40) NOT NULL,
  `con_saldoatual` decimal(15,2) DEFAULT NULL,
  PRIMARY KEY (`con_conta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clinica-medica`.`contas`
--

/*!40000 ALTER TABLE `contas` DISABLE KEYS */;
INSERT INTO `clinica-medica`.`contas` (`con_conta`,`con_agencia`,`con_numeroconta`,`con_nome`,`con_saldoatual`) VALUES 
 (1,'','','Caixa','18.00');
/*!40000 ALTER TABLE `contas` ENABLE KEYS */;


--
-- Structure for table `clinica-medica`.`contasmovimentacao`
--

DROP TABLE IF EXISTS `clinica-medica`.`contasmovimentacao`;
CREATE TABLE  `clinica-medica`.`contasmovimentacao` (
  `com_movimentacao` int(10) unsigned NOT NULL,
  `com_conta` int(11) NOT NULL,
  `com_saldo` float NOT NULL,
  `com_valormovimentado` float NOT NULL,
  `com_tipopagamento` int(10) unsigned NOT NULL,
  `com_fluxodecaixa` int(10) unsigned NOT NULL,
  `com_datamovimentacao` date NOT NULL,
  `com_codigoordem` int(10) unsigned NOT NULL,
  PRIMARY KEY (`com_movimentacao`,`com_conta`,`com_codigoordem`) USING BTREE,
  KEY `FK_contasmovimentacao_conta` (`com_conta`),
  KEY `FK_contasmovimentacao_fluxo` (`com_fluxodecaixa`,`com_movimentacao`),
  KEY `FK_contasmovimentacao_tipopagamento` (`com_tipopagamento`),
  CONSTRAINT `FK_contasmovimentacao_conta` FOREIGN KEY (`com_conta`) REFERENCES `contas` (`con_conta`) ON UPDATE CASCADE,
  CONSTRAINT `FK_contasmovimentacao_fluxo` FOREIGN KEY (`com_fluxodecaixa`, `com_movimentacao`) REFERENCES `fluxodecaixa` (`flux_fluxodecaixa`, `flux_codigo`) ON UPDATE CASCADE,
  CONSTRAINT `FK_contasmovimentacao_tipopagamento` FOREIGN KEY (`com_tipopagamento`) REFERENCES `tiposdeconta` (`tip_tipoconta`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clinica-medica`.`contasmovimentacao`
--

/*!40000 ALTER TABLE `contasmovimentacao` DISABLE KEYS */;
/*!40000 ALTER TABLE `contasmovimentacao` ENABLE KEYS */;


--
-- Structure for table `clinica-medica`.`convenios`
--

DROP TABLE IF EXISTS `clinica-medica`.`convenios`;
CREATE TABLE  `clinica-medica`.`convenios` (
  `con_convenio` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `con_nome` varchar(75) NOT NULL,
  PRIMARY KEY (`con_convenio`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clinica-medica`.`convenios`
--

/*!40000 ALTER TABLE `convenios` DISABLE KEYS */;
INSERT INTO `clinica-medica`.`convenios` (`con_convenio`,`con_nome`) VALUES 
 (1,'Circulo'),
 (2,'IPE'),
 (3,'Unimed'),
 (4,'Particular');
/*!40000 ALTER TABLE `convenios` ENABLE KEYS */;


--
-- Structure for table `clinica-medica`.`destinocheque`
--

DROP TABLE IF EXISTS `clinica-medica`.`destinocheque`;
CREATE TABLE  `clinica-medica`.`destinocheque` (
  `des_destinocheque` int(10) unsigned NOT NULL,
  `des_descricao` varchar(45) NOT NULL,
  PRIMARY KEY (`des_destinocheque`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clinica-medica`.`destinocheque`
--

/*!40000 ALTER TABLE `destinocheque` DISABLE KEYS */;
INSERT INTO `clinica-medica`.`destinocheque` (`des_destinocheque`,`des_descricao`) VALUES 
 (1,'Depósito'),
 (2,'Custódia'),
 (3,'Pagamento');
/*!40000 ALTER TABLE `destinocheque` ENABLE KEYS */;


--
-- Structure for table `clinica-medica`.`diasapospagamento`
--

DROP TABLE IF EXISTS `clinica-medica`.`diasapospagamento`;
CREATE TABLE  `clinica-medica`.`diasapospagamento` (
  `dias_diasapos` int(10) unsigned NOT NULL,
  `dias_descricao` varchar(45) NOT NULL,
  PRIMARY KEY (`dias_diasapos`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clinica-medica`.`diasapospagamento`
--

/*!40000 ALTER TABLE `diasapospagamento` DISABLE KEYS */;
INSERT INTO `clinica-medica`.`diasapospagamento` (`dias_diasapos`,`dias_descricao`) VALUES 
 (1,'após data do pedido'),
 (2,'após data da entrada');
/*!40000 ALTER TABLE `diasapospagamento` ENABLE KEYS */;


--
-- Structure for table `clinica-medica`.`enderecos`
--

DROP TABLE IF EXISTS `clinica-medica`.`enderecos`;
CREATE TABLE  `clinica-medica`.`enderecos` (
  `end_endereco` int(10) unsigned NOT NULL,
  `end_logradouro` varchar(80) NOT NULL,
  `end_bairro` varchar(45) NOT NULL,
  `end_numero` varchar(10) NOT NULL,
  `end_cidade` int(10) unsigned DEFAULT NULL,
  `end_estado` int(10) unsigned DEFAULT NULL,
  `end_cep` varchar(8) NOT NULL,
  `end_complemento` varchar(50) DEFAULT NULL,
  `end_pais` int(10) unsigned NOT NULL,
  PRIMARY KEY (`end_endereco`),
  KEY `FK_enderecos` (`end_cidade`,`end_estado`,`end_pais`),
  CONSTRAINT `FK_enderecos` FOREIGN KEY (`end_cidade`, `end_estado`, `end_pais`) REFERENCES `cidades` (`cid_cidade`, `cid_estado`, `cid_pais`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `clinica-medica`.`enderecos`
--

/*!40000 ALTER TABLE `enderecos` DISABLE KEYS */;
INSERT INTO `clinica-medica`.`enderecos` (`end_endereco`,`end_logradouro`,`end_bairro`,`end_numero`,`end_cidade`,`end_estado`,`end_cep`,`end_complemento`,`end_pais`) VALUES 
 (1,'Rua X','Centro','1',1,1,'95680000','',1),
 (2,'Av. Borges de Medeiros','Centro','97',1,1,'95680000','sala 08',1);
/*!40000 ALTER TABLE `enderecos` ENABLE KEYS */;


--
-- Structure for table `clinica-medica`.`estados`
--

DROP TABLE IF EXISTS `clinica-medica`.`estados`;
CREATE TABLE  `clinica-medica`.`estados` (
  `est_estado` int(10) unsigned NOT NULL,
  `est_nome` varchar(50) NOT NULL,
  `est_sigla` char(3) NOT NULL,
  `est_pais` int(10) unsigned NOT NULL,
  PRIMARY KEY (`est_estado`,`est_pais`),
  KEY `FK_estados_paises` (`est_pais`),
  CONSTRAINT `FK_estados_paises` FOREIGN KEY (`est_pais`) REFERENCES `paises` (`pai_pais`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clinica-medica`.`estados`
--

/*!40000 ALTER TABLE `estados` DISABLE KEYS */;
INSERT INTO `clinica-medica`.`estados` (`est_estado`,`est_nome`,`est_sigla`,`est_pais`) VALUES 
 (1,'Rio Grande do Sul','RS',1),
 (2,'São Paulo','SP',1),
 (3,'Minas Gerais','MG',1),
 (4,'Santa Catarina','SC',1),
 (5,'Paraná','PR',1),
 (6,'Pará','PA',1),
 (7,'Distrito Federal','DF',1),
 (8,'Espírito Santo','ES',1),
 (9,'Bahia','BA',1),
 (10,'Tocantins','TO',1),
 (11,'Acre','AC',1),
 (12,'Maranhão','MA',1),
 (13,'Amazonas','AM',1),
 (14,'Mato Grosso','MT',1),
 (15,'Mato Grosso do Sul','MS',1),
 (16,'Alagoas','AL',1),
 (17,'Amapá','AP',1),
 (18,'Ceará','CE',1),
 (19,'Rio Grande do Norte','RN',1),
 (20,'Paraíba','PB',1),
 (21,'Sergipe','SE',1),
 (22,'Rio de Janeiro','RJ',1),
 (23,'Goiás','GO',1),
 (24,'Rondônia','RO',1),
 (25,'Roraima','RR',1),
 (26,'Piauí','PI',1),
 (27,'Pernambuco','PE',1);
/*!40000 ALTER TABLE `estados` ENABLE KEYS */;


--
-- Structure for table `clinica-medica`.`fluxodecaixa`
--

DROP TABLE IF EXISTS `clinica-medica`.`fluxodecaixa`;
CREATE TABLE  `clinica-medica`.`fluxodecaixa` (
  `flux_fluxodecaixa` int(10) unsigned NOT NULL,
  `flux_parcela` int(10) unsigned NOT NULL,
  `flux_qtdparcelas` int(10) unsigned NOT NULL,
  `flux_codpessoa` int(10) unsigned NOT NULL,
  `flux_datapagamento` date DEFAULT NULL,
  `flux_datavencimento` date NOT NULL,
  `flux_dataemissao` date NOT NULL,
  `flux_codigo` int(10) unsigned NOT NULL,
  `flux_valor` decimal(15,2) DEFAULT NULL,
  `flux_estahpago` char(2) NOT NULL DEFAULT 'N',
  `flux_descricao` varchar(80) DEFAULT NULL,
  `flux_formapagamento` int(10) unsigned NOT NULL,
  `flux_codconta` int(11) DEFAULT NULL,
  `flux_tipopagamento` int(10) unsigned NOT NULL,
  `flux_categoriamovimentacao` int(11) NOT NULL,
  `flux_cedente` int(10) unsigned DEFAULT NULL,
  `flux_agenda` int(10) unsigned DEFAULT NULL,
  `flux_valortotal` decimal(15,2) DEFAULT NULL,
  `flux_codpedido` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`flux_fluxodecaixa`,`flux_codigo`),
  KEY `FK_fluxodecaixa_pessoa` (`flux_codpessoa`),
  KEY `FK_fluxodecaixa_contas` (`flux_codconta`),
  KEY `FK_fluxodecaixa_tipopagamento` (`flux_tipopagamento`),
  KEY `FK_fluxodecaixa_categoria` (`flux_categoriamovimentacao`),
  KEY `FK_fluxodecaixa_formapagto` (`flux_formapagamento`),
  KEY `FK_fluxodecaixa_agenda` (`flux_agenda`),
  CONSTRAINT `FK_fluxodecaixa_agenda` FOREIGN KEY (`flux_agenda`) REFERENCES `agenda` (`ag_agenda`) ON UPDATE CASCADE,
  CONSTRAINT `FK_fluxodecaixa_categoriamovimentacao` FOREIGN KEY (`flux_categoriamovimentacao`) REFERENCES `categoriasdemovimentacao` (`cat_categoria`) ON UPDATE CASCADE,
  CONSTRAINT `FK_fluxodecaixa_contas` FOREIGN KEY (`flux_codconta`) REFERENCES `contas` (`con_conta`) ON UPDATE CASCADE,
  CONSTRAINT `FK_fluxodecaixa_formapagto` FOREIGN KEY (`flux_formapagamento`) REFERENCES `formaspagamento` (`form_formapagto`) ON UPDATE CASCADE,
  CONSTRAINT `FK_fluxodecaixa_pessoa` FOREIGN KEY (`flux_codpessoa`) REFERENCES `pessoas` (`pes_pessoa`) ON UPDATE CASCADE,
  CONSTRAINT `FK_fluxodecaixa_tipopagamento` FOREIGN KEY (`flux_tipopagamento`) REFERENCES `tiposdeconta` (`tip_tipoconta`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clinica-medica`.`fluxodecaixa`
--

/*!40000 ALTER TABLE `fluxodecaixa` DISABLE KEYS */;
/*!40000 ALTER TABLE `fluxodecaixa` ENABLE KEYS */;


--
-- Structure for table `clinica-medica`.`formaspagamento`
--

DROP TABLE IF EXISTS `clinica-medica`.`formaspagamento`;
CREATE TABLE  `clinica-medica`.`formaspagamento` (
  `form_formapagto` int(10) unsigned NOT NULL,
  `form_descricao` varchar(45) NOT NULL,
  PRIMARY KEY (`form_formapagto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clinica-medica`.`formaspagamento`
--

/*!40000 ALTER TABLE `formaspagamento` DISABLE KEYS */;
INSERT INTO `clinica-medica`.`formaspagamento` (`form_formapagto`,`form_descricao`) VALUES 
 (1,'boleto'),
 (2,'cheque'),
 (3,'dinheiro'),
 (4,'cartão');
/*!40000 ALTER TABLE `formaspagamento` ENABLE KEYS */;


--
-- Structure for table `clinica-medica`.`fornecedores`
--

DROP TABLE IF EXISTS `clinica-medica`.`fornecedores`;
CREATE TABLE  `clinica-medica`.`fornecedores` (
  `for_fornecedor` int(10) unsigned NOT NULL,
  `for_razaosocial` varchar(80) DEFAULT NULL,
  `for_contato` varchar(45) DEFAULT NULL,
  `for_cpf` varchar(15) DEFAULT NULL,
  `for_cnpj` varchar(20) DEFAULT NULL,
  `for_endereco` int(10) unsigned NOT NULL,
  `for_con_comercial` varchar(15) DEFAULT NULL,
  `for_con_residencial` varchar(15) DEFAULT NULL,
  `for_con_celular` varchar(15) DEFAULT NULL,
  `for_con_email` varchar(45) DEFAULT NULL,
  `for_observacoes` mediumtext,
  `for_estahativo` char(1) NOT NULL,
  `for_tipodepessoa` char(1) NOT NULL,
  `for_inscricao_rg` varchar(15) NOT NULL,
  PRIMARY KEY (`for_fornecedor`),
  KEY `FK_fornecedores_end` (`for_endereco`),
  CONSTRAINT `FK_fornecedores_end` FOREIGN KEY (`for_endereco`) REFERENCES `enderecos` (`end_endereco`) ON UPDATE CASCADE,
  CONSTRAINT `FK_fornecedores_pessoas` FOREIGN KEY (`for_fornecedor`) REFERENCES `pessoas` (`pes_pessoa`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `clinica-medica`.`fornecedores`
--

/*!40000 ALTER TABLE `fornecedores` DISABLE KEYS */;
/*!40000 ALTER TABLE `fornecedores` ENABLE KEYS */;


--
-- Structure for table `clinica-medica`.`gruposcategorias`
--

DROP TABLE IF EXISTS `clinica-medica`.`gruposcategorias`;
CREATE TABLE  `clinica-medica`.`gruposcategorias` (
  `gcat_grupo` int(10) unsigned NOT NULL,
  `gcat_descricao` varchar(45) NOT NULL,
  PRIMARY KEY (`gcat_grupo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clinica-medica`.`gruposcategorias`
--

/*!40000 ALTER TABLE `gruposcategorias` DISABLE KEYS */;
INSERT INTO `clinica-medica`.`gruposcategorias` (`gcat_grupo`,`gcat_descricao`) VALUES 
 (1,'Entrada'),
 (2,'Saida');
/*!40000 ALTER TABLE `gruposcategorias` ENABLE KEYS */;


--
-- Structure for table `clinica-medica`.`horarios`
--

DROP TABLE IF EXISTS `clinica-medica`.`horarios`;
CREATE TABLE  `clinica-medica`.`horarios` (
  `horario` time NOT NULL,
  PRIMARY KEY (`horario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clinica-medica`.`horarios`
--

/*!40000 ALTER TABLE `horarios` DISABLE KEYS */;
INSERT INTO `clinica-medica`.`horarios` (`horario`) VALUES 
 ('08:00:00'),
 ('08:15:00'),
 ('08:30:00'),
 ('08:45:00'),
 ('09:00:00'),
 ('09:15:00'),
 ('09:30:00'),
 ('09:45:00'),
 ('10:00:00'),
 ('10:15:00'),
 ('10:30:00'),
 ('10:45:00'),
 ('11:00:00'),
 ('11:15:00'),
 ('11:30:00'),
 ('11:45:00'),
 ('13:00:00'),
 ('13:15:00'),
 ('13:30:00'),
 ('13:45:00'),
 ('14:00:00'),
 ('14:15:00'),
 ('14:30:00'),
 ('14:45:00'),
 ('15:00:00'),
 ('15:15:00'),
 ('15:30:00'),
 ('15:45:00'),
 ('16:00:00'),
 ('16:15:00'),
 ('16:30:00'),
 ('16:45:00'),
 ('17:00:00'),
 ('17:15:00'),
 ('17:30:00'),
 ('17:45:00'),
 ('18:00:00'),
 ('18:15:00'),
 ('18:30:00'),
 ('18:45:00'),
 ('19:00:00'),
 ('19:15:00'),
 ('19:30:00');
/*!40000 ALTER TABLE `horarios` ENABLE KEYS */;


--
-- Structure for table `clinica-medica`.`marcas`
--

DROP TABLE IF EXISTS `clinica-medica`.`marcas`;
CREATE TABLE  `clinica-medica`.`marcas` (
  `mar_marca` int(10) unsigned NOT NULL,
  `mar_nome` varchar(50) NOT NULL,
  PRIMARY KEY (`mar_marca`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clinica-medica`.`marcas`
--

/*!40000 ALTER TABLE `marcas` DISABLE KEYS */;
INSERT INTO `clinica-medica`.`marcas` (`mar_marca`,`mar_nome`) VALUES 
 (1,'Roche');
/*!40000 ALTER TABLE `marcas` ENABLE KEYS */;


--
-- Structure for table `clinica-medica`.`naturezasdeoperacao`
--

DROP TABLE IF EXISTS `clinica-medica`.`naturezasdeoperacao`;
CREATE TABLE  `clinica-medica`.`naturezasdeoperacao` (
  `nat_natdeoperacao` int(10) unsigned NOT NULL,
  `nat_naturezadeoperacao` varchar(100) NOT NULL,
  `nat_cfop` varchar(10) NOT NULL,
  `nat_calculaimposto` char(1) NOT NULL,
  `nat_calculaipi` char(1) NOT NULL,
  `nat_baixaemestoque` char(1) NOT NULL DEFAULT 'n',
  PRIMARY KEY (`nat_natdeoperacao`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clinica-medica`.`naturezasdeoperacao`
--

/*!40000 ALTER TABLE `naturezasdeoperacao` DISABLE KEYS */;
INSERT INTO `clinica-medica`.`naturezasdeoperacao` (`nat_natdeoperacao`,`nat_naturezadeoperacao`,`nat_cfop`,`nat_calculaimposto`,`nat_calculaipi`,`nat_baixaemestoque`) VALUES 
 (1,'Venda de Mercadoria Adquirida ou Recebida de Terceiros','5102','s','s','n');
/*!40000 ALTER TABLE `naturezasdeoperacao` ENABLE KEYS */;


--
-- Structure for table `clinica-medica`.`orcamentos`
--

DROP TABLE IF EXISTS `clinica-medica`.`orcamentos`;
CREATE TABLE  `clinica-medica`.`orcamentos` (
  `orc_orcamento` int(10) unsigned NOT NULL DEFAULT '0',
  `orc_descricao` varchar(80) NOT NULL,
  `orc_cliente` int(10) unsigned NOT NULL,
  `orc_data` date NOT NULL,
  `orc_total` float NOT NULL,
  `orc_situacao` int(10) unsigned NOT NULL,
  `orc_responsavel` int(10) unsigned NOT NULL,
  `orc_parceiro` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`orc_orcamento`),
  KEY `FK_orcamentos_cli` (`orc_cliente`),
  KEY `FK_orcamentos_sit` (`orc_situacao`),
  KEY `FK_orcamentos_users` (`orc_responsavel`),
  KEY `FK_orcamentos_parceiros` (`orc_parceiro`),
  CONSTRAINT `FK_orcamentos_cli` FOREIGN KEY (`orc_cliente`) REFERENCES `clientes` (`cli_cliente`) ON UPDATE CASCADE,
  CONSTRAINT `FK_orcamentos_parceiros` FOREIGN KEY (`orc_parceiro`) REFERENCES `parceiros` (`par_parceiro`) ON UPDATE CASCADE,
  CONSTRAINT `FK_orcamentos_sit` FOREIGN KEY (`orc_situacao`) REFERENCES `situacoes` (`sit_situacao`) ON UPDATE CASCADE,
  CONSTRAINT `FK_orcamentos_users` FOREIGN KEY (`orc_responsavel`) REFERENCES `usuarios` (`usu_usuario`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clinica-medica`.`orcamentos`
--

/*!40000 ALTER TABLE `orcamentos` DISABLE KEYS */;
/*!40000 ALTER TABLE `orcamentos` ENABLE KEYS */;


--
-- Structure for table `clinica-medica`.`orcamentos_produtos`
--

DROP TABLE IF EXISTS `clinica-medica`.`orcamentos_produtos`;
CREATE TABLE  `clinica-medica`.`orcamentos_produtos` (
  `orcpro_orcamentosprodutos` int(10) unsigned NOT NULL DEFAULT '0',
  `orcpro_orcamento` int(10) unsigned NOT NULL,
  `orcpro_produto` int(10) unsigned NOT NULL,
  `orcpro_quantidade` float DEFAULT NULL,
  `orcpro_subtotal` float NOT NULL,
  `orcpro_valorunitario` float DEFAULT NULL,
  PRIMARY KEY (`orcpro_orcamentosprodutos`),
  KEY `FK_orcamentos_produtos` (`orcpro_orcamento`),
  KEY `FK_orcamentos_produtos_2` (`orcpro_produto`),
  CONSTRAINT `FK_orcamentos_produtos` FOREIGN KEY (`orcpro_orcamento`) REFERENCES `orcamentos` (`orc_orcamento`) ON UPDATE CASCADE,
  CONSTRAINT `FK_orcamentos_produtos_2` FOREIGN KEY (`orcpro_produto`) REFERENCES `produtos` (`pro_produto`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clinica-medica`.`orcamentos_produtos`
--

/*!40000 ALTER TABLE `orcamentos_produtos` DISABLE KEYS */;
/*!40000 ALTER TABLE `orcamentos_produtos` ENABLE KEYS */;


--
-- Structure for table `clinica-medica`.`orcamentoscondicoespagamento`
--

DROP TABLE IF EXISTS `clinica-medica`.`orcamentoscondicoespagamento`;
CREATE TABLE  `clinica-medica`.`orcamentoscondicoespagamento` (
  `ocon_orcamentocondicaopagamento` int(10) unsigned NOT NULL,
  `ocon_orcamento` int(10) unsigned NOT NULL,
  `ocon_condicaopagamento` int(10) unsigned NOT NULL,
  `ocon_qtdparcelas` int(10) unsigned DEFAULT NULL,
  `ocon_desconto` int(10) unsigned DEFAULT NULL,
  `ocon_estahaprovado` char(1) DEFAULT NULL,
  PRIMARY KEY (`ocon_orcamentocondicaopagamento`),
  KEY `FK_orcamentoscondicoespagamento_1` (`ocon_orcamento`),
  KEY `FK_orcamentoscondicoespagamento_2` (`ocon_condicaopagamento`),
  CONSTRAINT `FK_orcamentoscondicoespagamento_1` FOREIGN KEY (`ocon_orcamento`) REFERENCES `orcamentos` (`orc_orcamento`) ON UPDATE CASCADE,
  CONSTRAINT `FK_orcamentoscondicoespagamento_2` FOREIGN KEY (`ocon_condicaopagamento`) REFERENCES `condicoespagamento` (`con_condicao`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clinica-medica`.`orcamentoscondicoespagamento`
--

/*!40000 ALTER TABLE `orcamentoscondicoespagamento` DISABLE KEYS */;
/*!40000 ALTER TABLE `orcamentoscondicoespagamento` ENABLE KEYS */;


--
-- Structure for table `clinica-medica`.`ordensdeservico`
--

DROP TABLE IF EXISTS `clinica-medica`.`ordensdeservico`;
CREATE TABLE  `clinica-medica`.`ordensdeservico` (
  `ord_ordemdeservico` int(10) unsigned NOT NULL DEFAULT '0',
  `ord_cliente` int(10) unsigned NOT NULL,
  `ord_responsavel` int(10) unsigned NOT NULL,
  `ord_situacao` int(10) unsigned NOT NULL,
  `ord_defeito` mediumtext NOT NULL,
  `ord_dataentrada` date NOT NULL,
  `ord_datasaida` date DEFAULT NULL,
  `ord_valor` float DEFAULT NULL,
  `ord_equipamento` varchar(100) NOT NULL,
  `ord_observacoes` mediumtext,
  PRIMARY KEY (`ord_ordemdeservico`),
  KEY `FK_ordensdeservico_clientes` (`ord_cliente`),
  KEY `FK_ordensdeservico_usuarios` (`ord_responsavel`),
  KEY `FK_ordensdeservico_situacoes` (`ord_situacao`),
  CONSTRAINT `FK_ordensdeservico_clientes` FOREIGN KEY (`ord_cliente`) REFERENCES `clientes` (`cli_cliente`) ON UPDATE CASCADE,
  CONSTRAINT `FK_ordensdeservico_situacoes` FOREIGN KEY (`ord_situacao`) REFERENCES `situacoes` (`sit_situacao`) ON UPDATE CASCADE,
  CONSTRAINT `FK_ordensdeservico_usuarios` FOREIGN KEY (`ord_responsavel`) REFERENCES `usuarios` (`usu_usuario`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clinica-medica`.`ordensdeservico`
--

/*!40000 ALTER TABLE `ordensdeservico` DISABLE KEYS */;
/*!40000 ALTER TABLE `ordensdeservico` ENABLE KEYS */;


--
-- Structure for table `clinica-medica`.`ordensprodutos`
--

DROP TABLE IF EXISTS `clinica-medica`.`ordensprodutos`;
CREATE TABLE  `clinica-medica`.`ordensprodutos` (
  `orde_ordenproduto` int(10) unsigned NOT NULL,
  `orde_ordemdeservico` int(10) unsigned NOT NULL,
  `orde_produto` int(10) unsigned NOT NULL,
  `orde_quantidade` int(10) unsigned NOT NULL,
  `orde_valorunitario` float NOT NULL,
  `orde_subtotal` float NOT NULL,
  PRIMARY KEY (`orde_ordenproduto`),
  KEY `FK_ordensprodutos_produto` (`orde_produto`),
  KEY `FK_ordensprodutos_ordens` (`orde_ordemdeservico`),
  CONSTRAINT `FK_ordensprodutos_ordens` FOREIGN KEY (`orde_ordemdeservico`) REFERENCES `ordensdeservico` (`ord_ordemdeservico`) ON UPDATE CASCADE,
  CONSTRAINT `FK_ordensprodutos_produto` FOREIGN KEY (`orde_produto`) REFERENCES `produtos` (`pro_produto`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clinica-medica`.`ordensprodutos`
--

/*!40000 ALTER TABLE `ordensprodutos` DISABLE KEYS */;
/*!40000 ALTER TABLE `ordensprodutos` ENABLE KEYS */;


--
-- Structure for table `clinica-medica`.`paises`
--

DROP TABLE IF EXISTS `clinica-medica`.`paises`;
CREATE TABLE  `clinica-medica`.`paises` (
  `pai_pais` int(10) unsigned NOT NULL,
  `pai_nome` varchar(45) NOT NULL,
  PRIMARY KEY (`pai_pais`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clinica-medica`.`paises`
--

/*!40000 ALTER TABLE `paises` DISABLE KEYS */;
INSERT INTO `clinica-medica`.`paises` (`pai_pais`,`pai_nome`) VALUES 
 (1,'Brasil');
/*!40000 ALTER TABLE `paises` ENABLE KEYS */;


--
-- Structure for table `clinica-medica`.`parametros`
--

DROP TABLE IF EXISTS `clinica-medica`.`parametros`;
CREATE TABLE  `clinica-medica`.`parametros` (
  `par_parametros` int(10) unsigned NOT NULL,
  `par_taxadejuros` float NOT NULL,
  PRIMARY KEY (`par_parametros`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clinica-medica`.`parametros`
--

/*!40000 ALTER TABLE `parametros` DISABLE KEYS */;
INSERT INTO `clinica-medica`.`parametros` (`par_parametros`,`par_taxadejuros`) VALUES 
 (1,3.2);
/*!40000 ALTER TABLE `parametros` ENABLE KEYS */;


--
-- Structure for table `clinica-medica`.`parceiros`
--

DROP TABLE IF EXISTS `clinica-medica`.`parceiros`;
CREATE TABLE  `clinica-medica`.`parceiros` (
  `par_parceiro` int(10) unsigned NOT NULL,
  `par_razaosocial` varchar(80) DEFAULT NULL,
  `par_contato` varchar(45) DEFAULT NULL,
  `par_cpf` varchar(15) DEFAULT NULL,
  `par_cnpj` varchar(20) DEFAULT NULL,
  `par_endereco` int(10) unsigned NOT NULL,
  `par_con_comercial` varchar(15) DEFAULT NULL,
  `par_con_residencial` varchar(15) DEFAULT NULL,
  `par_con_celular` varchar(15) DEFAULT NULL,
  `par_con_email` varchar(45) DEFAULT NULL,
  `par_observacoes` mediumtext,
  `par_estahativo` char(1) NOT NULL,
  `par_tipodepessoa` char(1) NOT NULL,
  `par_inscricao_rg` varchar(15) NOT NULL,
  PRIMARY KEY (`par_parceiro`),
  KEY `FK_parceiros_end` (`par_endereco`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `clinica-medica`.`parceiros`
--

/*!40000 ALTER TABLE `parceiros` DISABLE KEYS */;
INSERT INTO `clinica-medica`.`parceiros` (`par_parceiro`,`par_razaosocial`,`par_contato`,`par_cpf`,`par_cnpj`,`par_endereco`,`par_con_comercial`,`par_con_residencial`,`par_con_celular`,`par_con_email`,`par_observacoes`,`par_estahativo`,`par_tipodepessoa`,`par_inscricao_rg`) VALUES 
 (11,'','','454.545.454-54','',11,'(54) 3286 6666','','','','','S','F','454545454');
/*!40000 ALTER TABLE `parceiros` ENABLE KEYS */;


--
-- Structure for table `clinica-medica`.`pedidos`
--

DROP TABLE IF EXISTS `clinica-medica`.`pedidos`;
CREATE TABLE  `clinica-medica`.`pedidos` (
  `ped_pedido` int(10) unsigned NOT NULL,
  `ped_data` date NOT NULL,
  `ped_formapagto` int(10) unsigned NOT NULL,
  `ped_intervalo` int(10) unsigned DEFAULT NULL,
  `ped_diasapos` int(10) unsigned DEFAULT NULL,
  `ped_valortotal` float NOT NULL,
  `ped_responsavel` int(10) unsigned NOT NULL,
  `ped_parceiro` int(10) unsigned DEFAULT NULL,
  `ped_orcamento` int(10) unsigned DEFAULT NULL,
  `ped_cliente` int(10) unsigned NOT NULL,
  `ped_descricao` varchar(80) DEFAULT NULL,
  `ped_os` int(10) unsigned DEFAULT NULL,
  `ped_condicao` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`ped_pedido`),
  KEY `FK_pedidos_formas` (`ped_formapagto`),
  KEY `FK_pedidos_dias` (`ped_diasapos`),
  KEY `FK_pedidos_users` (`ped_responsavel`),
  KEY `FK_pedidos_parceiros` (`ped_parceiro`),
  KEY `FK_pedidos_orcamentos` (`ped_orcamento`),
  KEY `FK_pedidos_os` (`ped_os`),
  KEY `FK_pedidos_condicoes` (`ped_condicao`),
  CONSTRAINT `FK_pedidos_condicoes` FOREIGN KEY (`ped_condicao`) REFERENCES `condicoespagamento` (`con_condicao`) ON UPDATE CASCADE,
  CONSTRAINT `FK_pedidos_dias` FOREIGN KEY (`ped_diasapos`) REFERENCES `diasapospagamento` (`dias_diasapos`) ON UPDATE CASCADE,
  CONSTRAINT `FK_pedidos_formas` FOREIGN KEY (`ped_formapagto`) REFERENCES `formaspagamento` (`form_formapagto`) ON UPDATE CASCADE,
  CONSTRAINT `FK_pedidos_orcamentos` FOREIGN KEY (`ped_orcamento`) REFERENCES `orcamentos` (`orc_orcamento`) ON UPDATE CASCADE,
  CONSTRAINT `FK_pedidos_os` FOREIGN KEY (`ped_os`) REFERENCES `ordensdeservico` (`ord_ordemdeservico`) ON UPDATE CASCADE,
  CONSTRAINT `FK_pedidos_parceiros` FOREIGN KEY (`ped_parceiro`) REFERENCES `parceiros` (`par_parceiro`) ON UPDATE CASCADE,
  CONSTRAINT `FK_pedidos_users` FOREIGN KEY (`ped_responsavel`) REFERENCES `usuarios` (`usu_usuario`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clinica-medica`.`pedidos`
--

/*!40000 ALTER TABLE `pedidos` DISABLE KEYS */;
/*!40000 ALTER TABLE `pedidos` ENABLE KEYS */;


--
-- Structure for table `clinica-medica`.`pedidosprodutos`
--

DROP TABLE IF EXISTS `clinica-medica`.`pedidosprodutos`;
CREATE TABLE  `clinica-medica`.`pedidosprodutos` (
  `pedp_pedidosprodutos` int(10) unsigned NOT NULL,
  `pedp_pedido` int(10) unsigned NOT NULL,
  `pedp_produto` int(10) unsigned NOT NULL,
  `pedp_valorunitario` float NOT NULL,
  `pedp_quantidade` float NOT NULL,
  `pedp_subtotal` float NOT NULL,
  PRIMARY KEY (`pedp_pedidosprodutos`),
  KEY `FK_pedidosprodutos_pedido` (`pedp_pedido`),
  KEY `FK_pedidosprodutos_produto` (`pedp_produto`),
  CONSTRAINT `FK_pedidosprodutos_pedido` FOREIGN KEY (`pedp_pedido`) REFERENCES `pedidos` (`ped_pedido`) ON UPDATE CASCADE,
  CONSTRAINT `FK_pedidosprodutos_produto` FOREIGN KEY (`pedp_produto`) REFERENCES `produtos` (`pro_produto`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clinica-medica`.`pedidosprodutos`
--

/*!40000 ALTER TABLE `pedidosprodutos` DISABLE KEYS */;
/*!40000 ALTER TABLE `pedidosprodutos` ENABLE KEYS */;


--
-- Structure for table `clinica-medica`.`permissoes`
--

DROP TABLE IF EXISTS `clinica-medica`.`permissoes`;
CREATE TABLE  `clinica-medica`.`permissoes` (
  `per_permissao` int(10) unsigned NOT NULL,
  `per_descricao` varchar(45) NOT NULL,
  PRIMARY KEY (`per_permissao`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clinica-medica`.`permissoes`
--

/*!40000 ALTER TABLE `permissoes` DISABLE KEYS */;
INSERT INTO `clinica-medica`.`permissoes` (`per_permissao`,`per_descricao`) VALUES 
 (1,'cadastrar produtos'),
 (2,'cadastrar orçamentos e pedidos'),
 (3,'cadastrar usuários');
/*!40000 ALTER TABLE `permissoes` ENABLE KEYS */;


--
-- Structure for table `clinica-medica`.`pessoas`
--

DROP TABLE IF EXISTS `clinica-medica`.`pessoas`;
CREATE TABLE  `clinica-medica`.`pessoas` (
  `pes_pessoa` int(10) unsigned NOT NULL,
  `pes_nome` varchar(80) NOT NULL,
  PRIMARY KEY (`pes_pessoa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clinica-medica`.`pessoas`
--

/*!40000 ALTER TABLE `pessoas` DISABLE KEYS */;
INSERT INTO `clinica-medica`.`pessoas` (`pes_pessoa`,`pes_nome`) VALUES 
 (1,'Administrador'),
 (2,'Denes Stumpf');
/*!40000 ALTER TABLE `pessoas` ENABLE KEYS */;


--
-- Structure for table `clinica-medica`.`pit`
--

DROP TABLE IF EXISTS `clinica-medica`.`pit`;
CREATE TABLE  `clinica-medica`.`pit` (
  `pit_pit` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pit_titulo` varchar(200) NOT NULL,
  `pit_descricao` text NOT NULL,
  `pit_cliente` int(10) unsigned NOT NULL,
  `pit_dataprazo` date NOT NULL,
  `pit_datacriacao` date NOT NULL,
  `pit_categoria` int(10) unsigned NOT NULL,
  `pit_status` int(10) unsigned DEFAULT NULL,
  `pit_valor` decimal(15,2) DEFAULT NULL,
  `pit_responsavel` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`pit_pit`),
  KEY `FK_pit_categorias` (`pit_categoria`),
  CONSTRAINT `FK_pit_categorias` FOREIGN KEY (`pit_categoria`) REFERENCES `categoriasdetrabalho` (`cat_categoriatrabalho`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clinica-medica`.`pit`
--

/*!40000 ALTER TABLE `pit` DISABLE KEYS */;
INSERT INTO `clinica-medica`.`pit` (`pit_pit`,`pit_titulo`,`pit_descricao`,`pit_cliente`,`pit_dataprazo`,`pit_datacriacao`,`pit_categoria`,`pit_status`,`pit_valor`,`pit_responsavel`) VALUES 
 (1,'Criação de Banners','Criação de banners para a  página inicial e popup.',148,'2013-02-15','2013-02-11',3,4,'140.00',NULL),
 (2,'Atualização Sistema Logicbox','Instalar atualização do sistema para gerar inventário em uma data anterior. \r\nCobrar depois do carnaval.',149,'2013-02-13','2013-02-13',4,4,'300.00',2),
 (3,'Site de Compras Coletivas','Site está pronto, falta atualizar o cadastro no pagseguro e realizar novos testes.',150,'2013-02-28','2013-02-14',1,2,'0.00',2);
/*!40000 ALTER TABLE `pit` ENABLE KEYS */;


--
-- Structure for table `clinica-medica`.`produtos`
--

DROP TABLE IF EXISTS `clinica-medica`.`produtos`;
CREATE TABLE  `clinica-medica`.`produtos` (
  `pro_produto` int(10) unsigned NOT NULL,
  `pro_nome` varchar(50) NOT NULL,
  `pro_descricao` mediumtext,
  `pro_valorcompra` float NOT NULL,
  `pro_valorvenda` float NOT NULL,
  `pro_quantidade` float NOT NULL DEFAULT '0',
  `pro_marca` int(10) unsigned NOT NULL,
  `pro_unidade` varchar(10) NOT NULL,
  `pro_codbarras` varchar(80) DEFAULT NULL,
  `pro_categoriaproduto` int(10) unsigned NOT NULL DEFAULT '1',
  `pro_margem` float DEFAULT NULL,
  `pro_fornecedor` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`pro_produto`),
  KEY `FK_produtos_marcas` (`pro_marca`),
  KEY `FK_produtos_categorias` (`pro_categoriaproduto`),
  KEY `FK_produtos_fornecedor` (`pro_fornecedor`),
  CONSTRAINT `FK_produtos_categorias` FOREIGN KEY (`pro_categoriaproduto`) REFERENCES `categoriasdeprodutos` (`catpro_categoriaproduto`) ON UPDATE CASCADE,
  CONSTRAINT `FK_produtos_fornecedor` FOREIGN KEY (`pro_fornecedor`) REFERENCES `fornecedores` (`for_fornecedor`) ON UPDATE CASCADE,
  CONSTRAINT `FK_produtos_marcas` FOREIGN KEY (`pro_marca`) REFERENCES `marcas` (`mar_marca`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clinica-medica`.`produtos`
--

/*!40000 ALTER TABLE `produtos` DISABLE KEYS */;
INSERT INTO `clinica-medica`.`produtos` (`pro_produto`,`pro_nome`,`pro_descricao`,`pro_valorcompra`,`pro_valorvenda`,`pro_quantidade`,`pro_marca`,`pro_unidade`,`pro_codbarras`,`pro_categoriaproduto`,`pro_margem`,`pro_fornecedor`) VALUES 
 (1,'Vacina Polivalente','   ',40,91.43,100,1,'un','',1,128.58,NULL);
/*!40000 ALTER TABLE `produtos` ENABLE KEYS */;


--
-- Structure for table `clinica-medica`.`setores`
--

DROP TABLE IF EXISTS `clinica-medica`.`setores`;
CREATE TABLE  `clinica-medica`.`setores` (
  `set_setor` int(10) unsigned NOT NULL,
  `set_nome` varchar(50) NOT NULL,
  PRIMARY KEY (`set_setor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clinica-medica`.`setores`
--

/*!40000 ALTER TABLE `setores` DISABLE KEYS */;
INSERT INTO `clinica-medica`.`setores` (`set_setor`,`set_nome`) VALUES 
 (1,'Administração'),
 (2,'Vendas');
/*!40000 ALTER TABLE `setores` ENABLE KEYS */;


--
-- Structure for table `clinica-medica`.`situacoes`
--

DROP TABLE IF EXISTS `clinica-medica`.`situacoes`;
CREATE TABLE  `clinica-medica`.`situacoes` (
  `sit_situacao` int(10) unsigned NOT NULL,
  `sit_nome` varchar(50) NOT NULL,
  PRIMARY KEY (`sit_situacao`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clinica-medica`.`situacoes`
--

/*!40000 ALTER TABLE `situacoes` DISABLE KEYS */;
INSERT INTO `clinica-medica`.`situacoes` (`sit_situacao`,`sit_nome`) VALUES 
 (1,'Aguardando resposta'),
 (2,'Em trabalho'),
 (3,'Aprovado'),
 (4,'Concluído');
/*!40000 ALTER TABLE `situacoes` ENABLE KEYS */;


--
-- Structure for table `clinica-medica`.`situacoestributarias`
--

DROP TABLE IF EXISTS `clinica-medica`.`situacoestributarias`;
CREATE TABLE  `clinica-medica`.`situacoestributarias` (
  `sit_situacaotributaria` int(10) unsigned NOT NULL,
  `sit_descricao` varchar(90) NOT NULL,
  `sit_situacao` varchar(3) NOT NULL,
  PRIMARY KEY (`sit_situacaotributaria`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clinica-medica`.`situacoestributarias`
--

/*!40000 ALTER TABLE `situacoestributarias` DISABLE KEYS */;
INSERT INTO `clinica-medica`.`situacoestributarias` (`sit_situacaotributaria`,`sit_descricao`,`sit_situacao`) VALUES 
 (1,'Nacional / Tributada Integralmente','000'),
 (2,'Nacional / ICMS Cobrado anteriormente por substituição tributária','060'),
 (3,'Nacional / Outros','090'),
 (4,'Nacional / Isenta','040');
/*!40000 ALTER TABLE `situacoestributarias` ENABLE KEYS */;


--
-- Structure for table `clinica-medica`.`tiposdeconta`
--

DROP TABLE IF EXISTS `clinica-medica`.`tiposdeconta`;
CREATE TABLE  `clinica-medica`.`tiposdeconta` (
  `tip_tipoconta` int(10) unsigned NOT NULL,
  `tip_descricao` varchar(45) NOT NULL,
  PRIMARY KEY (`tip_tipoconta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clinica-medica`.`tiposdeconta`
--

/*!40000 ALTER TABLE `tiposdeconta` DISABLE KEYS */;
INSERT INTO `clinica-medica`.`tiposdeconta` (`tip_tipoconta`,`tip_descricao`) VALUES 
 (1,'crédito'),
 (2,'débito');
/*!40000 ALTER TABLE `tiposdeconta` ENABLE KEYS */;


--
-- Structure for table `clinica-medica`.`usuarios`
--

DROP TABLE IF EXISTS `clinica-medica`.`usuarios`;
CREATE TABLE  `clinica-medica`.`usuarios` (
  `usu_usuario` int(10) unsigned NOT NULL,
  `usu_login` varchar(15) NOT NULL,
  `usu_senha` varchar(8) NOT NULL,
  `usu_setor` int(10) unsigned NOT NULL,
  `usu_endereco` int(10) unsigned NOT NULL,
  `usu_telefone` varchar(15) DEFAULT NULL,
  `usu_celular` varchar(15) DEFAULT NULL,
  `usu_email` varchar(45) DEFAULT NULL,
  `usu_ehadministrador` char(2) DEFAULT NULL,
  `usu_estahativo` char(1) NOT NULL DEFAULT 's',
  `usu_datanascimento` date DEFAULT NULL,
  `usu_dataadmissao` date DEFAULT NULL,
  PRIMARY KEY (`usu_usuario`),
  KEY `FK_usuarios_end` (`usu_endereco`),
  KEY `FK_usuarios_setor` (`usu_setor`),
  CONSTRAINT `FK_usuarios_end` FOREIGN KEY (`usu_endereco`) REFERENCES `enderecos` (`end_endereco`) ON UPDATE CASCADE,
  CONSTRAINT `FK_usuarios_pessoas` FOREIGN KEY (`usu_usuario`) REFERENCES `pessoas` (`pes_pessoa`) ON UPDATE CASCADE,
  CONSTRAINT `FK_usuarios_setor` FOREIGN KEY (`usu_setor`) REFERENCES `setores` (`set_setor`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clinica-medica`.`usuarios`
--

/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `clinica-medica`.`usuarios` (`usu_usuario`,`usu_login`,`usu_senha`,`usu_setor`,`usu_endereco`,`usu_telefone`,`usu_celular`,`usu_email`,`usu_ehadministrador`,`usu_estahativo`,`usu_datanascimento`,`usu_dataadmissao`) VALUES 
 (1,'admin','admin',1,1,'','','','on','s','1980-01-01','2010-06-01'),
 (2,'denes','denes1',1,2,'(54) 3282 3730','(54) 9979 6485','denes@nexun.com.br','','s','1984-10-02','2007-01-01');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;


--
-- Structure for table `clinica-medica`.`usuarios_permissoes`
--

DROP TABLE IF EXISTS `clinica-medica`.`usuarios_permissoes`;
CREATE TABLE  `clinica-medica`.`usuarios_permissoes` (
  `up_permissao` int(10) unsigned NOT NULL,
  `up_usuario` int(10) unsigned NOT NULL,
  PRIMARY KEY (`up_usuario`,`up_permissao`),
  KEY `FK_usuarios_permissoes` (`up_permissao`),
  CONSTRAINT `FK_up_usuarios` FOREIGN KEY (`up_usuario`) REFERENCES `usuarios` (`usu_usuario`) ON UPDATE CASCADE,
  CONSTRAINT `FK_usuarios_permissoes` FOREIGN KEY (`up_permissao`) REFERENCES `permissoes` (`per_permissao`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clinica-medica`.`usuarios_permissoes`
--

/*!40000 ALTER TABLE `usuarios_permissoes` DISABLE KEYS */;
INSERT INTO `clinica-medica`.`usuarios_permissoes` (`up_permissao`,`up_usuario`) VALUES 
 (1,1),
 (2,1),
 (3,1);
/*!40000 ALTER TABLE `usuarios_permissoes` ENABLE KEYS */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
