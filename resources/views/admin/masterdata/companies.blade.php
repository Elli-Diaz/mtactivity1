@extends('adminlte::page')

@section('content')
    <div id="app">
        <company-component></company-component>
    </div>
@stop

@section('js')
    <script src="{{ asset('js/app.js') }}"></script>
@stop