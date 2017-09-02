@extends('layouts.dashboard')

@section('content')


    <div class="panel-body">
        <div class="row">
            <div class="col-md-6 col-xs-12">
                <div class="card">
                    <div class="card-header" data-background-color="blue">
                        <h4 class="nav-tabs-title">Miesięczne wydatki na leki</h4>
                        @if($cabinetsList->count() > 0 )
                            <div class=" dropdown " id="cabinet-list">
                                <a href="#" class="btn btn-info btn-round dropdown-toggle " id="cabinetsList" data-toggle="dropdown">
                                    <i class="material-icons">local_pharmacy</i> Twoje apteczki
                                    <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu">
                                    @foreach (Auth::user()->cabinets as $cabinet)
                                        <li><a href="/stats/{{$cabinet->id}}">{{$cabinet->cabinet_name}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <div class="card-content" id="priceStat" data-keys="{{$cabinetCost->keys()}}" data-values="{{$cabinetCost->values()}}">

                        <canvas id="myChart" width="200" height="150"></canvas>
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
                    <div class="card-content" id="usageStat" data-keys="{{$drugUsage->keys()}}" data-values="{{$drugUsage->values()}}">
                        <canvas id="myChart2" width="200" height="150"></canvas>
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

//        var jsonData = $.ajax({
//            url: 'stats/'+id,
//            dataType: 'json',
//        }).done(function (results) {
//
//        });
        var keys= $('#priceStat').data('keys');
        var values= $('#priceStat').data('values');

        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: keys,
                datasets: [{
                    label: 'Koszt zakupionych leków',
                    data: values,
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

        var keys2= $('#usageStat').data('keys');
        var values2= $('#usageStat').data('values');

        var ctx2 = document.getElementById("myChart2");
        var myChart2 = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: keys2,
                datasets: [{
                    label: 'Zużycie leków w apteczce',
                    data: values2,
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