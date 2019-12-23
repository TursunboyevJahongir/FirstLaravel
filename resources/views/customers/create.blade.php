@extends('layout')
@section('title')
   Add Customer
@endsection


@section('content')
    <h1>Customers</h1>

    <form action="/customers" class="pb-4" method="post">
        @include('customers.form')
        <button type="submit" class="btn btn-primary">Create</button>
        @csrf
    </form>

@endsection
