<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|

Ruta: routes/web.php
 */

/* Route::get('/', function () {
return view('welcome');
}); */

Route::get('/', 'PaginasController@inicio');
Route::get('inicio', 'PaginasController@inicio');
Route::get('quienes-somos', 'PaginasController@quienesSomos');

Route::get('contacto', function () {
    return "contacto";
});





/*--------------------------------------------------------------------------
|  Rutas que solo necesitan devolver una vista
|
Si únicamente se necesita devolver una vista desde una ruta,
se puede utilizar el método  Route::view

El método view acepta una URI como primer parámetro y un nombre de vista como segundo. Además, se le puede pasar un array de datos a la vista como tercer parámetro opcional:
--------------------------------------------------------------------------*/
Route::view('/welcome', 'welcome');

Route::view('/welcome2', 'welcome', ['name' => 'Taylor']);





/*--------------------------------------------------------------------------
|  Rutas con parámetros
|--------------------------------------------------------------------------*/

Route::get('/{param1}/{param2}/{param...}', function ($param1, $param2) {
    return "Este es el post numero " . $id;
});

Route::get('post/{id}', function ($id) {
    return "Este es el post numero " . $id;
});
// http://localhost/laravel/public/post/5

// EJEMPLO Ruta pasando varios parametros

Route::get('categoria/{id}/{nombre}', function ($id, $nombre) {
    return "Esta es la categoria numero " . $id . " con nombre " . $nombre;
});
// http://localhost/laravel/public/categoria/5/naturaleza

/*--------------------------------------------------------------------------
|  Ruta con parámetros opcionales
|--------------------------------------------------------------------------*/

/**A veces es necesario especificar un parámetro, pero la
 * presencia de este parámetro es opcional. Se puede definir
 * simplemente añadiendo el símbolo ? detrás del nombre del
 * parámetro. Asegúrese de dar a esa variable un valor por
 * defecto en su callback/controlador: */

Route::get('user/{name?}', function ($name = null) {
    return $name;
});

// http://localhost/laravel/public/user

/* Route::get('user/{name?}', function ($name = 'John') {
return $name; // John
}); */





/*--------------------------------------------------------------------------
|  Expresiones regulares para definir parametros
|--------------------------------------------------------------------------*/

/*Es posible limitar el formato de los elementos dentro de los
parámetros de una ruta usando el método where en una instancia
de Route. El método where acepta el nombre del parámetro y la
expresión regular que define como se debe limitar el
parámetro:*/

Route::get('letras/{name}', function ($name) {
    // name solo puede tener letras mayusculas y minusculas
})->where('name', '[A-Za-z]+');

Route::get('numeros/{id}', function ($id) {
    // id solo puede ser un numero
})->where('id', '[0-9]+');

Route::get('numerosletras/{id}/{name}', function ($id, $name) {
    //
})->where(['id' => '[0-9]+', 'name' => '[a-z]+']);








/*--------------------------------------------------------------------------
|  Llamar a un controlador desde la ruta
--------------------------------------------------------------------------*/

/**
 * | Route::get('/controlador','MiControladorController@nombreFuncion');
 */
Route::get('/controlador', 'MiControladorController@inicio');

/*--------------------------------------------------------------------------
|  Paso de parámetros a un controlador
---------------------------------------------------------------
-----------*/
/**
 * | En este caso la función  dameParametros del controlador
 *MiControladorController recibe el parámetro parametro1 de
 * la  ruta
 */
Route::get('/pasoParam/{parametro1}', 'MiControladorController@dameParametros');

/*--------------------------------------------------------------------------
|  Llamada a un controlador que solo contiene un único método
---------------------------------------------------------------
-----------*/
Route::get('user/{param}', 'NombreControladorController');





/*--------------------------------------------------------------------------
|  Ruta a un controlador de recursos
---------------------------------------------------------------
-----------*/

/**
 * Route::resource("/nombreRuta",'NombreControladorRecursosController');
 */

Route::resource("usuarios",'RecursoController');

// NOTA: Se pueden registrar varios controladores de recursos a la vez pasando una array al método resources:

Route::resources([
    'usuarios2','RecursoController',
    'photos' => 'PhotoController',
    'posts' => 'PostController'
]);

/*--------------------------------------------------------------------------
|  Ruta a un controlador de recursos con acceso solo a algunos métodos
---------------------------------------------------------------
-----------*/
//Cuando se declara una ruta de recursos, se puede especificar un subconjunto de acciones
// que el controlador debe manejar en lugar del conjunto completo de acciones predeterminadas:

// Solo acceso a las funciones especificadas (only)
Route::resource('photo', 'PhotoController', ['only' => [ 
    'index', 'show'
]]);

// Acceso a todas las funciones menos las especificadas (except)
Route::resource('photo', 'PhotoController', ['except' => [
    'create', 'store', 'update', 'destroy'
]]);

/*--------------------------------------------------------------------------
|  Ruta a un controlador de recursos con algun método propio
---------------------------------------------------------------
-----------*/
/**
 * Si es necesario agregar rutas adicionales a un controlador de recursos más 
 * allá de las predeterminadas, se deben definir antes de llamar a Route::resource; 
 * de otro modo, las rutas definidas por el método resource pueden prevalecer sobre 
 * las rutas suplementarias:
 */
Route::get('photos/popular', 'PhotoRecursoController@miMetodoPopular');

Route::resource('photos', 'PhotoRecursoController');

/*--------------------------------------------------------------------------
|  Cambiar nombre de ruta de una accion del controlador de recursos 
---------------------------------------------------------------
-----------*/
/**
 * Por defecto, todas las acciones de los controladores de recursos tienen un
 *  nombre de ruta; sin embargo, se puede sobrescribir este nombre pasando un
 *  array names con sus opciones:
 */
Route::resource('rutaDeLaWeb', 'RecursoController', ['names' => [
    'create' => 'nombreDeRuta'
]]);

/*--------------------------------------------------------------------------
|  Cambiar nombre de parametros en rutas de recursos
---------------------------------------------------------------
-----------*/
/**
 * Por defecto, Route::resource crea los parámetros de ruta para las rutas de 
 * recursos utilizando la versión "singular" del nombre del recurso. Se puede
 *  sobrescribir esto fácilmente por recurso pasando parameters en el array de 
 * opciones. El array de parameters debe ser un array asociativo de los nombres 
 * de los recursos y el nombre de su parámetro:
 */

Route::resource('categorias', 'AdminUserController', ['parameters' => [
    'categorias' => 'catName'
]]);

// El ejemplo anterior genera las siguientes URIs para la ruta show del recurso:
// /categorias/{catName}   en lugar de    /categorias/{categoria}


/*--------------------------------------------------------------------------
|  Acciones gestionadas por controladores de recursos
---------------------------------------------------------------
-----------*/
/**
 * Route::resource('photos', PhotosResourceController);
 * 
Verbo       URI                     Acción          Nombre de Ruta
GET         /photos                 index           photos.index
GET         /photos/create          create          photos.create
POST        /photos	store           photos.store
GET         /photos/{photo}         show            photos.show
GET         /photos/{photo}/edit	edit            photos.edit
PUT/PATCH	/photos/{photo}         update          photos.update
DELETE      /photos/{photo}         destroy         photos.destroy
 */

/**
 * Suplantación de métodos en formularios
Los formularios HTML no pueden realizar peticiones PUT, PATCH, o DELETE, para 
 * hacerlo se necesita agregar un campo oculto _method para suplantar estos 
 * verbos HTTP. El helper method_field permite crear este campo de forma rápida:
 */

// {{ method_field('PUT') }}