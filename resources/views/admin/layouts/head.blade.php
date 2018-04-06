<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Hector Javier Minaya Trinidad">
    <meta name="keyword" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <script src="{{ asset('js/vendor/pace.min.js') }}"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>