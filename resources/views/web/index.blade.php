@extends('web.master')
@section('content')
<link rel="stylesheet" href="{{ secure_asset("css/style.css") }}"><
    <router-view></router-view>    

@endsection