@extends('layouts.dashboard')

@section('content')

    <div class="col-md-12">
        <h4 class="nav-tabs-title">Apteczki & Użytkownicy
            <button class="btn btn-primary btn-round pull-right" id="userInfo" data-toggle="modal" data-target="#userInfoModal">Moje Dane<div class="ripple-container"></div></button>
        </h4>
    </div>
    @if ($cabinets)
        @foreach(array_chunk($cabinetsList->all(), 2) as $row)
            <div class="row">
                @foreach ($row as  $key=>$cabinet)
                    <div class="col-md-6 col-xs-12">
                        <div class="card">
                            <div class="card-header" data-background-color="orange">
                                <h4 class="nav-tabs-title"><a href="/cabinet/{{$cabinet->id}}">{{$cabinet->cabinet_name}}</a></h4>
                                @if (\Auth::user()->isCabinetAdmin($cabinet))
                                {{--<a class="pull-right deleteCabinet" href="/cabinet/delete-cabinet/{{$cabinet->id}}"><i class="material-icons">close</i></a>--}}
                                    <form class="form-horizontal pull-right deleteCabinet" role="form" method="Post" action="{{ url('/cabinet/delete-cabinet/'.$cabinet->id) }}">
                                        {{ csrf_field() }}
                                        <div class="col-md-6 col-md-offset-4">
                                            <button type="submit" class="btn btn-danger btn-simple btn-bin">
                                                <i class="material-icons">close</i>
                                            </button>
                                        </div>
                                    </form>
                            @endif
                            </div>
                            <div class="card-content">
                                <table class="table table-hover">
                                    <thead class="text-warning">
                                    <th>Email użytkownika</th>
                                    <th></th>
                                    </thead>
                                    <tbody>
                                    @foreach($cabinet->users as $user)
                                        <tr>
                                            <td>{{$user->email}}</td>
                                            <td>
                                                @if (!$user->isCabinetAdmin($cabinet) && \Auth::user()->isCabinetAdmin($cabinet))
                                                <form class="form-horizontal" role="form" method="Post" action="{{ url('/cabinet/delete-user/'.$cabinet->id.'/'.$user->id) }}">
                                                    {{ csrf_field() }}
                                                    <div class="col-md-6 col-md-offset-4">
                                                        <button type="submit" class="btn btn-primary btn-simple btn-bin">
                                                            <i class="material-icons bin">delete</i>
                                                        </button>
                                                    </div>
                                                </form>
                                                    @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td>
                                        <form class="form-horizontal addUserForm" role="form" method="Post" action="{{ url('/cabinet/add-user/'.$cabinet->id) }}">
                                                {{ csrf_field() }}

                                            <input id="newUser" class="form-control" type="email" name="newUser" placeholder="Wprowadź email nowego użytkownika" autofocus>
                                            <button type="submit" class="btn btn-primary btn-simple btn-bin addUserBtn">
                                                <i class="material-icons">add_circle_outline</i>
                                            </button>
                                        </form>
                                        </td>
                                        <td>
                                        </td>

                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <div class="card-footer">

                        </div>
                    </div>


                @endforeach
            </div>
        @endforeach
    @endif

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
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/users/edit/'.Auth::user()->id) }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Imię</label>

                                <div class="col-md-6">
                                    <input id="editName" class="form-control" name="editName" value="{{Auth::user()->name}}" autofocus>

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
                                    <input id="editEmail" class="form-control" name="editEmail" type="email" value="{{Auth::user()->email}}" autofocus>

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
                                        Zmień dane
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