@extends('layouts.dashboard')

@section('content')

    <div class="col-md-6">
        <div class="card">
            <div class="card-header" data-background-color="blue">
                <h4 class="nav-tabs-title">Leki po terminie ważności</h4>
            </div>
            <div class="card-content">
                <table class="table table-hover">

                    <tbody>
                    @foreach($pastDateDrugs as $drug)
                        <tr><th>{{$drug->name}}</th></tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <div class="stats">

                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header" data-background-color="blue">
                <h4 class="nav-tabs-title">Leki które należy uzupełnić</h4>
            </div>
            <div class="card-content">
                <table class="table table-hover">
                    <tbody>
                    @foreach($finishedDrugs as $drug)
                        <tr><th>{{$drug->name}}</th></tr>
                    @endforeach
                    </tbody>
                </table>



            </div>
            <div class="card-footer">
                <div class="stats">

                </div>
            </div>
        </div>
    </div>

@endsection
