@extends('adminlte::page')

@section('content')
    <div id="app">
        <test-component></test-component>
    </div>
@stop 

@section('js')
    <script src="{{ asset('js/app.js') }}"></script>
@stop