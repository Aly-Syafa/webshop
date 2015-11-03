@extends('backend.layouts.master')
@section('content')

<div class="row">
    <div class="col-md-12">

        <h3>Utilisateur/Comptes</h3>

        <div class="options text-right" style="margin-bottom: 10px;">
            <div class="btn-toolbar">
                <a href="{{ url('admin/user/create') }}" class="btn btn-success"><i class="fa fa-plus"></i> &nbsp;Ajouter</a>
            </div>
        </div>

         <div class="row">

             <div class="col-md-3">
                 <div class="panel panel-midnightblue">
                     <div class="panel-body">
                        <h4>Rechercher</h4>
                         <form action="{{ url('admin/user/search') }}" method="post">
                             <div class="form-group">
                                 <label>Prénom</label>
                                 <input type="first_name" class="form-control" placeholder="Prénom">
                             </div>
                             <div class="form-group">
                                 <label>Nom</label>
                                 <input type="last_name" class="form-control" placeholder="Nom">
                             </div>
                             <div class="form-group">
                                 <label>Email</label>
                                 <input type="email" class="form-control" placeholder="Email">
                             </div>
                             <div class="form-group">
                                 <label>Entreprise</label>
                                 <input type="company" class="form-control" placeholder="Entreprise">
                             </div>
                             <button type="submit" class="btn btn-default">Rechercher</button>
                         </form>
                     </div>
                 </div>
             </div>

             <div class="col-md-9">
                 <div class="panel panel-midnightblue">
                     <div class="panel-body">
                         <h4>Dernier comptes crées</h4>
                         <table class="table" style="margin-bottom: 0px;" id="">
                             <thead>
                             <tr>
                                 <th class="col-sm-1">Action</th>
                                 <th class="col-sm-3">Nom</th>
                                 <th class="col-sm-3">Email</th>
                                 <th class="col-sm-3">Adresse(s)</th>
                                 <th class="col-sm-2"></th>
                             </tr>
                             </thead>
                             <tbody class="selects">
                             @if(!empty($users))
                                 @foreach($users as $user)
                                     <tr>
                                         <td><a class="btn btn-sky btn-sm" href="{{ url('admin/user/'.$user->id) }}">&Eacute;diter</a></td>
                                         <td><strong>{{ $user->name }}</strong></td>
                                         <td>{{ $user->email }}</td>
                                         <td>
                                             @if( !$user->adresses->isEmpty())
                                                 <ul class="list-group" style="margin-bottom: 0;">
                                                     @foreach ($user->adresses as $adresse)
                                                         <li class="list-group-item">
                                                             {{ $adresse->type_title }}
                                                             <a href="{{ url('admin/adresse/'.$adresse->id) }}" class="btn btn-xs btn-info pull-right">éditer</a>
                                                         </li>
                                                     @endforeach
                                                 </ul>
                                             @endif
                                         </td>
                                         <td class="text-right">
                                             {!! Form::open(array('route' => array('admin.user.destroy', $user->id), 'method' => 'delete')) !!}
                                             <button data-action="{{ $user->name }}" class="btn btn-danger btn-sm deleteAction">Supprimer</button>
                                             {!! Form::close() !!}
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

    </div>
</div>

@stop