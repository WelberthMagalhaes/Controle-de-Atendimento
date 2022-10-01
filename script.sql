create database InfoBeta;
  GO

use InfoBeta;
  GO

CREATE TABLE usuarios(
  id_usuario INT PRIMARY KEY IDENTITY,
  nome       CHAR(50) NOT NULL,
  id_setor   INT      NOT NULL --criar relação - constraint
);

CREATE TABLE setores(
  id_setor   INT NOT NULL PRIMARY KEY,
  setor      VARCHAR(10) NOT NULL
);

CREATE TABLE atendentes(
  id_atendente INT NOT NULL PRIMARY KEY IDENTITY,
  nome         VARCHAR(20) NOT NULL
);

CREATE TABLE atendimentos(
  id_demanda                  INT NOT NULL PRIMARY KEY IDENTITY,
  descricao_demanda           VARCHAR(50) NOT NULL,
  custo                       FLOAT       NOT NULL,
  id_usuario                  INT         NOT NULL,
  id_atendente                INT         NOT NULL,
  data_cadastro               DATETIME    NOT NULL,
  data_previsao_atendimento   DATE        NOT NULL,
  data_termino_atendimento    DATE,
  observacoes                 VARCHAR(30)
);
  GO

/*
DROP TABLE usuarios;
DROP TABLE setores;
DROP TABLE atendentes;
DROP TABLE atendimentos;
*/