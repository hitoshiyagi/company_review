@extends('adminlte::page')

@section('title', '会社詳細')

@section('content_header')
<h1>会社詳細</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $company->name }}</h3>
    </div>
    <div class="card-body">
        <p><strong>ID:</strong> {{ $company->id }}</p>
        <p><strong>会社名:</strong> {{ $company->name }}</p>
        <p><strong>説明:</strong> {{ $company->description }}</p>
        <p><strong>作成日:</strong> {{ $company->created_at }}</p>
        <p><strong>更新日:</strong> {{ $company->updated_at }}</p>

        <hr>
        <h4>評価スコア</h4>
        @if($criteria->isEmpty())
        <p>評価軸が登録されていません。</p>
        @else
        <ul>
            @foreach($criteria as $criterion)
            <li>{{ $criterion->name }}: {{ $evaluations[$criterion->id]->score ?? '未評価' }}/10</li>
            @endforeach
        </ul>
        <p><strong>合計点数:</strong> {{ $evaluations->sum('score') ?? 0 }}/{{ $criteria->count() * 10 }}</p>
        @endif
    </div>
    <div class="card-footer">
        <a href="{{ route('companies.edit', $company) }}" class="btn btn-warning">編集</a>
        <a href="{{ route('companies.index') }}" class="btn btn-secondary">一覧に戻る</a>
    </div>
</div>
@stop