{{-- resources/views/companies/index.blade.php --}}
@extends('adminlte::page')

@section('title', '会社一覧')

@section('content_header')
<h1>会社一覧</h1>
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

        <table class="table table-bordered table-striped">
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