@extends('layouts.admin')

@section('content')

    <div class="col-md-12">
        <div class="card">
            <div class="card-header" data-background-color="purple">
                <h4 class="nav-tabs-title">Apteczki użytkowników</h4>
            </div>
            <div class="card-content">
                <p class="category"></p>
                {!! $grid !!}
            </div>
            <div class="card-footer">
            </div>
        </div>
    </div>

@endsection
