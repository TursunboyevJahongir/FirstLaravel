@extends('layout')
@section('title')
   Add Customer
@endsection


@section('content')
    <h1>Customers</h1>

    <form action="/customers" class="pb-4" method="post">
        <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" class="form-control" placeholder="Enter email" name="email" value="{{old('email')}}" required="required">
            <i class="mb-3" style="color: red"><b>{{$errors->first('email')}}</b></i>
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Name Customer</label>
            <input type="text" class="form-control" placeholder="Name" name="name" value="{{old('name')}}" required="required">
            <u class="mb-3" style="color: red"><b>{{$errors->first('name')}}</b></u>
        </div>
        <div class="row pb-4">
            <div class="col-lg-9">
                <label>Company name:</label>
                <select class="form-control custom-select custom-select-sm form-control" name="company_id" id="company">
                    @foreach($companies as $company)
                        <option selected value="{{$company->id}}">{{$company->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class=" col-lg-3">
                <label>Status :</label>
                <select class="form-control custom-select custom-select-sm form-control" name="status" id="status">
                    <option selected value="1">Active</option>
                    <option value="0" style="background-color: #ff2f99;color: white">Inavtive</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        @csrf
    </form>

@endsection
