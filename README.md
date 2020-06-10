# SIGECOL
Aplicación web de evaluaciones de comprensión lectora

SIGECOL nacio con una meta especifica, ser una aplicacion web capaz de otorgar funcionalidades especiales para la elaboracion de evaluaciones de comprension lectora, tales como elaborar mapas conceptuales, completar partes de un texto, ordenar conceptos, entre otras. Dichas funcionalidades se lograron gracias al uso de Javascript junto a la biblioteca JQUERY, mezclandolo todo con las instrucciones en PHP y HTML, ademas de CSS para todo lo que es el estilo de la pagina y de las funciones.

Por otro lado se considera importante el enfoque en la comprension, por lo que el sistema de evaluacion no se basa en preguntas buena o malas, sino que cada respuesta que el alumno responda tendra un puntaje que ira variando en base a si la respuesta entregada fue de un mayor nivel de comprension o si fue una comprension superficial, permitiendo de este modo ver el nivel de cada alumno y sus competencias metacognitivas.

Actualmente el sitio web (http://elcu.informatica-unab-vm.cl/), esta siendo utilizado por investigadores de la Universidad Andres Bello con la finalidad de crear un sistema predictivo sobre como sera el rendimiento de los alumnos en evaluacioes como por ejemplo la PSU (Prueba de seleccion universitaria), que se rinde en chile o pruebas similares, por lo que su acceso aun se encuentra restringido.

Se pone a disposicion el codigo fuente con la finalidad de servir como una base para quienes deseen crear herramientas similares y requieran de ideas o que quieran iterar sobre este mismo codigo para lograr algo aun mas potente de lo que se tiene hasta ahora.

(Esta aplicacion fue desarrollada usando el framework SowerPHP)

Requisitos para el montaje:

  Preferiblemente utilizar algun sistema GNU/LINUX para hospedar la pagina.
  Tener instalado apache2.
  Contar con PHP 5.6 (Versiones mayores de PHP causan incompatibilidad con ciertas funciones utilizadas).
  Instalar mercurial y curl.
  Tener instalado modulos de php: php-pear, php5.6-gd, php5.6-curl, php5.6-imap, php5.6-mbstring.
  Tener instalado PostgreSQL y ejecutar el script que dentro de base de datos.
