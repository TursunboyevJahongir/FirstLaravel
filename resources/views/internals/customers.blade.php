@extends('layout')
@section('title')
    Customer List
@endsection
<link rel="stylesheet" type="text/css" href="{{ asset('/sass/marquee.css') }}"/>


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
        <label>Status :</label>
        <div class="form-control">
            <select class=" custom-select custom-select-sm form-control" name="status" id="status">
                <option selected value="1">Active</option>
                <option value="0" style="background-color: #ff2f99;color: white">Inavtive</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        @csrf
    </form>

    <div class="row">
        <div class="col-lg-6">
            <div class="alert alert-primary" role="alert">
                <center style="font-family: 'Bookman Old Style'"><b>Active</b></center>
            </div>
            <table class="table table-striped   table-hover table-bordered">
                <thead class="table-active">
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    @foreach($activeCustomers as  $key=> $customer)

                        <td class="labelContainer " style="color: black">
                            <div class="boardindex_themefitted_board_main">
                                <div class=" boardindex_themefitted_board_main_description scroll_on_hover ellipsis">
                                    {{$customer->name}}
                                </div>
                            </div>
                        </td>
                        <td><a style="color: #636b6f" href="#">
                                <marquee behavior="alternate" direction="left"
                                         onmouseover="this.stop();"
                                         onmouseout="this.start();" scrollamount="3">{{$customer->email}}</marquee>
                            </a></td>
                </tr>
                @endforeach

                </tbody>
            </table>
        </div>
        <div class="col-lg-6">
            <div class="alert alert-danger" role="alert">
                <center style="font-family: 'Bookman Old Style'"><b>Inactive</b></center>
            </div>
            <table class="table table-striped  table-danger table-hover table-bordered">
                <thead class="thead-dark">
                <tr>

                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    @foreach($inactiveCustomers as  $key=> $customer)

                        <td class="labelContainer" style="color: black">
                            <div class="boardindex_themefitted_board_main">
                                <div class=" boardindex_themefitted_board_main_description scroll_on_hover ellipsis">
                                    {{$customer->name}}
                                </div>
                            </div>
                        </td>
                        <td><a style="color: #636b6f" href="#">
                                <marquee behavior="alternate" direction="left"
                                         onmouseover="this.stop();"
                                         onmouseout="this.start();" scrollamount="3">{{$customer->email}}</marquee>
                            </a></td>
                </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-1.6.min.js"></script>
    <script src="{{ asset('/js/marquee.js') }}"></script>
@endsection
