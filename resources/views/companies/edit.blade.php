{{-- resources/views/companies/edit.blade.php --}}
@extends('adminlte::page')

@section('title', '会社情報編集')

@section('content_header')
<h1>{{ $company->name }} の編集</h1>
@stop

@section('content')
<div class="container">

    {{-- 成功メッセージ --}}
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- バリデーションエラー --}}
    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('companies.update', $company->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- 会社名 --}}
        <div class="mb-3">
            <label for="name" class="form-label">会社名</label>
            <input type="text" name="name" id="name" class="form-control"
                value="{{ old('name', $company->name) }}" required>
        </div>

        {{-- 会社説明 --}}
        <div class="mb-3">
            <label for="description" class="form-label">説明</label>
            <textarea name="description" id="description" class="form-control">{{ old('description', $company->description) }}</textarea>
        </div>

        {{-- 評価スコア --}}
        <h3>評価スコア</h3>

        @if($criteria->isEmpty())
        <p class="text-muted">評価軸が登録されていません。まず評価軸を作成してください。</p>
        @else
        @foreach($criteria as $criterion)
        <div class="mb-2">
            <label>{{ $criterion->name }} (重み: {{ $criterion->weight }})</label>
            <input type="number"
                name="scores[{{ $criterion->id }}]"
                min="0"
                max="100"
                class="form-control"
                value="{{ old('scores.'.$criterion->id, $evaluations[$criterion->id]->score ?? '') }}">
        </div>
        @endforeach
        @endif

        <button type="submit" class="btn btn-primary mt-3">更新する</button>
        <a href="{{ route('companies.index') }}" class="btn btn-secondary mt-3">戻る</a>
    </form>
</div>
@stop