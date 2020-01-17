@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        Letters Sent by Day
                        <span class="float-right">
                            <input
                                id="days"
                                name="days"
                                type="number"
                                value="{{ $days }}"
                                style="width: 4em"
                                onchange="document.getElementById('days-apply').style.visibility = 'visible'"
                            > days
                            <button id="days-apply"
                                    class="btn btn-outline-primary"
                                    style="visibility: hidden"
                                    onclick="window.location.search = ('?days=' + document.getElementById('days').value)"
                            >Apply</button>
                        </span>
                    </div>
                    <div class="card-body">
                        <canvas id="per-day-canvas"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css" integrity="sha256-aa0xaJgmK/X74WM224KMQeNQC2xYKwlAt08oZqjeF0E=" crossorigin="anonymous"/>
@endpush

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js" integrity="sha256-4iQZ6BVL4qNKlQ27TExEhBN1HFPvAvAMbFavKKosSWQ=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI=" crossorigin="anonymous"></script>
@endpush

@push('script')
    <script>
        document.getElementById('app').removeAttribute('id'); // disable vue.js

        var ctx = document.getElementById('per-day-canvas').getContext("2d");

        function buildPerDay(data) {
            let output = {
                labels: [],
                datasets: [{
                    data: [],
                    label: "Letters Sent",
                    borderColor: "#cd1917",
                    fill: false
                }, {
                    data: [],
                    label: "New Penpals",
                    borderColor: "#3321cd",
                    fill: false
                }
                ]
            };
            for (var i = 0; i < data.length; i++) {
                output.labels.push(data[i].day);
                output.datasets[0].data.push(data[i].sent);
                output.datasets[1].data.push(data[i].penpals);
            }

            return output;
        }


        var perDayChart = new Chart(ctx, {
            type: 'line',
            data: buildPerDay(JSON.parse('{!! $perDay !!}')),
            options: {
                scales: {
                    xAxes: [{
                        type: 'time',
                        distribution: 'series',
                        time: {
                            unit: 'day'
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
@endpush
