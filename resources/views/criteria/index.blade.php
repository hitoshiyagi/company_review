{{-- resources/views/criteria/index.blade.php --}}
@extends('adminlte::page')

@section('title', '評価軸一覧')

@section('content_header')
<h1>評価軸一覧</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createCriterionModal">新規登録</button>
    </div>

    {{-- 新規作成モーダル --}}
    <div class="modal fade" id="createCriterionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('criteria.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">評価軸登録</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>名前</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        {{-- 重みは固定なので入力欄は削除 --}}
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
        @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>名前</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach($criteria as $criterion)
                <tr>
                    <td>{{ $criterion->name }}</td>
                    <td>
                        {{-- 編集モーダル --}}
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $criterion->id }}">編集</button>

                        {{-- 削除フォーム --}}
                        <form action="{{ route('criteria.destroy', $criterion) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('削除してもよいですか？')">削除</button>
                        </form>

                        {{-- 編集モーダル --}}
                        <div class="modal fade" id="editModal{{ $criterion->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('criteria.update', $criterion) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title">評価軸編集</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label>名前</label>
                                                <input type="text" name="name" class="form-control" value="{{ $criterion->name }}" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">更新</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        {{-- /編集モーダル --}}
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
<script>
    var createModal = document.getElementById('createCriterionModal');
    createModal.addEventListener('shown.bs.modal', function() {
        document.querySelector('#createCriterionModal input[name="name"]').focus();
    });
</script>
@stop