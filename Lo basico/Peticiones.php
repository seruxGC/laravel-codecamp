<?php
/*--------------------------------------------------------------------------
|  Peticiones

Para obtener una instancia de la petición HTTP actual vía inyección de dependencias,
 se debe hacer type-hint de la clase Illuminate\Http\Request en el método del controlador.
  La instancia de la petición entrante será automáticamente inyectada por el service container
---------------------------------------------------------------
-----------*/
/* A continuacón se accede a un elemento recibido por metodo GET o POST llamado "name
usando Request
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        /* Obtenemos el valor del parametro name*/
        $name = $request->input('name');

        //
    }
}

/*--------------------------------------------------------------------------
|  Inyección de dependencias & parámetros de rutas
---------------------------------------------------------------
-----------*/

/* Si el método del controlador también espera datos de entrada de un parámetro en la ruta se deben listar los parámetros de ruta después de las otras dependencias. Por ejemplo, si la ruta está definida así: */

// En web.php
Route::put('user/{parametroURL}', 'UserController@update');

// En el controlador
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Update the specified user.
     *
     * @param  Request  $request
     * @param  string  $parametroURL
     * @return Response
     */
    public function update(Request $request, $parametroURL)
    {
        // Obteniendo informacion del request y del parametro de la url de la ruta
        $usuario = $request->input('user');
        $parametroURL = $parametroURL;
    }
}


/*--------------------------------------------------------------------------
Accediendo a las peticiones usando Closures de ruta
---------------------------------------------------------------
-----------*/
use Illuminate\Http\Request;

Route::get('/', function (Request $request) {
    //
});






/*--------------------------------------------------------------------------
Metodos y ruta de la petición
---------------------------------------------------------------
-----------*/



/* #### Obtener la ruta desde la que se ha realizado la petición */


/* El método path retorna la información de la ruta de la petición. Así que, si la petición se realizara sobre http://domain.com/foo/bar, el método path retornaría foo/bar: */

    $uri = $request->path();

/*     El método is permite verificar si la ruta coincide con un patrón determinado. Se puede utilizar el carácter * como comodín al utilizar este método: */
    
    if ($request->is('admin/*')) {
        //
    }




    /*     #### Obtener la URL de la petición

Para obtener la URL completa de una petición entrante se pueden usar los métodos url o  fullUrl. El método url retorna la URL sin la cadena de consulta, mientras que fullUrl incluye todos los parámetros: */

// Without Query String...
$url = $request->url();

// With Query String...
$url = $request->fullUrl();




/* #### Obtener el método de la petición

El método method retornará el verbo HTTP de la petición. Además se puede utilizar el método isMethod para verificar que el verbo HTTP coincide con una cadena dada: */

$method = $request->method();

if ($request->isMethod('post')) {
    //
}


/*--------------------------------------------------------------------------
Obtener datos de entrada
---------------------------------------------------------------
-----------*/

/* ##### Obtener todos los datos de entrada */

/* Obtener todos los datos de entrada
También se pueden recuperar todos los datos de entrada como un array usando el método all: */

$input = $request->all();

/* ##### Recuperar un valor de entrada
 Sin importar el verbo HTTP, el método input se puede usar para recuperar las entradas del usuario: */

$name = $request->input('name');

/* Se puede pasar un valor por defecto como segundo argumento del método input. Este valor se retornará si el valor de la entrada solicitada no está presente en la petición: */

$name = $request->input('name', 'Sally');


/* ###### Recuperar una parte de los datos de entrada */

$input = $request->only(['username', 'password']);

$input = $request->only('username', 'password');

$input = $request->except(['credit_card']);

$input = $request->except('credit_card');


/*--------------------------------------------------------------------------
Determinar si un valor esta presente
---------------------------------------------------------------
-----------*/

/* Puede utilizar el método has para determinar si un valor está presente en la solicitud. El método has devuelve true si el valor está presente: */

if ($request->has('name')) {
    //
}

/* Cuando se le pasa un array, el método has determinará si todos los valores especificados están presentes: */

if ($request->has(['name', 'email'])) {
    //
}

/* Si desea determinar si un valor está presente en la solicitud y no está vacío, puede utilizar el método filled: */

if ($request->filled('name')) {
    //
}




/*--------------------------------------------------------------------------
Cookies
---------------------------------------------------------------
-----------*/

### Obtener las cookies de la petición

/*Todas las cookies creadas por el framework de Laravel están cifradas y firmadas con un código de autenticación, lo que significa que se considerarán inválidas si han sido modificadas por el cliente. Para recuperar un valor de una cookie de la solicitud, utilice el método cookie en una instancia de Illuminate\Http\Request: */

$value = $request->cookie('name');




/*--------------------------------------------------------------------------
Archivos
---------------------------------------------------------------
-----------*/


/* #### Obtener archivos subidos

Puede acceder a los archivos subidos desde una instancia Illuminate\Http\Request usando el método file o usando propiedades dinámicas. El método file devuelve una instancia de la clase Illuminate\Http\UploadedFile, que hereda la clase PHP SplFileInfo y proporciona una variedad de métodos para interactuar con el archivo: */

$file = $request->file('photo');

$file = $request->photo;

/* Puede determinar si un archivo está presente en la solicitud utilizando el método hasFile: */

if ($request->hasFile('photo')) {
    //
}

/* #### Validación de subidas exitosas

Además de comprobar si el archivo está presente, puede verificar que no hubo problemas para cargar el archivo a través del método isValid: */

if ($request->file('photo')->isValid()) {
    //
}


/* #### Extensiones & rutas de archivo

La clase UploadedFile también contiene métodos para acceder a la ruta totalmente calificada del archivo y su extensión. El método extension intentará adivinar la extensión del archivo en función de su contenido. Esta extensión puede ser diferente de la que fue suministrada por el cliente: */

$path = $request->photo->path();

$extension = $request->photo->extension();