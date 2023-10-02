-- DQL para consultar datos

-- Consulta de todos los autores
SELECT * FROM Authors;

-- Consulta de todos los libros con el nombre del autor
SELECT Books.title, Authors.name AS author_name
FROM Books
INNER JOIN Authors ON Books.author_id = Authors.id;

-- Consulta de todos los usuarios
SELECT * FROM Users;
