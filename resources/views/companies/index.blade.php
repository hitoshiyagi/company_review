{{-- resources/views/companies/index.blade.php --}}
@extends('adminlte::page')

@section('title', '会社一覧')

@section('content_header')
<h1 class="font-weight-bold">会社一覧</h1>
@stop

@section('css')
<style>
    /* --- 全体のベース設定 --- */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Sawarabi+Gothic&display=swap');

    body,
    .wrapper {
        font-family: 'Sawarabi Gothic', 'Inter', sans-serif !important;
        background-color: #f0f4f8 !important;
        color: #102a43;
        font-size: 0.9375rem;
    }

    h1,
    .card-title {
        font-weight: 700 !important;
    }

    /* --- テーブルのレイアウト調整 --- */
    .table-container {
        background: white;
        border-radius: 12px;
        overflow: hidden;
    }

    .table {
        table-layout: fixed;
        /* 列幅を固定 */
        width: 100%;
        margin-bottom: 0 !important;
    }

    /* 列ごとの幅指定 */
    .col-name {
        width: 200px;
    }

    .col-desc {
        width: auto;
    }

    .col-type {
        width: 150px;
    }

    .col-score {
        width: 100px;
    }

    .col-action {
        width: 200px;
    }

    .table th {
        background-color: #f8fafc;
        border-bottom: 2px solid #e2e8f0 !important;
        color: #486581;
        font-weight: 700;
        text-align: center;
    }

    .table td {
        vertical-align: middle !important;
        padding: 12px 15px !important;
    }

    /* 長いテキストを「...」で省略 */
    .text-truncate {
        display: block;
        width: 100%;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* 操作ボタン列の固定 */
    .action-column {
        white-space: nowrap !important;
        text-align: center;
    }

    /* --- ボタンデザイン --- */
    .btn {
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.2s;
    }

    .btn-sm {
        padding: 5px 12px;
        font-size: 0.85rem;
    }

    .btn-primary {
        background: #2CB1BC;
        border: none;
    }

    .btn-success {
        background: #4A90E2;
        border: none;
    }

    .btn-info {
        background: #607D8B;
        border: none;
    }

    .btn-warning {
        background: #FF9800;
        border: none;
        color: white !important;
    }

    .btn-danger {
        background: #C62828;
        border: none;
    }

    .btn:hover {
        transform: translateY(-1px);
        filter: brightness(0.9);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
</style>
@stop

@section('content')
<div class="card shadow-sm table-container">
    <div class="card-header bg-white">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createCompanyModal">
            <i class="fas fa-plus-circle mr-1"></i> 新規会社登録
        </button>
    </div>

    <div class="modal fade" id="createCompanyModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('companies.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-bold">会社新規登録</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">会社名</label>
                            <input type="text" name="name" class="form-control" placeholder="例：株式会社キャリアアップ" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">説明</label>
                            <textarea name="description" class="form-control" rows="2" placeholder="メモなど"></textarea>
                        </div>
                        <div class="form-group mb-4">
                            <label class="font-weight-bold">状況</label>
                            <select name="type" class="form-control">
                                <option value="interest">見学／気になる企業</option>
                                <option value="desired">志望企業</option>
                                <option value="current">現職</option>
                            </select>
                        </div>

                        <h5 class="font-weight-bold border-bottom pb-2">評価スコア（10点満点）</h5>
                        @if($criteria->isEmpty())
                        <p class="text-muted small">評価軸がありません。設定から作成してください。</p>
                        @else
                        @foreach($criteria->take(5) as $criterion)
                        <div class="form-group d-flex align-items-center mb-2">
                            <label class="mb-0 flex-grow-1">{{ $criterion->name }}</label>
                            <input type="number" name="scores[{{ $criterion->id }}]" min="0" max="10" class="form-control col-3" value="0">
                        </div>
                        @endforeach
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                        <button type="submit" class="btn btn-primary">登録する</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card-body p-0">
        @if(session('success'))
        <div class="alert alert-success m-3">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="col-name text-left">会社名</th>
                        <th class="col-desc text-left">説明</th>
                        <th class="col-type">状況</th>
                        <th class="col-score">スコア</th>
                        <th class="col-action">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($companies as $company)
                    <tr>
                        <td class="text-left">
                            <span class="text-truncate font-weight-bold" title="{{ $company->name }}">
                                {{ $company->name }}
                            </span>
                        </td>
                        <td class="text-left">
                            <span class="text-truncate text-muted" title="{{ $company->description }}">
                                {{ $company->description ?: '---' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-pill badge-light border px-3 py-2">
                                {{ $company->type_label }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="h5 mb-0 font-weight-bold text-primary">{{ $company->total_score }}</span>
                        </td>
                        <td class="action-column">
                            <a href="{{ route('companies.show', $company) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('companies.edit', $company) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('companies.destroy', $company) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('削除してもよいですか？')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stop