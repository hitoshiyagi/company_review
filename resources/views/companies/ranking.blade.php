<!-- @extends('adminlte::page')

@section('title', '総合スコアランキング')

@section('content_header')
<h1>総合スコア ランキング</h1>
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
<div class="card">
    <div class="card-body">
        <table class="table table-bordered table-striped text-center">
            <thead>
                <tr>
                    <th>順位</th>
                    <th>会社名</th>
                    <th>合計スコア</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ranking as $index => $company)
                <tr>
                    <td>
                        @if($index === 0) 🥇 1位
                        @elseif($index === 1) 🥈 2位
                        @elseif($index === 2) 🥉 3位
                        @else {{ $index + 1 }} 位
                        @endif
                    </td>

                    <td>{{ $company->name }}</td>

                    <td>{{ $company->total_score }}</td>
                    <td>
                        <a href="{{ route('companies.compare', $company->id) }}" class="btn btn-info">
                            比較
                        </a>
                    </td>


                </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>
@stop -->

@extends('adminlte::page')

@section('title', '総合スコアランキング')

@section('content_header')
<div class="d-flex align-items-center justify-content-between">
    <h1 class="font-weight-bold text-dark"><i class="fas fa-trophy text-warning mr-2"></i>総合ランキング</h1>
    <span class="badge badge-pill badge-dark px-3 py-2">全 {{ count($ranking) }} 社比較中</span>
</div>
@stop

@section('css')
<style>
    /* 共通設定（既存のフォント・ボタン設定と統合） */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Sawarabi+Gothic&display=swap');

    body,
    .wrapper {
        font-family: 'Sawarabi Gothic', 'Inter', sans-serif !important;
        background-color: #f4f7f6 !important;
    }

    /* --- TOP 3 カードデザイン --- */
    .podium-container {
        display: flex;
        justify-content: center;
        align-items: flex-end;
        gap: 20px;
        margin-bottom: 40px;
        padding-top: 20px;
    }

    .podium-card {
        background: white;
        border-radius: 20px;
        text-align: center;
        padding: 25px 15px;
        flex: 1;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease;
        position: relative;
        border: 2px solid transparent;
    }

    .podium-card:hover {
        transform: translateY(-5px);
    }

    /* 1位を最大にする */
    .rank-1 {
        order: 2;
        min-height: 280px;
        border-color: #FFD700;
        z-index: 2;
    }

    .rank-2 {
        order: 1;
        min-height: 240px;
        border-color: #C0C0C0;
    }

    .rank-3 {
        order: 3;
        min-height: 220px;
        border-color: #CD7F32;
    }

    .medal-icon {
        font-size: 3rem;
        display: block;
        margin-bottom: 10px;
    }

    .company-name {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 10px;
        color: #334155;
    }

    .score-display {
        font-family: 'Inter', sans-serif;
        font-size: 2.5rem;
        font-weight: 700;
        color: #2CB1BC;
        line-height: 1;
    }

    .score-unit {
        font-size: 0.9rem;
        margin-left: 4px;
    }

    /* --- 4位以下のリストデザイン --- */
    .ranking-list {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
    }

    .ranking-item {
        display: flex;
        align-items: center;
        padding: 15px 25px;
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.2s;
    }

    .ranking-item:hover {
        background: #f8fafc;
    }

    .rank-num {
        width: 40px;
        font-weight: 700;
        font-size: 1.1rem;
        color: #64748b;
    }

    .list-company-name {
        flex: 1;
        font-weight: 600;
        font-size: 1.1rem;
        padding-left: 15px;
    }

    .list-score {
        font-weight: 700;
        font-size: 1.25rem;
        color: #2CB1BC;
        width: 100px;
        text-align: right;
    }

    /* 既存ボタンのカスタマイズ適用 */
    .btn-info {
        background: #607D8B;
        border-radius: 8px;
        margin-left: 20px;
    }
</style>
@stop

@section('content')
<div class="container-fluid">

    @if($ranking->isNotEmpty())
    <div class="podium-container">
        @foreach($ranking->take(3) as $index => $company)
        <div class="podium-card rank-{{ $index + 1 }}">
            <span class="medal-icon">
                @if($index === 0) 🥇 @elseif($index === 1) 🥈 @else 🥉 @endif
            </span>
            <div class="company-name">{{ $company->name }}</div>
            <div class="score-display">
                {{ $company->total_score }}<span class="score-unit">pt</span>
            </div>
            <div class="mt-3">
                <a href="{{ route('companies.show', $company->id) }}" class="btn btn-sm btn-outline-primary">詳細</a>
                <a href="{{ route('companies.compare', $company->id) }}" class="btn btn-sm btn-info">比較</a>
            </div>
        </div>
        @endforeach
    </div>

    <h5 class="font-weight-bold mb-3 px-2">4位以下の企業</h5>
    <div class="ranking-list mb-5">
        @foreach($ranking->slice(3) as $index => $company)
        <div class="ranking-item">
            <div class="rank-num">{{ $index + 4 }}</div>
            <div class="list-company-name">{{ $company->name }}</div>
            <div class="list-score">{{ $company->total_score }}<span class="small ml-1">pt</span></div>
            <a href="{{ route('companies.compare', $company->id) }}" class="btn btn-info btn-sm ml-3">比較</a>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-5">
        <p class="text-muted">企業データがまだありません。まずは企業を登録しましょう。</p>
        <a href="{{ route('companies.index') }}" class="btn btn-primary">企業登録へ</a>
    </div>
    @endif

</div>
@stop