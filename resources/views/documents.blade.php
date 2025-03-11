@extends('layouts.app-master')

@section('content')
<div id="app">
    <crew-documents-component crew_id="{{$id}}" user_data="{{Auth::user()}}"></crew-documents-component>
</div>
@endsection
