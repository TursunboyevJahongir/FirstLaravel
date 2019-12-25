@extends('layout')

@section('content')
    <h1>Customers</h1>

    <form action="customers" class="pb-5" method="post">
    <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="Name Customer" aria-label="Recipient's username" aria-describedby="basic-addon2" name="name">
        <div class="input-group-append">
            <button class="btn btn-outline-secondary" type='submit'>Add</button>
        </div>
    </div>
        @csrf
    </form>


    <ul>
        @foreach($customers as $customer)
            <li>{{$customer->name}}</li>
        @endforeach
    </ul>
@endsection
