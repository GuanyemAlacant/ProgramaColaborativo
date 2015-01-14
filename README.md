Programa-colaborativo
=====================

Herramienta para la elaboración del programa colaborativo de **Ganemos Alicante**.
Basado en el programa colaborativo de **Ganemos Zaragoza**.

**Requisitos:**
Servidor web con soporte de PHP 5.1 o superior.
MySQL

**Instalación:**

Copia todos los ficheros en la carpeta destino del servidor.

Crea la base de datos y ejecuta, teniendola seleccionada, el script de la carpeta DB. 

Edita el fichero lib/config.php para indicar los datos de conexión a la base de datos.

Introduce los datos que se vayan a utilizar en la elaboración del programa:
Por ejemplo habrá que rellenar la tabla de sectores (prog_sectores) y la de barrios (prog_barrios).

Personaliza las imágenes en static/images/
Personalizar los textos en vistas/texto_XXXXXXX.html
Personaliza el mapa de barrios.

**Estructura:**

* /DB: contiene el script MysQL con las tablas necesarias para que funcione.
* /lib: Contiene el archivo de funciones principal.
* /static: Contiene imágenes, estilos y js
* /vistas: Plantillas twig.
* En la raíz se encuentran los archivos php base del proyecto.



**Licencia de Uso**

Este software se distribuye bajo the Apache License, Version 2.0 (the "License").

Esta herramienta se ha creado a partir del software libre publicado por: [guillermolazaro.com](http://guillermolazaro.com)