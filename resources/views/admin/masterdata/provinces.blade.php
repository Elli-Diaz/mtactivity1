@extends('adminlte::page')

@section('content')
    <div id="app">
        <province-component
        :region="{{json_encode($region)}}">
        </province-component>
    </div>
@stop

@section('js')
    <script src="{{ asset('js/app.js') }}"></script>
@stop