@extends('layout')
@section('title')
    Edit Customer {{$customer->name}}
@endsection


@section('content')
    <h1>Edit Customer</h1>

    <form action="/customers/{{$customer->id}}" class="pb-4" method="post">
        @method('PATCH')
        <div class="form-group">
            @include('customers.form')
            <button type="submit" class="btn btn-primary">Save</button>
        @csrf
    </form>

@endsection
