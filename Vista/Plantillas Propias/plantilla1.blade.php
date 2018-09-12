<!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Page Title</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <style>
        .contenedor-principal{
            color: blue;
        }
        </style>

    </head>

    <body>

        <div class="contenedor-principal">
            
             {{-- La directiva @yield es utilizada para 
            mostrar el contenido de una sección. --}}
            
            <h1>@yield('titulo-pagina')</h1>
            
            @yield('contenido-principal')

        </div>

        <div class="pie-pagina">
            @yield('contenido-pie')
        </div>

        {{-- Cuando se define una seccion con la directiva @show , el contenido
            en ella se muestra inmediatamente --}}
        @section('debajo')
        Contenido de la seccion por defecto.
        @show

    </body>

    </html>