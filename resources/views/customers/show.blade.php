@extends('layout')
@section('title')
    {{$customer->name}}
@endsection


@section('content')
    <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>

    <a href="/customers" style="border-right: 1px dashed;border-bottom: 1px dashed">
        <ion-icon size="large" src="{{asset('/images/icons/ios-undo.svg')}}"></ion-icon>
    </a>
    <div class="row">
        <div class="col-11">
            <h1>{{$customer->name}}</h1>
            <ul>
                <li>{{$customer->email}}</li>
                <li><b>{{$customer->company->name}}</b></li>
                <li>{{$customer->status}}</li>
            </ul>
        </div>
        <div class="col-1"><br>
            <a href="/customers/{{$customer->id}}/edit" style="border-right: 1px solid;border-bottom: 1px dashed">
                <ion-icon size="large" src="{{asset('/images/icons/ios-build.svg')}}"></ion-icon>
            </a>
            <a href="#" onclick="myFunction()" style="border-right: 1px solid;border-bottom: 1px dashed;">
                <ion-icon size="large" src="{{asset('/images/icons/ios-trash.svg')}}"></ion-icon>
            </a>
        </div>
    </div>

    <form action="" method="post" id="delete">
        @method('delete')
        @csrf
        <button id="send" type="submit" hidden></button>
    </form>
    <script>
        function myFunction() {
            var txt;
            if (confirm("Press a button!")) {
                $('#delete').submit();
            }
        }
    </script>
@endsection
