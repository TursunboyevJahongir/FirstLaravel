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
<script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>


@section('content')
    <div class="row">
        <div class="col-11"><h1>Customers List</h1></div>
        <div class="col-1"><a href="/customers/create" id="addCustomer" class="badge badge-primary Shadow"
                              title="Add Customer">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path fill="none" d="M0 0h24v24H0V0z"/>
                    <path
                        d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0-6c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2zm0 8c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4zm-6 4c.22-.72 3.31-2 6-2 2.7 0 5.8 1.29 6 2H9zm-3-3v-3h3v-2H6V7H4v3H1v2h3v3z"/>
                </svg>
            </a></div>
    </div>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
        Launch demo modal
    </button>



    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
            <div class="col-lg-6" id="pjax-container">
            <div class="card-header Shadow">
                <h3>Active</h3>
            </div>
            <table class="table table-striped table-hover table-bordered"
                   style="box-shadow: -15px 1px 31px 4px rgba(62,68,72,0.61)">
                <thead class="table-active  ">
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Company name</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    @foreach($activeCustomers as $customer)

                        <td class="labelContainer " style="color: black">
                            <div class="boardindex_themefitted_board_main">
                                <div class=" boardindex_themefitted_board_main_description scroll_on_hover ellipsis">
                                    <a href="/customers/{{$customer->id}}">{{$customer->name}}</a>
                                </div>
                            </div>
                        </td>
                        <td><a style="color: #636b6f" href="#{{$customer->company->id}}">
                                <marquee behavior="alternate" direction="left"
                                         onmouseover="this.stop();"
                                         onmouseout="this.start();"
                                         scrollamount="3">{{$customer->company->name}}</marquee>
                            </a></td>
                        <td style="width: 25%">
                            <form action="/customers/{{$customer->id}}" method="post">
                                <a href="/customers/{{$customer->id}}"
                                   style="border-right: 1px solid;border-bottom: 1px dashed">
                                    <ion-icon size="small" src="{{asset('/images/icons/ios-eye.svg')}}"></ion-icon>
                                </a>
                                <a href="/customers/{{$customer->id}}/edit"
                                   style="border-right: 1px solid;border-bottom: 1px dashed">
                                    <ion-icon size="small" src="{{asset('/images/icons/ios-build.svg')}}"></ion-icon>
                                </a>

                                @method('delete')
                                @csrf
                                <button type="submit" class="btn btn-danger">
                                    <ion-icon size="small" src="{{asset('/images/icons/ios-trash.svg')}}"></ion-icon>
                                </button>
                            </form>
                        </td>
                </tr>
                @endforeach
                </tbody>
            </table>

        </div>
        <div class="col-lg-6">
            <div class="card-header Shadow">
                <h3>Inactive</h3>
            </div>
            <table class="table table-striped  table-danger table-hover table-bordered"
                   style="box-shadow: 19px 1px 36px 4px rgba(255,47,153,0.61)">
                <thead class="thead-dark">
                <tr>

                    <th scope="col">Name</th>
                    <th scope="col">Company name</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($inactiveCustomers as $customer)
                    <tr>
                        <td class="labelContainer" style="color: black">
                            <div class="boardindex_themefitted_board_main">
                                <div class="boardindex_themefitted_board_main_description scroll_on_hover ellipsis">
                                    <a href="/customers/{{$customer->id}}">{{$customer->name}}</a>
                                </div>
                            </div>
                        </td>
                        <td><a style="color: #636b6f" href="#{{$customer->company->id}}">
                                <marquee behavior="alternate" direction="left"
                                         onmouseover="this.stop();"
                                         onmouseout="this.start();"
                                         scrollamount="3">{{$customer->company->name}}</marquee>
                            </a></td>
                        <td>
                            <a href="/customers/{{$customer->id}}"
                               style="border-right: 1px solid;border-bottom: 1px dashed">
                                <ion-icon size="small" src="{{asset('/images/icons/ios-eye.svg')}}"></ion-icon>
                            </a>
                            <a href="/customers/{{$customer->id}}/edit"
                               style="border-right: 1px solid;border-bottom: 1px dashed">
                                <ion-icon size="small" src="{{asset('/images/icons/ios-build.svg')}}"></ion-icon>
                            </a>
                            <a href="#" onclick="myFunction()"
                               style="border-right: 1px solid;border-bottom: 1px dashed">
                                <ion-icon size="small" src="{{asset('/images/icons/ios-trash.svg')}}"></ion-icon>
                            </a>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
{{--            {{$inactiveCustomers->links()}}--}}
        </div>
    </div>

    <br><br>

    @foreach($companies as $company)
        @if($cnt>8)
            {{$cnt==1}}
        @endif


        <table id="{{$company->id}}" class="table table-striped table-{{$color[$cnt]}}  table-hover table-bordered"
               style="box-shadow: 27px 16px 34px 15px rgba(0,0,0,0.61)">
            <thead class="table-dark">
            <tr>
                <div class="card-header Shadow" style="box-shadow: 5px 28px 67px 11px rgba(0,0,0,0.61);">
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

    <form action="" method="post" id="delete">
        @method('delete')
        @csrf
        <button type="submit" hidden></button>
    </form>
    <script>
        function myFunction() {

            if (confirm("Ishinchingiz komilmi ?!")) {
                $('#delete').submit();
            }
        }
    </script>

    <script src="{{ asset('/js/jquery-1.6.min.js') }}"></script>
    <script src="{{ asset('/js/marquee.js') }}"></script>
@endsection
