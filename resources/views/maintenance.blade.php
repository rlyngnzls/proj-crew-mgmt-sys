@extends('layouts.app-master')

@section('content')
<div id="app">
    <data-setup-component user_data="{{Auth::user()}}"></data-setup-component>
</div>
@endsection
