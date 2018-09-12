{{-- Comentario en plantilla Blade --}}


{{----------------------------------------------------------------------------
|  Mostrar datos
|----------------------------------------------------------------------------}}
Mostrar contenido de {{ $variable }}
Mostrar contenido de {{ metodo() }}

{{----------------------------------------------------------------------------
|  Mostrar Variable solo si existe
|----------------------------------------------------------------------------}}
Metodo 1 {{ isset($variable) ? $variable : 'Valor por defecto' }}
Metodo 2 (notacion propia de Blade) {{ $variable or 'Valor por defecto' }}





{{----------------------------------------------------------------------------
|  Estructuras de control
|----------------------------------------------------------------------------}}

@if( count($users) === 1 )
    Solo hay un usuario!
@elseif (count($users) > 1)
    Hay muchos usuarios!
@else
    No hay ningún usuario :(
@endif

{{-------------------------------------------------------------------------}}

@for ($i = 0; $i < 10; $i++)
El valor actual es {{ $i }}
@endfor

{{-------------------------------------------------------------------------}}

@while (true)
<p>Soy un bucle while infinito!</p>
@endwhile

{{-------------------------------------------------------------------------}}

@foreach ($users as $user)
<p>Usuario {{ $user->name }} con identificador: {{ $user->id }}</p>
@endforeach

{{-------------------------------------------------------------------------}}





{{----------------------------------------------------------------------------
| Insertar una plantilla dentro de otra plantilla 

(Por ejemplo un fragmento de codigo html que tengamos en un archivo 
a parte dentro de un archivo html principal)

Esta opción es muy útil para crear vistas que sean reutilizables o para separar el contenido
de una vista en varios ficheros.
|----------------------------------------------------------------------------}}
@include('view_name')

{{-- Ademas podemos pasarle un array de datos a la vista a cargar usando el segundo
parámetro del método include : --}}
@include('view_name', array('some'=>'data'))




{{----------------------------------------------------------------------------
|  Definicion de plantillas (layout)
|----------------------------------------------------------------------------}}

{{-- PlantillaPrincipal.blade.html --}}
<!DOCTYPE html>
    <html>
        <head>
        </head>
            <body>
                    {{-- La directiva @yield('nombreSeccion') es utilizada para mostrar el contenido 
                        de una sección. @yield será sustituido por el contenido que se indique. --}}  
                    <div class="contenedor-principal">
                        @yield('contenido-seccion-principal')
                    </div>

                    {{-- El método @yield también permite establecer un contenido por 
                        defecto mediante su segundo parámetro --}}
                        @yield('nombreSeccion', 'Contenido por defecto')




                {{-- Cuando se define una seccion con la directiva @show , el contenido
                    en ella se muestra inmediatamente. La directiva @section permite ir 
                    añadiendo contenido en las plantillas hijas a diferencia de yield --}}
                @section('debajo')
                Contenido de la seccion por defecto.Con posibilidad de añadir mas en 
                las plantillas hijas usando la directiva @parent.
                @show

            </body>
    </html>

{{-- Posteriormente, en otra plantilla o vista, podemos indicar que extienda el layout que hemos
creado (con @extends('PlantillaPrincipal.blade.html') ) y que complete las dos secciones de contenido
que habíamos definido en el mismo: --}}

    {{-- ExtiendePlantillaPrincipal.blade.html --}}
    @extends('PlantillaPrincipal.blade.html')

    @section('contenido-seccion-principal')
        <p>Este contenido se insertara donde PlantillaPrincipal.blade.html definió
            el yield que referencia a contenido-seccion-principal</p>
    @endsection

    @section('debajo')
        @parent
        <p>Suma este contenido al que había previamente por defecto en la plantilla principal.</p>

        <p> En caso de no usar la directiva @parent simplemente se sustituita el contenido
            de la plantilla principal por este.</p>
    @endsection