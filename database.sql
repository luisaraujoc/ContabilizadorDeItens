-- Criação do banco de dados com collation utf8mb4_bin
CREATE DATABASE IF NOT EXISTS sistema_inventario 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_bin;

USE sistema_inventario;

-- Tabela Categoria (modificada)
CREATE TABLE IF NOT EXISTS Categoria (
    idCategoria INT AUTO_INCREMENT PRIMARY KEY,
    CodCategoria VARCHAR(20) NOT NULL COLLATE utf8mb4_bin,  -- Collation específica
    Nome VARCHAR(100) NOT NULL COLLATE utf8mb4_bin,
    UNIQUE KEY (CodCategoria)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Tabela Item (modificada)
CREATE TABLE IF NOT EXISTS Item (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Nome VARCHAR(100) NOT NULL COLLATE utf8mb4_bin,
    CodCategoria VARCHAR(20) COLLATE utf8mb4_bin,
    Quantidade INT NOT NULL DEFAULT 0,
    Valor DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (CodCategoria) REFERENCES Categoria(CodCategoria)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;