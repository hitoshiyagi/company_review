@extends('adminlte::page')

@section('title', '総合スコアランキング')

@section('content_header')
<h1>総合スコア ランキング</h1>
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