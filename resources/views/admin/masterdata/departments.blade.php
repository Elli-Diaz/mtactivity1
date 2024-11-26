@extends('adminlte::page')

@section('content')
    <div id="app">
        <department-component
        :company="{{json_encode($company)}}">
        </department-component>
    </div>
@stop

@section('js')
    <script src="{{ asset('js/app.js') }}"></script>
@stop