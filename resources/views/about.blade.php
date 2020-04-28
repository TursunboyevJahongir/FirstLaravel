@extends('layout')
@section('title')
    About List
@endsection

@section('content')
    <h1>About</h1>
    @foreach ($users as $user)
        
    <li>{{$user->name}}</li>
    @endforeach
@endsection
