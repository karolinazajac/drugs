@extends('layouts.dashboard')

@section('content')


    <div class="panel-body">
        <div class="row">
            <div class="col-md-6 col-xs-12">
                <div class="card">
                    <div class="card-header" data-background-color="blue">
                        <h4 class="nav-tabs-title">Miesięczne wydatki na leki</h4>
                    </div>
                    <div class="card-content">
                        <canvas id="myChart" width="200" height="200"></canvas>
                    </div>
                </div>
                <div class="card-footer">
                </div>
            </div>
            <div class="col-md-6 col-xs-12">
                <div class="card">
                    <div class="card-header" data-background-color="blue">
                        <h4 class="nav-tabs-title">Miesięczne zużycie leków</h4>
                    </div>
                    <div class="card-content">
                        <canvas id="myChart2" width="200" height="200"></canvas>
                    </div>
                </div>
                <div class="card-footer">
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>
    <script>
        var ctx = document.getElementById("myChart");
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["Styczeń", "Luty", "Marzec", "Kwiecień", "Maj", "Czerwiec"],
                datasets: [{
                    label: 'Koszt leków w apteczce',
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });

        var ctx2 = document.getElementById("myChart2");
        var myChart2 = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
                datasets: [{
                    label: 'Zużycie leków w apteczce',
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
    </script>
@endsection