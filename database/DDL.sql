-- DDL para crear las tablas

-- Autores
CREATE TABLE Authors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    biography TEXT
);

-- Libros
CREATE TABLE Books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author_id INT,
    genre VARCHAR(255),
    publisher VARCHAR(255),
    publication_year YEAR,
    description TEXT,
    price DECIMAL(10, 2),
    stock INT,
    FOREIGN KEY (author_id) REFERENCES Authors(id)
);

-- Usuarios
CREATE TABLE Users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(255),
    role VARCHAR(50)
);

-- Black List Tokens
CREATE TABLE blacklist_tokens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    token VARCHAR(255) NOT NULL
);
