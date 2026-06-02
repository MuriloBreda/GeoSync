CREATE DATABASE geosync;
USE geosync;

CREATE USER 'murilo'@'%' IDENTIFIED BY '123456';
GRANT ALL PRIVILEGES ON geosync.* TO 'murilo'@'%';
FLUSH PRIVILEGES;

-- USERS (usuario)
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    birth_date DATE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

ALTER TABLE users ADD foto VARCHAR(255) NULL;

-- REMESSAS
CREATE TABLE remessas (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    codigo_rastreio VARCHAR(100),
    origem VARCHAR(100),
    destino VARCHAR(100),
    tipo_carga VARCHAR(100),
    peso DECIMAL(10,2),
    previsao_entrega DATE,
    status VARCHAR(50),

    user_id BIGINT UNSIGNED,

    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE SET NULL
        ON UPDATE CASCADE
);

-- ALERTAS
CREATE TABLE alertas (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tipo_alerta VARCHAR(100),
    descricao VARCHAR(255),

    remessa_id BIGINT UNSIGNED,

    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    FOREIGN KEY (remessa_id) REFERENCES remessas(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- LOCALIZACOES
CREATE TABLE localizacoes (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    latitude DECIMAL(10,8),
    longitude DECIMAL(11,8),

    remessa_id BIGINT UNSIGNED,

    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    FOREIGN KEY (remessa_id) REFERENCES remessas(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE pagamentos (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED,
    valor DECIMAL(10,2),
    status VARCHAR(50),
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE avaliacoes (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED,
    nota INT,
    comentario VARCHAR(255),
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE contatos (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    email VARCHAR(100),
    mensagem TEXT,
    created_at TIMESTAMP NULL
);


ALTER TABLE users
ADD tipo ENUM(
    'admin',
    'cliente',
    'motorista'
) DEFAULT 'cliente';

ALTER TABLE users
ADD telefone VARCHAR(20) NULL;

ALTER TABLE users
ADD cpf VARCHAR(14) NULL;

ALTER TABLE users
ADD dark_mode BOOLEAN DEFAULT FALSE;


ALTER TABLE remessas
ADD cliente_id BIGINT UNSIGNED NULL,
ADD motorista_id BIGINT UNSIGNED NULL;


ALTER TABLE remessas
ADD CONSTRAINT fk_cliente
FOREIGN KEY (cliente_id)
REFERENCES users(id);

ALTER TABLE remessas
ADD CONSTRAINT fk_motorista
FOREIGN KEY (motorista_id)
REFERENCES users(id);

ALTER TABLE remessas
DROP FOREIGN KEY remessas_ibfk_1;

ALTER TABLE remessas
DROP COLUMN user_id;

ALTER TABLE remessas
ADD cliente_id BIGINT UNSIGNED NULL,
ADD motorista_id BIGINT UNSIGNED NULL;

ALTER TABLE remessas
ADD CONSTRAINT fk_cliente
FOREIGN KEY (cliente_id)
REFERENCES users(id)
ON DELETE SET NULL;

ALTER TABLE remessas
ADD CONSTRAINT fk_motorista
FOREIGN KEY (motorista_id)
REFERENCES users(id)
ON DELETE SET NULL;


CREATE TABLE ocorrencias (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    remessa_id BIGINT UNSIGNED NOT NULL,
    motorista_id BIGINT UNSIGNED NOT NULL,

    tipo VARCHAR(100) NOT NULL,
    descricao TEXT NOT NULL,

    nivel ENUM('Baixo','Médio','Alto','Crítico') DEFAULT 'Baixo',

    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,

    CONSTRAINT fk_ocorrencia_remessa
        FOREIGN KEY (remessa_id)
        REFERENCES remessas(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_ocorrencia_motorista
        FOREIGN KEY (motorista_id)
        REFERENCES users(id)
        ON DELETE CASCADE
);


select * from users;
select * from remessas;
select * from alertas;
select * from ocorrencias;
select * from localizacoes;
select * from pagamentos;
select * from avaliacoes;
select * from contatos;