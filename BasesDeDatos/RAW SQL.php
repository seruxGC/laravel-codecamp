<?php

/* Select , devuelve un array con los elementos seleccionados */
$users = DB::select('SELECT * from users where id = :id', ['id' => 1]);

/* Recorre el array obteniendo los valores de los campos
de la tabla */
foreach ($users as $user) {
    echo $user->name;
}

/* Insert */
DB::insert(
    'INSERT into users (id, name) values (:id, :name)',
    [
        'id' => 1,
        'name' => 'Dayle'
    ]
);

/* Update , devuelve un int con el numero de filas afectadas */
$affected = DB::update('update users set votes = 100 where name = :name', ['name' => 'John']);

/* Delere ,devuelve un int con el numero de filas afectadas   */
$deleted = DB::delete('delete from users');
