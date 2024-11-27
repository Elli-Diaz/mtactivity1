@extends('adminlte::page')

@section('content')
    <div id="app">
        <employee-component
        :companies="{{json_encode($companies)}}">
        </-component>
    </div>
@stop

@section('js')
    <script src="{{ asset('js/app.js') }}"></script>
@stop