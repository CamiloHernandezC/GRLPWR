<style>
    canvas {
        width: 100% !important;
        height: 450px !important;
    }
</style>

<div style="width:90%; margin: auto;">
    <canvas id="{{ $id }}"></canvas>
</div>

<script>
    var ctx = document.getElementById('{{ $id }}').getContext('2d');
    var datasets = [
            @foreach($datasets as $dataset)
        {
            label: '{{ $dataset["label"] }}',
            data: {!! json_encode($dataset["data"]) !!},
            backgroundColor: '{{ $dataset["backgroundColor"] }}',
            borderColor: '{{ $dataset["borderColor"] ?? 'rgba(75, 192, 192, 1)' }}',
            borderWidth: {{ $dataset["borderWidth"] ?? 1 }},
            @if(isset($dataset["showLine"]) && $dataset["showLine"] === false)
            showLine: false,
            pointRadius: {{ $dataset["pointRadius"] ?? 5 }},
            pointHoverRadius: {{ $dataset["pointHoverRadius"] ?? 7 }},
            @endif
        },
        @endforeach
    ];

    var myChart = new Chart(ctx, {
        type: '{{ $type }}',
        data: {
            labels: {!! $labels !!},
            datasets: datasets
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        },
        plugins: [{
            id: 'verticalLinesPlugin',
            afterDatasetsDraw(chart) {
                const ctx = chart.ctx;
                ctx.save();
                chart.data.datasets.forEach((dataset, datasetIndex) => {
                    if (dataset.showLine === false) {
                        const meta = chart.getDatasetMeta(datasetIndex);
                        ctx.lineWidth = dataset.borderWidth || 1;
                        ctx.strokeStyle = dataset.borderColor || 'rgba(0,0,0,0.5)';
                        meta.data.forEach((point) => {
                            const yAxis = chart.scales.y;
                            ctx.beginPath();
                            ctx.moveTo(point.x, yAxis.getPixelForValue(0));
                            ctx.lineTo(point.x, point.y);
                            ctx.stroke();
                        });
                    }
                });
                ctx.restore();
            }
        }]
    });
</script>

