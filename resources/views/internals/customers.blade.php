@extends('layout')

@section('content')
    <h1>Customers</h1>

    <form action="customers" class="pb-5" method="post">
    <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="Name Customer"  name="name" value="{{old('name')}}">
        <input type="text" class="form-control" placeholder="Email Customer"  name="email" value="{{old('email')}}">
        <div class="input-group-append">
            <button class="btn btn-outline-secondary" type='submit'>Add</button>
        </div>
    </div>
    <i class="mb-3" style="color: red"><b>{{$errors->first('name')}}</b></i>
    <i class="mb-3" style="color: red "><b>{{$errors->first('email')}}</b></i>
        @csrf
    </form>


    <ul>
        @foreach($customers as $customer)
            <li>{{$customer->name}}  <a style="color: #636b6f" href="#">({{$customer->email}})</a></li>
        @endforeach
    </ul>
@endsection
