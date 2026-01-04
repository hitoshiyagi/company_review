<!-- @extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Dashboard</h1>
@stop

@section('content')
<p>Welcome to this beautiful admin panel.</p>
@stop

@section('css')
{{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
<script>
    console.log('Hi!');
</script>
@stop -->
@extends('adminlte::page')

@section('title', 'ダッシュボード')

@section('content_header')
<h1 class="font-weight-bold">JobScoreへようこそ！</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info shadow-sm">
                <div class="inner">
                    <h3>{{ auth()->user()->criteria->count() }}</h3>
                    <p>設定済みの評価軸</p>
                </div>
                <div class="icon"><i class="fas fa-tasks"></i></div>
                <a href="{{ route('criteria.index') }}" class="small-box-footer">
                    管理画面へ <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success shadow-sm">
                <div class="inner">
                    <h3>{{ auth()->user()->companies->count() }}</h3>
                    <p>登録済みの企業数</p>
                </div>
                <div class="icon"><i class="fas fa-building"></i></div>
                <a href="{{ route('companies.index') }}" class="small-box-footer">
                    一覧画面へ <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card card-outline card-primary shadow-sm">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold">
                        <i class="fas fa-map-signs mr-1 text-primary"></i> 転職成功への3ステップ
                    </h3>
                </div>
                <div class="card-body">
                    <div class="timeline timeline-inverse">
                        <div class="time-label">
                            <span class="bg-primary px-3">STEP 1</span>
                        </div>
                        <div>
                            <i class="fas fa-list bg-primary"></i>
                            <div class="timeline-item shadow-none border">
                                <h3 class="timeline-header font-weight-bold text-primary">自分の「評価軸」を決める</h3>
                                <div class="timeline-body">
                                    年収、残業、やりがい…あなたが転職で譲れない条件を登録しましょう。
                                    それぞれの重要度（重み）を設定するのが、納得のいく比較への近道です。
                                </div>
                                <div class="timeline-footer">
                                    <a href="{{ route('criteria.index') }}" class="btn btn-primary btn-sm">評価軸を設定する</a>
                                </div>
                            </div>
                        </div>

                        <div class="time-label">
                            <span class="bg-success px-3">STEP 2</span>
                        </div>
                        <div>
                            <i class="fas fa-home bg-success"></i>
                            <div class="timeline-item shadow-none border">
                                <h3 class="timeline-header font-weight-bold text-success">「現職」のスコアを付ける</h3>
                                <div class="timeline-body">
                                    比較の基準を作るために、まずは今の仕事に点数を付けます。
                                    「今の不満はどこにあるのか？」を可視化することで、次の会社に求めるものが明確になります。
                                </div>
                                <div class="timeline-footer">
                                    <a href="{{ route('companies.index') }}" class="btn btn-success btn-sm">会社一覧・登録へ</a>
                                </div>
                            </div>
                        </div>

                        <div class="time-label">
                            <span class="bg-warning px-3">STEP 3</span>
                        </div>
                        <div>
                            <i class="fas fa-chart-line bg-warning"></i>
                            <div class="timeline-item shadow-none border">
                                <h3 class="timeline-header font-weight-bold text-warning">志望企業を登録して比較する</h3>
                                <div class="timeline-body">
                                    気になる企業を登録し、現職との「比較チャート」を見てみましょう。
                                    直感的な「なんとなく良さそう」を、客観的なスコアに変えて冷静に判断できます。
                                </div>
                                <div class="timeline-footer">
                                    <a href="{{ route('companies.index') }}" class="btn btn-warning btn-sm text-white">企業を追加する</a>
                                </div>
                            </div>
                        </div>

                        <div>
                            <i class="fas fa-check bg-gray"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-dark shadow-sm">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold">クイックガイド</h3>
                </div>
                <div class="card-body">
                    <p class="text-muted">
                        JobScoreは、あなたの価値観を数値化するためのツールです。
                        面接を終えるたびにスコアを更新することで、より精度の高い比較が可能になります。
                    </p>
                    <hr>
                    <div class="text-center">
                        <p class="small text-secondary mb-3">準備ができたらランキングをチェック！</p>
                        <a href="{{ route('companies.ranking') }}" class="btn btn-outline-dark btn-block">
                            <i class="fas fa-trophy mr-1"></i> ランキングを確認
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    /* タイムラインの背景色と余白の微調整 */
    .timeline-item {
        background-color: #fcfdfe !important;
        border-radius: 8px !important;
    }

    .timeline-header {
        border-bottom: none !important;
        font-size: 1.1rem !important;
        padding-top: 15px !important;
    }

    .timeline:before {
        border-radius: 0.25rem;
        background-color: #e9ecef !important;
        bottom: 0;
        content: "";
        left: 31px;
        margin: 0;
        position: absolute;
        top: 0;
        width: 4px;
    }
</style>
@stop

@section('js')
<script>
    console.log('Dashboard Loaded');
</script>
@stop