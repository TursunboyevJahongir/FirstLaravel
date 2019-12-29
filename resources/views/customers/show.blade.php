@extends('layout')
@section('title')
    {{$customer->name}}
@endsection


@section('content')
    <h1>{{$customer->name}}</h1>
    <ul>
        <li>{{$customer->email}}</li>
        <li><b>{{$customer->company->name}}</b></li>
    </ul>
@endsection
