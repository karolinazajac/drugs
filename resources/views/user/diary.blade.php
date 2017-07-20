@extends('layouts.dashboard')

@section('content')

    <div class="col-md-12">
        <div class="card">
            <div class="card-header" data-background-color="purple">
                <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                        <ul class="nav nav-tabs" data-tabs="tabs">
                            <li class="active">
                                <a href="#profile" data-toggle="tab">
                                    <i class="material-icons">message</i>
                                    Notatki
                                    <div class="ripple-container"></div></a>
                            </li>
                            <li class="">
                                <a href="#messages" data-toggle="tab">
                                    <i class="material-icons">event_note</i>
                                    Wizyty lekarskie
                                    <div class="ripple-container"></div></a>
                            </li>
                            <li class="">
                                <a href="#settings" data-toggle="tab">
                                    <i class="material-icons">assignment</i>
                                    Recepty
                                    <div class="ripple-container"></div></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card-content">
                <div class="tab-content">
                    <div class="tab-pane active" id="profile">
                        <div class="col-md-2">
                            <button class="btn btn-primary btn-round" id="add-note" data-toggle="modal" data-target="#noteModal">+ Nowa Notatka <div class="ripple-container"></div></button>
                        </div>
                        <table class="table">
                            <tbody>
                            <tr>
                                <td>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="optionsCheckboxes" checked>
                                        </label>
                                    </div>
                                </td>
                                <td>Sign contract for "What are conference organizers afraid of?"</td>
                                <td class="td-actions text-right">
                                    <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-simple btn-xs">
                                        <i class="material-icons">edit</i>
                                    </button>
                                    <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
                                        <i class="material-icons">close</i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="optionsCheckboxes">
                                        </label>
                                    </div>
                                </td>
                                <td>Lines From Great Russian Literature? Or E-mails From My Boss?</td>
                                <td class="td-actions text-right">
                                    <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-simple btn-xs">
                                        <i class="material-icons">edit</i>
                                    </button>
                                    <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
                                        <i class="material-icons">close</i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="optionsCheckboxes">
                                        </label>
                                    </div>
                                </td>
                                <td>Flooded: One year later, assessing what was lost and what was found when a ravaging rain swept through metro Detroit
                                </td>
                                <td class="td-actions text-right">
                                    <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-simple btn-xs">
                                        <i class="material-icons">edit</i>
                                    </button>
                                    <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
                                        <i class="material-icons">close</i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="optionsCheckboxes" checked>
                                        </label>
                                    </div>
                                </td>
                                <td>Create 4 Invisible User Experiences you Never Knew About</td>
                                <td class="td-actions text-right">
                                    <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-simple btn-xs">
                                        <i class="material-icons">edit</i>
                                    </button>
                                    <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
                                        <i class="material-icons">close</i>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane" id="messages">
                        <table class="table">
                            <tbody>
                            <tr>
                                <td>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="optionsCheckboxes" checked>
                                        </label>
                                    </div>
                                </td>
                                <td>Flooded: One year later, assessing what was lost and what was found when a ravaging rain swept through metro Detroit
                                </td>
                                <td class="td-actions text-right">
                                    <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-simple btn-xs">
                                        <i class="material-icons">edit</i>
                                    </button>
                                    <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
                                        <i class="material-icons">close</i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="optionsCheckboxes">
                                        </label>
                                    </div>
                                </td>
                                <td>Sign contract for "What are conference organizers afraid of?"</td>
                                <td class="td-actions text-right">
                                    <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-simple btn-xs">
                                        <i class="material-icons">edit</i>
                                    </button>
                                    <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
                                        <i class="material-icons">close</i>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane" id="settings">
                        <table class="table">
                            <tbody>
                            <tr>
                                <td>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="optionsCheckboxes">
                                        </label>
                                    </div>
                                </td>
                                <td>Lines From Great Russian Literature? Or E-mails From My Boss?</td>
                                <td class="td-actions text-right">
                                    <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-simple btn-xs">
                                        <i class="material-icons">edit</i>
                                    </button>
                                    <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
                                        <i class="material-icons">close</i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="optionsCheckboxes" checked>
                                        </label>
                                    </div>
                                </td>
                                <td>Flooded: One year later, assessing what was lost and what was found when a ravaging rain swept through metro Detroit
                                </td>
                                <td class="td-actions text-right">
                                    <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-simple btn-xs">
                                        <i class="material-icons">edit</i>
                                    </button>
                                    <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
                                        <i class="material-icons">close</i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="optionsCheckboxes">
                                        </label>
                                    </div>
                                </td>
                                <td>Sign contract for "What are conference organizers afraid of?"</td>
                                <td class="td-actions text-right">
                                    <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-simple btn-xs">
                                        <i class="material-icons">edit</i>
                                    </button>
                                    <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
                                        <i class="material-icons">close</i>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('modal')
    <!-- Start Modal -->
    <div class="modal fade" id="noteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="material-icons">clear</i>
                    </button>
                    <h4 class="modal-title">Dodaj nową notatkę</h4>
                </div>
                <div class="modal-body">
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/diary/create-note') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}


                            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                <label for="title" class="col-md-4 control-label">Tytuł</label>

                                <div class="col-md-6">
                                    <input id="title" type="text" class="form-control" name="title" value="{{ old('quantity') }}" required>

                                    @if ($errors->has('title'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
                                <label for="body" class="col-md-4 control-label">Treść notatki</label>

                                <div class="col-md-6">

                                    <textarea  id="body" name="body" class="form-control" cols="50" rows="7" placeholder="Zacznij pisać swoją notatkę..."> </textarea>

                                    @if ($errors->has('body'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('body') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('file') ? ' has-error' : '' }}">
                                <div class="col-md-6 col-md-offset-4">
                                    <input type="file" id="image" name="image" class="form-control" >
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Dodaj notatkę
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
