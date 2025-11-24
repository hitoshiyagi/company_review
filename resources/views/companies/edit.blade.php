{{-- resources/views/companies/edit.blade.php --}}
@extends('adminlte::page')

@section('title', '会社情報編集')

@section('content_header')
<h1>{{ $company->name }} の編集</h1>
@stop
@section('css')
<style>
    /* --- 0. 全体のベース設定 --- */
    /* Noto Sans JP を Sawarabi Gothic + Inter に変更 */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Sawarabi+Gothic&display=swap');

    :root {
        /* ... (その他の変数は維持) ... */
    }

    body,
    .wrapper {
        /* 日本語フォントを優先し、欧文（数字や英語）をInterに設定 */
        font-family: 'Sawarabi Gothic', 'Inter', sans-serif !important;
        background-color: var(--bg-light) !important;
        color: var(--text-dark);
        /* 本文のフォントサイズを微調整して可読性アップ */
        font-size: 0.9375rem;
    }

    /* 見出しの太さを強化 */
    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    .card-title {
        font-family: 'Inter', 'Sawarabi Gothic', sans-serif !important;
        font-weight: 700 !important;
    }

    /* --------------------
    ボタンデザイン（落ち着いたトーン）
-------------------- */
    .btn {
        border: none;
        border-radius: 10px;
        padding: 0.5rem 1rem;
        font-weight: 600;
        transition: all 0.25s ease;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.08);
    }

    /* プライマリ（メインCTA/応募・登録など - アクセントカラーを使用） */
    .btn-primary {
        background: #2CB1BC;
        /* アクセントカラーのティール */
        color: #fff;
        box-shadow: 0 4px 8px rgba(44, 177, 188, 0.4);
        /* ティールに合わせた影 */
    }

    .btn-primary:hover {
        background: #1f8b94;
        transform: translateY(-2px);
    }

    /* 成功（アクションが成功した後の確認 - 落ち着いたブルー） */
    .btn-success {
        background: #4A90E2;
        /* 落ち着いたブルー */
        color: #fff;
    }

    .btn-success:hover {
        background: #357ab8;
        transform: translateY(-2px);
    }

    /* 情報（詳細を見る、中立的なアクション - グレー系） */
    .btn-info {
        background: #607D8B;
        /* セカンダリカラーの落ち着いたグレー */
        color: #fff;
    }

    .btn-info:hover {
        background: #455A64;
        transform: translateY(-2px);
    }

    /* 警告（重要なお知らせ、確認 - オレンジ） */
    .btn-warning {
        background: #FF9800;
        /* 明瞭なオレンジ */
        color: #fff;
    }

    .btn-warning:hover {
        background: #e68900;
        transform: translateY(-2px);
    }

    /* 危険（削除、離脱 - レッド） */
    .btn-danger {
        background: #C62828;
        /* 深みのあるレッド */
        color: #fff;
    }

    .btn-danger:hover {
        background: #9a1f1f;
        transform: translateY(-2px);
    }

    /* アウトラインボタン（ログインなど、プライマリより控えめなアクションに） */
    .btn-outline-primary {
        background: transparent;
        border: 2px solid #2CB1BC;
        color: #2CB1BC;
        box-shadow: none;
    }

    .btn-outline-primary:hover {
        background: #2CB1BC;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 3px 6px rgba(44, 177, 188, 0.3);
    }
</style>
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
        <p>各項目１０点満点で評価する</p>
        @if($criteria->isEmpty())
        <p class="text-muted">評価軸が登録されていません。まず評価軸を作成してください。</p>
        @else
        @foreach($criteria as $criterion)
        <div class="mb-2">
            <label>{{ $criterion->name }}</label>
            <input type="number"
                name="scores[{{ $criterion->id }}]"
                min="0"
                max="10"
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