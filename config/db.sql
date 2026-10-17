-- =========================================
-- CRIAÇÃO DO BANCO
-- =========================================

CREATE DATABASE PBL;

-- Seleciona o banco
USE PBL;


-- =========================================
-- TABELA: CLIENTES
-- =========================================

CREATE TABLE clientes (
    id_cliente INT AUTO_INCREMENT PRIMARY KEY,
    cpf_cnpj VARCHAR(18) NOT NULL,
    nome VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL,
    telefone VARCHAR(20),
    telefone_secundario VARCHAR(20),
    logradouro VARCHAR(200),
    numero VARCHAR(10),
    bairro VARCHAR(100),
    cidade VARCHAR(100),
    estado VARCHAR(50),
    cep VARCHAR(10),
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(20) DEFAULT 'Ativo'
);


-- =========================================
-- TABELA: USUÁRIOS
-- =========================================

CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    telefone VARCHAR(20),
    perfil VARCHAR(50),
    status VARCHAR(20) DEFAULT 'Ativo',
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP,
    ultimo_acesso DATETIME NULL
);


-- =========================================
-- TABELA: EQUIPAMENTOS
-- =========================================

CREATE TABLE equipamentos (
    id_equipamento INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT NOT NULL,
    tipo VARCHAR(100) NOT NULL,
    marca VARCHAR(100),
    modelo VARCHAR(100),
    numero_serie VARCHAR(100),
    patrimonio VARCHAR(100),
    descricao TEXT,
    sistema_operacional VARCHAR(100),
    senha_acesso VARCHAR(255),
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(20) DEFAULT 'Ativo',

    -- Relacionamento com clientes
    CONSTRAINT fk_equipamento_cliente
        FOREIGN KEY (id_cliente)
        REFERENCES clientes(id_cliente)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
);



CREATE TABLE tecnicos (
    id_tecnico INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    cpf VARCHAR(14) NOT NULL UNIQUE,
    email VARCHAR(150) NOT NULL,
    telefone VARCHAR(20),
    especialidade VARCHAR(100),
    nivel VARCHAR(50),
    data_admissao DATE,
    status VARCHAR(20) DEFAULT 'Ativo',
    observacoes TEXT
);

CREATE TABLE ordens_servico (
    id_os INT AUTO_INCREMENT PRIMARY KEY,

    id_cliente INT NOT NULL,
    id_equipamento INT NOT NULL,
    id_tecnico INT NOT NULL,

    numero_os VARCHAR(30) NOT NULL UNIQUE,

    data_abertura DATETIME DEFAULT CURRENT_TIMESTAMP,
    data_previsao DATE,
    data_conclusao DATE,

    problema_relatado TEXT,
    diagnostico TEXT,
    servico_realizado TEXT,

    status VARCHAR(30) DEFAULT 'Aberta',
    prioridade VARCHAR(30) DEFAULT 'Normal',

    valor_estimado DECIMAL(10,2) DEFAULT 0.00,
    valor_final DECIMAL(10,2) DEFAULT 0.00,

    forma_pagamento VARCHAR(50),
    observacoes TEXT,

    -- Cliente da ordem de serviço
    CONSTRAINT fk_os_cliente
        FOREIGN KEY (id_cliente)
        REFERENCES clientes(id_cliente)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,

    -- Equipamento da ordem de serviço
    CONSTRAINT fk_os_equipamento
        FOREIGN KEY (id_equipamento)
        REFERENCES equipamentos(id_equipamento)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,

    -- Técnico responsável pela ordem de serviço
    CONSTRAINT fk_os_tecnico
        FOREIGN KEY (id_tecnico)
        REFERENCES tecnicos(id_tecnico)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
);