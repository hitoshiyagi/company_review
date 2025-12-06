@extends('adminlte::page')

@section('title', '会社比較チャート')

@section('content_header')
<h1 class="font-weight-bold">会社比較チャート</h1>
@stop

@section('content')

<div class="container-fluid">
    <div class="row">

        <!-- 左側：会社情報＋スコア詳細 -->
        <div class="col-lg-4">

            <!-- 会社情報カード -->
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">

                    <div class="mb-3">
                        <span class="badge badge-primary mb-1">現職</span>
                        <h4 class="font-weight-bold text-primary">
                            {{ $currentCompany->name }}
                        </h4>
                    </div>

                    <div>
                        <span class="badge badge-success mb-1">比較先</span>
                        <h4 class="font-weight-bold text-success">
                            {{ $company->name }}
                        </h4>
                    </div>

                </div>
            </div>

            <!-- スコア詳細カード -->
            <div class="card shadow-sm">
                <div class="card-body">

                    <h5 class="mb-4 font-weight-bold text-center">
                        スコア詳細
                    </h5>

                    @foreach($criteria as $criterion)

                    @php
                    $current = $currentScores[$loop->index];
                    $target = $targetScores[$loop->index];
                    $diff = $target - $current;
                    @endphp

                    <div class="border-bottom pb-2 mb-3">

                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <strong>{{ $criterion->name }}</strong>

                            @if($diff > 0)
                            <span class="text-success">▲ 有利</span>
                            @elseif($diff < 0)
                                <span class="text-danger">▼ 不利</span>
                                @else
                                <span class="text-secondary">＝ 同等</span>
                                @endif
                        </div>

                        <div class="d-flex justify-content-between small">
                            <span class="text-primary">
                                {{ $currentCompany->name }}：{{ number_format($current, 1) }}
                            </span>

                            <span class="text-success">
                                {{ $company->name }}：{{ number_format($target, 1) }}
                            </span>
                        </div>

                    </div>

                    @endforeach

                </div>
            </div>
        </div>

        <!-- 右側：レーダーチャート -->
        <div class="col-lg-8">

            <div class="card shadow-sm">
                <div class="card-body text-center">

                    <h5 class="font-weight-bold mb-4">
                        総合比較レーダーチャート
                    </h5>

                    <div style="max-width: 550px; margin: 0 auto;">
                        <canvas id="myRadarChart"></canvas>
                    </div>

                </div>
            </div>

            <!-- 総合判定メッセージ -->
            @php
            $currentTotal = $currentScores->sum();
            $targetTotal = $targetScores->sum();
            @endphp

            <div class="card mt-4 shadow-sm">
                <div class="card-body text-center">

                    @if($targetTotal > $currentTotal)
                    <h5 class="text-success font-weight-bold mb-2">
                        比較先の方が総合評価は高い
                    </h5>
                    <p class="mb-0">
                        あなたの評価基準では<br>
                        <strong>{{ $company->name }}</strong> がより魅力的な選択肢です。
                    </p>

                    @elseif($targetTotal < $currentTotal)
                        <h5 class="text-primary font-weight-bold mb-2">
                        現職の方が総合評価は高い
                        </h5>
                        <p class="mb-0">
                            現状では<br>
                            <strong>{{ $currentCompany->name }}</strong> の方があなたに合っています。
                        </p>

                        @else
                        <h5 class="text-secondary font-weight-bold mb-2">
                            両社の評価はほぼ同等
                        </h5>
                        <p class="mb-0">
                            他の要素（勤務地・人間関係など）で決めるのもアリです。
                        </p>
                        @endif

                </div>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('companies.ranking') }}" class="btn btn-secondary">
                    ← ランキングへ戻る
                </a>
            </div>

        </div>

    </div>
</div>

<script>
    const labels = @json($criteria->pluck('name'));
    const currentData = @json($currentScores->values());
    const targetData = @json($targetScores->values());
    const maxScore = {{ $maxScore }};
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('myRadarChart').getContext('2d');

    new Chart(ctx, {
        type: 'radar',
        data: {
            labels: labels,
            datasets: [{
                    label: "{{ $currentCompany->name }}",
                    data: currentData,
                    backgroundColor: 'rgba(0, 123, 255, 0.2)',
                    borderColor: 'rgba(0, 123, 255, 1)',
                    borderWidth: 2,
                    pointBackgroundColor: 'rgba(0, 123, 255, 1)',
                },
                {
                    label: "{{ $company->name }}",
                    data: targetData,
                    backgroundColor: 'rgba(40, 167, 69, 0.2)',
                    borderColor: 'rgba(40, 167, 69, 1)',
                    borderWidth: 2,
                    pointBackgroundColor: 'rgba(40, 167, 69, 1)',
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                r: {
                    beginAtZero: true,
                    min: 0,
                    max: maxScore,
                    ticks: {
                        stepSize: maxScore / 5
                    },
                    pointLabels: {
                        font: {
                            size: 14
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: {
                            size: 14
                        }
                    }
                }
            }
        }
    });
</script>

@endsection