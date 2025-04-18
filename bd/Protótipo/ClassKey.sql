CREATE TABLE `usuario`(
    `usuario_id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `nome` CHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `senha` VARCHAR(255) NOT NULL,
    `cpf` VARCHAR(11) NOT NULL,
    `celular` VARCHAR(255) NOT NULL,
    `data_criacao` DATETIME NOT NULL,
    `data_ultimo_acesso` DATETIME NOT NULL
);

ALTER TABLE `usuario` ADD UNIQUE `usuario_email_unique`(`email`);
ALTER TABLE `usuario` ADD UNIQUE `usuario_cpf_unique`(`cpf`);
ALTER TABLE `usuario` ADD UNIQUE `usuario_celular_unique`(`celular`);

CREATE TABLE `endereco`(
    `endereco_id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `usuario_id` INT UNSIGNED NOT NULL,
    `cep` VARCHAR(255) NOT NULL,
    `rua` VARCHAR(255) NOT NULL,
    `numero` INT NOT NULL,
    `complemento` VARCHAR(255),
    `bairro` VARCHAR(255) NOT NULL,
    `cidade` CHAR(255) NOT NULL
);

CREATE TABLE `pedido`(
    `pedido_id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `usuario_id` INT UNSIGNED NOT NULL,
    `carrinho_id` INT NOT NULL,
    `pedido_data` DATETIME NOT NULL,
    `status` CHAR(255) NOT NULL
);

CREATE TABLE `produto`(
    `produto_id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `nome` VARCHAR(255) NOT NULL,
    `preco` DECIMAL(10,2) NOT NULL,
    `categoria` CHAR(255) NOT NULL,
    `status` CHAR(255) NOT NULL
);

CREATE TABLE `key`(
    `key_id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `produto_id` INT UNSIGNED NOT NULL,
    `status` CHAR(255) NOT NULL
);

CREATE TABLE `carrinho`(
    `carrinho_id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `usuario_id` INT UNSIGNED NOT NULL,
    `data_adicao` DATETIME NOT NULL
);

CREATE TABLE `carrinho_item`(
    `carrinho_item_id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `carrinho_id` INT UNSIGNED NOT NULL,
    `produto_id` INT UNSIGNED NOT NULL,
    `qtd` INT NOT NULL
);

CREATE TABLE `pedido_item`(
    `pedido_item_id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `pedido_id` INT UNSIGNED NOT NULL,
    `produto_id` INT UNSIGNED NOT NULL,
    `qtd` INT NOT NULL,
    `preco_unitario` DECIMAL(10,2) NOT NULL
);

CREATE TABLE `pedido_key`(
    `pedido_id` INT UNSIGNED NOT NULL,
    `key_id` INT UNSIGNED NOT NULL,
    `data_venda` DATETIME NOT NULL,
    PRIMARY KEY(`pedido_id`, `key_id`)
);

CREATE TABLE `pagamento`(
    `pagamento_id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `pedido_id` INT UNSIGNED NOT NULL,
    `metodo_pagamento` ENUM('Cartão', 'Boleto', 'Pix') NOT NULL,
    `status` ENUM('Pendente', 'Aprovado', 'Recusado') NOT NULL,
    `valor_total` DECIMAL(10,2) NOT NULL,
    `data_pagamento` DATETIME NOT NULL
);

CREATE TABLE `admin`(
    `admin_id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `usuario` VARCHAR(255) NOT NULL,
    `senha_hash` VARCHAR(255) NOT NULL,
    `salt` VARCHAR(255) NOT NULL,
    `data_criacao` DATETIME NOT NULL,
    `data_ultimo_acesso` DATETIME NOT NULL
);

ALTER TABLE `admin` ADD UNIQUE `admin_usuario_unique`(`usuario`);

CREATE TABLE `admin_log`(
    `log_id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `admin_id` INT UNSIGNED NOT NULL,
    `acao` VARCHAR(255) NOT NULL,
    `data` DATETIME NOT NULL
);

CREATE TABLE `admin_login_log`(
    `login_id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `admin_id` INT UNSIGNED NOT NULL,
    `data_login` DATETIME NOT NULL,
    `tentativa` BOOLEAN NOT NULL,
    `endereco_ip` VARCHAR(255) NOT NULL
);

CREATE TABLE `usuario_login_log`(
    `log_id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `usuario_id` INT UNSIGNED NOT NULL,
    `data_acesso` DATETIME NOT NULL,
    `tentativa` BOOLEAN NOT NULL,
    `endereco_ip` VARCHAR(255) NOT NULL
);

ALTER TABLE `pedido` ADD CONSTRAINT `pedido_usuario_id_foreign` FOREIGN KEY(`usuario_id`) REFERENCES `usuario`(`usuario_id`);

ALTER TABLE `endereco` ADD CONSTRAINT `endereco_usuario_id_foreign` FOREIGN KEY(`usuario_id`) REFERENCES `usuario`(`usuario_id`);

ALTER TABLE `carrinho` ADD CONSTRAINT `carrinho_usuario_id_foreign` FOREIGN KEY(`usuario_id`) REFERENCES `usuario`(`usuario_id`);

ALTER TABLE `carrinho_item` ADD CONSTRAINT `carrinho_item_carrinho_id_foreign` FOREIGN KEY(`carrinho_id`) REFERENCES `carrinho`(`carrinho_id`);

ALTER TABLE `carrinho_item` ADD CONSTRAINT `carrinho_item_produto_id_foreign` FOREIGN KEY(`produto_id`) REFERENCES `produto`(`produto_id`);

ALTER TABLE `pedido_item` ADD CONSTRAINT `pedido_item_pedido_id_foreign` FOREIGN KEY(`pedido_id`) REFERENCES `pedido`(`pedido_id`);

ALTER TABLE `pedido_item` ADD CONSTRAINT `pedido_item_produto_id_foreign` FOREIGN KEY(`produto_id`) REFERENCES `produto`(`produto_id`);

ALTER TABLE `pedido_key` ADD CONSTRAINT `pedido_key_pedido_id_foreign` FOREIGN KEY(`pedido_id`) REFERENCES `pedido`(`pedido_id`);

ALTER TABLE `pedido_key` ADD CONSTRAINT `pedido_key_key_id_foreign` FOREIGN KEY(`key_id`) REFERENCES `key`(`key_id`);

ALTER TABLE `pagamento` ADD CONSTRAINT `pagamento_pedido_id_foreign` FOREIGN KEY(`pedido_id`) REFERENCES `pedido`(`pedido_id`);

ALTER TABLE `admin_log` ADD CONSTRAINT `admin_log_admin_id_foreign` FOREIGN KEY(`admin_id`) REFERENCES `admin`(`admin_id`);

ALTER TABLE `admin_login_log` ADD CONSTRAINT `admin_login_log_admin_id_foreign` FOREIGN KEY(`admin_id`) REFERENCES `admin`(`admin_id`);

ALTER TABLE `usuario_login_log` ADD CONSTRAINT `usuario_login_log_usuario_id_foreign` FOREIGN KEY(`usuario_id`) REFERENCES `usuario`(`usuario_id`);

ALTER TABLE `key` ADD CONSTRAINT `key_produto_id_foreign` FOREIGN KEY(`produto_id`) REFERENCES `produto`(`produto_id`);
