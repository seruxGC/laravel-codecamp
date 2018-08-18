<?php 
/**
 * Si se necesita, se puede definir un controlador que 
 * únicamente gestione una única acción, simplemente es
 *  necesario colocar el método __invoke dentro del 
 * controlador:
 */
namespace App\Http\Controllers;

class UnicoMetodoController extends Controller
{
    public function __invoke($param)
    {

    }
}

/**
 * Cuando se registra una ruta de un controlador de acción 
 * única, no se necesita especificar ningún método en la ruta:
 * 
 * Route::get('user/{param}', 'UnicoMetodoController');
 */