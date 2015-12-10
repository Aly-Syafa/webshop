@extends('backend.layouts.master')
@section('content')

    <div class="row">
        <div class="col-md-12">

            <div class="options text-left" style="margin-bottom: 10px;">
                <div class="btn-toolbar">
                    <a href="{{ url('admin/abo') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> &nbsp;Retour</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-9">

            <div class="panel panel-midnightblue">
                <div class="panel-heading">
                    <h4><i class="fa fa-edit"></i> &nbsp;Ajouter abo</h4>
                </div>
                <form action="{{ url('admin/abo') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                    {!! csrf_field() !!}

                    <div class="panel-body">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Titre</label>
                            <div class="col-sm-3 col-xs-6">
                                <input type="text" class="form-control" name="title">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Centre/institut</label>
                            <div class="col-sm-3 col-xs-6">
                                <input type="text" class="form-control" name="name">
                            </div>
                            <div class="col-sm-3 col-xs-12">
                                <p class="help-block">facultatif</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Récurrence</label>
                            <div class="col-sm-3 col-xs-6">
                                <select class="form-control" name="plan">
                                    <option value=""></option>
                                    @foreach($plans as $name => $plan)
                                        <option {{ $name == 'year' ? 'selected' : '' }} value="{{ $name }}">{{ $plan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="file" class="col-sm-3 control-label">Logo</label>
                            <div class="col-sm-7">
                                <div class="list-group">
                                    <div class="list-group-item">
                                        {!!  Form::file('file')!!}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="message" class="col-sm-3 control-label">Produits</label>
                            <div class="col-sm-5 col-xs-8">
                                <select multiple class="form-control" id="multi-select" name="products_id[]">
                                    @if(!empty($products))
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->title }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="panel-footer text-right">
                        <button type="submit" class="btn btn-info">Créer un abo</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

@stop