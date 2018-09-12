@extends('plantillasPropias.plantilla1')

@section('contenido-principal')
   
    @if (count($viewData) > 0 )

        @foreach ($viewData as $data)
            {{ $data }} <br>
        @endforeach 

    @else  
        {{ 'Array sin datos' }}
    @endif

@endsection

{{-- 
La variable $viewData fue recibida esde el controlador
//PaginasController.php

 public function galeria()
    {
        $viewData = ['dato1', 'dato2', 'dato3'];
        return view('plantillasPropias.extiende2Plantilla1', compact('viewData'));
    }

--}}