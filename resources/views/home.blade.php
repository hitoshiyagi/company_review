@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
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
<style>
    /* --- 1. 全体のベース設定（フォント・背景） --- */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Sawarabi+Gothic&display=swap');

    body,
    .wrapper,
    .content-wrapper {
        font-family: 'Sawarabi Gothic', 'Inter', sans-serif !important;
        background-color: #f8fafc !important;
        /* 少し青みのある明るいグレー */
        color: #1e293b;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    .card-title,
    .timeline-header {
        font-family: 'Inter', 'Sawarabi Gothic', sans-serif !important;
        font-weight: 700 !important;
    }

    /* --- 2. タイムラインのデザイン --- */
    .timeline::before {
        border-radius: 0.25rem;
        background-color: #dee2e6 !important;
        width: 4px !important;
        left: 31px !important;
    }

    .timeline-item {
        border: none !important;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.05) !important;
        border-radius: 12px !important;
        transition: all 0.3s ease;
        margin-bottom: 20px !important;
        background: #fff !important;
    }

    /* マウスホバーで浮き上がる演出 */
    .timeline-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.08) !important;
    }

    .timeline-header {
        border-bottom: 1px solid #f1f5f9 !important;
        padding: 15px !important;
        font-size: 1.1rem !important;
        color: #334155 !important;
    }

    .timeline-header a {
        color: inherit !important;
        text-decoration: none;
    }

    .timeline-body {
        padding: 15px !important;
        color: #64748b !important;
        line-height: 1.7;
    }

    /* ステップラベル (STEP 1等) */
    .time-label span {
        border-radius: 20px !important;
        padding: 6px 20px !important;
        font-weight: 700 !important;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .timeline-footer {
        padding: 12px 15px !important;
        background-color: #fcfdfe !important;
        border-radius: 0 0 12px 12px !important;
        border-top: 1px solid #f1f5f9;
    }

    /* --- 3. 統一されたボタンデザイン --- */
    .btn {
        border: none;
        border-radius: 8px !important;
        font-weight: 600 !important;
        transition: all 0.25s ease;
    }

    .btn-sm {
        padding: 6px 16px !important;
    }

    /* 各種ボタンカラー */
    .btn-primary {
        background-color: #2CB1BC !important;
        color: #fff;
    }

    /* ティール */
    .btn-success {
        background-color: #4A90E2 !important;
        color: #fff;
    }

    /* ブルー */
    .btn-warning {
        background-color: #FF9800 !important;
        color: #fff;
    }

    /* オレンジ */
    .btn-info {
        background-color: #607D8B !important;
        color: #fff;
    }

    /* グレー */
    .btn-dark {
        background-color: #1e293b !important;
        color: #fff;
    }

    .btn:hover {
        transform: translateY(-1px);
        filter: brightness(0.9);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15) !important;
    }

    /* コールアウト（ウェルカムメッセージ）の調整 */
    .callout {
        border-radius: 12px !important;
        border-left-width: 5px !important;
        background-color: #fff !important;
    }
</style>
@stop

@section('js')
<script>
    console.log('Hi!');
</script>
@stop