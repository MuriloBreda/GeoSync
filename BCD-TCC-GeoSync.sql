CREATE DATABASE TCC_GeoSync;
USE TCC_GeoSync;

-- Criando as tabelas --
CREATE TABLE usuario (
    id_usuario VARCHAR(50) PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE, 
    senha VARCHAR(255) NOT NULL,
    data DATE
);
SELECT * FROM Usuario;

CREATE TABLE remessa (
    id_remessa VARCHAR(50) PRIMARY KEY,
    codigo_rastreio VARCHAR(100),
    origem VARCHAR(100),
    destino VARCHAR(100),
    tipo_carga VARCHAR(100),
    peso DECIMAL(10,2),
    previsao_entrega DATE,
    status VARCHAR(50),
    data_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    id_usuario VARCHAR(50),

    FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario)
        ON DELETE SET NULL
        ON UPDATE CASCADE
);
SELECT * FROM remessa;

CREATE TABLE alerta (
    id_alerta VARCHAR(50) PRIMARY KEY,
    tipo_alerta VARCHAR(100),
    descricao VARCHAR(255),
    data_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    id_remessa VARCHAR(50),

    FOREIGN KEY (id_remessa) REFERENCES remessa(id_remessa)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);
SELECT * FROM alerta;

CREATE TABLE localizacao (
    id_localizacao INT AUTO_INCREMENT PRIMARY KEY,
    latitude DECIMAL(10,8),
	longitude DECIMAL(11,8),
    data_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    id_remessa VARCHAR(50),

    FOREIGN KEY (id_remessa) REFERENCES remessa(id_remessa)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);
SELECT * FROM localizacao; 