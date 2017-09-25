@extends('layouts.dashboard')

@section('content')

    <div class="col-md-12">
        <div class="card">
            <div class="card-header" data-background-color="purple">
                <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                       {{$note->title}}
                    </div>
                </div>
            </div>

            <div class="card-content">
                <div class="tab-content">
                    <div class="tab-pane active" id="notes">
                        <div class="panel-body">

                            <p id="body">
{{$note->body}}
                            </p>
                            <img src="{{ asset('storage/' . $note->images->first()->path) }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

