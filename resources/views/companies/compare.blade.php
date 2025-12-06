@extends('adminlte::page')

@section('title', 'チャート表示')

@section('content_header')
<h1>チャート表示</h1>
    @stop
    @section('content')
    <div class="container">


        <div class="row">

            <!-- 左：会社情報 -->
            <div class="col-md-4">
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <h5 class="text-muted mb-1">現職</h5>
                        <h3 class="mb-3">{{ $currentCompany->name }}</h3>

                        <h5 class="text-muted mb-1">比較先</h5>
                        <h3>{{ $company->name }}</h3>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="mb-3">スコア詳細</h5>

                        @foreach($criteria as $criterion)
                        <div class="d-flex justify-content-between border-bottom py-2">
                            <div>{{ $criterion->name }}</div>
                            <div>
                                {{ $currentScores[$loop->index] }}
                                /
                                {{ $targetScores[$loop->index] }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- 右：レーダーチャート -->
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="mb-3">総合比較レーダーチャート</h5>

                        <div style="max-width:500px; margin:0 auto;">
                            <canvas id="myRadarChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <script>
        const labels = @json($criteria->pluck('name'));
        const currentData = @json($currentScores->values());
        const targetData = @json($targetScores->values());
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('myRadarChart');

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
                        min: 0,
                        max: 10,
                        ticks: {
                            stepSize: 2
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>

    @endsection