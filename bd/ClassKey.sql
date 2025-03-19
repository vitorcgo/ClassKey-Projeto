CREATE TABLE `usuario`(
    `usuario_id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `nome` CHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `senha` VARCHAR(255) NOT NULL,
    `cpf` INT NOT NULL,
    `celular` VARCHAR(255) NOT NULL,
    `data_criacao` DATETIME NOT NULL,
    `data_ultimo_acesso` DATETIME NOT NULL
);
ALTER TABLE
    `usuario` ADD UNIQUE `usuario_email_unique`(`email`);
ALTER TABLE
    `usuario` ADD UNIQUE `usuario_cpf_unique`(`cpf`);
ALTER TABLE
    `usuario` ADD UNIQUE `usuario_celular_unique`(`celular`);
CREATE TABLE `produto`(
    `produto_id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `nome` VARCHAR(255) NOT NULL,
    `preco` FLOAT(53) NOT NULL,
    `status` CHAR(255) NOT NULL
);
CREATE TABLE `key`(
    `produto_id` INT NOT NULL,
    `key_id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `key` VARCHAR(255) NOT NULL,
    `status` CHAR(255) NOT NULL
);
ALTER TABLE
    `key` ADD UNIQUE `key_key_unique`(`key`);
CREATE TABLE `admin`(
    `admin_id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `usuario` VARCHAR(255) NOT NULL,
    `senha` VARCHAR(255) NOT NULL,
    `data_criacao` DATETIME NOT NULL,
    `data_ultimo_acesso` DATETIME NOT NULL
);
ALTER TABLE
    `admin` ADD UNIQUE `admin_usuario_unique`(`usuario`);
CREATE TABLE `admin_log`(
    `admin_id` INT NOT NULL,
    `log_id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `acao` VARCHAR(255) NOT NULL,
    `data` DATETIME NOT NULL
);
CREATE TABLE `admin_login_log`(
    `admin_id` INT NOT NULL,
    `login_id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `data_login` DATETIME NOT NULL,
    `tentativa` BOOLEAN NOT NULL,
    `endereco_ip` VARCHAR(255) NOT NULL
);
CREATE TABLE `usuario_login_log`(
    `log_id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `usuario_id` INT NOT NULL,
    `data_acesso` DATETIME NOT NULL,
    `tentativa` BOOLEAN NOT NULL,
    `endereco_ip` VARCHAR(255) NOT NULL
);
CREATE TABLE `produto_categoria`(
    `produto_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `categoria_id` INT NOT NULL
);
CREATE TABLE `categoria`(
    `categoria_id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `categoria` CHAR(255) NOT NULL
);
ALTER TABLE
    `produto_categoria` ADD CONSTRAINT `produto_categoria_categoria_id_foreign` FOREIGN KEY(`categoria_id`) REFERENCES `categoria`(`categoria_id`);
ALTER TABLE
    `key` ADD CONSTRAINT `key_produto_id_foreign` FOREIGN KEY(`produto_id`) REFERENCES `produto`(`produto_id`);
ALTER TABLE
    `usuario_login_log` ADD CONSTRAINT `usuario_login_log_usuario_id_foreign` FOREIGN KEY(`usuario_id`) REFERENCES `usuario`(`usuario_id`);
ALTER TABLE
    `admin_login_log` ADD CONSTRAINT `admin_login_log_admin_id_foreign` FOREIGN KEY(`admin_id`) REFERENCES `admin`(`admin_id`);
ALTER TABLE
    `produto_categoria` ADD CONSTRAINT `produto_categoria_produto_id_foreign` FOREIGN KEY(`produto_id`) REFERENCES `produto`(`produto_id`);
ALTER TABLE
    `admin_log` ADD CONSTRAINT `admin_log_admin_id_foreign` FOREIGN KEY(`admin_id`) REFERENCES `admin`(`admin_id`);