Base forum for Laravel 5.3 projects.


Este foro Se encuentra en la rama master y está en desarrollo.

Aún así es funcional y puedes usarlo y mandarme pull requests si quieres
ayudar a su desarroyo.

Instalar:
 
 - Clonar proyecto
 - Ejecutar composer install en la carpeta del proyecto.
 - Configurar la base de datos.
 - Ejecutar las migraciones.
 - Registar un nuevo usuario y cambiarlo a Admin directamente en la base
    de datos.
 - Tambien tienes diponibles seeders y tests para probar la aplicación
    según el patron TDD.
 - Por defecto el foro con ID = 1 solo lo verán los usuarios con el rol
    de Administrador pero puedes cambiar esto en el archivo forums.php
    en la carpeta config.

Notas:

 - Los permisos de foros estan implementados de la manera mas sencilla
 posible y son incrementales, de tal manera que el Moderator puede 
 realizar las acciones del User y el Guest, a su vez el Admin puede 
 realizar todas las acciones de Moderator y algunas mas. 
 El archichivo Roles Doc.txt sirve como guia para los permisos
 de cada rol, a los que el programa referencia como Skills. Los test:
 
 ForumPoliciesTest.php
 PostPoliciesTest.php
 CommentPoliciesTest.php
 ProfilePoliciesTest.php
 
 tambien pueden servirte como guia sobre que acciones puede realizar cada rol.

Copyright (c)
Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation
files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy,
modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following conditions:
The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE,
ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

Copyright (c)
Se concede permiso por la presente, de forma gratuita, a cualquier persona que obtenga una copia de este software y de
los archivos de documentación asociados (el "Software"), para utilizar el Software sin restricción, incluyendo sin
limitación los derechos de usar, copiar, modificar, fusionar, publicar, distribuir, sublicenciar, y/o vender copias
de este Software, y para permitir a las personas a las que se les proporcione el Software a hacer lo mismo, sujeto a
las siguientes condiciones:
El aviso de copyright anterior y este aviso de permiso se incluirán en todas las copias o partes sustanciales del Software.
EL SOFTWARE SE PROPORCIONA "TAL CUAL", SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A
GARANTÍAS DE COMERCIALIZACIÓN, IDONEIDAD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO LOS AUTORES O TITULARES
DEL COPYRIGHT SERÁN RESPONSABLES DE NINGUNA RECLAMACIÓN, DAÑOS U OTRAS RESPONSABILIDADES, YA SEA EN UN LITIGIO, AGRAVIO O
DE OTRO MODO, QUE SURJA DE O EN CONEXIÓN CON EL SOFTWARE O EL USO U OTRO TIPO DE ACCIONES EN EL SOFTWARE.