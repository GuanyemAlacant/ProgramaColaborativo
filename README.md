Programa Colaborativo
=====================

Herramienta para la elaboración del programa colaborativo de **Ganemos Alicante**.
Basado en el programa colaborativo de **Ganemos Zaragoza**.

**Requisitos:**
Servidor web con soporte de PHP 5.1 o superior.
MySQL

**Instalación:**

Copia todos los ficheros en la carpeta destino del servidor.

Crea la base de datos y ejecuta, teniendola seleccionada, el script de la carpeta DB (database_struct.sql). 

Edita el fichero lib/config.php para indicar los datos de conexión a la base de datos.

Introduce los datos que se vayan a utilizar en la elaboración del programa:
Por ejemplo habrá que rellenar la tabla de sectores (prog_sectores) y la de barrios (prog_barrios), se adjuntan ejemplos de datos utilizados en Alicante y Zaragoza dentro de la carpeta DB.

* Personaliza las imágenes en static/images/ (opcional)
* Añade un mapa de barrios en formato SVG en la ruta /vistas/barrios.svg (opcional)
* Personalizar los textos en vistas/texto_XXXXXXX.html
    Es indispensable que se modifiquen los ficheros texto_direccion.html, texto_email.html, texto_ganemos.html, texto_web.html.
    Modificar el resto de ficheros texto_XXXX.html es opcional.

Nota: El mapa en formato SVG debe identificar las zonas con su correspondiente identificador de la base de datos, es decir, los elementos PATH del fichero SVG deben tener el atributo ID asignado con el valor de la clave primaria del correspondiente barrio dentro de la tabla prog_barrios.

**Estructura:**

* /DB: contiene el script MysQL con las tablas necesarias para que funcione, además de las carpetas con los datos personalizados utilizados en Alicante y Zaragoza.
* /lib: Contiene archivos de funciones comunes.
* /static: Contiene imágenes, estilos y js
* /vistas: Plantillas twig.
* /vendor: Contiene la librería de plantillas TWIG que se usa en el proyecto.
* /ajax: Contiene los archivos de funciones que se invocan desde llamadas ajax.
* En la raíz se encuentran los archivos php base del proyecto.

**Licencia de Uso**

Este software se distribuye bajo the Apache License, Version 2.0 (the "License").

Esta herramienta se ha creado a partir del software libre publicado por [guillermolazaro.com](http://guillermolazaro.com) y ha sido modificada para que sea reutilizable por [Carlos Asensio Martínez](http://github.com/casensiom)