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

select * from users;
select * from remessas;