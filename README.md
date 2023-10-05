# Repositorio de la API en PHP Puro

Este repositorio aloja una API desarrollada en PHP puro como parte de la prueba técnica proporcionada por la empresa Innovus. El proyecto se creó desde cero, siguiendo un enfoque similar al de Laravel y adoptando sólidas prácticas de desarrollo.

La API está diseñada en torno al tema de una librería y cumple con los requisitos especificados en el enunciado de la prueba técnica, que incluyen:

- Autenticación mediante JWT (JSON Web Tokens).
- Control de acceso tanto en el lado del backend como en el frontend.
- Organización clara de directorios para el backend y el frontend.
- Mantenimiento de un código organizado y limpio.
- Implementación de una organización jerárquica en la base de datos.
- Garantía de seguridad en todo el aplicativo desarrollado.

Este repositorio refleja el esfuerzo y la atención al detalle dedicados a la creación de esta API, que cumple con los estándares más exigentes en términos de seguridad y eficiencia.

## Requisitos del Sistema

Asegúrate de cumplir con los siguientes requisitos antes de configurar y ejecutar esta API:

- **PHP 8.2 o superior:** Esta API está desarrollada utilizando PHP 8.2 o una versión posterior. Verifica tu versión de PHP ejecutando `php --version` en tu línea de comandos.

- **Composer:** Utilizamos Composer para gestionar las dependencias de PHP en este proyecto. Si aún no tienes Composer instalado, puedes descargarlo e instalarlo desde [getcomposer.org](https://getcomposer.org/).

- **MySQL:** Esta API utiliza una base de datos MySQL para almacenar datos. Asegúrate de tener un servidor MySQL instalado y configurado en tu entorno local. Puedes descargar MySQL desde [mysql.com](https://www.mysql.com/).

Si cumples con estos requisitos, estarás listo para configurar y ejecutar la API en tu máquina local. Si no tienes alguna de estas herramientas instaladas, sigue los enlaces proporcionados para obtener más información sobre cómo instalarlas.

## Instrucciones para Configurar y Ejecutar la API

Sigue estos pasos para configurar y ejecutar la API en tu entorno local:

1. **Clonar el Proyecto:** Clona este repositorio en tu máquina local utilizando el siguiente comando:

   ```
   git clone https://github.com/DannyelAlulema/Prueba_Tecnica-Innovus.git
   ```

2. **Instalar Dependencias:** Utiliza Composer para instalar las dependencias requeridas. Ve a la carpeta del proyecto y ejecuta:

   ```
   composer install
   ```

3. **Crear la Base de Datos:** Asegúrate de tener una base de datos MySQL configurada. Luego, ejecuta el script DDL.sql para crear las tablas:

   ```
   database/DDL.sql
   ```

4. **Insertar Registros:** Inserta los primeros registros en la base de datos creada con el script DML.sql para crear las tablas:

   ```
   database/DML.sql
   ```

5. **Conectar la API a la Base de Datos:** Abre el archivo config/app.php y ajusta las siguientes constantes según la configuración de tu servidor MySQL local:

   ```php
   define('DB_HOST', 'localhost');     // Cambia 'localhost' por la dirección de tu servidor MySQL.
   define('DB_PORT', '3306');          // Cambia '3306' por el puerto de tu servidor MySQL.
   define('DB_USERNAME', 'root');      // Cambia 'root' por tu nombre de usuario de MySQL.
   define('DB_PASSWORD', '');           // Cambia '' por tu contraseña de MySQL si la tienes.
   define('DB_DATABASE', 'innovus');   // Cambia 'innovus' por el nombre de tu base de datos.
   ```

6. **Ejecutar el Proyecto:** Inicia el servidor local con el siguiente comando:

   ```
   php -S localhost:8000 -t public
   ```

7. **Acceso al Frontend:** Para acceder al frontend de la aplicación, por favor, sigue este enlace: [Repositorio Frontend Innovus](https://github.com/DannyelAlulema/Prueba_Tecnica-Innovus_FrontEnd)

¡Listo! Ahora deberías tener la API configurada y funcionando en tu entorno local.

Claro, aquí está la parte adicional que menciona la guía de consumo del API:

## Guía de Consumo del API

En el directorio raíz de este repositorio, encontrarás el archivo `Prueba Técnica API Reference.postman_collection`. Este archivo es una guía completa para consumir el API y contiene todos los endpoints junto con sus respectivos métodos HTTP.

Puedes importar este archivo en [Postman](https://www.postman.com/) para acceder a una colección preconfigurada que facilitará tus pruebas y solicitudes al API. A continuación, se detallan los pasos para importar el archivo en Postman:

1. Abre Postman.
2. Haz clic en el botón "Import" en la parte superior izquierda de la ventana principal.
3. Selecciona la opción "File" y luego busca y selecciona el archivo `Prueba Técnica API Reference.postman_collection` que se encuentra en el directorio raíz del repositorio.
4. Una vez importada la colección, verás todos los endpoints disponibles junto con ejemplos de solicitudes que puedes usar como referencia.

Esta guía de consumo te ayudará a comprender y utilizar eficazmente la API, lo que facilitará el desarrollo y las pruebas de tu aplicación.

¡No dudes en utilizar esta colección de Postman como una herramienta útil para interactuar con la API de manera eficiente!