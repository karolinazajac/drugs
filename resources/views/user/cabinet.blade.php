@extends('layouts.dashboard')

@section('content')


    <div class="col-md-12">
        <div class="col-md-2">
            <button class="btn btn-info btn-round" id="add-cabinet" data-toggle="modal" data-target="#cabinetModal">+ Nowa Apteczka <div class="ripple-container"></div></button>
        </div>
         {{--<div class="col-md-4">--}}
            {{--<button class="btn btn-info btn-round" id="cabinet_login" data-toggle="modal" data-target="#loginModal">Zaloguj się do istniejącej apteczki <div class="ripple-container"></div></button>--}}
        {{--</div>--}}
        <div class="col-md-2 dropdown">
            <a href="#" class="btn btn-info btn-round dropdown-toggle " id="cabinetsList" data-toggle="dropdown">
                <i class="material-icons">local_pharmacy</i> Twoje apteczki
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
                @foreach (Auth::user()->cabinets as $cabinet)
                    <li><a href="#">{{$cabinet->cabinet_name}}</a></li>
                @endforeach
            </ul>
        </div>
        <div class="card">
            <div class="card-header" data-background-color="blue">
                <h4 class="title">{{$mainCabinet->cabinet_name}} <button class="btn btn-primary btn-round pull-right" id="add-drug" data-toggle="modal" data-target="#myModal">+ Lek <div class="ripple-container"></div></button></h4>
            </div>
            <div class="card-content table-responsive">
                <table class="table table-hover">
                    <thead class="text-warning">
                    <th>ID</th>
                    <th>Nazwa</th>
                    <th>Ilość</th>
                    <th>Data ważności</th>
                    <th>Cena</th>
                    <th></th>
                    </thead>
                    <tbody>
                    @foreach($cabinetDrugs as $key=>$cabinetDrug)
                    <tr>
                        {{--{{$i=0; $i++;}}--}}
                        <td>{{$key+1}}</td>
                        <td>{{$cabinetDrug->name}}</td>
                        <td data-editable>{{$cabinetDrug->quantity}}</td>
                        <td>{{$cabinetDrug->expiration_date}}</td>
                        <td>{{$cabinetDrug->price}} zł</td>
                        <td>
                            <form class="form-horizontal" role="form" method="Post" action="{{ url('/cabinet/delete-drug/'.$cabinetDrug->id) }}">
                            {{ csrf_field() }}
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary btn-simple btn-lg">
                                            <i class="material-icons">delete</i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{--{!! $grid !!}--}}
        </div>
    </div>

@endsection
@section('modal')
<!-- Start Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="material-icons">clear</i>
                </button>
                <h4 class="modal-title">Dodaj nowy lek do swojej apteczki!</h4>
            </div>
            <div class="modal-body">
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/cabinet/add-drug') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Nazwa</label>

                            <div class="col-md-6">
                                <input id="name" class="form-control" name="name" required autofocus>
                                <input type="hidden" id="ean" name="ean">
                                <input type="hidden" id="cabinetId" name="cabinetId" value="{{$mainCabinet->id}}">
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
                            <label for="quantity" class="col-md-4 control-label">Ilość</label>

                            <div class="col-md-6">
                                <input id="quantity" type="number" class="form-control" name="quantity" value="{{ old('quantity') }}" required>

                                @if ($errors->has('quantity'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('quantity') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">
                            <label for="date" class="col-md-4 control-label">Data ważności</label>

                            <div class="col-md-6">

                                    <input type="text" id="date" name="date" class="form-control" required>
                                    <i class="glyphicon glyphicon-calendar fa fa-calendar" id="calendar"></i>

                                @if ($errors->has('date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('date') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                            <label for="price" class="col-md-4 control-label">Cena</label>

                            <div class="col-md-6">
                                <input id="price" type="number" class="form-control" name="price" value="{{ old('price') }}" required>

                                @if ($errors->has('price'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Dodaj lek
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
        </div>
    </div>
</div>
</div>
<div class="modal fade" id="cabinetModal" tabindex="-1" role="dialog" aria-labelledby="cabinetModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="material-icons">clear</i>
                </button>
                <h4 class="modal-title">Dodaj nową apteczkę</h4>
            </div>
            <div class="modal-body">
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/cabinet/create') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="cabinetName" class="col-md-4 control-label">Nazwa</label>

                            <div class="col-md-6">
                                <input id="cabinetName" class="form-control" name="cabinet_name" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cabinetName') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="container1 form-group">
                            <div class="col-md-6 col-md-offset-4">
                            <button class="add_form_field btn btn-info btn-round">+ Dodaj użytkownika<span style="font-size:16px; font-weight:bold;"></span></button>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Dodaj apteczkę
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  End Modal -->
@endsection

@section('scripts')
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/daterangepicker.js') }}"></script>
    <script src="{{ asset('js/jquery.easy-autocomplete.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#date').daterangepicker({
                "singleDatePicker": true,
                "showDropdowns": true,
                "alwaysShowCalendars": true,
                "startDate": "06/09/2017",
                "endDate": "06/15/2017",
                "drops": "up"
            }, function(start, end, label) {
                console.log("New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
            });

            var options = {
                url: "/drugs",

                getValue: "name",

                template: {
                    type: "description",
                    fields: {
                        description: "package"
                    }
                },
                theme: 'blue-light',
                list: {
                    onChooseEvent: function() {
                        var value = $("#name").getSelectedItemData().id;
                        $("#ean").val(value).trigger("change");
                    },
                    match: {
                        enabled: true
                    }

                }

            };
            $("#name").easyAutocomplete(options);
            $('.easy-autocomplete').width('100%');



                var max_fields      = 10;
                var wrapper         = $(".container1");
                var add_button      = $(".add_form_field");

                var x = 1;
                $(add_button).click(function(e){
                    e.preventDefault();
                    if(x < max_fields){
                        x++;
                        $(wrapper).append('<div><label for="user_email[]" class="col-md-4 control-label">Email użytkownika</label><div class="col-md-6"><input type="text" name="user_email[]" class="form-control"/><a href="#" class="delete"><i class="material-icons">delete</i></a></div></div>'); //add input box
                    }
                    else
                    {
                        alert('Przekroczyłeś limit użytkowników')
                    }
                });

                $(wrapper).on("click",".delete", function(e){
                    e.preventDefault(); $(this).parent('div').parent('div').remove(); x--;
                });

            $('table').on('click', '[data-editable]', function(){

                var $el = $(this);

                var $input = $('<input class="form-control quantity"/>').val( $el.text() );
                $el.replaceWith( $input );

                var save = function(){
                    var $td = $('<td data-editable />').text( $input.val() );
                    $input.replaceWith( $td );
                };

                $input.one('blur', save).focus();

            });
        })
    </script>
@endsection