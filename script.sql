create database InfoBeta;
  GO

use InfoBeta;
  GO

CREATE TABLE usuarios(
  id_usuario INT PRIMARY KEY IDENTITY,
  nome       CHAR(50) NOT NULL,
  id_setor   INT
);

CREATE TABLE setores(
  id_setor   INT NOT NULL PRIMARY KEY,
  setor      VARCHAR(20) NOT NULL
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

--Criação de relações, foreign keys
ALTER TABLE usuarios
  ADD CONSTRAINT fk_usuarios_setor FOREIGN KEY (id_setor)
    REFERENCES setores (id_setor);

ALTER TABLE atendimentos
  ADD CONSTRAINT fk_atendimentos_usuario FOREIGN KEY (id_usuario)
    REFERENCES usuarios (id_usuario);

ALTER TABLE atendimentos
  ADD CONSTRAINT fk_atendimentos_atendente FOREIGN KEY (id_atendente)
    REFERENCES atendentes (id_atendente);

  GO

--Povoar DB - Usuários (10); Setores (3); Atendentes (5)

--povoando setores
INSERT INTO dbo.setores (id_setor, setor) VALUES (10,'RH');
INSERT INTO dbo.setores (id_setor, setor) VALUES (11,'Comercial');
INSERT INTO dbo.setores (id_setor, setor) VALUES (12,'Financeiro');

  GO

--povoando usuarios
INSERT INTO dbo.usuarios (nome, id_setor) VALUES ('Roberto Campos',11);
INSERT INTO dbo.usuarios (nome, id_setor) VALUES ('Maria Freitas',12);
INSERT INTO dbo.usuarios (nome, id_setor) VALUES ('José Diniz',11);
INSERT INTO dbo.usuarios (nome, id_setor) VALUES ('Robervaldo Quintão',11);
INSERT INTO dbo.usuarios (nome, id_setor) VALUES ('Cristina Gazire',12);
INSERT INTO dbo.usuarios (nome, id_setor) VALUES ('Elaine Sobrinho',10);
INSERT INTO dbo.usuarios (nome, id_setor) VALUES ('Osvaldo Aguiar',10);
INSERT INTO dbo.usuarios (nome, id_setor) VALUES ('Carla Santos',11);
INSERT INTO dbo.usuarios (nome, id_setor) VALUES ('Marcos Eisenberg',10);
INSERT INTO dbo.usuarios (nome, id_setor) VALUES ('Fabilene Guerra',12);
  GO

--povoando atendentes
INSERT INTO dbo.atendentes (nome) VALUES ('Camila Fernandes');
INSERT INTO dbo.atendentes (nome) VALUES ('Viviane Dias');
INSERT INTO dbo.atendentes (nome) VALUES ('Renato Felix');
INSERT INTO dbo.atendentes (nome) VALUES ('Felipe Andrade');
INSERT INTO dbo.atendentes (nome) VALUES ('Tiago Neto');
  GO

--select * from dbo.usuarios;
--select * from dbo.setores;
--select * from dbo.atendentes;
/*
DROP TABLE usuarios;
DROP TABLE setores;
DROP TABLE atendentes;
DROP TABLE atendimentos;
*/
