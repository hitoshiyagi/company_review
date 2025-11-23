@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Dashboard</h1>
@stop

@section('content')
<p>Welcome to this beautiful admin panel.</p>
@stop

<div class="container mt-3">
    <h1>ようこそ AdminLTE サンプルサイトへ</h1>
    <p>ここから会社一覧や転職軸の管理ができます。</p>
</div>

@section('css')
{{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
<script>
    console.log('Hi!');
</script>
@stop