{{-- resources/views/companies/index.blade.php --}}
@extends('adminlte::page')

@section('title', '会社一覧')

@section('content_header')
<h1>会社一覧</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <!-- モーダルを開くボタン -->
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createCompanyModal">
            新規会社登録
        </button>
    </div>

    <!-- モーダル -->
    <div class="modal fade" id="createCompanyModal" tabindex="-1" aria-labelledby="createCompanyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('companies.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createCompanyModalLabel">会社新規登録</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
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

                        <div class="mb-3">
                            <label for="name" class="form-label">会社名</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">説明</label>
                            <textarea name="description" id="description" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">登録</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- 会社一覧テーブル -->
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
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
                    <td>{{ $company->id }}</td>
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
                @if($companies->isEmpty())
                <tr>
                    <td colspan="5" class="text-center">登録されている会社はありません</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    var createModal = document.getElementById('createCompanyModal');
    createModal.addEventListener('shown.bs.modal', function() {
        document.getElementById('name').focus();
    });
</script>
@stop