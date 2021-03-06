@extends('backend.layouts.master')
@section('content')
    <p><a href="{{ url('admin/abonnements/'.$abo->id) }}" class="btn btn-default"><i class="fa fa-arrow-left"></i> &nbsp;Retour</a></p>
    <div class="panel panel-default">
        <div class="panel-body" style="padding-bottom: 10px;">
            <div class="row">
                <div class="col-md-2">
                    <img class="thumbnail" style="height: 50px; float:left; margin-right: 15px;padding: 2px;" src="{{ asset('files/products/'.$product->image) }}" />
                    <h3 style="margin-bottom:0;line-height:24px">{{ $abo->title }}</h3>
                    <p style="margin-bottom: 8px;">&Eacute;dition {{ $product->reference.' '.$product->edition }}</p>
                </div>
                <div class="col-md-10 text-right">
                    <div>
                        <a href="{{ url('admin/facture/generate/'.$product->id) }}" class="btn btn-brown">Générer toutes les factures</a>
                        <a href="{{ url('admin/facture/bind/'.$product->id) }}" class="btn btn-default" title="Re-attacher toutes les factures"><i class="fa fa-link"></i></a>
                        <span class="btn-left-space">|</span>
                        <a href="{{ url('admin/rappel/generate/'.$product->id) }}" class="btn btn-warning">Générer tous les rappels</a>
                        <a href="{{ url('admin/rappel/bind/'.$product->id) }}" class="btn btn-default" title="Re-attacher tous les rappels"><i class="fa fa-link"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2 col-xs-12">

            <div class="panel panel-midnightblue">
                <div class="panel-body" style="padding-bottom: 0;">
                    <h4 style="margin-bottom: 10px; margin-top: 0;">Factures et rappels liés</h4>
                    @if(!empty($files))
                        <div class="list-group">
                            @foreach($files as $file)
                                <?php $name = explode('/',$file); ?>
                                <a href="{{ asset($file.'?'.rand(1000,2000)) }}" target="_blank" class="list-group-item"><i class="fa fa-download"></i>&nbsp; {{ end($name) }}</a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-10 col-xs-12">
            <div class="panel panel-midnightblue">
                <div class="panel-body">
                    <h3 style="margin-bottom: 30px;">Factures pour l'&eacute;dition {{ $product->reference.' '.$product->edition }}</h3>
                    <table class="table" id="abos-table">
                        <thead>
                            <tr>
                                <th width="20px;">Action</th>
                                <th width="20px;">Numero</th>
                                <th>Nom</th>
                                <th>Date</th>
                                <th>Facture</th>
                                <th>Status</th>
                                <th>Rappels</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(!$factures->isEmpty())
                            @foreach($factures as $facture)
                                <tr>
                                    <td><a href="{{ url('admin/facture/'.$facture->id) }}" class="btn btn-sm btn-brown"><i class="fa fa-edit"></i></a></td>
                                    <td>{{ $facture->abonnement->numero }}</td>
                                    <td>
                                        @if($facture->abonnement->user)
                                            <a href="{{ url('admin/abonnement/'.$facture->abonnement->id) }}">{{ $facture->abonnement->user->name }}</a>
                                        @elseif($facture->abonnement->originaluser)
                                            <a href="{{ url('admin/abonnement/'.$facture->abonnement->id) }}">{{ $facture->abonnement->originaluser->name }}</a>
                                        @else
                                            <p><span class="label label-warning">Duplicata</span></p>
                                        @endif
                                    </td>
                                    <td>{{ $facture->created_at->formatLocalized('%d %B %Y') }}</td>
                                    <td>
                                        @if($facture->abo_facture)
                                            <a class="btn btn-default btn-sm" target="_blank" href="{{ asset($facture->abo_facture) }}"><i class="fa fa-file"></i> &nbsp;Facture pdf</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if($facture->payed_at)
                                            <p><span class="label label-success">Payé le {!! $facture->payed_at->formatLocalized('%d %B %Y') !!}</span></p>
                                        @else
                                            <p><span class="label label-default">Ouverte</span></p>
                                        @endif
                                    </td>
                                    <td>
                                        @if(!$facture->rappels->isEmpty())
                                            @foreach($facture->rappels as $rappel)
                                                <p><strong>{!! $rappel->created_at->formatLocalized('%d %B %Y') !!}</strong></p>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        <form action="{{ url('admin/facture/'.$facture->id) }}" method="POST" class="form-horizontal">
                                            <input type="hidden" name="_method" value="DELETE">{!! csrf_field() !!}
                                            <button data-what="Supprimer" data-action="Facture" class="btn btn-danger btn-sm deleteAction">x</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

@stop