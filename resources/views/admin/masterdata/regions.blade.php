@extends('adminlte::page')

@section('content')
    <div id="app">
        <region-component></region-component>
    </div>
@stop

@section('js')
    <script src="{{ asset('js/app.js') }}"></script>
@stop