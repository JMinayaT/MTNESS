@extends('admin.layouts.main') 
    @section('page-title')
    <i class="fas fa-users"></i> test
   
    @endsection 
    @section('page-breadcrumb')
        <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i> test</a></li>
        <li class="breadcrumb-item active" aria-current="page">test </li>
    @endsection

    @section('content')
        <h1>test</h1>

    @endsection
