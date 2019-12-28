<?
$color = [
    1 => 'primary',
    2 => 'secondary',
    3 => 'success',
    4 => 'danger',
    5 => 'warning',
    6 => 'info',
    7 => 'light',
    8 => 'dark ',
];
$cnt = 1;
?>
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

    <div class="row">
        <div class="col-lg-6">
            <div class="card-header" >
                <h3>Active</h3>
            </div>
            <table class="table table-striped   table-hover table-bordered" style="box-shadow: -15px 1px 31px 4px rgba(62,68,72,0.61)">
                <thead class="table-active">
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Company name</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    @foreach($activeCustomers as $customer)

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
                                         onmouseout="this.start();"
                                         scrollamount="3">{{$customer->company->name}}</marquee>
                            </a></td>
                </tr>
                @endforeach

                </tbody>
            </table>
        </div>
        <div class="col-lg-6" >
            <div class="card-header" >
                <h3>Inactive</h3>
            </div>
            <table class="table table-striped  table-danger table-hover table-bordered" style="box-shadow: 19px 1px 36px -4px rgba(255,47,153,0.61)">
                <thead class="thead-dark">
                <tr>

                    <th scope="col">Name</th>
                    <th scope="col">Company name</th>
                </tr>
                </thead>
                <tbody>
                @foreach($inactiveCustomers as $customer)
                    <tr>

                        <td class="labelContainer" style="color: black">
                            <div class="boardindex_themefitted_board_main">
                                <div class="boardindex_themefitted_board_main_description scroll_on_hover ellipsis">
                                    {{$customer->name}}
                                </div>
                            </div>
                        </td>
                        <td><a style="color: #636b6f" href="#">
                                <marquee behavior="alternate" direction="left"
                                         onmouseover="this.stop();"
                                         onmouseout="this.start();"
                                         scrollamount="3">{{$customer->company->name}}</marquee>
                            </a></td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>
    <br><br>

    @foreach($companies as $company)
        @if($cnt>8)
            {{$cnt==1}}
        @endif
        <table class="table table-striped table-{{$color[$cnt]}}  table-hover table-bordered"
               style="box-shadow: 27px 16px 34px 15px rgba(0,0,0,0.61)">
            <thead class="table-dark">
            <tr>
                <div class="card-header" style="box-shadow: 5px 28px 67px 11px rgba(0,0,0,0.61);">
                    <h3>{{$company->name}}</h3>
                </div>
            </tr>

            <tr>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
            </tr>
            </thead>
            <tbody>
            @foreach($company->customers as $customer)
                <tr>
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
        <br>
        <br>
        <?php $cnt++?>
    @endforeach


    <script src="{{ asset('/js/jquery-1.6.min.js') }}"></script>
    <script src="{{ asset('/js/marquee.js') }}"></script>
@endsection
