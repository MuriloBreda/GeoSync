DROP DATABASE IF EXISTS geosync;
CREATE DATABASE geosync;
USE geosync;

-- 1. TABELA DE USUÁRIOS
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    birth_date DATE NULL,
    foto VARCHAR(255) NULL,
    tipo ENUM('admin', 'cliente', 'motorista') DEFAULT 'cliente',
    telefone VARCHAR(20) NULL,
    cpf VARCHAR(14) NULL,
    dark_mode BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- 2. TABELA DE REMESSAS (Com os IDs corretos e limpos)
CREATE TABLE remessas (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    codigo_rastreio VARCHAR(100) NOT NULL,
    origem VARCHAR(100) NOT NULL,
    destino VARCHAR(100) NOT NULL,
    tipo_carga VARCHAR(100) NULL,
    peso DECIMAL(10,2) NULL,
    previsao_entrega DATE NULL,
    status VARCHAR(50) DEFAULT 'Pendente',
    cliente_id BIGINT UNSIGNED NULL,
    motorista_id BIGINT UNSIGNED NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    CONSTRAINT fk_cliente FOREIGN KEY (cliente_id) REFERENCES users(id) ON DELETE SET NULL,
    CONSTRAINT fk_motorista FOREIGN KEY (motorista_id) REFERENCES users(id) ON DELETE SET NULL
);

-- 3. TABELA DE ALERTAS (Ajustada com 'tipo' e 'mensagem' para bater com o Controller)
CREATE TABLE alertas (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tipo VARCHAR(100) NOT NULL,
    mensagem TEXT NOT NULL,
    remessa_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    CONSTRAINT fk_alertas_remessa FOREIGN KEY (remessa_id) REFERENCES remessas(id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- 4. TABELA DE LOCALIZAÇÕES
CREATE TABLE localizacoes (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    latitude DECIMAL(10,8) NOT NULL,
    longitude DECIMAL(11,8) NOT NULL,
    remessa_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    CONSTRAINT fk_localizacoes_remessa FOREIGN KEY (remessa_id) REFERENCES remessas(id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- 5. TABELA DE PAGAMENTOS
CREATE TABLE pagamentos (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    valor DECIMAL(10,2) NOT NULL,
    status VARCHAR(50) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- 6. TABELA DE AVALIAÇÕES
CREATE TABLE avaliacoes (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    nota INT NOT NULL,
    comentario VARCHAR(255) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- 7. TABELA DE CONTATOS
CREATE TABLE contatos (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    mensagem TEXT NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

select * from users;

select * from remessas;

select * from alertas;

select * from localizacoes;

select * from pagamentos;

select * from avaliacoes;

select * from contatos; 

