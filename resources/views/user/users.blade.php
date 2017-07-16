@extends('layouts.dashboard')

@section('content')

    <div class="col-md-12">
        <div class="card">
            <div class="card-header" data-background-color="blue">
                <h4 class="nav-tabs-title">Użytkownicy apteczek
                    <button class="btn btn-primary btn-round pull-right" id="userInfo" data-toggle="modal" data-target="#userInfoModal">Moje Dane<div class="ripple-container"></div></button>
                </h4>
            </div>
            <div class="card-content">

                @if ($cabinets)
                    @foreach($cabinetsList as $key=>$cabinet)
                    <table class="table table-hover">
                        <thead class="text-warning">
                        <th>{{$cabinet->cabinet_name}}</th>
                        <th></th>
                        </thead>
                        <tbody>
                        @foreach($cabinet->users as $user)
                            <tr>
                                <td>{{$user->email}}</td>
                                <td>
                                    <form class="form-horizontal" role="form" method="Post" action="{{ url('/cabinet/delete-user/'.$cabinet->id.'/'.$user->id) }}">
                                        {{ csrf_field() }}
                                        <div class="col-md-6 col-md-offset-4">
                                            <button type="submit" class="btn btn-primary btn-simple btn-bin">
                                                <i class="material-icons bin">delete</i>
                                            </button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td>Dodaj użytkownika do apteczki</td>
                            <td>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    @endforeach

                @endif
            </div>

            </div>
            <div class="card-footer">

            </div>
        </div>
    </div>

@endsection

@section('modal')

    <div class="modal fade" id="userInfoModal" tabindex="-1" role="dialog" aria-labelledby="cabinetModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="material-icons">clear</i>
                    </button>
                    <h4 class="modal-title">Edytuj swoje dane</h4>
                </div>
                <div class="modal-body">
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/cabinet/create') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Imię</label>

                                <div class="col-md-6">
                                    <input id="name" class="form-control" name="name" placeholder="{{Auth::user()->name}}" autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('cabinetName') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Email</label>

                                <div class="col-md-6">
                                    <input id="email" class="form-control" name="email" placeholder="{{Auth::user()->email}}" autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('cabinetName') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Zmień hasło
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection