-- Criação das tabelas
CREATE TABLE usuario (
    usuario_id INTEGER PRIMARY KEY AUTOINCREMENT,
    nome TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    senha TEXT NOT NULL,
    cpf TEXT NOT NULL UNIQUE,
    celular TEXT NOT NULL UNIQUE,
    data_criacao TEXT NOT NULL,
    data_ultimo_acesso TEXT NOT NULL
);

CREATE TABLE produto (
    produto_id INTEGER PRIMARY KEY AUTOINCREMENT,
    nome TEXT NOT NULL,
    preco REAL NOT NULL,
    status TEXT NOT NULL
);

CREATE TABLE categoria (
    categoria_id INTEGER PRIMARY KEY AUTOINCREMENT,
    categoria TEXT NOT NULL
);

CREATE TABLE produto_categoria (
    produto_id INTEGER NOT NULL,
    categoria_id INTEGER NOT NULL,
    FOREIGN KEY (produto_id) REFERENCES produto(produto_id),
    FOREIGN KEY (categoria_id) REFERENCES categoria(categoria_id)
);

CREATE TABLE produto_media (
    media_id INTEGER PRIMARY KEY AUTOINCREMENT,
    produto_id INTEGER NOT NULL,
    url TEXT NOT NULL,
    FOREIGN KEY (produto_id) REFERENCES produto(produto_id)
);

CREATE TABLE "key" (
    key_id INTEGER PRIMARY KEY AUTOINCREMENT,
    produto_id INTEGER NOT NULL,
    key TEXT NOT NULL UNIQUE,
    status TEXT NOT NULL,
    FOREIGN KEY (produto_id) REFERENCES produto(produto_id)
);

CREATE TABLE admin (
    admin_id INTEGER PRIMARY KEY AUTOINCREMENT,
    usuario TEXT NOT NULL UNIQUE,
    senha TEXT NOT NULL,
    data_criacao TEXT NOT NULL,
    data_ultimo_acesso TEXT NOT NULL
);

CREATE TABLE admin_log (
    log_id INTEGER PRIMARY KEY AUTOINCREMENT,
    admin_id INTEGER NOT NULL,
    acao TEXT NOT NULL,
    data TEXT NOT NULL,
    FOREIGN KEY (admin_id) REFERENCES admin(admin_id)
);

CREATE TABLE admin_login_log (
    login_id INTEGER PRIMARY KEY AUTOINCREMENT,
    admin_id INTEGER NOT NULL,
    data_login TEXT NOT NULL,
    tentativa INTEGER NOT NULL,
    endereco_ip TEXT NOT NULL,
    FOREIGN KEY (admin_id) REFERENCES admin(admin_id)
);

CREATE TABLE usuario_login_log (
    log_id INTEGER PRIMARY KEY AUTOINCREMENT,
    usuario_id INTEGER NOT NULL,
    data_acesso TEXT NOT NULL,
    tentativa INTEGER NOT NULL,
    endereco_ip TEXT NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuario(usuario_id)
);
