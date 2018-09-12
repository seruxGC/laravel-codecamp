

 {{--  Heredar una plnatilla @extends('directorio.nombrePlantilla') --}}

@extends('plantillasPropias.plantilla1')

{{-- La directiva  @section , como su nombre indica, define una
sección de contenido , en este caso enlaza con un 
contenido yield definido previamente en la plantilla 
padre (  @yield('contenido-principal')  ) --}}

@section('titulo-pagina')
Extiende Plantilla 1
@endsection

@section('contenido-principal')
Contenido principal
@endsection

{{-- @section('debajo')
    Sobreescribe la sección 'debajo' de la plantilla padre
@endsection --}}