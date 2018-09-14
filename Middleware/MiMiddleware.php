<?php
/*--------------------------------------------------------------------------
|  Definicion Middleware

Los middleware proporcionan una herramienta para filtrar las peticiones HTTP que entran a la aplicación.

Esto es antes de que el controlador ejecute su acción o la ruta su funcion Closure.

Route::get('contacto', function () {
    return "contacto";
});

Todos estos middleware están ubicados en el directorio app/Http/Middleware
|--------------------------------------------------------------------------*/




/*--------------------------------------------------------------------------
|  Creación del Middleware

Con artisan:
php artisan make:middleware MiMiddleware

Este comando creará un nuevo middleware llamado MiMiddleware en el directorio  app/Http/Middleware
|--------------------------------------------------------------------------*/

namespace App\Http\Middleware;

use Closure;

class MiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }
}


/*--------------------------------------------------------------------------
| Middleware antes o después de realizar la petición http

Que el middleware se ejecute antes o después de que la petición entre en la aplicación depende del uso del middleware en si mismo. 
|--------------------------------------------------------------------------*/

// Before Middleware
namespace App\Http\Middleware;

use Closure;

class BeforeMiddleware
{
    public function handle($request, Closure $next)
    {
        // Acciones a realizar antes de que se ejecute la petición

        return $next($request);
    }
}


// After Middleware
namespace App\Http\Middleware;

use Closure;

class AfterMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // Acciones a realizar después de que se ejecute la petición

        return $response;
    }
}


/*--------------------------------------------------------------------------
| Middleware Terminable (realizar algunas acciones después de que la respuesta HTTP ha sido enviada al navegador.)

Si se define un método terminate en el middleware, se ejecutará automáticamente después de que la respuesta se haya enviado al navegador.

El método terminate debe recibir tanto la petición como la respuesta. (como parámetros)
|--------------------------------------------------------------------------*/
namespace App\Http\Middleware;

use Closure;

class MiMiddleware
{
    public function handle($request, Closure $next)
    {
        // Acciones a realizar antes de que la petición HTTP entre en la aplicación
        return  $next($request);
    }

    public function terminate($request, $response)  // --> debe recibir tanto la petición como la respuesta. (como parámetros)
    {
        // Acciones a realizar  después de que la respuesta HTTP ha sido enviada al navegador.
    }
}





/*--------------------------------------------------------------------------
| Registrar un Middleware

Para poder usar el Middleware hay que registrarlo en la app.
|--------------------------------------------------------------------------*/

/* - Middleware Global

Si se desea que un middleware se ejecute en todas las peticiones HTTP de la aplicación, simplemente 
debe listar el middleware en la propiedad $middleware de la clase  app/Http/Kernel.php
*/ 

// app/Http/Kernel.php
 
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \App\Http\Middleware\TrustProxies::class,
        
        //Añadimos aqui nuestro Middleware global
        \App\Http\Middleware\MiMiddleware::class
    ];


    /* - Middleware para rutas especificas

Si se desea que el middleware se ejecute en rutas especificas, primero debe asignarse al middleware 
un identificador en el archivo app/Http/Kernel.php. La propiedad  $routeMiddleware de esta clase 
contiene registros de middleware incluidos por Laravel por defecto. Para agregar middleware 
personalizados, simplemente debe añadirse a la lista el nuevo middleware y asignarle el identificador
 de acceso rápido que se desee. 
*/ 

// app/Http/Kernel.php

protected $routeMiddleware = [
    'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
    'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
    'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
    'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
    'can' => \Illuminate\Auth\Middleware\Authorize::class,
    'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
    'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
    'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
    'testMiddle' => \App\Http\Middleware\middleTest::class,

    //Añadimos aqui nuestro Middleware de ruta
    'miMiddleware' => \App\Http\Middleware\MiMiddleware::class
];

/**Una vez que el middleware ha sido registrado en el kernel HTTP, se puede utilizar el identificador 
 * de middleware para asignarlo a una ruta: */

// \Routes\web.
Route::get('admin/profile', function () {
    //
})->middleware('miMiddleware');

Route::get('/controlador', 'MiControladorController@inicio')->middleware('miMiddleware');

/*Se puede además asignar varios middleware a una ruta:*/ 

// \Routes\web.
Route::get('/', function () {
    //
})->middleware('miMiddleware', 'otroMiddleware');

Route::get('/controlador', 'MiControladorController@inicio')->middleware('miMiddleware','otroMiddleware');





/* - Grupos de Middleware

/** 
 * En ocasiones es útil agrupar varios middleware sobre un mismo identificador haciendo la asignación 
 * a rutas mucho más simple. Esto se puede hacer utilizando la propiedad  $middlewareGroups del kernel
 *  HTTP.

Por defecto, Laravel incluye los grupos de middleware web y api que contienen el middleware común que
 se suele aplicar a las rutas de web UI y API:
*/

// app/Http/Kernel.php
protected $middlewareGroups = [
    'web' => [
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        // \Illuminate\Session\Middleware\AuthenticateSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ],

    'api' => [
        'throttle:60,1',
        'bindings',
    ],

    //Añadimos nuestro grupo
    'miGrupoMiddleware' => [
        App\Http\Middleware\MiMiddleware::class,
        App\Http\Middleware\OtroMiddlewareMio::class
    ],
];

/**Los grupos de middleware se pueden asignar a rutas y acciones de controladores utilizando la misma
 *  sintaxis que un middleware individual.  */

 // \Routes\web.
Route::get('admin/profile', function () {
    //
})->middleware('miGrupoMiddleware');

Route::get('/controlador', 'MiControladorController@inicio')->middleware('miGrupoMiddleware');



/*--------------------------------------------------------------------------
|  Middleware con Parámetros (especificados en la llamada al Middleware)

->middleware('miMiddleware:valorMiParametro');

Los middleware pueden recibir parámetros adicionales.

Los parámetros adicionales del middleware deben ser pasados después de argumento  $next :
--------------------------------------------------------------------------*/
class MiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $miParametro) // <-----
    {
        return $next($request);
    }
}

/**
 * Los parámetros del middleware pueden ser especificados se define la ruta, separando el nombre del 
 * middleware y los parámetros con :. Multiples parámetros deben ser separados por comas.
 */
// Llamada al Middleware desde routes/web.php
Route::get('ruta', function () {
    //
})->middleware('miMiddleware:valorMiParametro');

// LLamada al Middleware desde el constructor de un controlador
$this->middleware('miMiddleware:valorMiParametro');


// CON VARIOS PARAMETROS

// miMiddleware.php
public function handle($request, Closure $next, $miParametro, $otroParametro) // <-----
{
    return $next($request);
}

// routes/web.php
Route::put('post/{id}', function ($id) {
   
})->middleware('miMiddleware:valorMiParametro,valorOtroParametro');

// LLamada al Middleware desde el constructor de un controlador
$this->middleware('miMiddleware:valorMiParametro,valorOtroParametro');





/*--------------------------------------------------------------------------
|  Obtener parametros de la ruta en el Middleware (url)

Se puede usar la clase Illuminate\Http\Request para obtener directamente parametros
de la ruta usando:

$request->nombreDelParametroURL;
--------------------------------------------------------------------------*/
// routes/web.php
Route::get('/url/{parametroURL}', 'MiControladorController@miFuncion')->middleware('miMiddleware');

// app/Http/Middleware/MiMiddleware.php
namespace App\Http\Middleware;

use Closure;

class MiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $valor = $request->parametroURL; // /url/mivalorURL   ->   $valor = 'mivalorURL';
        return $next($request);
    }
}


/*--------------------------------------------------------------------------
|  Redireccionar en un Middleware

Cuando el Middleware determina que no se debe continuar con la petición HTTP
se puede redireccionar a otra ruta de la siguiente menera (obviamente debe ser una ruta
válida especificada en routes/web.php)
--------------------------------------------------------------------------*/
// app/Http/Middleware/MiMiddleware.php
namespace App\Http\Middleware;

use Closure;

class MiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        if( $request->acceso == false ){
            return redirect('index'); // Suponiendo que existe la ruta index...
        }
        
        return $next($request);
    }
}