@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Dashboard</h1>
@stop

@section('content')

<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="callout callout-info shadow-sm bg-white">
                <h5 class="font-weight-bold text-info">JobScoreへようこそ！</h5>
                <p>
                    このアプリは、あなたの転職活動を「感覚」ではなく「数値」でサポートするツールです。<br>
                    以下のステップに沿ってデータを入力し、納得のいくキャリア選択を実現しましょう。
                </p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary shadow-sm">
                <div class="card-header border-0">
                    <h3 class="card-title font-weight-bold">
                        <i class="fas fa-map-signs text-primary mr-1"></i> 転職判断への4ステップ
                    </h3>
                </div>
                <div class="card-body">
                    <div class="timeline timeline-inverse">

                        <div class="time-label">
                            <span class="bg-primary px-3">STEP 1</span>
                        </div>
                        <div>
                            <i class="fas fa-balance-scale bg-primary"></i>
                            <div class="timeline-item shadow-sm">
                                <h3 class="timeline-header"><a href="{{ route('criteria.index') }}">転職の「軸」を決める</a></h3>
                                <div class="timeline-body">
                                    まずは「あなたが仕事選びで何を重視するか」を定義します。
                                    年収、勤務地、スキルアップ環境など、項目を作成し、それぞれの<strong>「重要度（重み）」</strong>を入力してください。
                                </div>
                                <div class="timeline-footer">
                                    <a href="{{ route('criteria.index') }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus mr-1"></i> 評価軸を設定する
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="time-label">
                            <span class="bg-secondary px-3">STEP 2</span>
                        </div>
                        <div>
                            <i class="fas fa-building bg-secondary"></i>
                            <div class="timeline-item shadow-sm">
                                <h3 class="timeline-header"><a href="{{ route('companies.index') }}">「現職」を登録する</a></h3>
                                <div class="timeline-body">
                                    比較の基準となるのは、今の職場です。
                                    STEP1で決めた軸に沿って、<strong>現在の仕事に点数</strong>をつけてください。
                                    「何に不満を感じているか」が明確になります。
                                </div>
                                <div class="timeline-footer">
                                    <a href="{{ route('companies.index') }}" class="btn btn-secondary btn-sm">
                                        <i class="fas fa-building mr-1"></i> 現職を登録
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="time-label">
                            <span class="bg-success px-3">STEP 3</span>
                        </div>
                        <div>
                            <i class="fas fa-user-tie bg-success"></i>
                            <div class="timeline-item shadow-sm">
                                <h3 class="timeline-header"><a href="{{ route('companies.index') }}">志望・検討企業を登録する</a></h3>
                                <div class="timeline-body">
                                    面接を受けたり、エージェントから紹介された企業を登録します。
                                    現職と同じ基準でスコアを入力していきましょう。
                                </div>
                                <div class="timeline-footer">
                                    <a href="{{ route('companies.index') }}" class="btn btn-success btn-sm">
                                        <i class="fas fa-plus-circle mr-1"></i> 候補企業を追加
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="time-label">
                            <span class="bg-warning px-3">GOAL!</span>
                        </div>
                        <div>
                            <i class="fas fa-chart-pie bg-warning"></i>
                            <div class="timeline-item shadow-sm">
                                <h3 class="timeline-header"><a href="{{ route('companies.ranking') }}">ランキング・レーダーで比較</a></h3>
                                <div class="timeline-body">
                                    データが揃ったら分析です。
                                    <strong>ランキング</strong>で総合点の高い順を確認し、<strong>レーダーチャート</strong>でバランスを比較します。
                                    直感とデータの両面から、納得のいく1社を見つけましょう。
                                </div>
                                <div class="timeline-footer">
                                    <a href="{{ route('companies.ranking') }}" class="btn btn-warning btn-sm text-dark font-weight-bold">
                                        <i class="fas fa-trophy mr-1"></i> ランキングを見る
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div>
                            <i class="fas fa-flag-checkered bg-gray"></i>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@stop

@section('css')
{{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
<script>
    console.log('Hi!');
</script>
@stop