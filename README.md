Base forum for Laravel 5.3 projects.


Este foro Se encuentra en la rama master y está en desarrollo.

Aún así es funcional y puedes usarlo y mandarme pull requests si quieres
ayudar a su desarroyo.

Instalar:
 
 1 - Dentro de la carpeta de Laravel ejecutar:
 
     composer require codehell/codehellbb=dev-master
 
 2 - Configurar .env la base de datos y el driver de email
 
 3 - Configurar el sistema de autentificación de laravel
 
     php artisan make:auth
 
 4 - En Routes/web.php comentar la linea:
 
     //Auth::routes();
 
 5 - En el archivo config/app añadir los providers:
 
     Codehell\Codehellbb\Providers\CbbServiceProvider::class,
     Rap2hpoutre\LaravelLogViewer\LaravelLogViewerServiceProvider::class,
 
 6 - En el archivo config/auth.php cambiar el modelo de autentificacion
 
     'providers' => [
         'users' => [
             'driver' => 'eloquent',
             'model' => \Codehell\Codehellbb\Entities\User::class,
         ],
 
 7 - Publicar los archivos de la aplicación
 art vendor:publish --provider='Codehell\Codehellbb\Providers\CbbServiceProvider'
 
 8 - En el archivo app/HTTP/kernel.php añadir los siguientes middlewares:
     protected $routeMiddleware = [
         .
         .
         'is_admin' => \Codehell\Codehellbb\Middleware\IsAdmin::class,
         'forum' => \Codehell\Codehellbb\Middleware\ForumAccessControl::class,
         'is_banned' => \Codehell\Codehellbb\Middleware\IsBanned::class,
     ]
 
 9 - Ejecutar las migraciones
 
     php artisan migrate
 
 10 - Registrar un usuario y cambiarlo a Admin y cambiar el campo 'registration_token' a null en la tabla 'profiles' de la base de datos.
 
 Acceder a http://my.web/forum
 
 11 - Disfruta de tu foro. (El primer foro que crees, sera solo accesible a los administradores, puedes cambiar esta configuración en:
     config/codehellbb.php)


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