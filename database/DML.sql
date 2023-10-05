-- DML para insertar datos de prueba

-- Inserción de autores
INSERT INTO Authors (name, biography) VALUES
    ('Autor 1', 'Biografía del Autor 1'),
    ('Autor 2', 'Biografía del Autor 2'),
    ('Autor 3', 'Biografía del Autor 3');

-- Inserción de libros
INSERT INTO Books (title, author_id, genre, publisher, publication_year, description, price, stock) VALUES
    ('Libro 1', 1, 'Ficción', 'Editorial A', 2020, 'Descripción del Libro 1', 29.99, 100),
    ('Libro 2', 2, 'Ciencia Ficción', 'Editorial B', 2019, 'Descripción del Libro 2', 24.99, 50),
    ('Libro 3', 1, 'Misterio', 'Editorial C', 2021, 'Descripción del Libro 3', 19.99, 75);

-- Inserción de usuarios
INSERT INTO Users (username, password, name, role) VALUES
    ('admin', '$2y$04$hjzNs06zJRuf/NYUCQDb5OrN99bhYoueM4KcgbZfKWq0vAfgIqaQu', 'Administrador Sistema', 'ADMIN');
