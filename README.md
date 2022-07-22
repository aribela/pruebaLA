# pruebaLA
Prueba light agency

Nombre: Mariano Jair Castañeda Sánchez

Posicion deseada: Desarrollador Fullstack

Niveles:

○ Php 90%

○ Javascript 90%

○ CSS 80 %

○ Bootstrap 90%

○ Laravel 80%

○ Jquery 90%

Correo: majacasa_jueves@hotmail.com

Sitio: https://github.com/aribela

○ Nivel que elegiste para resolver el assessment
	Intermedio

○ Instrucciones de instalación
	1. Crear una base de datos vacia
	2. Ejecutar el archivo scripts.sql de la carpeta install, para crear las tablas y registros iniciales
	3. En el archivo config.php de la carpeta install, modificar el nombre de la base de datos, usuario y contraseña
	4. Se pueden generar mas registros de prueba en el menu del sitio, dando clic en "Crear registros" y seleccionando la opcion deseada, como se puede ver en la captura "crear_registros.png"

○ Listado de qué actividades lograste completar (adjunto al proyecto en git el pdf donde subrayo los puntos terminado)
	1. Script sql con las tablas accesorios, categorias, productos y comentarios
		a) El script lleva los indices y llaves foraneas respectivas para cada tabla
		b) Incluye el campo visitas en la tabla de productos
	2. Script con 10 datos de prueba para cada tabla
	3. Opción en el menu para ejecutar la creacion de registros de prueba
		a) 10 por tabla (categorias, productos, comentarios)
		b) 200 productos
		c) 1000 comentarios
	4. Home donde se muestra menu con las categorias padre y sus subcategorias en menu desplegable
		a) Home donde se muestran productos destacados (40 productos de forma aleatoria)
		b) Se muestran los productos mas vendidos (De mayor a menor calificacion promedio)
		c) Los listados de productos, se muestran paginados
	5. Vista de detalle producto
		a) Se muestran los accesorios que tenga asociados la categoria del producto
		b) Se aumenta el numero de vistas al producto al ingresar al detalle
		c) Se muestran los comentarios con su califacación del producto
	6. Busqueda en el menu
		a) Se muestran los productos resultantes de la busqueda con paginación