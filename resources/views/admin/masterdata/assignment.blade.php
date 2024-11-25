@extends('adminlte::page')

@section('content')
    <div id="app">
        <assignment-component :name="{{json_encode($name)}}" :age="{{json_encode($age)}}">

        </assignment-component>
    </div>
@stop 

@section('js')
    <script src="{{ asset('js/app.js') }}"></script>
@stop