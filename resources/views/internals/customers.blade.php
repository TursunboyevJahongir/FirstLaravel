@extends('layout')
@section('title')
    Customer List
@endsection


@section('content')
    <h1>Customers</h1>



    <form action="customers" class="pb-4" method="post">
        <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" class="form-control" placeholder="Enter email" name="email" value="{{old('email')}}">
            <i class="mb-3" style="color: red"><b>{{$errors->first('email')}}</b></i>
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Name Customer</label>
            <input type="text" class="form-control" placeholder="Name" name="name" value="{{old('name')}}">
            <u class="mb-3" style="color: red"><b>{{$errors->first('name')}}</b></u>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        @csrf
    </form>


    <table class="table table-striped   table-hover">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            @foreach($customers as  $key=> $customer)
                <th scope="row">{{$key+1}}</th>
                <td>{{$customer->name}}  </td>
                <td><a style="color: #636b6f" href="#">({{$customer->email}})</a></td>
        </tr>
        @endforeach

        </tbody>
    </table>

    <ul>
    </ul>
@endsection
