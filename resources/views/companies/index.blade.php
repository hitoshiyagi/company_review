{{-- resources/views/companies/index.blade.php --}}
@extends('adminlte::page')

@section('title', '会社一覧')

@section('content_header')
<h1>会社一覧</h1>
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
    <div class="card-header">
        <!-- モーダル呼び出しボタン -->
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createCompanyModal">
            新規会社登録
        </button>
    </div>

    <!-- 新規会社登録モーダル -->
    <div class="modal fade" id="createCompanyModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('companies.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">会社新規登録</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>会社名</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>説明</label>
                            <textarea name="description" class="form-control"></textarea>
                        </div>

                        <h5>評価スコア（各10点満点）</h5>
                        @if($criteria->isEmpty())
                        <p class="text-muted">評価軸が登録されていません。まず評価軸を作成してください。</p>
                        @else
                        @foreach($criteria->take(5) as $criterion) {{-- 最大5項目 --}}
                        <div class="mb-2">
                            <label>{{ $criterion->name }}</label>
                            <input type="number"
                                name="scores[{{ $criterion->id }}]"
                                min="0"
                                max="10"
                                class="form-control"
                                value="0">
                        </div>
                        @endforeach
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">登録</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="card-body">
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-striped table-hover m-0">
            <thead>
                <tr>
                    <th>会社名</th>
                    <th>説明</th>
                    <th>合計点数</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach($companies as $company)
                @php
                $totalScore = $company->evaluations->sum('score');
                @endphp
                <tr>
                    <td>{{ $company->name }}</td>
                    <td>{{ $company->description }}</td>
                    <td>{{ $totalScore }}</td>
                    <td>
                        <a href="{{ route('companies.show', $company) }}" class="btn btn-info btn-sm">詳細</a>
                        <a href="{{ route('companies.edit', $company) }}" class="btn btn-warning btn-sm">編集</a>
                        <form action="{{ route('companies.destroy', $company) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('削除してもよいですか？')">削除</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stop