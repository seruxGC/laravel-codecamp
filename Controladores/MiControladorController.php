<?php
/*
|--------------------------------------------------------------------------
| Crear controlador desde la consola

Estando en el directorio del proyecto de Laravel ejecutar el siguiente comando:

php artisan make:controller NombreController

Para crear este mismo controlador:
php artisan make:controller MiControladorController
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Crear controlador desde la consola con recursos

Estando en el directorio del proyecto de Laravel ejecutar el siguiente comando:

php artisan make:controller --resource NombreController
--------------------------------------------------------------------------
*/



namespace App\Http\Controllers;

/*--------------------------------------------------------------------------
|  Controladores

Ruta: app/Http/Controllers

 En lugar de definir toda la lógica para la gestión de una 
 petición dentro de Closures o funciones anónimas en los 
 archivos de rutas, se puede organizar este comportamiento en
 unas clases llamadas Controladores (controllers). Los 
 controladores pueden agrupar la lógica de gestión de 
 peticiones relacionadas en una única clase. Estos 
 controladores se encuentran normalmente en el directorio
  app/Http/Controllers.

  NOTA: Los controladores no requieren heredar la clase base. 
  Sin embargo, no se tendrá acceso a las características como 
  los métodos middleware, validate, y dispatch.
|
---------------------------------------------------------------
-----------*/

class MiControladorController extends Controller
{
    public function inicio()
    {
        return 'Estas en el inicio';
    }


/*--------------------------------------------------------------------------
|  Se puede apuntar una ruta a la acción de este controlador
 así:

 En web.php: 

 Route::get('/nombreDeRuta', 'NombreControladorController@nombreMetodo');

 En este caso:
 Route::get('/controlador', 'MiControladorController@inicio');
|--------------------------------------------------------------------------*/


/*--------------------------------------------------------------------------
|  Crear en el controlador un método que reciba parámetros desde la ruta:

En web.php:

Route::get('/pasoParam/{parametro1}','MiControladorController@dameParametros');

url: http://localhost/laravel/public/pasoParam/ElParametro
|--------------------------------------------------------------------------*/
public function dameParametros($parametro)
{
    return 'He recibido este parametro ' . $parametro;
}


public function foro()
    {
        return view("foro");
    }

    public function galeria()
    {
        $viewData = ['dato1', 'dato2', 'dato3'];
        return view('plantillasPropias.extiende2Plantilla1', compact('viewData'));
    }
}



/*--------------------------------------------------------------------------
|  Asignar un Middleware a un controlador

 es más conveniente especificar el middleware en el constructor del controlador. Utilizando el método 
 middleware desde el constructor del controlador, se puede asignar un middleware a las acciones del
  controlador. Incluso se puede restringir el middleware a únicamente ciertos métodos:
--------------------------------------------------------------------------*/

// Tras registrar el Middleware en app/Http/Kernel.php

class MiControladorController extends Controller
{
    public function __construct()
    {
        // Para todas las funciones
        $this->middleware('miMiddleware');

        // Solo para las funciones especificadas. Nombre de las funciones separadas por comas.
        $this->middleware('miMiddleware')->only('miFuncion');

        // Para todas las funciones excepto las especificadas. Nombre de las funciones separadas por comas.
        $this->middleware('miMiddleware')->except('inicio');

    }

    public function inicio()
    {
        return 'Estas en el inicio';
    }

    public function miFuncion()
    {

    }
}