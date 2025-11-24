@extends('adminlte::page')

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
                        @if($index === 0)
                        🥇 1位
                        @elseif($index === 1)
                        🥈 2位
                        @elseif($index === 2)
                        🥉 3位
                        @else
                        {{ $index + 1 }} 位
                        @endif
                    </td>
                    <td>{{ $company->name }}</td>
                    <td>{{ $company->total_score }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop