@extends('layouts.index')

@section('content')

@include("frond.header")

@include("frond.category", ['assets' => $assets, 'categories' => $categories])

@include("frond.alur")

@include("frond.asset", ['assets' => $assets])

@endsection