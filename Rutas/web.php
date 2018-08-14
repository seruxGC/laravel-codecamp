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
Route::get('/','PaginasController@inicio');
Route::get('/inicio','PaginasController@inicio');
Route::get('/quienes-somos','PaginasController@quienesSomos');
Route::get('/donde-estamos','PaginasController@dondeEstamos');
Route::get('/foro','PaginasController@foro');

Route::get('/contacto', function () {
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

Route::get('/{param1}/{param2}/{param...}', function ($param1,$param2) {
    return "Este es el post numero " . $id;
});


Route::get('post/{id}', function ($id) {
    return "Este es el post numero " . $id;
});
// http://localhost/laravel/public/post/5



// EJEMPLO Ruta pasando varios parametros

Route::get('categoria/{id}/{nombre}', function ($id,$nombre) {
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
|--------------------------------------------------------------------------*/
Route::get('/controlador','MiControladorController@inicio');

/*--------------------------------------------------------------------------
|  Paso de parámetros a un controlador
| En este caso la función  dameParametros del controlador MiControladorController recibe el parámetro parametro1 de la ruta--------------------------------------------------------------------------*/
Route::get('/pasoParam/{parametro1}','MiControladorController@dameParametros');