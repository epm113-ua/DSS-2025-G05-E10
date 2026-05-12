@extends('layouts.app')
@section('titulo', 'Inicio')

@section('contenido')
@php
    return redirect(Auth::user()->rutaInicio());
@endphp
@endsection
